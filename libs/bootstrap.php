<?php
  class Bootstrap {
  	
  	function __construct() {
  	  session_start();
	  $url = explode('/',rtrim((isset($_GET['url'])?$_GET['url']:null),'/'));
      
      if (empty($url[0])) {
        require 'controllers/index.php';
        $controller = new Index();
        $controller->index();
        return false;
      }
      
  	  $file = 'controllers/'.$url[0].'.php';

      if (file_exists($file)) {
        require $file;
      } else {
      	require 'controllers/error.php';
      	$controller = new MyError();
      	$controller->index();
      	return false;
      }
      
      $controller = new $url[0];
      
      if ($url[0]=='logout') {
      	$shorttag = empty($url[1])?'':$url[1];
      	$redirect = empty($url[2])?'':urldecode($url[2]);
      	$controller->index($shorttag,$redirect);
      	return false;
      }
      
      $controller->loadModel($url[0]);
      
      $module    = $url[0];
      $method = empty($url[1])?'help':$url[1];
      $shorttag  = empty($url[2])?'':$url[2];
      $parameter = empty($url[3])?'':$url[3];
      
      if ($module!='login') {
        if ($shorttag!='' && is_file(_SHORT_DIR_.'/'.$shorttag.'/.password') && 
                 (strpos(file_get_contents(_SHORT_DIR_.'/'.$shorttag.'/.password'),'user:') !== false) &&
                 !(isset($_SESSION['session_'.$shorttag]) || isset($_SESSION['session_admin'])) ) {
          // Falls die login-Methode nicht direkt aufgerufen wird,
          // Basteln wir uns die redirect-URL aus der $_GET['url']-Variable
          require 'controllers/login.php';
    	  $controller = new Login();
      	  $controller->auth($shorttag,$_GET['url']);
      	  return false;
        }
      } else $parameter = '';
      
      if ($shorttag=='help' || ($method!='help' && $shorttag=='')) {
      	require 'controllers/help.php';
      	$controller = new Help($module,$method);
      	$controller->render_method_help();
      	return false;
      }
      
      $controller->$method($shorttag,$parameter);

  	}
  }
?>