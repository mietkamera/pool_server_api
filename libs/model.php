<?php

require 'globals.php';

class Model {
  
  function __construct() {
	
  }
	
  protected function encrypt_decrypt($string, $action = 'encrypt') {
    $encrypt_method = "AES-256-CBC";
    $secret_key = _SECRET_KEY_;                     // user define private key
    $secret_iv = _SECRET_INITIALIZATION_VECTOR_;    // user define initialization vector
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo
    if ($action == 'encrypt') {
      $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
      $output = base64_encode($output);
    } else if ($action == 'decrypt') {
      $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
  }

  function getShorttagDataFromFile($st) {
    $data = array();
    if (is_file(_SHORT_DIR_.'/'.$st.'/shorttag.data')) {
      foreach(file(_SHORT_DIR_.'/'.$st.'/shorttag.data') as $row) {
        // Im Value können durchaus Doppelpunkte auftauchen
        $var_name  = trim(str_replace(array('"',':','\''),'',strstr($row, ':', true)));
        $var_value = trim(str_replace(array('"','\''),'',substr(strstr($row, ':'),1)));
        if ($var_name == 'api_operator_secret' || $var_name =='api_user_secret')
          $var_value = $this->encrypt_decrypt($var_value,'decrypt');
        switch (gettype($var_value)) {
          case "integer":
            $data[$var_name] = intval($var_value);
            break;
          case "boolean":
            $data[$var_name] = $var_value=='true'?1:0;
            break;
          default:
            $data[$var_name] = $var_value;
        }
      }
    }
    return $data;
  }

  //
  // Hilfsfunktion, die alle Image-Dateinamen eines bestimmten Verzeichnisses 
  // liefert. Die Funktion pflegt dabei den Cache, der sich in jedem Verzeichnis
  // befindet.
  //
  function get_image_file_names($st,$date='') {
  	
  	$images = array();
  	$image_stub_dir = _SHORT_DIR_.'/'.$st.'/img';
        $use_cache = false;
  	
  	if (is_dir($image_stub_dir)) {
  	  $last_image_time = is_link($image_stub_dir.'/lastimage.jpg')?filemtime($image_stub_dir.'/lastimage.jpg'):0;
	  // Zuerst mal schauen, ob es einen Cache gibt 
	  // error_log('$st='.$st.' strlen($date)='.strlen($date));
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
                  //$img = iterator_to_array($rx);
                  $image_dir_len = strlen($image_dir_y)-4;
                  foreach(chunk_iterator($rx, 1024) as $image) {
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
  
    function get_video_file_names($st) {

  	  $videos = array();
  	  $video_dir = _SHORT_DIR_.'/'.$st.'/movies';
  	  
  	  if (is_dir($video_dir)) {
  	  
        $subdirs = array('all'=>'',
                         'kw'=>'week',
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
