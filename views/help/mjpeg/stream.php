<div class="container-fluid">
  <h1><?php $this->render_breadcrumb("mjpeg","stream");?></h1>
  <p class="lead">Ausgabe eines MJPEG-kodierten Streams einer bestimmten Kamera.</p>
  <h5>URL</h5>
  <code><span class="text-success">https://mobil.mietkamera.de/http-api/mjpeg/stream/</span><abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr>/<abbr title="Parameter der Methode"><b><em>par</em></b></abbr></code>
  <hr><h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.</p>
  <h5>par = Parameter</h5>
  <p>Syntax: <code>date[.size]</code></p>
  <p>Man kann mehrere Parameter angeben, die durch einen Punkt voneinander getrennt sind. Ihre Reihenfolge
  muss eingehalten werden, da keine Bezeichner vorhanden werden.</p>
  <div class="row">
    <div class="col-sm-2 col-lg-1"><code>date</code></div>
    <div class="col-sm-8 col-lg-6"><p>Dieser Parameter bezeichnet einen Datumsbereich. Die ersten vier Stellen bezeichnen 
  das Jahr, die folgenden zwei Stellen den Monat und die darauf folgenden zwei Stellen den
  Tag. L&auml;sst man den Tag weg, werden alle Bilder des Monats verwendet. L&auml;sst man
  den Monat ebenfalls weg, werden alle Bilder des Jahres verwendet. Wird der Parameter 
  komplett ausgelassen, liefert die URL alle Bilder der Kamera als Stream</p></div>
  </div>
  <div class="row">
    <div class="col-sm-2 col-lg-1"><code>size</code></div>
    <div class="col-sm-8 col-lg-6"><p>Dieser optionale Parameter &uuml;bergibt die Bildgr&ouml;&szlig;e des Streams.
  Zul&auml;ssige Werte sind 512x383, 768x576, 1024x768, 2048x1536. Wird der Parameter 
  weggelassen, werden die Bilder des Streams in Originalgr&ouml;&szlig;e ausgeliefert.</p></div>
  </div>
 
  <hr><h5>Beispiel</h5>
  <code><b>https://mobil.mietkamera.de/http-api/mjpeg/stream/</b>df34e2/201805.512x384</code>
  <hr><h5><a href="<?php echo _URL_STUB_.'/help';?>">HTTP-API Beschreibung</a></h5>
</div>