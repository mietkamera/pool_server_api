<?php

class Image extends Controller {
	
  function __construct() {
  	parent::__construct();
  }
  
  function index() {
  	$this->view->render('image/index');
  }
  
  function help() {
  	require('controllers/help.php');
  	$this->view->help = new Help();
  	$this->view->render('header');
  	$this->view->render('image/help');
  	$this->view->render('footer');
  }
  
  //
  // Gibt ein Bild aus einer Datei aus
  private function image_jpg($filename,$size) {
  	$must_resize = false;
    if ($size!='') {
      list($ow,$oh) = getimagesize($filename);
      list($w,$h) = explode('x',$size);
      $must_resize = ($ow!=$w || $oh!=$h);
    }
    
  	header("Content-type: image/jpeg");
  	if ($must_resize) {
  	  $img =  imagecreatefromjpeg($filename);
      $timg = imagecreatetruecolor($w,$h);
      imagecopyresized($timg, $img, 0, 0, 0, 0, $w, $h, $ow, $oh);
      imagejpeg($timg);
      imagedestroy($img);
      imagedestroy($timg);
  	} else 
    readfile($filename);
  }
  
  //
  // Gibt das erste Bild eines bestimmten Datumsbereichs aus
  // 
  function first($st,$parameter='') {
    $param = array_map('trim',explode('.',$parameter));
  	$date = empty($param[0])?'':$param[0];
  	$size = $this->check_size(empty($param[1])?'':$param[1]);
  	
  	$images = $this->get_image_file_names($st,$date);
  	
    if (count($images)>0) {
      switch (strlen($date)) {
        case 0:
          $image_dir = _SHORT_DIR_.'/'.$st.'/01';
          break;
        case 4:
          $image_dir = _SHORT_DIR_.'/'.$st.'/01/'.$date;
      	  break;
        case 6:
      	  $y = substr($date,0,4);
  	      $m = substr($date,4,2);
          $image_dir =  _SHORT_DIR_.'/'.$st.'/01/'.$y.'/'.$m;
          break;
        case 8:
      	  $y = substr($date,0,4);
  	      $m = substr($date,4,2);
  	      $d = substr($date,6,2);
          $image_dir =  _SHORT_DIR_.'/'.$st.'/01/'.$y.'/'.$m.'/'.$d;
          break;
        default:
      	  $image_dir = '';
      }
    } else {
      $image_dir = 'public/images';
      $images[] = 'empty.jpg'.PHP_EOL;
    }
    
  	$filename = $image_dir.'/'.substr($images[0],0,strlen($images[0])-1);
    if (!is_file($filename))
      $filename = 'public/images/empty.jpg'; 
      
    $this->image_jpg($filename,$size);
  }
  
  //
  // Gib das erste Bild eines bestimmten Datumsbereichs aus
  // 
  function last($st,$parameter='') {
  	$param = array_map('trim',explode('.',$parameter));
  	$date = empty($param[0])?'':$param[0];
  	$size = $this->check_size(empty($param[1])?'':$param[1]);
  	
  	if ($date=='' && is_link(_SHORT_DIR_.'/'.$st.'/01/lastimage.jpg')) {
  	  $images[] = readlink(_SHORT_DIR_.'/'.$st.'/01/lastimage.jpg')."\n";
  	} else
      $images = $this->get_image_file_names($st,$date);
    if (count($images)>0) {
      switch (strlen($date)) {
        case 0:
          $image_dir = _SHORT_DIR_.'/'.$st.'/01';
          break;
        case 4:
          $image_dir = _SHORT_DIR_.'/'.$st.'/01/'.$date;
          break;
        case 6:
      	  $y = substr($date,0,4);
  	      $m = substr($date,4,2);
          $image_dir = _SHORT_DIR_.'/'.$st.'/01/'.$y.'/'.$m;
          break;
        case 8:
      	  $y = substr($date,0,4);
  	      $m = substr($date,4,2);
  	      $d = substr($date,6,2);
          $image_dir = _SHORT_DIR_.'/'.$st.'/01/'.$y.'/'.$m.'/'.$d;
          break;
        default:
      	  $image_dir = '';
      }
    } else {
      $image_dir = 'public/images';
      $images[] = 'empty.jpg'.PHP_EOL;
    }
  	
  	$index = count($images)-1;
  	$filename = $image_dir.'/'.substr($images[$index],0,strlen($images[$index])-1);
    if (!is_file($filename))
      $filename = 'public/images/empty.jpg'; 
      
    $this->image_jpg($filename,$size);
  }
  
  //
  // gib ein bestimmtes Bild zurück
  //
  function get($st,$parameter='') {
  	$param = array_map('trim',explode('.',$parameter));
  	$date = empty($param[0])?'':$param[0];
  	$size = $this->check_size(empty($param[1])?'':$param[1]);

  	$y = substr($date,0,4);
  	$m = substr($date,4,2);
  	$d = substr($date,6,2);
  	
  	$filename = _SHORT_DIR_.'/'.$st.'/01/'.$y.'/'.$m.'/'.$d.'/'.substr($date,8).'.jpg';
    if (!is_file($filename))
      $filename = 'public/images/empty.jpg';
    
    $this->image_jpg($filename,$size);
  }
  
  function live($st,$parameter="") {
  	$param = array_map('trim',explode('.',$parameter));
  	$size = $this->check_size(empty($param[0])?'':$param[0]);

  	require 'models/xml_model.php';
  	$xmldata = new XML_Model();
    if ($st!='' && isset($xmldata->st[$st])) {
      $webcam = $xmldata->st[$st];
      if ($webcam['active']) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://'.$webcam['url'].$xmldata->api_image_path($webcam['api'],$size));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, $webcam['secret']);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
    
        $result = curl_exec($ch);
        $rescode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($rescode=='200') {
          header("Content-Type: image/jpeg");
          echo $result;
          return;
        } else $text = 'Sorry :-('."\n".'Kein Livebild vorhanden!'."\n\n".'Die Webcam ist nicht erreichbar.';
      } else $text = 'sorry :-('."\n".'Kein Livebild vorhanden!'."\n\n".'Die Webcam ist nicht aktiv.';
    } else $text = 'sorry :-('."\n".'Kein Livebild vorhanden!'."\n\n".'Shorttag existiert nicht.';
    
    header("Content-Type: image/jpeg");
    list($w,$h) = explode('x',$size);
    $img = imagecreatetruecolor($w,$h);
    $tcolor = imagecolorallocate($img, 255, 255, 255);
    $bcolor = imagecolorallocate($img, 0, 64, 128);
    $font = 'DejaVuSans';

    imagefilledrectangle($img, 0, 0, $w, $h, $bcolor);
    imagettftext($img, ceil($w/32), 0, 30, 100, $tcolor, $font, $text);
    imagejpeg($img);
    imagedestroy($img);
  }
  
  function check_day_value($val) {
    $return_value = true;
    if (strlen($val)==8) {
      $y = (int) substr($val,0,4);
      $m = (int) substr($val,4,2);
      $d = (int) substr($val,6,2);
      $return_value = $return_value && ($y>2000);
      $return_value = $return_value && ($m>=1 && $m<=12);
      $return_value = $return_value && ($d>=1 && $d<=31);
    } else $return_value = array(false,'0','0');
    return array($return_value,substr($val,0,4),substr($val,4,2),substr($val,6,2));
  }

  function getJsonDay($image,$date) {
  	switch (strlen($date)) {
  	  case 0:
  	  	  list($y,$m,$d) = explode('/',$image);
  	  	  break;
  	  case 4:
  	  	  $y = $date;
  	  	  list($m,$d) = explode('/',$image);
  	  	  break;
  	  case 6:
  	  	  $y = substr($date,0,4);
  	      $m = substr($date,4,2);
  	      $d = substr($image,0,2);
  	      break;
  	  case 8:
  	      $y = substr($date,0,4);
  	      $m = substr($date,4,2);
  	      $d = substr($date,6,2);
  	      break;
  	}
  	return $y.$m.$d;
  }
  
  function getJsonTime($image,$date) {
  	switch (strlen($date)) {
  	  case 0:
  	  	  $time = substr($image,11,strlen($image)-16);
  	  	  break;
  	  case 4:
  	  	  $time = substr($image,7,strlen($image)-12);
  	  	  break;
  	  case 6:
  	      $time = substr($image,3,strlen($image)-8);
  	      break;
  	  case 8:
  	      $time = substr($image,0,strlen($image)-5);
  	      break;
  	}
  	return $time;
  }
  
  function json($st,$date) {
  	$images = $this->get_image_file_names($st,$date);
  	if (count($images)>0) {
  	  $js_text = '{';
  	  $hourList = '';
  	  $thisDay = $this->getJsonDay($images[0],$date);
  	  $arr_length = count($images);
      $i = 1;
      foreach($images as $key => $filename) {
        $nextDay = $this->getJsonDay($filename,$date);
        $minute = $this->getJsonTime($filename,$date);
        if ($nextDay == $thisDay && $key < ($arr_length-1)) {
          $hourList .= ($hourList == ''?'':',').'"'.$minute.'"';
        } else {
          if ($key == ($arr_length-1)) {
            if ($nextDay == $thisDay)
              $hourList .= ($hourList == ''?'':',').'"'.$minute.'"';
             else {
              $js_text .= '"'.$i.'": { day: "'.$thisDay.'", files: ['.$hourList.'] }'."\n";
              $i++;
              $thisDay = $nextDay;
              $hourList = '"'.$minute.'"';
            }
          }
          $js_text .= '"'.$i.'": { "day": "'.$thisDay.'", "files": ['.$hourList.'] }'.
              ($key==($arr_length-1)?'':',')."\n";
          $i++;
          $thisDay = $nextDay;
          $hourList = '"'.$minute.'"';
        }
      }
      $js_text .= '}';
      //$js_text .= 'allDaysPictures.length = '.($i-1).';'."\n";
  	}
  	
  	header('Content-type:application/json;charset=utf-8');
  	echo utf8_encode($js_text);
  }
}

?>
