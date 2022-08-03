<?php

class Impressum extends Controller {
	
  function __construct() {
  	parent::__construct();
  	
  }
  
  function index() {
  	$this->view->render('header');
  	$this->view->render('help/impressum');
  	$this->view->render('footer');
  }
  
  function help() {
  	require('controllers/help.php');
  	$this->help = new Help('mjpeg','help');
  	$this->help->render_module_help();
    
  }
  
}

?>