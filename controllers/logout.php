<?php

class Logout extends Controller {
	
  function __construct() {
  	parent::__construct();
  	
  }
  
  function index($st,$redirect='') {
  	$this->view->shorttag = $st;
  	$this->view->redirect = $redirect;
  	$this->view->render('logout/index',1);
  }
  
  function help() {
  	require('controllers/help.php');
  	$this->view->help = new Help();
  	$this->view->render('header');
  	$this->view->render('logout/help');
  	$this->view->render('footer');
  }

}

?>