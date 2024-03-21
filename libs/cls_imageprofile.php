<?php
  /* ****************************************************************************************************************
     ImageProfile

     Klasse zur Verwaltung der Image-Profile der Kamera
     Diese Klasse muss nicht instantiiert werden, da sie aus statischen Methoden und Variablen besteht
  **************************************************************************************************************** */
  class ImageProfile {
    const MOBOTIX   = 'm12d';
    const MOBOTIX2M = 'm26m';
    const MOBOTIX2D = 'm15d';
    const AXIS      = 'axis';
    const REOLINK   = 'reolink';

    public static $profiles = array( APIType::MOBOTIX => array( 'QXGA' => array('2048x1536','live'),
                                                                'MEGA' => array('1280x960','live'),
                                                                'XGA' => array('1024x768','live'),
                                                                'VGA' => array('640x480','live'),
                                                                'CIF' => array('320x240','live'),
                                                                '3D' => array('1280x960','both')
                                                              ),
                                     APIType::MOBOTIX2M => array ( '6MP' => array('3072x2048','live'),
                                                                   '5MP' => array('2592x1944','live'),
                                                                   'QXGA' => array('2048x1536','live'),
                                                                   'MEGA' => array('1280x960','live'),
                                                                   'XGA' => array('1024x768','live'),
                                                                   'VGA' => array('640x480','live'),
                                                                   'CIF' => array('320x240','live')
                                                                 ),
                                     APIType::MOBOTIX2D => array ( '6MP' => array('3072x2048','live'),
                                                                   '5MP' => array('2592x1944','live'),
                                                                   'QXGA' => array('2048x1536','live'),
                                                                   'MEGA' => array('1280x960','live'),
                                                                   'XGA' => array('1024x768','live'),
                                                                   'VGA' => array('640x480','live'),
                                                                   'CIF' => array('320x240','live')
                                                                 ),
                                     APIType::AXIS => array ( '4K' => array('3840x2160','live'),
                                                              'HD' => array('1920x1080','live'),
                                                              'HD720' => array('1280x720','live'),
                                                              'XGA' => array('1024x768','live'),
                                                              'SVGA' => array('800x600','live'),
                                                              'VGA' => array('640x480','live'),
                                                              'CIF' => array('320x240','live')
                                                             ),
                                     APIType::REOLINK => array ( '4K' => array('3840x2160','live'),
                                                              'HD' => array('1920x1080','live')
                                                             )
                                   );

    public static function size($key,$type=APIType::MOBOTIX) {
      return self::$profiles[$type][$key][0];
    }

    public static function best_fitting_profile($type,$size) {
      $dimension = explode('x',$size);
      $width  = isset($dimension[0])?intval($dimension[0]):320;
      $height = isset($dimension[1])?intval($dimension[1]):(is_int($width*3/4)?$width*3/4:intval($width*9/16));
      $profile = array_key_first(self::$profiles[$type]);
      $found  = false;
      foreach(self::$profiles[$type] as $key => $value) {
        list($key_width,$key_height) = explode('x', $value[0]);
        if ($width == intval($key_width)) {
          $profile = $key;
          $found = true;
          break;
        }
      }
      return strtolower($profile);
    }
    
    public static function objective($key) {
      return self::$profiles[$type][$key][1];
    }

  }

?>
