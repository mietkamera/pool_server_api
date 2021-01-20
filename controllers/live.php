<?php

class Live extends Controller {
	
  function __construct() {
  	parent::__construct();
  }
  
  function index() {
  	$this->view->render('live/index');
  }
  
  function help() {
  	require('controllers/help.php');
  	$this->help = new Help('live','help');
  	$this->help->render_module_help();
  }

  function player($st,$parameter="") {
  	$param = array_map('trim',explode('.',$parameter));
  	$size = $this->check_size(empty($param[0])?'':$param[0]);
  	$this->view->resolution = $size==''?'800x600':$size;
  	switch(empty($param[1])?'1':$param[1]) {
  	  case '0':
  	  case 'false':
  	  	$this->view->autoplay = false;
  	  	break;
  	  case '1':
  	  case 'true':
  	  default:
  	  	$this->view->autoplay = true;
  	}
  	$this->view->div = empty($param[2])?'':$param[2];
   	$this->view->shorttag = $st;
  	$this->view->render('live/header');
  	$this->view->render('live/player');
  	$this->view->render('footer');
  }
  
  
}

?>