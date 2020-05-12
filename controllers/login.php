<?php

class Login extends Controller {

  function __construct() {
    parent::__construct();
  }

  //
  // Ist der Shorttag gültig und wenn ja wird ein Passwort benötigt ?
  //
  function valid($st) {
  	$dirname = _SHORT_DIR_.'/'.$st;
  	$filename = _SHORT_DIR_.'/'.$st.'/.password';
  	$js_text = '{ "valid": '.($st!='' && is_dir($dirname)?'true':'false').",\n".
  	           '  "required":'.(is_file($filename)?'true':'false').'}';
  	header('Content-type:application/json;charset=utf-8');
  	echo utf8_encode($js_text);
  }
  
  //
  // Informationen über den Zustand der Sendeeinheit
  //
  function health($st) {
  	$dirname = _SHORT_DIR_.'/'.$st;
  	$success = 0;
  	$text = 'keine Information.';
  	$signal = '';
  	if ($st!='' && is_dir($dirname)) {
  	  require 'models/xml_model.php';
  	  $xml = new XML_Model;
  	  if (isset($xml->st[$st])) {
  	    $ip = $xml->st[$st]['ip'];
  	    $port = $xml->st[$st]['routerport'];
  	    $output = array();
        exec("/usr/bin/ping -c 1 $ip 2>&1",$output,$rs);
        if ($rs==0) {
          $success = 1;
          $text = 'Sendeeinheit erreichbar.';
          unset($output);
          $output = array();
          exec("/usr/bin/curl -1 -k -l --connect-timeout 30 --max-time 50 ".
            'https://'.$ip.':'.$port.'/cgi-bin/luci 2>/dev/null '.
            '| grep 3g | grep tr | cut -d \'>\' -f5 | cut -d \'<\' -f1',$output,$rs);
          if ($rs==0) {
            foreach($output as $txt)
              $signal .= ($signal!=''?' ':'').$txt;
          } else {
            $signal = 'Kann Signal-Info nicht finden.';
          }
        } else {
          $success = 0;
          $text = 'Kann Sendeeinheit nicht erreichen.';
        }
  	  }
  	}
  	$js_text = '{ "result": "'.$success.'", "text": "'.$text.'", "signal": "'.$signal.'" }';
  	header('Content-type:application/json;charset=utf-8');
  	echo utf8_encode($js_text);
  }

  //
  // Rendert den Login-Dialog
  //
  function auth($st,$redirect='') {
  	$this->view->shorttag = $st;
    $this->view->redirect = $redirect;
  	$this->view->render('header');
    $this->view->render('login/auth');
    $this->view->render('footer'); 
  }
  
  //
  // Rendert die Hile-Seite des Moduls
  //
  function help() {
  	require('controllers/help.php');
  	$this->view->help = new Help();
  	$this->view->render('header');
  	$this->view->render('login/help');
  	$this->view->render('footer');
  }

}

?>