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
                   	                 [  '1024x768' , 'xga'   ],
  	                                 [  '1280x960' , 'mega'  ],
  	                                 [ '2048x1536' , 'qxga'  ],
  	                                 [ '2592x1944' , '5mp'   ],
  	                                 [ '3072x2048' , '6mp'   ],
  	                                 [   '640x360' , 'qhd'   ],
  	                                 [  '1280x720' , 'hd720' ],
  	                                 [ '1920x1080' , 'hd'    ],
  	                                 [ '2560x1440' , 'xga'   ],
  	                                 [ '3840x2160' , 'uhd'   ]);
  	                                 
  public function check_size($size_parameter) {
  	$size = '';
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
  // Hilfsfunktion, die alle Image-Dateinamen eines bestimmten Verzeichnisses 
  // liefert. Die Funktion pflegt dabei den Cache, der sich in jedem Verzeichnis
  // befindet.
  //
  public function get_image_file_names($st,$date='') {
  	
  	$images = array();
  	$image_stub_dir = _SHORT_DIR_.'/'.$st.'/01';
    $use_cache = false;
  	
  	if (is_dir($image_stub_dir)) {
  	  $last_image_time = is_link($image_stub_dir.'/lastimage.jpg')?filemtime($image_stub_dir.'/lastimage.jpg'):0;
  	  // Zuerst mal schauen, ob es einen Cache gibtse 
  	  switch (strlen($date)) {
  	    case 0:
  	      $image_dir = $image_stub_dir;
   	      $cache_time_offset = 86400000;
   	      break;
  	    case 4:  // Bilder eines bestimmten Jahres
  	      $image_dir = $image_stub_dir.'/'.$date;
          $cache_time_offset = 31536000000; // 365*24*60*60*1000
  	  	  break;
  	    case 6:
  	      $y = substr($date,0,4);
  	      $m = substr($date,4,2);
          $image_dir = $image_stub_dir.'/'.$y.'/'.$m;
          $cache_time_offset = 2678400000; // 31*24*60*60*1000
          break;
        case 8:
          $y = substr($date,0,4);
  	      $m = substr($date,4,2);
  	      $d = substr($date,6,2);
          $image_dir = $image_stub_dir.'/'.$y.'/'.$m.'/'.$d;
          $cache_time_offset = 86400000; // 24*60*60*1000
          break;
        default:
          $image_dir = '';
  	  }
	 
	  if (is_dir($image_dir)) {
	    $image_cache = $image_dir.'/.img_cache';
	  	$image_first = $image_dir.'/.first';
	  	$image_last = $image_dir.'/.last';
	  	$cache_time = is_file($image_cache)?filemtime($image_cache):0;
	  	if (is_file($image_cache)) {
	  	  if ($cache_time>$last_image_time || 
	  	       ($cache_time+$cache_time_offset)<$last_image_time) {
	  	    $images = file($image_cache);
	  	    $use_cache = true;
	  	  }
	    } 
	    if (!$use_cache) {
	  	  switch (strlen($date)) {
	  	  	case 0:
	  	      $all_files = scandir($image_stub_dir);
	  	      foreach($all_files as $year) {
	  	        if (strlen($year)==4 && is_numeric($year)) {
	  	          $image_dir_y = $image_stub_dir.'/'.$year;
	  	          $di = new RecursiveDirectoryIterator($image_dir_y);
	  	          $it = new RecursiveIteratorIterator($di);
                  $rx = new RegexIterator($it, "/^.+\.jpg$/i");
                  $img = iterator_to_array($rx);
                  $image_dir_len = strlen($image_dir_y)-4;
                  foreach($img as $image) {
                    $images[] = substr($image,$image_dir_len).PHP_EOL;
                  }
	  	   	    }
	  	      }
	  	      break;
	  	    case 4:
	  	    case 6:
	  	    case 8:
	  	      $di = new RecursiveDirectoryIterator($image_dir);
	  	      $it = new RecursiveIteratorIterator($di);
                $rx = new RegexIterator($it, "/^.+\.jpg$/i");
                $img = iterator_to_array($rx);
                $image_dir_len = strlen($image_dir)+1;
                foreach($img as $image) {
              	  $images[] = substr($image,$image_dir_len).PHP_EOL;
                }
                break;
              default:
	  	    }
	  	    if (sizeof($images)>0) {
	  	      sort($images);
  	          // schreibe die Cache-Files
  	          file_put_contents($image_cache,$images);
  	          if (!is_link($image_first)) {
  	      	    $first = $image_dir.'/'.$images[0];
  	          }
  	        }
	      }
  	    }
      }
  	  return $images;
    }
  
    public function get_video_file_names($st) {

  	  $videos = array();
  	  $video_dir = _SHORT_DIR_.'/'.$st.'/01/movies';
  	  
  	  if (is_dir($video_dir)) {
  	  
        $subdirs = array('all'=>'',
                         'kw'=>'weeks',
                         'month'=>'month');
      
        foreach($subdirs as $name => $subdir) {
          $dir_name = $video_dir.($subdir==''?'':'/').$subdir;
       
          $dir = new DirectoryIterator($dir_name);
          $farr = array();
          foreach ($dir as $fileinfo) {
            $filename = $fileinfo->getFilename();
            if (!$fileinfo->isDot() && strpos($filename,'.mp4') && !strpos($filename,'768')) {
              $farr[] = substr($filename,0,-4);
            }
          }
          sort($farr);
          if (count($farr)>0) $videos[$name] = $farr;
          unset($farr);
        }
  	  }
      return $videos;
    }
  	
  }
?>