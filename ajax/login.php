<?php

session_start();

require '../config/globals.php';
require '../config/dbconfig.php';
require '../libs/database.php';
require '../libs/session.php';

$data = ['returncode' => 500, 'message' => 'bad request'];
$sh = new Session();

// if login comes from our websites, you don't need csrf token
//$need_csrf_validation = _NEED_CSRF_VALIDATION_;
//$valid_url_without_csrf_token = array('mietkamera.de', '136.243.113.83', '192.168.122.83');

// ip from where this script is called
$myIP = $sh::getSessionIP();

if (_DEBUG_LOG_)
  error_log('login from: ' . $myIP);
// foreach ($valid_url_without_csrf_token as $url) {
//   if (strpos($ip, $url) !== false) {
//     $need_csrf_validation = false;
//     // but next login from this session needs a csrf token (mietkamera.de javascript from inbetriebnahme)
//     $_SESSION['token'] = bin2hex(random_bytes(32));
//     $_SESSION['token-expire'] = time() + 60 * 60;
//     // error_log('login: dont need csrf validation');
//     break;
//   }
// }

// if ($dbc->noLoginRequiredFromIP($ip, '/ajax/login')) {
//   $need_csrf_validation = false;
//   // error_log('login: dont need csrf validation (database)');
// }

// // first handle the csrf stuff
// if ($need_csrf_validation) {
//   // error_log('login: need csrf validation');
//   $error_count = 0;
//   if (!isset($_POST['token']))
//     $error_count++;
//   if (!isset($_SESSION['token']))
//     $error_count++;
//   if ($error_count == 0) {
//     $token = filter_var($_POST['token'], FILTER_SANITIZE_STRING);
//     // error_log('token='.$token);
//     if ($token !== $_SESSION['token']) {
//       $error_count++;
//     } else {
//       if (!isset($_SESSION['token-expire'])) {
//         $error_count++;
//       } else {
//         if ($_SESSION['token-expire'] < time())
//           $error_count++;
//       }
//     }
//     ;
//   }

// if ($error_count > 0) {
//   header('Content-Type: application/json; charset=utf-8');
//   echo json_encode($data);
//   return false;
// }

// handle dos attacks
//   if (!isset($_SESSION['login_count']))
//     $_SESSION['login_count'] = 0;
//   $_SESSION['login_count']++;
//   if ($_SESSION['login_count'] > _MAX_LOGIN_ATTEMPTS_) {
//     if (!isset($_SESSION['login-count-expire'])) {
//       $_SESSION['login-count-expire'] = time() + 5 * 60;
//     }
//     if (time() < $_SESSION['login-count-expire']) {
//       $data = array(
//         'returncode' => 300,
//         'message' => 'zu viele Loginversuche / gesperrt bis ' .
//           date('H:i:s', $_SESSION['login-count-expire'])
//       );
//       header('Content-Type: application/json; charset=utf-8');
//       echo json_encode($data);
//       return false;
//     } else
//       unset($_SESSION['login-count-expire']);
//   }
// }

// sanitize user input data
$st = isset($_POST['shorttag']) ? strtolower(trim($_POST['shorttag'])) : '';
$shorttag = preg_match('/^[a-zA-Z0-9]+$/', $st) ? substr($st, 0, _DEFAULT_SHORTTAG_LENGTH_) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';


$data = $sh::login($shorttag, $password, 'user');

if ($data['returncode'] == 200) {
  if (_DEBUG_LOG_)
    error_log('session var "session_' . $shorttag . '" ' . ($_SESSION['session_' . $shorttag] === null ? 'not ' : '') . 'set');
  // if login call sends an IP address as POST, it is assumed as the ip from where to make the next login call
  if (isset($_POST['ip']) && filter_var($_POST['ip'], FILTER_VALIDATE_IP)) {
    if ($myIP != $_POST['ip'] && $myIP != null)
      $sh::setTempAllowedIP($_POST['ip']);
  } else {
    // if a former call made my ip 
    if ($myIP != null)
      $sh::unsetTempAllowedIP($myIP);
  }
  unset($_SESSION['token']);
  unset($_SESSION['token-expire']);
  unset($_SESSION['login-count']);
  if (isset($_SESSION['login-count-expire']))
    unset($_SESSION['login-count-expire']);
} else $sh::writeErrorLog($data['returncode']);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
return false;