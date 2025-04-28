<?php

class Access
{

    private static $dbc;

    public function __construct()
    {
        self::$dbc = new Database();

    }

    public static function getMyRemoteIP()
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

    // get the ip from the session
    private static function getStartFromIP()
    {
        return isset($_SESSION['startFromIP']) ? $_SESSION['startFromIP'] : null;
    }

    // save the remote ip in the session
    private static function setStartFromIP()
    {
        $ip = self::getMyRemoteIP();
        if (!isset($_SESSION['startFromIP']) && $ip != null)
            $_SESSION['startFromIP'] = $ip;
        return $ip;
    }

    public static function usageAllowedFromIP()
    {
        return self::$dbc->usageAllowedFromIP(self::getStartFromIP());
    }

    public static function setSessionIPs()
    {
        $result = false;
        if (self::getStartFromIP() == null) {
            if (self::getMyRemoteIP() != null) {
                self::setStartFromIP();
                $result = true;
            }
        } else
            $result = true;
        if (_DEBUG_LOG_ && $result) {
            error_log('startFromIP: ' . self::getStartFromIP());
            error_log('myRemoteIP: ' . self::getMyRemoteIP());
        }
        return $result;
    }

    public static function noLoginRequiredFromIP($url)
    {
        return self::$dbc->noLoginRequiredFromIP(self::getMyRemoteIP(), $url);
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

    // if shorttag directory contains a password file with a user entry
    // and this shorttag has no session entry and no admin is logged in
    public static function loginRequired($shorttag)
    {
        $result = false;
        if (
            is_string($shorttag) &&
            strlen($shorttag) == _DEFAULT_SHORTTAG_LENGTH_
        ) {
            if (
                is_file(_SHORT_DIR_ . '/' . $shorttag . '/.password') &&
                (strpos(file_get_contents(_SHORT_DIR_ . '/' . $shorttag . '/.password'), 'user:') !== false) &&
                !isset($_SESSION['session_' . $shorttag]) &&
                !isset($_SESSION['session_admin'])
            )
                $result = true;
        }
        return $result;
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
                            $data = array('returncode' => 200, 'message' => 'login successful');
                            $_SESSION['session_' . $shorttag . '_type'] = $typ;
                            $_SESSION['session_' . $shorttag] = rand();
                        } else {
                            error_log('login error 403 from ' . $_SERVER['REMOTE_ADDR']);
                            $data = array('returncode' => 300, 'message' => 'falsche Zugangsdaten');
                        }
                    }
                }
                if (!$found_user && $password == '') {
                    $data = array('returncode' => 200, 'message' => 'login successful');
                    $_SESSION['session_' . $shorttag . '_type'] = $typ;
                    $_SESSION['session_' . $shorttag] = rand();
                }
            } else {
                if ($password == '') {
                    $data = array('returncode' => 200, 'message' => 'login successful');
                    $_SESSION['session_' . $shorttag . '_type'] = 'user';
                    $_SESSION['session_' . $shorttag] = rand();
                }
            }
        } else {
            if (_DEBUG_LOG_)
                error_log('shorttag error 403 from ' . self::getMyRemoteIP());
            $data = ['returncode' => 500, 'message' => 'no shorttag directory'];
        }
        return $data;
    }

    public static function setTempAllowedIP($ip)
    {
        return self::$dbc->setTempAllowedIP($ip);
    }

    public static function unsetTempAllowedIP($ip = '')
    {
        if ($ip == '')
            return self::$dbc->unsetTempAllowedIP(self::getMyRemoteIP());
        else
            return self::$dbc->unsetTempAllowedIP($ip);
    }

}