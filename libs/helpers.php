<?php
  if (!defined('_HELPERS_')) {

    function shorttag_needs_login($shorttag)
    {
      $result = false;
      if (is_string($shorttag) && strlen($shorttag)==_DEFAULT_SHORTTAG_LENGTH_) {
        if (is_file(_SHORT_DIR_.'/'.$shorttag.'/.password') && 
                 (strpos(file_get_contents(_SHORT_DIR_.'/'.$shorttag.'/.password'),'user:') !== false))
          $result = true;
      }
      return $result;
    }

    # check if a shorttag is logged in
  	function shorttag_is_logged_in($shorttag)
    {
      $result = false;
      if (is_string($shorttag) && strlen($shorttag)==_DEFAULT_SHORTTAG_LENGTH_) {
        if (isset($_SESSION['session_'.$shorttag]) && isset($_SESSION['session_'.$shorttag])) {
          $result = true;
        }
      }
      return $result;
    }

    function admin_is_logged_in()
    {
      $result = false;
      if (isset($_SESSION['session_admin'])) {
        $result = true;
      }
      return $result;
    }

  } else define('_HELPERS_');
?>