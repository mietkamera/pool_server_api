<?php
  class Bootstrap {
  	
  	function __construct() {
  	  
  	  session_start();

      // this is a get method call of the website
      // we use this session vars to implement a simple csrf token mechanism 
  	  $_SESSION['token'] = bin2hex(random_bytes(32));
      $_SESSION['token-expire'] = time() + 60 * 60;

      // sanitize $_GET variable url
      $sanitized_url = rtrim((isset($_GET['url'])?$_GET['url']:null),'/');
      
      if (!is_null($sanitized_url) && $sanitized_url!='' && !preg_match('/^[a-zA-Z0-9-_:.\/]+$/', $sanitized_url)) {
        require 'controllers/error.php';
        $controller = new MyError();
        $controller->page('400');
        return false;
      }

      // von welchen URLs aus kann man ohne Passwort Daten abrufen 
  	  $this->dbc = new Database;      
      $validip = $this->dbc->is_valid_ip($sanitized_url);
      
      $url = explode('/',$sanitized_url);

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
      	$controller->page('404');
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
      $method    = empty($url[1])?'help':$url[1];
      $shorttag  = empty($url[2])?'':substr($url[2],0,_DEFAULT_SHORTTAG_LENGTH_);
      $parameter = !isset($url[3])?'':$url[3];

      if (!$validip && $module!='login' && $module!='publish') {
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
      } else if (!$validip && $module!='publish') $parameter = '';
      
      if ($shorttag=='help' || ($method!='help' && $shorttag=='')) {
      	require 'controllers/help.php';
      	$controller = new Help($module,$method);
      	$controller->render_method_help();
      	return false;
      }

      if (method_exists($controller,$method)) {
        if ($shorttag=='' || strlen($shorttag)==6)
          $controller->$method($shorttag,$parameter);
         else {
           require 'controllers/error.php';
      	   $controller = new MyError();
      	   $controller->page('500');
           return false;
         }
      } else {
       	require 'controllers/error.php';
      	$controller = new MyError();
      	$controller->page('404');
      	return false;
      }
        
  	}
  }
?>
