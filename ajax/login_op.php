<?php

  session_start();
  require '../globals.php';
  require '../dbconfig.php';
 

  $shorttag = trim($_POST['shorttag']);
  $user_password = trim($_POST['password']);
  $json_text = '{ "return": "500", "message": "Unbekannter Fehler" }';
  if ($user_password!='') {
    $password = md5($user_password);
    $asadmin = isset($_POST['asadmin'])?trim($_POST['asadmin']):'normal';
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
          if ($row['user_password']==$password){
            $json_text = '{ "return": "200", "message": "Login als Administrator" }';
            $_SESSION['session_admin'] = rand();
          } else {
            $json_text = '{ "return": "400", "message": "Email und/oder Passwort ist falsch" }'; 
          }
          return;
        }

        catch(PDOException $e){
          echo $e->getMessage();
        }

        break;
      case 'normal':
      default:
        $inhalt = explode("\n",file_get_contents('../'._SHORT_DIR_.'/'.$shorttag.'/.password'));
        $json_text = '{ "return": "400", "message": "Email und/oder Passwort ist falsch" }';
        foreach($inhalt as $zeile) {
          list($typ,$pass) = explode(':',$zeile);
          if ($password==$pass && $typ=='operator') {
	        $json_text = '{ "return": "202", "message": "Login als Operator" }';
	        $_SESSION['session_'.$shorttag.'_type'] = $typ;
	        $_SESSION['session_'.$shorttag] = rand();
	        break;
	      }
	    }
    }
  }
  header('Content-type:application/json;charset=utf-8');
  echo utf8_encode($json_text);
?>
