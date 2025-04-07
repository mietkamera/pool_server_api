<?php
require_once 'libs/cls_apitype.php';
require_once 'libs/cls_imageprofile.php';

class Image extends Controller
{
  function __construct()
  {
    parent::__construct();
  }

  function index()
  {
    $this->view->render('image/index');
  }

  function help()
  {
    require('controllers/help.php');
    $this->help = new Help('image', 'help');
    $this->help->render_module_help();
  }

  //
  // Gibt ein Bild aus einer Datei aus
  private function image_jpg($filename, $size)
  {
    $must_resize = false;
    if ($size != '') {
      list($ow, $oh) = getimagesize($filename);
      list($w, $h) = explode('x', $size);
      $must_resize = ($ow != $w || $oh != $h);
    }
    header("Content-type: image/jpeg");
    if ($must_resize) {
      $img = imagecreatefromjpeg($filename);
      $timg = imagecreatetruecolor($w, $h);
      imagecopyresized($timg, $img, 0, 0, 0, 0, $w, $h, $ow, $oh);
      imagejpeg($timg);
      imagedestroy($img);
      imagedestroy($timg);
    } else
      readfile($filename);
  }

  //
  // Gibt das erste Bild eines bestimmten Datumsbereichs aus
  // 
  function first($st, $parameter = '')
  {
    $param = array_map('trim', explode('.', $parameter));
    $date = empty($param[0]) ? '' : $this->check_date($param[0]);
    $size = empty($param[1]) ? '' : $this->check_size($param[1]);
    $images = $this->model->get_image_file_names($st, $date);

    if (count($images) > 0) {
      switch (strlen($date)) {
        case 0:
          $image_dir = _SHORT_DIR_ . '/' . $st . '/img';
          break;
        case 4:
          $image_dir = _SHORT_DIR_ . '/' . $st . '/img/' . $date;
          break;
        case 6:
          $y = substr($date, 0, 4);
          $m = substr($date, 4, 2);
          $image_dir = _SHORT_DIR_ . '/' . $st . '/img/' . $y . '/' . $m;
          break;
        case 8:
          $y = substr($date, 0, 4);
          $m = substr($date, 4, 2);
          $d = substr($date, 6, 2);
          $image_dir = _SHORT_DIR_ . '/' . $st . '/img/' . $y . '/' . $m . '/' . $d;
          break;
        default:
          $image_dir = '';
      }
    } else {
      $image_dir = 'public/images';
      $images[] = 'empty.jpg' . PHP_EOL;
    }

    $filename = $image_dir . '/' . substr($images[0], 0, strlen($images[0]) - 1);
    if (!is_file($filename))
      $filename = 'public/images/empty.jpg';

    $this->image_jpg($filename, $size);
  }

  //
  // Gib das erste Bild eines bestimmten Datumsbereichs aus
  // 
  function last($st, $parameter = '')
  {
    $param = array_map('trim', explode('.', $parameter));
    $date = empty($param[0]) ? '' : $this->check_date($param[0]);
    $size = empty($param[1]) ? '' : $this->check_size($param[1]);

    if ($date == '' && is_link(_SHORT_DIR_ . '/' . $st . '/img/lastimage.jpg')) {
      $images[] = readlink(_SHORT_DIR_ . '/' . $st . '/img/lastimage.jpg') . "\n";
    } else
      $images = $this->model->get_image_file_names($st, $date);

    if (count($images) > 0) {
      switch (strlen($date)) {
        case 0:
          $image_dir = _SHORT_DIR_ . '/' . $st . '/img';
          break;
        case 4:
          $image_dir = _SHORT_DIR_ . '/' . $st . '/img/' . $date;
          break;
        case 6:
          $y = substr($date, 0, 4);
          $m = substr($date, 4, 2);
          $image_dir = _SHORT_DIR_ . '/' . $st . '/img/' . $y . '/' . $m;
          break;
        case 8:
          $y = substr($date, 0, 4);
          $m = substr($date, 4, 2);
          $d = substr($date, 6, 2);
          $image_dir = _SHORT_DIR_ . '/' . $st . '/img/' . $y . '/' . $m . '/' . $d;
          break;
        default:
          $image_dir = '';
      }
    } else {
      $image_dir = 'public/images';
      $images[] = 'empty.jpg' . PHP_EOL;
    }
    $index = count($images) - 1;
    $filename = $image_dir . '/' . substr($images[$index], 0, strlen($images[$index]) - 1);
    if (!is_file($filename))
      $filename = 'public/images/empty.jpg';
    $this->image_jpg($filename, $size);
  }

  //
  // gib ein bestimmtes Bild zurück
  //
  function get($st, $parameter = '')
  {
    $param = array_map('trim', explode('.', $parameter));

    $date = empty($param[0]) ? '' : $this->check_time($param[0]);
    $size = empty($param[1]) ? '' : $this->check_size($param[1]);
    $y = substr($date, 0, 4);
    $m = substr($date, 4, 2);
    $d = substr($date, 6, 2);

    $filename = _SHORT_DIR_ . '/' . $st . '/img/' . $y . '/' . $m . '/' . $d . '/' . substr($date, 8) . '.jpg';
    if (!is_file($filename))
      $filename = 'public/images/empty.jpg';

    $this->image_jpg($filename, $size);
  }

  //
  // Gibt ein Bild aus einer Datei als Downloadlink zurück
  //
  function download($st, $parameter = '')
  {
    $param = array_map('trim', explode('.', $parameter));
    $date = $this->check_time(empty($param[0]) ? '' : $param[0]);

    error_log('date=' . $date);
    $y = substr($date, 0, 4);
    $m = substr($date, 4, 2);
    $d = substr($date, 6, 2);

    $filename = _SHORT_DIR_ . '/' . $st . '/img/' . $y . '/' . $m . '/' . $d . '/' . substr($date, 8) . '.jpg';
    if (!is_file($filename)) {
      $filename = 'public/images/empty.jpg';
    }

    define('CHUNK_SIZE', 1024 * 1024); // Size (in bytes) of tiles chunk

    $size = @getimagesize($filename);
    if (!isset($size['mime'])) {
      $size['mime'] = 'video/mp4';
    }
    $handle = @fopen($filename, "rb");
    $buffer = '';
    if ($size && $handle) {
      header("Content-type: {$size['mime']}");
      header("Content-Length: " . filesize($filename));
      header("Content-Disposition: attachment; filename=" . $st . '_' . $date . '.jpg');
      header('Content-Transfer-Encoding: binary');
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

      while (!feof($handle)) {
        $buffer = fread($handle, CHUNK_SIZE);
        echo $buffer;
        ob_flush();
        flush();
      }
      exit;
    }
  }


  //
  // gib den Thumbnail eines bestimmten Bildes zurück
  //
  function thumb($st, $parameter = '')
  {
    $param = array_map('trim', explode('.', $parameter));
    $date = $this->check_time(empty($param[0]) ? '' : $param[0]);
    $width = '240';

    $y = substr($date, 0, 4);
    $m = substr($date, 4, 2);
    $d = substr($date, 6, 2);

    $filename = _SHORT_DIR_ . '/' . $st . '/img/' . $y . '/' . $m . '/' . $d . '/' . substr($date, 8) . '.jpg';
    $thumbname = _SHORT_DIR_ . '/' . $st . '/img/' . $width . '/' . $y . '/' . $m . '/' . $d . '/' . substr($date, 8) . '.jpg';
    header("Content-type: image/jpeg");
    if (!is_file($filename)) {
      $w = 240;
      $h = 180;
      $text = 'sorry :-(' . "\n" . 'Kein Thumbnail vorhanden!' . "\n\n";
      $img = imagecreatetruecolor($w, $h);
      $tcolor = imagecolorallocate($img, 255, 255, 255);
      $bcolor = imagecolorallocate($img, 0, 64, 128);
      $font = './public/fonts/DejaVuSans.ttf';

      imagefilledrectangle($img, 0, 0, $w, $h, $bcolor);
      imagettftext($img, ceil($w / 32), 0, 30, 100, $tcolor, $font, $text);
      imagejpeg($img);
      imagedestroy($img);
    } else {
      if (!is_file($thumbname)) {
        $size = @getimagesize($filename);
        $breite = $size[0];
        $hoehe = $size[1];
        $thumbdir = _SHORT_DIR_ . '/' . $st . '/img/' . $width . '/' . $y . '/' . $m . '/' . $d;
        if (!is_dir($thumbdir))
          mkdir($thumbdir, 0770, true);
        $height = intval($hoehe * $width / $breite);
        $myImage = @ImageCreateFromJPEG($filename);
        $myThumb = @ImageCreateTrueColor($width, $height);
        @ImageCopyResized($myThumb, $myImage, 0, 0, 0, 0, $width, $height, $breite, $hoehe);
        @ImageJPEG($myThumb, $thumbname);
      }
      readfile($thumbname);
    }
  }

  function live($st, $parameter = "")
  {

    $param = array_map('trim', explode('.', $parameter));
    $size = empty($param[0]) ? '320x240' : $this->check_size($param[0]);

    // Ermittle die IP und die Zugangsdaten des Routers
    if (is_file(_SHORT_DIR_ . '/' . $st . '/shorttag.data')) {
      $data = $this->model->getShorttagDataFromFile($st);
      $active = $data['active'] === "true";
      $api_type = $data['api_type'];
      $allow_live = $data['allow_live'] === "true";
      $router_type = $data['router_type'];
      $protocol = $data['camera_url_protocol'];
      $ip = $data['camera_url_address'];
      $port = $data['camera_url_port'];
      $secret = $data['camera_url_secret'];
    }
    if (isset($ip)) {
      if ($active) {
        switch ($router_type) {
          case 'teltonika':
            if ($api_type != APIType::REOLINK) {
              $image_profile = ImageProfile::best_fitting_profile($api_type, $size);
              $url = $protocol . '://' . $ip . ':' . $port . APIType::get_image_url($api_type, $image_profile);
            } else {
              $param = explode(':', $secret);
              $user = isset($param[0]) ? $param[0] : '';
              $pass = isset($param[1]) ? $param[1] : '';
              $url = $protocol . '://' . $ip . ':' . $port . '/cgi-bin/api.cgi?cmd=Snap&channel=0&rs=' . time() . '&user=' . $user . '&password=' . $pass;
              $secret = '';
            }
            break;
          case 'virtual':
          default:
            $url = $protocol . '://' . $ip;
        }
        $ch = curl_init($url);
        if ($secret != '')
          curl_setopt($ch, CURLOPT_USERPWD, $secret);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

        $result = curl_exec($ch);
        $rescode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($rescode == '200') {
          header("Content-Type: image/jpeg");
          list($w, $h) = explode('x', $size);
          if ($allow_live) {
            echo $result;
            return;
          } else
            $text = "\n\n" . 'Anzeige gesperrt!' . "\n\n" . 'Livebild darf nicht angezeigt werden.';
        } else
          $text = 'Sorry :-(' . "\n\n" . 'Kein Livebild vorhanden!' . "\n\n" . 'Die Webcam ist nicht erreichbar.';
      } else
        $text = 'Sorry :-(' . "\n\n" . 'Kein Livebild vorhanden!' . "\n\n" . 'Die Webcam ist nicht aktiv.';
    } else
      $text = 'Sorry :-(' . "\n\n" . 'Kein Livebild vorhanden!' . "\n\n" . 'Shorttag existiert nicht.';

    header("Content-Type: image/jpeg");
    list($w, $h) = explode('x', $size);
    $img = imagecreatetruecolor($w, $h);
    $bcolor = imagecolorallocate($img, 255, 255, 255);
    $tcolor = imagecolorallocate($img, 0, 0, 0);
    $font = './public/fonts/DejaVuSans.ttf';

    imagefilledrectangle($img, 0, 0, $w, $h, $bcolor);
    imagettftext($img, ceil($w / 48), 0, 30, 100, $tcolor, $font, $text);
    imagejpeg($img);
    imagedestroy($img);
  }

  private function check_day_value($val)
  {
    $return_value = true;
    if (strlen($val) == 8) {
      $y = (int) substr($val, 0, 4);
      $m = (int) substr($val, 4, 2);
      $d = (int) substr($val, 6, 2);
      $return_value = $return_value && ($y > 2000);
      $return_value = $return_value && ($m >= 1 && $m <= 12);
      $return_value = $return_value && ($d >= 1 && $d <= 31);
    } else
      $return_value = array(false, '0', '0');
    return array($return_value, substr($val, 0, 4), substr($val, 4, 2), substr($val, 6, 2));
  }

  private function getJsonDay($image, $date)
  {
    switch (strlen($date)) {
      case 0:
        list($y, $m, $d) = explode('/', $image);
        break;
      case 4:
        $y = $date;
        list($m, $d) = explode('/', $image);
        break;
      case 6:
        $y = substr($date, 0, 4);
        $m = substr($date, 4, 2);
        $d = substr($image, 0, 2);
        break;
      case 8:
        $y = substr($date, 0, 4);
        $m = substr($date, 4, 2);
        $d = substr($date, 6, 2);
        break;
    }
    return $y . $m . $d;
  }

  private function getJsonTime($image, $date)
  {
    switch (strlen($date)) {
      case 0:
        $time = substr($image, 11, strlen($image) - 16);
        break;
      case 4:
        $time = substr($image, 7, strlen($image) - 12);
        break;
      case 6:
        $time = substr($image, 3, strlen($image) - 8);
        break;
      case 8:
        $time = substr($image, 0, strlen($image) - 5);
        break;
    }
    return $time;
  }

  function json($st, $parameter = '')
  {
    $param = array_map('trim', explode('.', $parameter));
    $date = empty($param[0]) ? '' : $this->check_date($param[0]);
    $js_text = '{ }';
    $images = $this->model->get_image_file_names($st, $date);
    if (count($images) > 0) {
      $js_text = "{\n";
      $hourList = '';
      $lastDay = $this->getJsonDay($images[0], $date);
      $arr_length = count($images);
      // error_log(print_r($images[count($images)-1],true));
      $i = 1;
      foreach ($images as $key => $filename) {
        $thisDay = $this->getJsonDay($filename, $date);
        $minute = $this->getJsonTime($filename, $date);
        if ($thisDay == $lastDay) {
          if ($key < ($arr_length - 1)) {
            $hourList .= ($hourList == '' ? '' : ',') . '"' . $minute . '"';
          } else {
            $hourList .= ($hourList == '' ? '' : ',') . '"' . $minute . '"';
            $js_text .= '"' . $i . '": { "day": "' . $lastDay . '", "files": [' . $hourList . '] }' . "\n";
          }
        } else {
          $js_text .= '"' . $i . '": { "day": "' . $lastDay . '", "files": [' . $hourList . '] }';
          $hourList = '"' . $minute . '"';
          $i++;
          if ($key < ($arr_length - 1)) {
            $js_text .= ',' . "\n";
          } else {
            $js_text .= ',' . "\n";
            $js_text .= '"' . $i . '": { "day": "' . $thisDay . '", "files": [' . $hourList . '] }' . "\n";
          }

        }
        $lastDay = $thisDay;
      }
      $js_text .= '}';
    }

    header('Content-type:application/json;charset=utf-8');
    echo utf8_encode($js_text);
  }
}
