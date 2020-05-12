<?php

class Mjpeg extends Controller {
	
  function __construct() {
  	parent::__construct();
  	
  }
  
  function index() {
  	$this->view->render('image/index');
  }
  
  function help() {
  	require('controllers/help.php');
  	$this->view->help = new Help();
  	$this->view->render('header');
  	$this->view->render('mjpeg/help');
  	$this->view->render('footer');
  }
  
  //
  // Gib das erste Bild eines bestimmten Datumsbereichs aus
  // 
  function stream($st,$parameter) {
  	$param = array_map('trim',explode('.',$parameter));
  	$date = empty($param[0])?'':$param[0];
  	$size = empty($param[1])?'2048x1536':$param[1];
  	switch ($size) {
  	  case '1280x720':
  	  case '512x384':
  	  case '768x576':
  	  case '1024x768':
  	  case '2048x1536':
  	    break;
  	  default:
  	  	$size = '2048x1536';
  	}
  	
  	list($w,$h) = explode('x',$size);
    $images = $this->get_image_file_names($st,$date);
    if (sizeof($images)>0) {
      switch (strlen($date)) {
        case 0:
          $image_dir = _SHORT_DIR_.'/'.$st.'/01';
          break;
        case 4:
          $image_dir = _SHORT_DIR_.'/'.$st.'/01/'.$date;
          break;
        case 6:
      	  $y = substr($date,0,4);
  	      $m = substr($date,4,2);
          $image_dir = _SHORT_DIR_.'/'.$st.'/01/'.$y.'/'.$m;
          break;
        case 8:
      	  $y = substr($date,0,4);
  	      $m = substr($date,4,2);
  	      $d = substr($date,6,2);
          $image_dir = _SHORT_DIR_.'/'.$st.'/01/'.$y.'/'.$m.'/'.$d;
          break;
        default:
      	  $image_dir = '';
      }
    } else {
      $image_dir = 'public/images';
      $images[] = 'empty.jpg'.PHP_EOL;
    }
  	
  	$boundary = "my_mjpeg";
  	# We start with the standard headers. PHP allows us this much
    header("Cache-Control: no-cache");
    header("Cache-Control: private");
    header("Pragma: no-cache");
    header("Content-type: multipart/x-mixed-replace; boundary=$boundary");

    # From here out, we no longer expect to be able to use the header() function
    print "--$boundary\r\n";

    # Set this so PHP doesn't timeout during a long stream
    set_time_limit(0);

    # Disable Apache and PHP's compression of output to the client
    @apache_setenv('no-gzip', 1);
    @ini_set('zlib.output_compression', 0);

    # Set implicit flush, and flush all current buffers
    @ini_set('implicit_flush', 1);
    for ($i = 0; $i < ob_get_level(); $i++)
    ob_end_flush();
    ob_implicit_flush(1);
    
    list($ow,$oh) = getimagesize($image_dir.'/'.substr($images[0],0,strlen($images[0])-1));
    
    $must_resize = ($ow!=$w || $oh!=$h);

    foreach($images as $index=>$image) {
  	  if ($must_resize) {
        $img =  imagecreatefromjpeg($image_dir.'/'.substr($images[$index],0,strlen($images[$index])-1));
        $timg = imagecreatetruecolor($w,$h);
        imagecopyresized($timg, $img, 0, 0, 0, 0, $w, $h, $ow, $oh);
  	  } else {
  	  	$timg =  imagecreatefromjpeg($image_dir.'/'.substr($images[$index],0,strlen($images[$index])-1));
  	  }
  	  
  	  echo "Content-type: image/jpeg\n\n";
  	  //echo "Content-Length: ".sizeof($timg);
      imagejpeg($timg); //you does not want to save.. just display
      imagedestroy($timg);
      # The separator
      echo "--$boundary\n";
  	  
    }
  }
  
}
?>
