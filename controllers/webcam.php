<?php

class Webcam extends Controller {
	
  function __construct() {
  	parent::__construct();
  }
  
  function index() {
  	$this->view->render('webcam/index');
  }

  function help() {
  	require('controllers/help.php');
  	$this->help = new Help('webcam','help');
  	$this->help->render_module_help();
  }
  
  function last($st,$parameter='') {
    $param = array_map('trim',explode('.',$parameter));
  	$this->view->print_information = isset($param[0]) && ($param[0]=='' || $param[0]=='1')?1:0;

    $dirname = _SHORT_DIR_.'/'.$st;
  	if ($st!='' && is_dir($dirname)) {
  	  $this->view->shorttag = $st;
  	  $this->view->data = $this->getShorttagDataFromFile($st);
  	  $this->view->render('header');
  	  $this->view->render('webcam/last');
  	  $this->view->render('webcam/last-class-js');
  	  $this->view->render('webcam/information-class-js');
  	  $this->view->render('webcam/last-ready-js');
  	} else {
      $this->view->render('header');
  	  $this->view->render('webcam/no_projekt');
  	}
  	$this->view->render('footer');
  }

  function live($st,$parameter='') {
    $param = array_map('trim',explode('.',$parameter));
    $size = $this->check_size(!isset($param[0]) || empty($param[0])?'640x480':$param[0]);
  	$this->view->print_information = !isset($param[1])?1:($param[1]=='' || $param[1]=='1')?1:0;
    $this->view->autostart         = !isset($param[2])?1:($param[2]=='' || $param[2]=='1')?1:0;
    
    $dirname = _SHORT_DIR_.'/'.$st;
  	if ($st!='' && is_dir($dirname)) {
  	  $this->view->shorttag = $st;
  	  $this->view->data = $this->getShorttagDataFromFile($st);
  	  $this->view->live_src = 'https://'.$_SERVER['SERVER_NAME']._URL_STUB_.'/image/live/'.$st.'/'.$size;
  	  $this->view->render('header');
  	  $this->view->render('webcam/live');
  	  $this->view->render('webcam/live-class-js');
  	  $this->view->render('webcam/information-class-js');
  	  $this->view->render('webcam/live-ready-js');
  	} else {
      $this->view->render('header');
  	  $this->view->render('webcam/no_projekt');
  	}
  	$this->view->render('footer');
  }

  function archiv($st,$parameter='') {
    $param = array_map('trim',explode('.',$parameter));
  	$this->view->print_information = isset($param[0]) && ($param[0]=='' || $param[0]=='1')?1:0;

    $dirname = _SHORT_DIR_.'/'.$st;
  	if ($st!='' && is_dir($dirname)) {
  	  $this->view->shorttag = $st;
  	  $this->view->data = $this->getShorttagDataFromFile($st);
  	  $this->view->render('header');
  	  $this->view->render('webcam/archiv');
  	  $this->view->render('webcam/archiv-class-js');
  	  $this->view->render('webcam/information-class-js');
  	  $this->view->render('webcam/archiv-ready-js');
  	} else {
      $this->view->render('header');
  	  $this->view->render('webcam/no_projekt');
  	}
  	$this->view->render('footer');
  }
  
  function video($st,$parameter='') {
    $param = array_map('trim',explode('.',$parameter));
  	$this->view->print_information = isset($param[0]) && ($param[0]=='' || $param[0]=='1')?1:0;

    $dirname = _SHORT_DIR_.'/'.$st;
  	if ($st!='' && is_dir($dirname)) {
  	  $this->view->shorttag = $st;
  	  $this->view->data = $this->getShorttagDataFromFile($st);
  	  $this->view->render('header');
  	  $this->view->render('webcam/video');
  	  $this->view->render('webcam/video-class-js');
  	  $this->view->render('webcam/video-ready-js');
  	} else {
      $this->view->render('header');
  	  $this->view->render('webcam/no_projekt');
  	}
  	$this->view->render('footer');
  }

  function projekt($st,$parameter='') {
    $param = array_map('trim',explode('.',$parameter));
  	$this->view->print_information = isset($param[0]) && ($param[0]=='' || $param[0]=='1')?1:0;

  	$dirname = _SHORT_DIR_.'/'.$st;
  	if ($st!='' && is_dir($dirname)) {
  	  $this->view->shorttag = $st;
  	  $this->view->data = $this->getShorttagDataFromFile($st);
  	  $this->view->live_src = 'https://'.$_SERVER['SERVER_NAME']._URL_STUB_.'/image/live/'.$st.'/';
  	  $this->view->render('header');
  	  $this->view->render('webcam/projekt');
  	  $this->view->render('webcam/archiv-class-js');
  	  $this->view->render('webcam/live-class-js');
  	  $this->view->render('webcam/video-class-js');
  	  $this->view->render('webcam/information-class-js');
  	  $this->view->render('webcam/projekt-ready-js');
  	} else {
      $this->view->render('header');
  	  $this->view->render('webcam/no_projekt');
  	}
  	$this->view->render('footer');
  }
  
}

?>