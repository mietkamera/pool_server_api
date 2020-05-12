<?php

class Player extends Controller {
	
  function __construct() {
  	parent::__construct();
  }
  
  function index() {
  	$this->view->render('player/index');
  }
  
  function help() {
  	require('controllers/help.php');
  	$this->view->help = new Help();
  	$this->view->render('header');
  	$this->view->render('player/help');
  	$this->view->render('footer');
  }

  function live($st,$parameter="") {
  	$param = array_map('trim',explode('.',$parameter));
  	$size = empty($param[0])?'':$param[0];
  	switch ($size) {
  	  case '512x384':
  	  case '640x480':
  	  case '768x576':
  	  case '800x600':
  	  case '1024x768':
  	  case '1280x720':
  	  case '2048x1536':
  	  	$this->view->resolution = $size;
  	    break;
  	  default:
  	  	$this->view->resolution = '768x576';
  	}
  	$this->view->shorttag = $st;
  	$this->view->render('player/header');
  	$this->view->render('player/live');
  	$this->view->render('footer');
  }
}

?>