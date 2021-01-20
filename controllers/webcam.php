<?php

class Webcam extends Controller {
	
  function __construct() {
  	parent::__construct();
  }
  
  function projekt($st) {
  	$this->view->render('webcam/projekt-cookie');
  	$dirname = _SHORT_DIR_.'/'.$st;
  	if ($st!='' && is_dir($dirname)) {
  	  $this->view->shorttag = $st;
  	  $pfilename = $dirname.'/description.js';
  	  if (is_file($pfilename)) {
  	    $strJsonFileContents = file_get_contents($pfilename);
  	    $description = json_decode($strJsonFileContents, true);
  	    $this->view->title = $description['projekt'].' '.$description['name']; 
  	  }
  	  $this->view->render('header');
  	  $this->view->render('webcam/projekt');
  	} else {
      $this->view->render('header');
  	  $this->view->render('webcam/no_projekt');
  	}
  	$this->view->render('footer');
  }
  
  function valid($st) {
  	$dirname = _SHORT_DIR_.'/'.$st;
  	$filename = _SHORT_DIR_.'/'.$st.'/.password';
  	$js_text = '{ "valid": '.($st!='' && is_dir($dirname)?'true':'false').",\n".
  	           '  "required":'.(is_file($filename)?'true':'false').'}';
  	header('Content-type:application/json;charset=utf-8');
  	echo utf8_encode($js_text);
  }

  function index() {
  	$this->view->render('webcam/index');
  }

  function help() {
  	require('controllers/help.php');
  	$this->help = new Help('webcam','help');
  	$this->help->render_module_help();
  }
  
}

?>