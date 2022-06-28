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
  	$this->view->print_information = isset($param[0])?$param[0]=='1'?1:0:0;

    $dirname = _SHORT_DIR_.'/'.$st;
  	if ($st!='' && is_dir($dirname)) {
  	  $this->view->shorttag = $st;
  	  $this->view->data = $this->model->getShorttagDataFromFile($st);
  	  $this->view->render('header');
  	  $this->view->render('webcam/last');
  	  if ($this->view->print_information) {
  	    $this->view->render_direct('<div class="col-12 col-lg-5 mt-3"><div class="row mx-2 mb-3">');
        $this->view->caption = 'Projekt | &Uuml;bersicht';
        $this->view->render('webcam/information-panel');
        $this->view->render_direct('</div></div>');
        $this->view->render_script_tag('webcam/class-information');
      }
  	  $this->view->render_script_tag('webcam/class-last');
  	  $this->view->render_script_tag('webcam/last');
  	} else {
      $this->view->render('header');
  	  $this->view->render('webcam/no_projekt');
  	}
  	$this->view->render('footer');
  }

  function live($st,$parameter='') {
    $param = array_map('trim',explode('.',$parameter));
    $size = $this->check_size(!isset($param[0]) || empty($param[0])?'640x480':$param[0]);
  	$this->view->autostart = !isset($param[1]) || $param[1]==''?0:$param[1]=='1'?1:0;
    $this->view->print_information = count($param)>2?isset($param[2])?$param[2]=='1'?1:0:0:0;
    
    $dirname = _SHORT_DIR_.'/'.$st;
  	if ($st!='' && is_dir($dirname)) {
  	  $this->view->shorttag = $st;
  	  $this->view->data = $this->model->getShorttagDataFromFile($st);
  	  $this->view->live_src = 'https://'.$_SERVER['SERVER_NAME']._URL_STUB_.'/image/live/'.$st.'/'.$size;
  	  $this->view->render('header');
  	  $this->view->render('webcam/live');
  	  if ($this->view->print_information) {
  	    $this->view->render_direct('<div class="col-12 col-lg-5 mt-3"><div class="row mx-2 mb-3">');
        $this->view->caption = 'Projekt | &Uuml;bersicht';
        $this->view->render('webcam/information-panel');
        $this->view->render_direct('</div></div>');
        $this->view->render_script_tag('webcam/class-information');
      }
  	  $this->view->render_script_tag('webcam/class-live');
  	  $this->view->render_script_tag('webcam/live');
  	} else {
      $this->view->render('header');
  	  $this->view->render('webcam/no_projekt');
  	}
  	$this->view->render('footer');
  }

  function archiv($st,$parameter='') {
    $param = array_map('trim',explode('.',$parameter));
  	$this->view->print_information = isset($param[0])?$param[0]=='1'?1:0:0;

    $dirname = _SHORT_DIR_.'/'.$st;
  	if ($st!='' && is_dir($dirname)) {
  	  $this->view->shorttag = $st;
  	  $this->view->data = $this->model->getShorttagDataFromFile($st);
  	  $this->view->render('header');
  	  $this->view->render('webcam/archiv');
  	  if ($this->view->print_information) {
  	    $this->view->render_direct('<div class="col-12 col-lg-5 mt-3"><div class="row mx-2 mb-3">');
        $this->view->caption = 'Projekt | &Uuml;bersicht';
        $this->view->render('webcam/information-panel');
        $this->view->render_direct('</div></div>');
        $this->view->render_script_tag('webcam/class-information');
      }
  	  $this->view->render_script_tag('webcam/class-archiv');
  	  $this->view->render_script_tag('webcam/archiv');
  	} else {
      $this->view->render('header');
  	  $this->view->render('webcam/no_projekt');
  	}
  	$this->view->render('footer');
  }
  
  function video($st,$parameter='') {
    $param = array_map('trim',explode('.',$parameter));
    $this->view->video_size = count($param)>0?empty($param[0])?'hd':$param[0]:'hd';
  	$this->view->video_controls = count($param)>1?(($param[1]=='' || $param[1]=='1')?true:false):true;
  	$this->view->print_information = count($param)>2?isset($param[2])?$param[2]=='1'?1:0:0:0;

    $dirname = _SHORT_DIR_.'/'.$st;
  	if ($st!='' && is_dir($dirname)) {
  	  $this->view->shorttag = $st;
  	  $this->view->data = $this->model->getShorttagDataFromFile($st);
  	  $this->view->render('header');
  	  $this->view->render('webcam/video');
  	  if ($this->view->print_information) {
  	    $this->view->render_direct('<div class="col-12 col-lg-5 mt-3"><div class="row mx-2 mb-3">');
        $this->view->caption = 'Projekt | &Uuml;bersicht';
        $this->view->render('webcam/information-panel');
        $this->view->render_direct('</div></div>');
        $this->view->render_script_tag('webcam/class-information');
      }
  	  $this->view->render_script_tag('webcam/class-video');
  	  $this->view->render_script_tag('webcam/video');
  	} else {
      $this->view->render('header');
  	  $this->view->render('webcam/no_projekt');
  	}
  	$this->view->render('footer');
  }

  function projekt($st,$parameter='') {
    $param = array_map('trim',explode('.',$parameter));
    $size = $this->check_size(!isset($param[0]) || empty($param[0])?'640x480':$param[0]);
  	$this->view->print_information = count($param)>0?($param[0]=='' || $param[0]=='1')?1:0:1;
  	$this->view->print_weather = count($param)>1?($param[1]=='' || $param[1]=='1')?1:0:1;

  	$dirname = _SHORT_DIR_.'/'.$st;
  	if ($st!='' && is_dir($dirname)) {
  	  $this->view->shorttag = $st;
  	  $this->view->data = $this->model->getShorttagDataFromFile($st);
  	  $this->view->live_src = 'https://'.$_SERVER['SERVER_NAME']._URL_STUB_.'/image/live/'.$st.'/'.$size;
  	  $this->view->video_size = 'hd';
  	  $this->view->video_controls = true;
  	  $this->view->render('header');
  	  $this->view->render('webcam/projekt');
  	  if (($this->view->print_information + $this->view->print_weather)>0) {
  	    $this->view->render_direct('<div class="col-12 col-lg-5 mt-3"><div class="row mx-2 mb-3">');
  	    if ($this->view->print_information) {
          $this->view->caption = 'Projekt | &Uuml;bersicht';
          $this->view->render('webcam/information-panel');
          $this->view->render_script_tag('webcam/class-information');
        }
        $this->view->render_direct('</div><div class="row mx-2">');
  	    if ($this->view->print_weather) {
          $this->view->render('weather/weather-panel');
  	    }
  	    $this->view->render_direct('</div></div>');
  	  }
  	  $this->view->render_script_tag('webcam/class-archiv');
  	  $this->view->render_script_tag('webcam/class-video');
  	  
  	  if ($this->view->data['allow_live']=="true") 
  	    $this->view->render_script_tag('webcam/class-live');
  	  $this->view->render_script_tag('webcam/projekt');
  	} else {
      $this->view->render('header');
  	  $this->view->render('webcam/no_projekt');
  	}
  	$this->view->render('footer');
  }
  
}

?>