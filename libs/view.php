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
  	
  	public function enable_cors($origin='') {
      // Allow from any origin
      if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
      }

      // Access-Control headers are received during OPTIONS requests
      if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
      }
  	}

  }
  
?>