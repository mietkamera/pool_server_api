<!DOCTYPE html>
<html lang="de">
<!-- Version 1.4 -->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <meta name="keywords" content="API Webcam Baustelle Mieten Mietkamera" />
  <meta name="rights" content="Roland Lauterbach 2019-2020" />
  
  <link rel="apple-touch-icon" href="<?php echo _URL_STUB_?>/public/icons/apple-touch-icon-iphone-60x60.png">
  <link rel="apple-touch-icon" sizes="60x60" href="<?php echo _URL_STUB_?>/public/icons/apple-touch-icon-ipad-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="<?php echo _URL_STUB_?>/public/icons/apple-touch-icon-iphone-retina-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="<?php echo _URL_STUB_?>/public/icons/apple-touch-icon-ipad-retina-152x152.png">

  <title><?php echo isset($this->title)?$this->title:'MIETKAMERA API';?></title>
  
  <!-- Bootstrap, Popper.js, and jQuery -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php if (isset($this->print_information)) { ?>  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.10/css/weather-icons.min.css" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.10/css/weather-icons.min.css" type="text/css">
  <link href="<?php echo _URL_STUB_;?>/public/css/weather.css" rel="stylesheet">
<?php }?>  

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

  <script src="<?php echo _URL_STUB_?>/public/js/my-bootstrap4-validate.js"></script>
  <link href="<?php echo _URL_STUB_;?>/public/css/website.css" rel="stylesheet">
<?php if (isset($this->use_leaflet)) { ?>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
<?php } ?>
</head>
<body>
  <script type="text/javascript">
    let url_stub = '<?php echo _URL_STUB_;?>';
    let hostName = "<?php echo $_SERVER['SERVER_NAME'];?>";
    let shorttag = "<?php echo isset($this->shorttag)?$this->shorttag:'';?>";
  </script>

