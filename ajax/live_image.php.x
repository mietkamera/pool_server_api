<?php
  session_start();
  
  require '../libs/view.php';
  require '../libs/controller.php';
  require 'xml_model.php';
  
  $controller = new Controller();
  
  $st = !empty($_REQUEST['st'])?$_REQUEST['st']:'';
  $size = $controller->check_size(!empty($_REQUEST['size'])?$_REQUEST['size']:'');
 
  $xmldata = new XML_Model(); 
  if ($st!='' && isset($xmldata->st[$st])) {
  	if (!is_file('../'._SHORT_DIR_.'/'.$st.'/.password') || 
      (is_file('../'._SHORT_DIR_.'/'.$st.'/.password') && isset($_SESSION['session_'.$shorttag]))) {
      
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
    
        $result = curl_exec($ch);
        $rescode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($rescode=='200') {
          header("Content-Type: image/jpeg");
          echo $result;
          return;
        } else $text = 'Sorry :-('."\n".'Kein Livebild vorhanden!'."\n\n".'Die Webcam ist nicht erreichbar.';
      } else $text = 'Sorry :-('."\n".'Kein Livebild vorhanden!'."\n\n".'Die Webcam ist nicht aktiv.';
    } else $text = 'Sorry :-('."\n".'Kein Livebild vorhanden!'."\n\n".'Sie sind nicht angemeldet.';
  } else $text = 'Sorry :-('."\n".'Kein Livebild vorhanden!'."\n\n".'Shorttag existiert nicht.';
    
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
  
?>