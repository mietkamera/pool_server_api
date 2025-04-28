<?php
class Bootstrap
{

  private $module, $method, $shorttag, $parameter;

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

    session_start();

    // this is a get method call of the website
    // we use this session vars to implement a simple csrf token mechanism
    $_SESSION['token'] = bin2hex(random_bytes(32));
    $_SESSION['token-expire'] = time() + 60 * 60;

    $access = new Access();

    // set the calling IP in session
    if (!$access::setSessionIPs()) {
      if (_DEBUG_LOG_)
        error_log('myRemoteIP == null');
      $this->exitWithError(500);
    }

    // sanitize $_GET variable url
    $sanitized_url = rtrim((isset($_GET['url']) ? $_GET['url'] : null), '/');
    if ($sanitized_url !== null && $sanitized_url != '' && !preg_match('/^[a-zA-Z0-9-_:.\/]+$/', $sanitized_url)) {
      $this->exitWithError(400);
    }

    // check if you call this API from an IP that has access without login
    // (this is not the IP that started the session)
    // we use this to grant access to the API to our management server
    $noLoginFromIPRequired = $access::noLoginRequiredFromIP($sanitized_url);


    // even if $sanitzed_url is null, explode gives back an array
    $url = explode('/', $sanitized_url);

    if (empty($url[0])) {
      require 'controllers/index.php';
      $controller = new Index();
      $controller->index();
      exit;
    }

    // get controller name and load controller class
    $file = 'controllers/' . $url[0] . '.php';
    if (file_exists($file)) {
      require $file;
    } else
      $this->exitWithError(404);
    $controller = new $url[0];

    // handle logout before others
    if ($url[0] == 'logout') {
      $this->shorttag = empty($url[1]) ? '' : $url[1];
      $redirect = empty($url[2]) ? '' : urldecode($url[2]);
      if (_DEBUG_LOG_)
        error_log('logout for ' . $this->shorttag);
      $controller->index($this->shorttag);
      exit;
    }

    $controller->loadModel($url[0]);

    // all URIs have the same structure
    // <module>/<method>/<shorttag>/<parameter>
    $this->module = $url[0];
    $this->method = empty($url[1]) ? 'help' : $url[1];
    $this->shorttag = empty($url[2]) ? '' : substr($url[2], 0, _DEFAULT_SHORTTAG_LENGTH_);
    $this->parameter = !isset($url[3]) ? '' : $url[3];

    if (isset($_SESSION['session_' . $this->shorttag]))
      $access::unsetTempAllowedIP();
    else
      if (!$noLoginFromIPRequired) {
        // if usage of the API is not allowed from all IP or your IP that
        // started the session is not in the allowed list, your request stops here 
        if (!($access::publicUsageAllowed() || $access::usageAllowedFromIP())) {
          if (_DEBUG_LOG_)
            error_log('there is no public usage and you did not start session from allowed ip');
          // usage from this ip is not allowed
          $this->exitWithError(403);
        }
      }

    // open login if required
    if ($access::loginRequired($this->shorttag) && !$noLoginFromIPRequired) {
      if (_DEBUG_LOG_)
        error_log('login for ' . $this->shorttag . ' required');
      if ($this->module != 'login') {
        require 'controllers/login.php';
        $controller = new Login();
      }
      $controller->auth($this->shorttag, $sanitized_url);
      exit;
    } else {
      if (_DEBUG_LOG_)
        error_log('no login required');
      // sessions vars have to be set
      if (!isset($_SESSION['session_' . $this->shorttag])) {
        $_SESSION['session_' . $this->shorttag . '_type'] = 'user';
        $_SESSION['session_' . $this->shorttag] = rand();
        if (_DEBUG_LOG_)
          error_log('nevertheless set session_' . $this->shorttag . ' variable');
      }
      if ($this->module == 'login') {
        if (_DEBUG_LOG_)
          error_log('load project website');
        require 'controllers/webcam.php';
        $controller = new Webcam();
        $controller->loadModel('webcam');
        $controller->projekt($this->shorttag);
        exit;
      }
    }
    if ($this->shorttag == 'help' || ($this->method != 'help' && $this->shorttag == '')) {
      require 'controllers/help.php';
      $controller = new Help($this->module, $this->method);
      $controller->render_method_help();
    }

    if (method_exists($controller, $this->method)) {
      if ($this->shorttag == '' || strlen($this->shorttag) == _DEFAULT_SHORTTAG_LENGTH_) {
        $controller->{$this->method}($this->shorttag, $this->parameter);
      } else
        $this->exitWithError(500);
    } else
      $this->exitWithError(404);
  }


  private function exitWithError($code = 500)
  {
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
    exit;
  }


}
