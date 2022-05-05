<?php

$this->cookie_show_header = isset($_COOKIE["show_header"])?$_COOKIE["show_header"]:'1';
$this->cookie_show_sidebar = isset($_COOKIE["show_sidebar"])?$_COOKIE["show_sidebar"]:'1';

setcookie("show_header",$this->cookie_show_header,time()+3600*24*365,"/samesite=strict");
setcookie("show_sidebar",$this->cookie_show_sidebar,time()+3600*24*365,"/samesite=strict");
?>