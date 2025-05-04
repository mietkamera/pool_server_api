<?php

class Session
{

    private static $dbc;

    public function __construct()
    {
        self::$dbc = new Database();
    }

    // determine client IP from $_SERVER array
    // this function also works if client connects via proxy
    public static function clientIP()
    {
        $ip = null;
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public static function getSessionIP()
    {
        return isset($_SESSION['clientIP']) ? $_SESSION['clientIP'] : null;
    }

    // when starting init session with the clientIP
    public static function init()
    {
        $result = false;
        if (self::getSessionIP() == null) {
            if (self::clientIP() != null) {
                $_SESSION['clientIP'] = self::clientIP();
                $result = true;
            }
        } else
            $result = true;
        if (_DEBUG_LOG_ && $result) {
            error_log('SESSION["clientIP"]: ' . self::getSessionIP());
        }
        return $result;
    }

    public static function logout()
    {
        if (isset($_SESSION['clientIP']))
            unset($_SESSION['clientIP']);
    }

    public static function isLoggedIn($shorttag)
    {
        return isset($_SESSION['session_' . $shorttag]);
    }

    public static function isValidShorttag($shorttag)
    {
        $result = false;
        if (
            is_string($shorttag) &&
            strlen($shorttag) == _DEFAULT_SHORTTAG_LENGTH_ &&
            is_dir(_SHORT_DIR_ . '/' . $shorttag)
        )
            $result = true;
        return $result;
    }

    // if shorttag directory contains a password file with a user entry
    // and this shorttag has no session entry and no admin is logged in
    public static function isLoginRequired($shorttag)
    {
        $result = false;
        if (
            self::isValidShorttag($shorttag) &&
            is_file(_SHORT_DIR_ . '/' . $shorttag . '/.password') &&
            (strpos(file_get_contents(_SHORT_DIR_ . '/' . $shorttag . '/.password'), 'user:') !== false)
        )
            $result = true;
        return $result;
    }

    public static function usageAllowedFromIP()
    {
        return self::$dbc->usageAllowedFromIP(self::getSessionIP());
    }


    public static function noLoginRequiredFromIP($url)
    {
        return self::$dbc->noLoginRequiredFromIP(self::clientIP(), $url);
    }

    public static function publicUsageAllowed()
    {
        if (defined('_PUBLIC_USAGE_'))
            return _PUBLIC_USAGE_;
        else {
            if (_DEBUG_LOG_)
                error_log('no public usage defined! Fall back to false');
            return false;
        }
    }


    public static function login($shorttag, $password, $type = 'user')
    {
        $data = ['returncode' => 500, 'message' => 'bad data'];
        if (is_dir(_SHORT_DIR_ . '/' . $shorttag)) {
            if (is_file(_SHORT_DIR_ . '/' . $shorttag . '/.password')) {
                $inhalt = explode("\n", file_get_contents(_SHORT_DIR_ . '/' . $shorttag . '/.password'));
                $found_user = false;
                foreach ($inhalt as $zeile) {
                    list($typ, $pass) = explode(':', $zeile);
                    if ($typ == $type) {
                        $found_user = true;
                        if (md5($password) == $pass || $password == $pass) {
                            $data = ['returncode' => 200, 'message' => 'login successful'];
                            $_SESSION['session_' . $shorttag . '_type'] = $typ;
                            $_SESSION['session_' . $shorttag] = rand();
                        } else {
                            error_log('login error 403 from ' . $_SERVER['REMOTE_ADDR']);
                            $data = array('returncode' => 300, 'message' => 'falsche Zugangsdaten');
                        }
                    }
                }
                if (!$found_user && $password == '') {
                    $data = ['returncode' => 200, 'message' => 'login successful'];
                    $_SESSION['session_' . $shorttag . '_type'] = $typ;
                    $_SESSION['session_' . $shorttag] = rand();
                }
            } else {
                if ($password == '') {
                    $data = ['returncode' => 200, 'message' => 'login successful'];
                    $_SESSION['session_' . $shorttag . '_type'] = 'user';
                    $_SESSION['session_' . $shorttag] = rand();
                }
            }
        } else {
            if (_DEBUG_LOG_)
                error_log('shorttag error 403 from ' . self::clientIP());
            $data = ['returncode' => 500, 'message' => 'no shorttag directory'];
        }
        return $data;
    }

    public static function setTempAllowedIP($ip)
    {
        return self::$dbc->setTempAllowedIP($ip);
        if (_DEBUG_LOG_)
            error_log('setTempAllowedIP: ' . $ip);
    }

    public static function unsetTempAllowedIP($ip = '')
    {
        if ($ip == '')
            return self::$dbc->unsetTempAllowedIP(self::clientIP());
        else
            return self::$dbc->unsetTempAllowedIP($ip);
    }

    public static function writeErrorLog($code)
    {
        date_default_timezone_set('Europe/Berlin');
        $date = new DateTime();
        $date_human = $date->format("d-M-Y H:i:s T");

        $actual_link = "$_SERVER[REQUEST_URI]";

        file_put_contents('/var/log/pool/error.log', '[' . $date_human . '] ' . self::clientIP() . ' "GET ' . $actual_link . ' HTTP/1.1" ' . $code . "\n", FILE_APPEND);

    }

}