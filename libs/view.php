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

  	public function render_script_tag($name) {
  	  echo "\n".
  	       '<script type="text/javascript" src="'._URL_STUB_.'/views/'.$name.'.js"></script>'.
  	       "\n";
  	}
  	
  	public function render_direct($html) {
  	  echo $html;
  	}
  	
  }
  
?>