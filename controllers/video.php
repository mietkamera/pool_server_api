<?php
class Video extends Controller {
	
  function __construct() {
  	parent::__construct();
  	
  }
  
  function index() {
  	$this->view->render('video/index');
  }
  
  function help() {
  	require('controllers/help.php');
  	$this->view->help = new Help();
  	$this->view->render('header');
  	$this->view->render('video/help');
  	$this->view->render('footer');
  }
  
  function player($st,$parameter) {
  	$param = array_map('trim',explode('.',$parameter));
  	$quality = empty($param[0])?'hd':$param[0];
  	switch ($quality) {
  	  case "full":
  	  case "uhd":
  	  case "hd":
  	  	$this->view->resolution ='hd';
  	  	break;
  	  case "hdready":
  	  	$this->view->resolution ='hdready';
  	  	break;
  	  case "preview":
  	  case "small":
  	  case "vgax":
  	  default:
  	  	$this->view->resolution = 'vgax';
  	}
  	$this->view->shorttag = $st;
  	$this->view->start = empty($param[1])?false:boolval($param[1]);
    $this->view->loop = empty($param[2])?false:boolval($param[2]);
    $this->view->reload = empty($param[3])?0:intval($param[3]);
    
  	$this->view->render('video/header');
  	$this->view->render('video/player');
  	$this->view->render('footer');
  }
  
  private function get_stub($st,$parameter) {
  	$param = array_map('trim',explode('.',$parameter));
  	$type = empty($param[0])?'hd':$param[0];
  	$scope = empty($param[1])?'':$param[1];
  	$date = empty($param[2])?'':$param[2];
  	switch ($type) {
  	  case "hd":
  	  case "full":
  	  	$name_extension = '';
  	  	break;
  	  case "hdready":
  	  	$name_extension = '-1280x720';
  	  	break;
  	  case "preview":
  	  case "vgax":
  	  default:
  	  	$name_extension = '-768x432';
  	}
  	switch ($scope) {
  	  case 'kw':
  	  	$subdir = 'weeks/';
  	  	$file_base_name = $date;
  	  	break;
  	  case "all":
  	  default:
  	  	$subdir = '';
  	  	$file_base_name = 'complete';
  	}
  	
  	$file_stub_name = _SHORT_DIR_.'/'.$st.'/01/movies/'.$subdir.$file_base_name.$name_extension;
  	return $file_stub_name;
  }
  
  private function stream_video($file,$type) {
  	switch ($type) {
  	  case "webm":
  	  	$ctype='webm';
  	  	break;
  	  case 'mp4':
  	  default:
  	  	$ctype = 'mp4';
  	}

  	if (!$fp = @fopen($file, 'rb')) {
  	  header('HTTP/1.1 404 Not Found');
  	  exit();
  	}

    $size   = filesize($file); // File size
    $length = $size;           // Content length
    $start  = 0;               // Start byte
    $end    = $size - 1;       // End byte

    header("Content-type: video/$ctype");
    header("Accept-Ranges: bytes 0-$length/$size");

    if (isset($_SERVER['HTTP_RANGE'])) {

      $c_start = $start;
      $c_end   = $end;

      list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
      if (strpos($range, ',') !== false) {
        header('HTTP/1.1 416 Requested Range Not Satisfiable');
        header("Content-Range: bytes $start-$end/$size");
        exit;
      }
      if ($range == '-') {
        $c_start = $size - substr($range, 1);
      }else{
        $range  = explode('-', $range);
        $c_start = $range[0];
        $c_end   = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size;
      }
      $c_end = ($c_end > $end) ? $end : $c_end;
      if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {
        header('HTTP/1.1 416 Requested Range Not Satisfiable');
        header("Content-Range: bytes $start-$end/$size");
        exit;
      }
      $start  = $c_start;
      $end    = $c_end;
      $length = $end - $start + 1;
      fseek($fp, $start);
      header('HTTP/1.1 206 Partial Content');
    }
    header("Content-Range: bytes $start-$end/$size");
    header("Content-Length: ".$length);


    $buffer = 1024 * 8;
    while(!feof($fp) && ($p = ftell($fp)) <= $end) {

      if ($p + $buffer > $end) {
        $buffer = $end - $p + 1;
      }
      set_time_limit(0);
      echo fread($fp, $buffer);
      flush();
    }

    fclose($fp);
    return false;
  }
  
  function mp4($st,$parameter) {
  	$file = $this->get_stub($st,$parameter).'.mp4';
    $this->stream_video($file,'mp4');  
  }
  
  function webm($st,$parameter) {
  	$file = $this->get_stub($st,$parameter).'.webm';
    $this->stream_video($file,'webm');  
  }
  
  function jpeg($st,$parameter) {
  	$file = $this->get_stub($st,$parameter).'.jpg';
  	if (!is_file($file)) {
  	  header('HTTP/1.1 404 Not Found');
  	  return false;
  	}
  	header("Content-type: image/jpeg");
  	readfile($file);
  }
  
  function json($st) {
  	$videos = $this->get_video_file_names($st);
  	
  	header('Content-type:application/json;charset=utf-8');
  	echo json_encode($videos);
  }
  
}
?>