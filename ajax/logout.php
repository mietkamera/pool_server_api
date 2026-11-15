<?php

session_start();
if (filter_has_var(INPUT_POST, 'token')) {
  $token = $_POST['token'];
  if (!$token || $token !== $_SESSION['token']) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    exit;
  }
} else {
  header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
  exit;
}

$shorttag = isset($_POST['shorttag']) ? trim($_POST['shorttag']) : (isset($_GET['shorttag']) ? $_GET['shorttag'] : '');

$destroy = false;
if ($shorttag != '') {
  if (isset($_SESSION['session_' . $shorttag])) {
    unset($_SESSION['session_' . $shorttag]);
    $destroy = true;
  }
} else {
  if (isset($_SESSION['session_admin'])) {
    unset($_SESSION['session_admin']);
    foreach ($_SESSION as $key => $val) {
      if (strpos($key, 'session_')) unset($_SESSION[$key]);
    }
    $destroy = true;
  }
}
if ($destroy) {
  session_destroy();
  $data = array('returncode' => 200, 'message' => 'session destroyed');
} else {
  $data = array('returncode' => 500, 'message' => 'no session destroyed');
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
return false;