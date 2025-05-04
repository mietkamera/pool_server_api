<?php

  class Help extends Controller {
  	
	private $module,$method;
  	function __construct($module='help',$method='index') {
  	  parent::__construct();
  	  $this->module = $module;
  	  $this->method = $method;
  	}
  	
  	function index() {
  	  $this->view->help = $this;
  	  $this->view->render('header');
  	  $this->view->render('help/index');
  	  $this->view->render('footer');
  	}
  	
  	// Ich nutze eine eigene Methode zum Rendern innerhalb des Controllers
  	function render($name) {
  	  require('views/'.$name.'.php');
  	}
  	
  	public function render_module_help() {
  	  require 'models/help_model.php';
  	  $model = new Help_Model();
  	  $this->view->render('header');
  	  $this->view->render('help/header');
  	  $this->render_breadcrumb($this->module);
      if (is_file('views/'.$this->module.'/'.$this->method.'.php')) {
  	  	require 'views/'.$this->module.'/'.$this->method.'.php';
  	  }
  	  $this->view->render('help/footer');
  	  $this->view->render('footer');
  	}
  	
  	public function render_method_help() {
  	  require 'models/help_model.php';
  	  $model = new Help_Model();
  	  $this->view->render('header');
  	  $this->view->render('help/header');
  	  $this->render_breadcrumb($this->module,$this->method);
      if (is_file('views/help/'.$this->module.'/'.$this->method.'.php')) {
      	$this->view->module = $this->module;
      	$this->view->method = $this->method;
  	  	require 'views/help/'.$this->module.'/'.$this->method.'.php';
  	  }
  	  $class_methods = get_class_methods($this->module);
  	  if (is_array($class_methods) && count($class_methods)>1) {
  	    echo '    <hr />'."\n".'    <div class="row">'."\n";
  	    foreach ($class_methods as $method_name) {
  	      switch ($method_name) {
  	        case '__construct':
  	        case 'index':
  	        case 'help':
  	        case 'loadModel':
  	        case 'check_size':
  	        case 'encrypt_decrypt':
  	        case 'getShorttagDataFromFile':
  	        case 'get_image_file_names':
  	        case 'get_video_file_names':
  	        case 'check_date':
  	        case 'check_time':
  	        case 'check_mrtg_scope':
  	          break;
  	  	    default:
  	  	      if ($method_name!=$this->method) {
  	  	        echo '      <div class="col-md-3"><a href="'._URL_STUB_.'/'.$this->module.'/'.$method_name.'/help'.'">'.$method_name.'</a></div>'."\n";
  	  	      } else {
  	  	        echo '      <div class="col-3">'.$method_name.'</div>'."\n";
  	  	      }
  	  	  }
  	  	}
  	    echo '    </div>'."\n";
  	  }
  	  $this->view->render('help/footer');
  	  $this->view->render('footer');
  	}
  	
  	function help() {
  	  $this->index();
  	}
  	
  	function render_breadcrumb($module,$method='') {
  	  echo '<h3><a href="'._URL_STUB_.'/help">'._URL_STUB_.'</a>/'.
  	       ($method==''?'':'<a href="'._URL_STUB_.'/'.$module.'/help">').$module.($method==''?'':'</a>').
  	       ($method==''?'':'/<span class="text-danger">'.$method.'</span>').'</h3>';
  	}
 	
    function list_image_sizes() {
  	  $list = '';
  	  foreach ($this->valid_image_sizes as $val) {
        $list .= $val[0].' ('.$val[1].'), ';
      }
      echo substr($list,0,-2);
    }
  	

  }
?>