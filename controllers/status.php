<?php
require_once 'libs/cls_apitype.php';
require_once 'libs/cls_imageprofile.php';

class Status extends Controller {
	
  function __construct() {
  	parent::__construct();
  	// require 'models/xml_model.php';
  	// $this->xml = new XML_Model;
  }
  
  private function needs_auth_for_usertype($st,$type) {
  	if (is_file(_SHORT_DIR_.'/'.$st.'/.password')) {
      if (strpos(file_get_contents(_SHORT_DIR_.'/'.$st.'/.password'),$type) !== false) {
        return true;
      }
    }
    return false;
  }
  
  function needauth($st='') {
  	if (is_dir(_SHORT_DIR_.'/'.$st)) {
  	  $unv = $this->needs_auth_for_usertype($st,'user');
  	  $onv = $this->needs_auth_for_usertype($st,'operator');
      $data = [ "returncode" => "200",
                "api_ver"    => _VERSION_,
                "message"    => "Shorttag gefunden",
                "payload"    => [ "shorttag" => $st,
                                  "user"     => ($unv?"1":"0"),
                                  "operator" => ($onv?"1":"0")
                                ]
              ];
  	} else {
  	  $data = [ "returncode" => "500",
  	            "api_ver"    => _VERSION_,
                "message"    => "Shorttag nicht gefunden"
              ];
  	}
  	header('Content-Type: application/json');
  	echo json_encode($data);
  }
  
  function information($st='',$parameter='') {
    if (is_file(_SHORT_DIR_.'/'.$st.'/status')) {
      $status = file_get_contents(_SHORT_DIR_.'/'.$st.'/status');
      $returncode = "200";
      $message    = "Shorttag gefunden";
      switch ($status) {
        case "ok":
          $short       = "online";
          $description = "Die Kamera liefert Bilder";
          $color       = "success";
          break;
        case "soft_fail":
          $short       = "offline";
          $description = "Das letzte Bild ist zu alt. Dies ist die 1. Meldung";
          $color       = "info";
          break;
        case "soft_fail2":
          $short       = "offline";
          $description = "Das letzte Bild ist zu alt. Dies ist die 2. Meldung";
          $color       = "warning";
          break;
        case "fail":
          $short       = "offline";
          $description = "Die Kamera ist offline";
          $color       = "danger";
          break;
        case "escalated":
          $short       = "offline";
          $description = "Die Kamera ist seit mehr als 4 Stunden offline";
          $color       = "secondary";
          break;
        case "soft_ok":
          $short       = "online";
          $description = "Die Kamera liefert wieder Bilder";
          $color       = "info";
          break;
        default:
          $returncode = "200";
          $message    = "Shorttag status unbekannt";
          $short       = "unbekannt";
          $description = "Keine g&uuml;ltigen Statusinformationen";
          $color       = "secondary";
          break;
      }
      $data = [ "returncode" => $returncode,
                "api_ver"    => _VERSION_,
                "message"    => $message,
                "payload"    => [ "shorttag" => $st,
                                  "image"    => 
                                        [ "status"      => $status,
                                          "short"       => $short,
                                          "description" => $description,
                                          "color"       => $color
                                        ]
                                ]
              ];
      if (is_file(_SHORT_DIR_.'/'.$st.'/shorttag.data')) {
        foreach(file(_SHORT_DIR_.'/'.$st.'/shorttag.data') as $row) {
          // Im Value können durchaus Doppelpunkte auftauchen
          $var_name  = trim(str_replace(array('"',':','\''),'',strstr($row, ':', true)));
          $var_value = trim(str_replace(array('"','\''),'',substr(strstr($row, ':'),1)));
          if ($var_name == 'camera_url_address') {
            $ip = $var_value;
            break;
          }
        }
      }
      if (is_link(_SHORT_DIR_.'/'.$st.'/img/lastimage.jpg')) {
        $last_img_array = explode('/',readlink(_SHORT_DIR_.'/'.$st.'/img/lastimage.jpg'));
        $last_img_time = substr($last_img_array[3],0,strpos($last_img_array[3],'.'));
      	$lastimage = $last_img_array[2].'.'.$last_img_array[1].'.'.$last_img_array[0].' '.
      	             substr($last_img_time,0,2).':'.
      	             substr($last_img_time,2,2).':'.
      	             substr($last_img_time,4,2);
      } else $lastimage = '';
      if (is_file(_SHORT_DIR_.'/'.$st.'/description.js')) {
      	$filename = _SHORT_DIR_.'/'.$st.'/description.js';
        $info = json_decode(file_get_contents($filename), true);
        $data['payload']['information'] = [ "name"      => isset($info['name'])?utf8_encode($info['name']):'',
                                            "ip"        => $ip,
                                            "lastimage" => $lastimage,
                                            "projekt"   => isset($info['projekt'])?utf8_encode($info['projekt']):'',
                                            "aktiv"     => isset($info['aktiv'])?$info['aktiv']==true?'1':'0':'',
                                            "monitor"   => isset($info['monitor'])?$info['monitor']==true?'1':'0':'',
                                            "other"     => isset($info['other'])?$info['other']:array()
                                          ];
      }
    } else {
      $data = [ "returncode" => "500",
                "api_ver"    => _VERSION_,
                "message"    => "Shorttag nicht gefunden"
              ];
    }
    header('Content-Type: application/json');
  	echo json_encode($data);
  }

  function connection_status($st='') {
  	// Ermittle die IP und die Zugangsdaten des Routers
    if (is_file(_SHORT_DIR_.'/'.$st.'/shorttag.data')) {
      foreach(file(_SHORT_DIR_.'/'.$st.'/shorttag.data') as $row) {
        $var_name  = trim(str_replace(array('"',':','\''),'',strstr($row, ':', true)));
        $var_value = trim(str_replace(array('"','\''),'',substr(strstr($row, ':'),1)));
        switch ($var_name) {
          case 'camera_url_protocol': $protocol = $var_value; break;
          case 'camera_url_address':  $ip = $var_value; break;
          case 'router_url_port':     $port = $var_value; break;
          case 'router_url_secret':   $secret = $var_value; break;
          default:
        }
      }
    }
    if(isset($ip)) {
      $url = $protocol.'://'.$ip.':'.$port.'/cgi-bin/luci';
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_USERPWD, $secret);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, 15);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
      $response = curl_exec($ch);
      if(curl_errno($ch)) {
        //throw new Exception(curl_error($ch));
        $data['returncode'] = "400";
        $data['api_ver']    = _VERSION_;
        $data['message']    = "Fehler beim Abruf";
        $data['payload']    = array( "url"     => $url,
                                     "type"    => "curl", 
                                     "number"  => curl_errno($ch), 
                                     "message" => curl_error($ch) );
      } else {
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML($response);
        $provider_name   = $dom->getElementById('3gProv')?$dom->getElementById('3gProv')->nodeValue:'unbekannt';
        $connection_type = $dom->getElementById('3gCType')?$dom->getElementById('3gCType')->nodeValue:'unbekannt';
        $signal_strength = $dom->getElementById('3gStr')?filter_var($dom->getElementById('3gStr')->nodeValue, FILTER_SANITIZE_NUMBER_INT):'-200';
        $data['returncode'] = "200";
        $data['api_ver']    = _VERSION_;
        $data['message']    = "Abruf erfolgreich";
        $data['payload'] = array( 'provider'        => $provider_name,
                                  'connection_type' => $connection_type,
                                  'signal_strength' => $signal_strength);
      }
      curl_close($ch);
    } else  {
      $data['returncode'] = "401";
      $data['api_ver']    = _VERSION_;
      $data['message']    = "Fehler beim Abruf";
      $data['payload']    = array( "message" => "Shorttag nicht vorhanden" );
    }
    header('Content-Type: application/json');
  	echo json_encode($data);
  }

  function webcam_status($st='') {
  	$res_code = '500';
  	$res_msg  = 'unknown error';
  	$res_pld  = '';
  	// Ermittle die IP und die Zugangsdaten des Routers
    if (is_file(_SHORT_DIR_.'/'.$st.'/shorttag.data')) {
      foreach(file(_SHORT_DIR_.'/'.$st.'/shorttag.data') as $row) {
        $var_name  = trim(str_replace(array('"',':','\''),'',strstr($row, ':', true)));
        $var_value = trim(str_replace(array('"','\''),'',substr(strstr($row, ':'),1)));
        switch ($var_name) {
          case 'api_type':            $api_type = $var_value; break;
          case 'router_type':         $router_type = $var_value; break;
          case 'camera_url_protocol': $protocol = $var_value; break;
          case 'camera_url_address':  $ip = $var_value; break;
          case 'camera_url_port':     $port = $var_value; break;
          case 'camera_url_secret':   $secret = $var_value; break;
          default:
        }
      }
      if(isset($ip)) {
      	$size = '320x240';
      	switch ($router_type) {
      	  case 'teltonika':
      	    $image_profile = ImageProfile::best_fitting_profile($api_type,$size);
            $url = $protocol.'://'.$ip.':'.$port.APIType::get_image_url($api_type,$image_profile);
            break;
          case 'virtual':
          default:
            $url = $protocol.'://'.$ip;
      	}
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, $secret);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        $result = curl_exec($ch);
        $rescode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($rescode=='200') {
          $res_code = '200';
          $res_msg  = 'Ein Vorschaubild konnte abgeholt werden.';
          $res_pld = base64_encode($result);
        } else $res_msg = 'Ein Vorschaubild konnte nicht abgeholt werden.';
      } else $res_msg = 'IP der Webcam nicht gefunden oder konfiguriert';
    } else $res_msg = 'Shorttag nicht vorhanden';
    $json = '{ "returncode":'.$res_code.', "message":"'.$res_msg.'", "payload": "'.$res_pld.'" }';
    header('Content-Type: application/json');
  	echo $json;
  }
  
  /* Ausgabe der MRTG-Images eines bestimmten Zeitbereiches */
  /* scope = day|month|year */
  function chart($st,$parameter='') {
    $param = array_map('trim',explode('.',$parameter));
    $scope = empty($param[0])?'day':$param[0];
    switch ($scope) {
      case 'day': break;
      case 'week': break;
      case 'month': break;
      case 'year': break;
      default: $scope='day';
    }
    $chart_file = _MRTG_DIR_.'/'.$st.'-'.$scope.'.png';
    if (is_file($chart_file)) {
      header("Content-type: image/png");
      readfile($chart_file);
    }
  }

  function help() {
  	require('controllers/help.php');
  	$this->help = new Help('status','help');
  	$this->help->render_module_help();
  }

}

?>