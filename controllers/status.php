<?php

class Status extends Controller {
	
  function __construct() {
  	parent::__construct();
  	// require 'models/xml_model.php';
  	// $this->xml = new XML_Model;
  }
  
  private function needs_auth_for_type($st,$type) {
  	if (is_file(_SHORT_DIR_.'/'.$st.'/.password')) {
      if (strpos(file_get_contents(_SHORT_DIR_.'/'.$st.'/.password'),$type) !== false) {
        return true;
      }
    }
    return false;
  }
  
  function needauth($st) {
  	if (is_dir(_SHORT_DIR_.'/'.$st)) {
  	  $unv = $this->needs_auth_for_type($st,'user');
  	  $onv = $this->needs_auth_for_type($st,'operator');
      $json_text = '{ "return": "200", "user": "'.($unv?'true':'false').'", "operator": "'.($onv?'true':'false').'" }';
  	} else {
  	  $json_text = '{ "return": "500", "message": "Shorttag nicht gefunden" }';
  	}
  	header('Content-type:application/json;charset=utf-8');
    echo utf8_encode($json_text);
  }
  
  function json($st) {
    $status_name = "unbekannt";
    $status_description = "Keine Statusinformationen vorhanden";
    $status_color = "secondary";
    if (is_file(_SHORT_DIR_.'/'.$st.'/status')) {
      $status = file_get_contents(_SHORT_DIR_.'/'.$st.'/status');
      switch ($status) {
        case "ok":
          $status_name = "online";
          $status_description = "Die Kamera l&auml;uft und liefert Bilder";
          $status_color = "success";
          break;
        case "soft_fail":
          $status_name = "offline";
          $status_description = "Die Kamera ist seit etwa 5 Minuten nicht erreichbar";
          $status_color = "info";
          break;
        case "soft_fail2":
          $status_name = "offline";
          $status_description = "Die Kamera ist seit mehr als 10 Minuten nicht erreichbar";
          $status_color = "warning";
          break;
        case "fail":
          $status_name = "offline";
          $status_description = "Die Kamera ist seit mehr als 15 Minuten offline";
          $status_color = "danger";
          break;
        case "escalated":
          $status_name = "offline";
          $status_description = "Die Kamera ist seit mehr als 4 Stunden offline";
          $status_color = "secondary";
          break;
        case "soft_ok":
          $status_name = "online";
          $status_description = "Die Kamera ist seit etwa 5 Minuten wieder erreichbar";
          $status_color = "info";
          break;
      }
    }
    $json_text = '{ "status": "'.$status_name.'", '.
                 '  "description": "'.$status_description.'", '.
                 '  "color": "'.$status_color.'"'.
                 '}';
    header('Content-type:application/json;charset=utf-8');
    echo utf8_encode($json_text);
  }
  
  function information($st) {
  	$dirname = _SHORT_DIR_.'/'.$st;
  	$js_text = '{ "name":"", "beschreibung":"", "projekt":"" }';
  	if ($st!='' && is_dir($dirname)) {
  	  $filename = $dirname.'/description.js';
  	  if (is_file($filename)) {
  	    $strJsonFileContents = file_get_contents($filename);
  	    $array = json_decode($strJsonFileContents, true);
  	    $js_text = '{ "name": "'.$array['name'].
  	      '", "beschreibung": "'.$array['beschreibung'].
  	      '", "projekt": "'.$array['projekt'].
  	      '", "aktiv": '.($array['aktiv']?'true':'false').
  	      ', "monitor": '.($array['monitor']?'true':'false').
  	      ', "other": [ ';
  	    $st_text = '';
  	    foreach($array['other'] as $st) {
  	      $st_text .= ($st_text==''?'':', ').'"'.$st.'"';
  	    }
  	    $js_text .= $st_text.' ] }';
  	  }
  	}
  	header('Content-type:application/json;charset=utf-8');
  	echo utf8_encode($js_text);
  }
  
  /* Ausgabe der MRTG-Images eines bestimmten Zeitbereiches */
  /* scape = day|month|year */
  function chart($st,$parameter='') {
    $param = array_map('trim',explode('.',$parameter));
    $scope = empty($param[0])?'day':$param[0];
    $chart_file = _MRTG_DIR_.'/'.$st.'-'.$scope.'.png';
    if (is_file($chart_file)) {
      header("Content-type: image/png");
      readfile($chart_file);
    }
  }
  
  function help() {
  	require('controllers/help.php');
  	$this->view->help = new Help();
  	$this->view->render('header');
  	$this->view->render('status/help');
  	$this->view->render('footer');
  }

}

?>