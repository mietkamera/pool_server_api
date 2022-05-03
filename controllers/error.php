<?php

  class MyError extends Controller {
  	
  	function __construct() {
  	  parent::__construct();
  	}
  	
  	function index() {
	  $this->view->msg = "Diese Seite existiert nicht";
  	  $this->view->render('error/index');
  	}
  	
  	function bad_shorttag() {
	  $this->view->msg = "Der Shorttag ist ung&uuml;ltig";
  	  $this->view->render('error/index');
  	}
  }
?>