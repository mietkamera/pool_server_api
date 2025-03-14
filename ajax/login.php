<?php

  session_start();
  if (!isset($_SESSION['login_count'])) $_SESSION['login_count'] = 0;
  $_SESSION['login_count']++;
  
  /*
  if (++$_SESSION['login_count']>10) {
    echo 'ZU viele Loginversuche';
    return;
  }
  */
  
  require '../config/globals.php';
  require '../config/dbconfig.php';
 
  // sanitize user input data
  $st = isset($_POST['shorttag'])?strtolower(trim($_POST['shorttag'])):'';
  $shorttag = preg_match('/^[a-zA-Z0-9]+$/', $st)?substr($st,0,_DEFAULT_SHORTTAG_LENGTH_):'';

  $password = isset($_POST['password'])?trim($_POST['password']):'';
  $asadmin = isset($_POST['asadmin'])?trim($_POST['asadmin']):'normal';
  
  $result = "Nicht autorisiert";
  switch ($asadmin) {
    case 'admin':
      $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
      $db = new Database;
      if ($db->is_valid_admin_login($email,$password)){
          echo "ok"; // log in    
          $_SESSION['session_admin'] = rand();
          $_SESSION['login_count'] = 0;
        } else {
          echo "Email und/oder Passwort ist falsch"; 
        }
        return;

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
	              echo "ok"; // log in
	              $_SESSION['session_'.$shorttag.'_type'] = $typ;
	              $_SESSION['session_'.$shorttag] = rand();
                $_SESSION['login_count'] = 0;
	              return;
	            } else {
                error_log('login error 403 from '.$_SERVER['REMOTE_ADDR']);
	              echo "Das Passwort ist falsch";
	              return;
	            }
            }
	        }
	        if (!$found_user && $password=='') {
	          echo "ok"; // log in
	          $_SESSION['session_'.$shorttag.'_type'] = $typ;
	          $_SESSION['session_'.$shorttag] = rand();
	          return;
	        } 
        } else {
          if ($password=='') {
            echo "ok"; // log in
	          $_SESSION['session_'.$shorttag.'_type'] = 'user';
	          $_SESSION['session_'.$shorttag] = rand();
	          return;
          }
        }
        error_log('login error 403 from '.$_SERVER['REMOTE_ADDR']);
	      echo "Das Passwort ist falsch";
        return;
      }
      error_log('shorttag error 403 from '.$_SERVER['REMOTE_ADDR']);
      echo "Shorttag nicht vorhanden";
  } /* switch(asadmin) */

?>
