<?php

class Login extends Controller {

  function __construct() {
    parent::__construct();
  }

  //
  // Ist der Shorttag gültig und wenn ja wird ein Passwort benötigt ?
  //
  function need_validation($st) {
  	$dirname = _SHORT_DIR_.'/'.$st;
  	$filename = _SHORT_DIR_.'/'.$st.'/.password';
  	if ($st!='' && is_dir($dirname)) {
  	  if (is_file($filename)) {
  	    $data = [ "returncode" => "200",
                  "api_ver"    => _VERSION_,
                  "message"    => "login required" 
                ];
  	  } else {
  	    $data = [ "returncode" => "201",
                  "api_ver"    => _VERSION_,
                  "message"    => "no login required" 
                ];
  	  }
  	} else {
  	  $data = [ "returncode" => "501",
                "api_ver"    => _VERSION_,
                "message"    => "invalid shorttag" 
              ];
  	}
  	header('Content-Type: application/json');
  	echo json_encode($data);
  }
  
  function login($st) {
    if (isset($_POST)) {
      if (isset($_POST['password'])) {
        if ($st!='' && is_dir(_SHORT_DIR_.'/'.$st)) {
          if (is_file(_SHORT_DIR_.'/'.$st.'/.password')) {
          	$found = false;
            $inhalt = explode("\n",file_get_contents(_SHORT_DIR_.'/'.$st.'/.password'));
            foreach($inhalt as $zeile) {
              list($typ,$pass) = explode(':',$zeile);
              if ($password==$pass) {
	            $found = true;
                $_SESSION['session_'.$shorttag.'_type'] = $typ;
	            $_SESSION['session_'.$shorttag] = rand();
	            break;
	          }
	        }
            $data = [ "returncode" => ($found?"200":"401"),
                      "api_ver"    => _VERSION_,
                      "message"    => "Login ".($found?'success':'failed')
                    ];
          } else {
            $data = [ "returncode" => "200",
                      "api_ver"    => _VERSION_,
                      "message"    => "Login failed (invalid shorttag)"
                    ];
          }
        } else {
          $data = [ "returncode" => "501",
  	                "api_ver"    => _VERSION_,
                    "message"    => "Login failed (invalid shorttag)"
                  ];
        }
      } else {
  	  $data = [ "returncode" => "401",
  	            "api_ver"    => _VERSION_,
                "message"    => "Login failed (no credentials sent)"
              ];
      }
    } else {
  	  $data = [ "returncode" => "501",
  	            "api_ver"    => _VERSION_,
                "message"    => "Login failed (use POST to send credentials)"
              ];
    }
  	header('Content-Type: application/json');
  	echo json_encode($data);
  } 
  
  //
  // Rendert den Login-Dialog
  //
  function auth($st,$redirect='') {
  	$this->view->shorttag = $st;
    $this->view->redirect = $redirect;
  	$this->view->render('header');
    $this->view->render('login/auth');
    $this->view->render('footer'); 
  }

  //
  // Rendert den Login-Dialog fuer den Operator
  //
  function auth_op($st,$redirect='') {
  	$this->view->shorttag = $st;
    $this->view->redirect = $redirect;
  	$this->view->render('header');
    $this->view->render('login/auth_op');
    $this->view->render('footer'); 
  }
  
  //
  // Rendert die Hile-Seite des Moduls
  //
  function help() {
  	require('controllers/help.php');
  	$this->help = new Help('login','help');
  	$this->help->render_module_help();
  }

}

?>