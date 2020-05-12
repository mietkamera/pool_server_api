  <p class="lead">Ausgabe eines Live-Bildes. Dieses Modul ist veraltet und wird durch das Modul &quot;live&quot; ersetzt.</p>
  <h5>URL</h5>
  <code><span class="text-success">https://mobil.mietkamera.de/http-api/player/live/</span><abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr>/<abbr title="Parameter der Methode"><b><em>par</em></b></abbr></code>
  <hr><h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.</p>
  <h5>par = Parameter</h5>
  <p>Syntax: <code>size</code></p>
   <div class="row">
    <div class="col-sm-2 col-lg-1"><code>size</code></div>
    <div class="col-sm-8 col-lg-6"><p>Dieser optionale Parameter legt die Gr&ouml;&szlig;e des Bildes fest. 
    Zul&auml;ssige Werte sind 512x383, 768x576, 1024x768 und 2048x1536. Wird der Parameter weggelassen, 
    wird das Bild in 768x576 ausgeliefert.</p></div>
  </div>
  <hr><h5>Beispiel</h5>
  <code><b>https://mobil.mietkamera.de/http-api/player/live/</b>df34e2/512x384</code>
  <p>Der Aufruf liefert die img-Ressource des aktuellen Bildes f&uuml;r den
  Kamera-Shorttag df34e2 in einer Aufl&ouml;sung von 512x384 Pixeln.</p>
  <hr>
  <div class="row">
  	<div class="col-1"><a>live</a></div>
  </div>
  </div><h5><a href="<?php echo _URL_STUB_.'/help';?>">HTTP-API Beschreibung</a></h5>
