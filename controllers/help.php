<?php

  class Help extends Controller {
  	
  	function __construct() {
  	  parent::__construct();
  	}
  	
  	function index() {
  	  $this->view->help = $this;
  	  $this->view->render('header');
  	  $this->view->render('help/index');
  	  $this->view->render('footer');
  	}
  	
  	public function load_topic($module,$operation) {
  	  require 'models/help_model.php';
  	  $model = new Help_Model();
  	  if (is_file('views/help/'.$module.'/'.$operation.'.php')) {
  	  	$this->view->render('header');
  	  	echo '<div class="container-fluid">'.
  	  	     '<h1>HTTP-API</h1><h6><small class="text-muted">Version '._VERSION_.'</small></h6>';
  	  	$this->render_breadcrumb($module,$operation);
  	  	require 'views/help/'.$module.'/'.$operation.'.php';
  	    $this->view->render('footer');
  	    echo '</div>';
  	  }
  	}
  	
  	function help() {
  	  $this->index();
  	}
  	
  	function render_breadcrumb($module,$method='') {
  	  echo '<h3><a href="'._URL_STUB_.'/help">'._URL_STUB_.'</a>/'.
  	       ($method==''?'':'<a href="'._URL_STUB_.'/'.$module.'/help">').$module.($method==''?'':'</a>').
  	       ($method==''?'':'/<span class="text-danger">'.$method.'</span>').'</h3>';
  	}
  }
?>