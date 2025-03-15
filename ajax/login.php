<?php

  session_start();

  require '../config/globals.php';
  require '../config/dbconfig.php';
 
  $data = array('returncode'=>500,'message'=>'bad request');
  // first handle the csrf stuff
  
  $error_count = 0;
  if (!isset($_POST['token'])) $error_count++;
  if (!isset($_SESSION['token'])) $error_count++;
  if ($error_count == 0) {
    $token = filter_var($_POST['token'],FILTER_SANITIZE_STRING); 
    if ($token !== $_SESSION['token']) { $error_count++; } else {
      if (!isset($_SESSION['token-expire'])) { $error_count++; } else { 
        if ($_SESSION['token-expire'] < time()) $error_count++; 
      }
    };

  }
  if ($error_count > 0) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    return false;
  }
  
  // handle dos attacks
  if (!isset($_SESSION['login_count'])) $_SESSION['login_count'] = 0;
  $_SESSION['login_count']++;
  if ($_SESSION['login_count'] > _MAX_LOGIN_ATTEMPTS_) {
    if (!isset($_SESSION['login-count-expire'])) {
      $_SESSION['login-count-expire'] = time() + 5 * 60;
    }
    if (time() < $_SESSION['login-count-expire']) {
      $data = array('returncode'=>300,'message'=>'zu viele Loginversuche / gesperrt bis '.
                    date('H:i:s',$_SESSION['login-count-expire']));
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode($data);
      return false;
    } else unset($_SESSION['login-count-expire']);
  }

  // sanitize user input data
  $st = isset($_POST['shorttag'])?strtolower(trim($_POST['shorttag'])):'';
  $shorttag = preg_match('/^[a-zA-Z0-9]+$/', $st)?substr($st,0,_DEFAULT_SHORTTAG_LENGTH_):'';

  $password = isset($_POST['password'])?trim($_POST['password']):'';
  $asadmin = isset($_POST['asadmin'])?trim($_POST['asadmin']):'normal';
  
  switch ($asadmin) {
    case 'admin':
      $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
      $db = new Database;
      if ($db->is_valid_admin_login($email,$password)) {
        $data = array('returncode'=>200,'message'=>'admin login successful');
        $_SESSION['session_admin'] = rand();
      } else {
        $data = array('returncode'=>400,'message'=>'falsche Zugangsdaten'); 
      }
      break;
    case 'normal':
    default:
      if (is_dir(_SHORT_DIR_.'/'.$shorttag)) {
        if (is_file(_SHORT_DIR_.'/'.$shorttag.'/.password')) {
          $inhalt = explode("\n",file_get_contents(_SHORT_DIR_.'/'.$shorttag.'/.password'));
          $found_user = false;
          foreach($inhalt as $zeile) {
            list($typ,$pass) = explode(':',$zeile);
            if ($typ=='user') {
              $found_user = true;
              if (md5($password)==$pass || $password==$pass) {
                $data = array('returncode'=>200,'message'=>'login successful');
                $_SESSION['session_'.$shorttag.'_type'] = $typ;
	              $_SESSION['session_'.$shorttag] = rand();
	            } else {
                error_log('login error 403 from '.$_SERVER['REMOTE_ADDR']);
                $data = array('returncode'=>300,'message'=>'falsche Zugangsdaten');
	            }
            }
	        }
	        if (!$found_user && $password=='') {
	          $data = array('returncode'=>200,'message'=>'login successful');
	          $_SESSION['session_'.$shorttag.'_type'] = $typ;
	          $_SESSION['session_'.$shorttag] = rand();
	        } 
        } else {
          if ($password=='') {
            $data = array('returncode'=>200,'message'=>'login successful');
	          $_SESSION['session_'.$shorttag.'_type'] = 'user';
	          $_SESSION['session_'.$shorttag] = rand();
          }
        }
      } else {
        error_log('shorttag error 403 from '.$_SERVER['REMOTE_ADDR']);
        $data = array('returncode'=>500,'message'=>'bad data');
      }
  } /* switch(asadmin) */


  if ($data['returncode'] == 200) {
    unset($_SESSION['token']);
    unset($_SESSION['token-expire']);
    unset($_SESSION['login-count']);
    if (isset($_SESSION['login-count-expire'])) unset($_SESSION['login-count-expire']);
  }
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode($data);
  return false;

?>
