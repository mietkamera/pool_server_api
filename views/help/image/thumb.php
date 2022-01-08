<p class="lead">Ausgabe des Thumbnails eines bestimmten Bildes einer Kamera. Die Gr&ouml;&szlig;e betr&auml;gt 240x180 Pixel.</p>
<h4>URL-Syntax</h4>
<code><span class="text-success"><?php echo _URL_STUB_.'/'.$this->module.'/'.$this->method.'/';?></span><abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr>/<abbr title="Parameter der Methode"><b><em>par</em></b></abbr></code>
<p></p>
<div class="col-sm-10">
  <h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.</p>
  <h5>par = Parameter</h5>
  <p>Syntax: <code>date</code></p>
  <div class="row">
    <div class="col-sm-2 col-lg-1"><code>date</code></div>
    <div class="col-sm-8 col-lg-6"><p>Zeitangabe in der Form YYYYmmddMMHHss. Die ersten vier Stellen 
      bezeichnen das Jahr, die folgenden zwei Stellen den Monat und die darauf folgenden zwei Stellen den 
      Tag. Danach zwei Stellen f&uuml;r die Stunde, zwei f&uuml;r die Minute und zwei f&uuml;r die Sekunde.</p></div>
  </div>  
</div>
<hr><h4>Beispiel</h4>
  <code><b>https://<?php echo $_SERVER['SERVER_NAME']._URL_STUB_.'/'.$this->module.'/'.$this->method.'/';?></b>df34e2/20180531185000</code>
  <p>Der Aufruf liefert die img-Ressource des Thumbnailbildes vom 31.05.2018 von 18:50:00 Uhr der Kamera mit 
  dem Shorttag df34e2.</p>
