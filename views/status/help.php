  <p class="lead">Das Modul status liefert Methoden zum Abruf von Status-Informationen.</p>
  <h5>URL</h5>
  <code><span class="text-success"><?php echo 'https://'.$_SERVER['SERVER_NAME']._URL_STUB_;?>/status/</span><abbr title="Eine Methode des Moduls"><b><em>meth</em></b></abbr>/<abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr>/<abbr title="Parameter der Methode"><b><em>par</em></b></abbr></code>
  <hr><h5>Methoden</h5>
  <div class="row">
    <div class="col-sm-3"><a href="<?php echo _URL_STUB_.'/status/needauth/help';?>">needauth</a></div>
    <div class="col-sm-8"><p>R&uuml;ckgabe eines JSON-Strings mit Informationen, ob f&uuml;r einen bestimmten 
      Shorttag ein Nutzer- oder Operator-Passwort ben&ouml;tigt wird. </p></div>
  </div>
  <div class="row">
    <div class="col-sm-3"><a href="<?php echo _URL_STUB_.'/status/information/help';?>">information</a></div>
    <div class="col-sm-8"><p>R&uuml;ckgabe eines JSON-Strings mit Status-Informationen der 
      Bildverarbeitung und allgemeinen Informationen zum Projekt. </p></div>
  </div>
  <div class="row">
    <div class="col-sm-3"><a href="<?php echo _URL_STUB_.'/status/connection_status/help';?>">connection_status</a></div>
    <div class="col-sm-8"><p>R&uuml;ckgabe eines JSON-Strings mit Status-Informationen zur Routerverbindung. </p></div>
  </div>
  <div class="row">
    <div class="col-sm-3"><a href="<?php echo _URL_STUB_.'/status/webcam_status/help';?>">webcam_status</a></div>
    <div class="col-sm-8"><p>R&uuml;ckgabe eines JSON-Objekts mit Status-Informationen zur angeschlossenen Webcam
     inklusive einem base64-kodierten Vorschaubild. </p></div>
  </div>
  <div class="row">
    <div class="col-sm-3"><a href="<?php echo _URL_STUB_.'/status/chart/help';?>">chart</a></div>
    <div class="col-sm-8"><p>R&uuml;ckgabe einer JPEG-&lt;IMG&gt;-Ressource mit dem MRTG-Bild f&uum;r einen 
      bestimmten Zeitraum. </p></div>
  </div>
