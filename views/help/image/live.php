<p class="lead">Ausgabe eines Live-Bildes.</p>
<h4>URL-Syntax</h4>
<code><span class="text-success">https://mobil.mietkamera.de/http-api/image/live/</span><abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr>/<abbr title="Parameter der Methode"><b><em>par</em></b></abbr></code>
<p></p>
<div class="col-sm-10">
  <h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.</p>
  <h5>par = Parameter</h5>
  <p>Syntax: <code>size</code></p>
   <div class="row">
    <div class="col-sm-2 col-lg-1"><code>size</code></div>
    <div class="col-sm-10 col-lg-8"><p>Dieser optionale Parameter legt die Gr&ouml;&szlig;e des Bildes fest. 
    Zul&auml;ssige Werte sind <?php $this->list_image_sizes();?>. Wird der Parameter weggelassen, 
    wird das Bild in Originalgr&ouml;ße ausgeliefert.</p></div>
  </div>
</div>
<h4>Beispiel</h4>
  <code><b>https://mobil.mietkamera.de/http-api/image/live/</b>df34e2/512x384</code>
  <p>Der Aufruf liefert die img-Ressource des aktuellen Bildes f&uuml;r den
  Kamera-Shorttag df34e2 in einer Aufl&ouml;sung von 512x384 Pixeln.</p>
<hr>
<div class="row">
  <div class="col-1"><a href="<?php echo _URL_STUB_.'/image/first/help';?>">first</a></div>
  <div class="col-1"><a href="<?php echo _URL_STUB_.'/image/last/help';?>">last</a></div>
  <div class="col-1"><a>last</a></div>
  <div class="col-1"><a href="<?php echo _URL_STUB_.'/image/get/help';?>">get</a></div>
  <div class="col-1"><a href="<?php echo _URL_STUB_.'/image/json/help';?>">json</a></div>
</div><p></p><h5><a href="<?php echo _URL_STUB_.'/help';?>">HTTP-API Beschreibung</a></h5>
