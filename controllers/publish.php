<?php

class Publish extends Controller {

  function __construct() {
    parent::__construct();
  }

  private function get_boolean_from_file($st, $name) {
    $val = false;
    if (is_file(_SHORT_DIR_.'/'.$st.'/.password') && 
          (strpos(file_get_contents(_SHORT_DIR_.'/'.$st.'/.password'),'user:') !== false)) {
      foreach(file(_SHORT_DIR_.'/'.$st.'/shorttag.data') as $row) {
        // Im Value können durchaus Doppelpunkte auftauchen
        $var_name  = trim(str_replace(array('"',':','\''),'',strstr($row, ':', true)));
        if ($var_name == $name) {
          $var_value = trim(str_replace(array('"','\''),'',substr(strstr($row, ':'),1)));
          $val = ($var_value=='true'?true:false);
          break;
        }
      }
    } else $val = true;
    return $val;
  }
  
  function image($st,$parameter='') {
    if ($st!='' && is_file(_SHORT_DIR_.'/'.$st.'/shorttag.data')) {
      if ($this->get_boolean_from_file($st,'allow_public_image')) {
        require 'controllers/image.php';
        $controller = new Image();
        $controller->last($st,$parameter);
      }
    }
  }

  function video($st,$parameter='hd.all') {
    if ($st!='' && is_file(_SHORT_DIR_.'/'.$st.'/shorttag.data')) {
      if ($this->get_boolean_from_file($st,'allow_public_movie')) {
        require 'controllers/video.php';
        $controller = new Video();
        $controller->mp4($st,$parameter);
      }
    }
  }
  
}
?>