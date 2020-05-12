<?php

  class MyError extends Controller {
  	
  	function __construct() {
  	  parent::__construct();
  	}
  	
  	function index() {
	  $this->view->msg = "Diese Seite existiert nicht";
  	  $this->view->render('error/index');
  	}
  }
?>