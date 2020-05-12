<!DOCTYPE html>
<html lang="de">
<!-- Version 1.4 -->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <meta name="keywords" content="Webcam Baustelle Mieten Mietkamera" />
  <meta name="rights" content="Roland Lauterbach 2017" />
  <title>MIETKAMERA Kundenportal</title>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="<?php echo _URL_STUB_;?>/public/js/jquery.validate.min.js" type="text/javascript"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link href="<?php echo _URL_STUB_;?>/public/css/website.css" rel="stylesheet">
  <link href="<?php echo _URL_STUB_;?>/public/css/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
  <style>
  	.description{
       position: absolute; /* absolute position (so we can position it where we want)*/
       top: 0px; /* position will be on bottom */
       left: 0px;
       width: <?php $w=explode('x',$this->resolution);echo $w[0];?>px;
       background-color: green;
       font-family: 'tahoma';
       font-size: 0.9em;
       color: white;
       opacity: 0.5; /* transparency */
       filter: alpha(opacity=50); /* IE transparency */
    }
    .description span {
      margin-top: 5px;
      margin-left: 5px; /* ein span innerhalb des a-Tag bekommt so die richtige Höhe */
    }
  </style>
</head>
<body>
<?php 
  if (isset($_SESSION['user_session'])) {
?>

<?php
  }  // If (isset($_SESSION['user_session'])) {
?>