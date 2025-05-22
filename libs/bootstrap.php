<?php
class Bootstrap
{

  public function __construct()
  {
    session_set_cookie_params([
      'lifetime' => 60 * 60,
      'path' => '/',
      'domain' => $_SERVER['SERVER_NAME'],
      'secure' => true,
      'httponly' => true,
      'samesite' => 'Strict'
    ]);

    if(!isset($_SESSION)) {
      session_start();
    }

    // this is a get method call of the website
    // we use this session vars to implement a simple csrf token mechanism
    $_SESSION['token'] = bin2hex(random_bytes(32));
    $_SESSION['token-expire'] = time() + 60 * 60;

    $sh = new Session();
    if (!$sh::init()) {
      if (_DEBUG_LOG_)
        error_log('clientIP == null -> exit');
      $this->exitWithError(500);
    }

    // sanitize $_GET variable url
    $sanitized_url = rtrim((isset($_GET['url']) ? $_GET['url'] : null), '/');
    if ($sanitized_url !== null && $sanitized_url != '' && !preg_match('/^[a-zA-Z0-9-_:.\/]+$/', $sanitized_url)) {
      if (_DEBUG_LOG_)
        error_log('url contains illegal characters -> exit');
      $this->exitWithError(400);
    }

    // even if $sanitzed_url is null, explode gives back an array
    $url = explode('/', $sanitized_url);

    // all URLs have the same structure
    // <module>/<method>/<shorttag>/<parameter>
    // with one exception for the logout module
    $module = empty($url[0]) ? 'index' : $url[0];
    switch ($module) {
      case 'logout':
        // handle logout before all other stuff
        $shorttag = empty($url[1]) ? '' : $url[1];
        $redirect = empty($url[2]) ? '' : urldecode($url[2]);
        require 'controllers/logout.php';
        $controller = new Logout;
        if (_DEBUG_LOG_)
          error_log('logout for ' . $shorttag);
        $controller->index($shorttag);
        exit;
      case 'login':
        // allow to check the login status of an shorttag without usage restrictions
        // this method is called by javascript to detect status changes of an logged in shorttag
        $method = empty($url[1]) ? 'help' : $url[1];
        $shorttag = empty($url[2]) ? '' : substr($url[2], 0, _DEFAULT_SHORTTAG_LENGTH_);
        $parameter = !isset($url[3]) ? '' : $url[3];
        if ($method == 'check_status' && $shorttag != '') {
          if (_DEBUG_LOG_)
            error_log('check_status for ' . $shorttag . ($sh::isLoggedIn($shorttag) ? ' logged in' : ''));
          require 'controllers/login.php';
          $controller = new Login;
          $controller->{$method}($shorttag, $parameter);
          exit;
        }
        break;
      default:
        $method = empty($url[1]) ? 'help' : $url[1];
        $shorttag = empty($url[2]) ? '' : substr($url[2], 0, _DEFAULT_SHORTTAG_LENGTH_);
        $parameter = !isset($url[3]) ? '' : $url[3];
        // if we have an empty shorttag or an shorttag "help" show some information about the 
        // method of this module
        if ($shorttag == 'help' || ($method != 'help' && $shorttag == '')) {
          require 'controllers/help.php';
          $controller = new Help($module, $method);
          $controller->render_method_help();
          exit;
        }
        // if we have a "help" method render the help screen for the module
        if ($method=='help') {
          require 'controllers/help.php';
          $controller = new Help($module, $method);
          $controller->render_module_help();
          exit;
        }
    }

    if ($sh::isLoginRequired($shorttag)) {
      if ($sh::noLoginRequiredFromIP($sanitized_url)) {

        if (_DEBUG_LOG_)
          error_log('no login required for ' . $sh::clientIP());
      } else {
        if (!$sh::isLoggedIn($shorttag)) {
          if ($sh::publicUsageAllowed() || $sh::usageAllowedFromIP()) {
            if (_DEBUG_LOG_)
              error_log('redirect to login site for ' . $shorttag);
            require 'controllers/login.php';
            $controller = new Login();
            $controller->auth($shorttag, $sanitized_url);
          } else
            $this->exitWithError(403);
          exit;
        } else {
          if (_DEBUG_LOG_)
            error_log($shorttag . ' is logged in');
        }
      }
    }

    if (!$sh::publicUsageAllowed()) {
      if (!$sh::isLoggedIn($shorttag)) {
        if (!$sh::usageAllowedFromIP()) {
          if (_DEBUG_LOG_)
            error_log('no usage allowed from ' . $sh::clientIP());
          $this->exitWithError(403);
        }
      }
    }

    $file = 'controllers/' . $module . '.php';
    if (file_exists($file)) {
      require $file;
      $controller = new $module;
      $controller->loadModel($module);
      if (method_exists($controller, $method)) {
        if ($shorttag == '' || strlen($shorttag) == _DEFAULT_SHORTTAG_LENGTH_) {
          $controller->{$method}($shorttag, $parameter);
        } else
          $this->exitWithError(500);
      } else
        $this->exitWithError(404);
    } else
      $this->exitWithError(404);


    // check if you call this API from an IP that has access without login
    // (this is not the IP that started the session)
    // we use this to grant access to the API to our management server
    // $noLoginFromIPRequired = $sh::noLoginRequiredFromIP($sanitized_url);


    // // get controller name and load controller class
    // $file = 'controllers/' . $url[0] . '.php';
    // if (file_exists($file)) {
    //   require $file;
    // } else
    //   $this->exitWithError(404);
    // $controller = new $url[0];

    // // handle logout before others
    // if ($url[0] == 'logout') {
    //   $shorttag = empty($url[1]) ? '' : $url[1];
    //   $redirect = empty($url[2]) ? '' : urldecode($url[2]);
    //   if (_DEBUG_LOG_)
    //     error_log('logout for ' . $shorttag);
    //   $controller->index($shorttag);
    //   exit;
    // }

    // $controller->loadModel($url[0]);


    // if (isset($_SESSION['session_' . $shorttag]))
    //   $sh::unsetTempAllowedIP();
    // else
    //   if (!$noLoginFromIPRequired) {
    //     // if usage of the API is not allowed from all IP or your IP that
    //     // started the session is not in the allowed list, your request stops here 
    //     if (!($sh::publicUsageAllowed() || $sh::usageAllowedFromIP())) {
    //       if (_DEBUG_LOG_)
    //         error_log('there is no public usage and you did not start session from allowed ip');
    //       // usage from this ip is not allowed
    //       $this->exitWithError(403);
    //     }
    //   }

    // // open login if required
    // if ($sh::isLoginRequired($shorttag) && !$noLoginFromIPRequired) {
    //   if (_DEBUG_LOG_)
    //     error_log('login for ' . $shorttag . ' required');
    //   if ($module != 'login') {
    //     require 'controllers/login.php';
    //     $controller = new Login();
    //   }
    //   $controller->auth($shorttag, $sanitized_url);
    //   exit;
    // } else {
    //   if (_DEBUG_LOG_)
    //     error_log('no login required');
    //   // sessions vars have to be set
    //   if (!isset($_SESSION['session_' . $shorttag])) {
    //     $_SESSION['session_' . $shorttag . '_type'] = 'user';
    //     $_SESSION['session_' . $shorttag] = rand();
    //     if (_DEBUG_LOG_)
    //       error_log('nevertheless set session_' . $shorttag . ' variable');
    //   }
    //   if ($module == 'login') {
    //     if (_DEBUG_LOG_)
    //       error_log('load project website');
    //     require 'controllers/webcam.php';
    //     $controller = new Webcam();
    //     $controller->loadModel('webcam');
    //     $controller->projekt($shorttag);
    //     exit;
    //   }
    // }
    // if ($shorttag == 'help' || ($method != 'help' && $shorttag == '')) {
    //   require 'controllers/help.php';
    //   $controller = new Help($module, $method);
    //   $controller->render_method_help();
    // }

    // if (method_exists($controller, $method)) {
    //   if ($shorttag == '' || strlen($shorttag) == _DEFAULT_SHORTTAG_LENGTH_) {
    //     $controller->{$method}($shorttag, $parameter);
    //   } else
    //     $this->exitWithError(500);
    // } else
    //   $this->exitWithError(404);

  }


  private function exitWithError($code = 500)
  {
    $sh = new Session;

    require 'controllers/error.php';
    $controller = new MyError();
    switch ($code) {
      case 400:
      case 403:
      case 404:
      case 500:
        $controller->page((string) $code);
        break;
      default:
        $controller->page('500');
    }
    $sh::writeErrorLog($code);
    exit;
  }


}
