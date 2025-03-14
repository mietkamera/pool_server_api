<?php

  session_start();
  
  require '../config/globals.php';
  require '../config/dbconfig.php';
 

  $shorttag = isset($_POST['shorttag'])?strtolower(trim($_POST['shorttag'])):'';
  $password = isset($_POST['password'])?trim($_POST['password']):'';
  $asadmin = isset($_POST['asadmin'])?trim($_POST['asadmin']):'normal';
  
  $result = "Nicht autorisiert";
  switch ($asadmin) {
    case 'admin':
      $email = trim($_POST['email']);
      try {
        $db_con = new PDO("mysql:host={$db_host};dbname={$db_name}",$db_user,$db_pass);
        $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $db_con->prepare("SELECT * FROM users WHERE user_email=:email");
        $stmt->execute(array(":email"=>$email));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();
        if ($row['user_password']==md5($password)){
          echo "ok"; // log in    
          $_SESSION['session_admin'] = rand();
        } else {
          echo "Email und/oder Passwort ist falsch"; 
        }
        return;
      }

      catch(PDOException $e) {
        echo $e->getMessage();
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
	            echo "ok"; // log in
	            $_SESSION['session_'.$shorttag.'_type'] = $typ;
	            $_SESSION['session_'.$shorttag] = rand();
	            return;
	          } else {
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
	    echo "Das Passwort ist falsch";
      } echo "Shorttag nicht vorhanden";
  } /* switch(asadmin) */

?>
