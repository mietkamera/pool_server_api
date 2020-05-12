<?php 
  $destroy = false;
  $shorttag = $this->shorttag;
  $redirect = $this->redirect;
  if ($shorttag!='') {
    if (isset($_SESSION['session_'.$shorttag])) { 
	  unset($_SESSION['session_'.$shorttag]);
	  $destroy = true;
    }
  } else {
    if (isset($_SESSION['session_admin'])) {
      unset($_SESSION['session_admin']);
      foreach($_SESSION as $key => $val) {
      	if (strpos($key,'session_')) unset($_SESSION[$key]);
      }
      $destroy = true;
    }
  }
  if($destroy && session_destroy()) {
	if ($redirect!='') header("Location: ".$_SERVER['HTTP_REFERER']);
  }
?>