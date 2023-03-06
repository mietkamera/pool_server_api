<?php

  class MyError extends Controller {
  	
  	function __construct() {
  	  parent::__construct();
  	}
  	
  	function page($code='500') {
      $this->view->render('header');
  	  $this->view->render('error/intro');
  	  $this->view->render('error/page_'.$code);
  	  $this->view->render('footer');
  	}

  	function index() {
	  $this->page('500');
  	}

  }
?>