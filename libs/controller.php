<?php

class Controller {
  	
    function __construct() {
  	  // echo 'main controller..';
  	  $this->view = new View();
  	  $this->httpRoot = $_SERVER["SERVER_NAME"].
  	         substr($_SERVER["PHP_SELF"],0,strlen($_SERVER["PHP_SELF"])-10);
    }
  	
    public function loadModel($name) {
  	  if (file_exists('models/'.$name.'_model.php')) {
  	  	$modelName = $name.'_Model';
  	  	require 'models/'.$name.'_model.php';
  	  	$this->model = new $modelName;
  	  }
  	}
  	

    //
    // hilfsfunktion, die Bildgrößen aus übergebenen Parametern bestimmt
    // Diese Funktion wird in vielen Methoden abgeleiteter Objekte benötigt 
    //
    public $valid_image_sizes = array( [   '320x240' , 'cif'   ],
                                       [   '512x384' , 'xcif'  ],
                                       [   '640x480' , 'vga'   ],
                                       [   '768x576' , 'd1pal' ],
                                       [   '800x600' , 'svga'  ],
                                       [  '1024x768' , 'xvga'   ],
  	                                   [  '1280x960' , 'mega'  ],
  	                                   [ '2048x1536' , 'qxga'  ],
  	                                   [ '2592x1944' , '5mp'   ],
  	                                   [ '3072x2048' , '6mp'   ],
  	                                   [   '640x360' , 'qhd'   ],
  	                                   [  '1280x720' , 'hd720' ],
  	                                   [ '1920x1080' , 'hd'    ],
  	                                   [ '2560x1440' , 'xga'   ],
  	                                   [ '3840x2160' , '4k'   ]);
  //
  // $size_parameter kann die Bildgroesse in der Form wxh 
  // oder als String, wie im Array $valid_image_sizes enthalten
  // Die Function prüft die Angabe und gibt einen gueltigen String 
  // in der Form wxh zurueck
  //
  public function check_size($size_parameter) {
  	$size = _DEFAULT_IMAGE_SIZE_;
  	if (!empty($size_parameter)) {
  	  foreach ($this->valid_image_sizes as $val) {
  	  	if ($val[0]==$size_parameter || $val[1]==$size_parameter) {
  	  	  return $val[0];
  	  	}
  	  }
  	}
  	return $size;
  }
  
  //
  // $date_parameter kann ein gueltiges Datum der Form YYYY, YYYYMM oder
  // YYYYMMDD enthalten
  // Die Funktion prüft den Eingabeparameter und gibt den aktuellen Tag 
  // in der Form YYYYMMDD aus, wenn der Parameter ungueltig ist
  //
  public function check_date($date_parameter) {
    $date_object = new DateTime();
    $date = $date_object->format('Ymd');
    if (!empty($date_parameter)) {
      switch (strlen($date_parameter)) {
        case 4:
          $y = intval($date_parameter);
          if (checkdate(1,1,$y)) $date = $date_parameter;
      	  break;
        case 6:
      	  $y = intval(substr($date,0,4));
  	      $m = intval(substr($date,4,2));
          if (checkdate(1,$m,$y)) $date = $date_parameter;
          break;
        case 8:
      	  $y = intval(substr($date,0,4));
  	      $m = intval(substr($date,4,2));
  	      $d = intval(substr($date,6,2));
  	      if (checkdate($d,$m,$y)) $date = $date_parameter;
      }
    }
    return $date;
  }
}

?>