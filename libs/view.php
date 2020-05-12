<?php

  class View {
  	
  	function __construct() {
  	  $this->httpRoot = 'https://'.$_SERVER["SERVER_NAME"].
  	         substr($_SERVER["PHP_SELF"],0,strlen($_SERVER["PHP_SELF"])-10).
  	         '/';
  	  $this->srcRoot = $_SERVER["DOCUMENT_ROOT"].
  	                   substr($_SERVER["PHP_SELF"],0,strlen($_SERVER["PHP_SELF"])-10).'/';
  	}
  	
  	public function render($name) {
  	  require($this->srcRoot.'views/'.$name.'.php');
  	}
  }
  
?>