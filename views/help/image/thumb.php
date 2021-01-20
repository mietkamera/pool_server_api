<p class="lead">Ausgabe des Thumbnails eines bestimmten Bildes einer Kamera. Die Gr&ouml;&szlig;e betr&auml;gt 240x180 Pixel.</p>
<h4>URL-Syntax</h4>
<code><span class="text-success">https://mobil.mietkamera.de/http-api/image/thumb/</span>
   <abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr>/
   <abbr title="Parameter der Methode"><b><em>par</em></b></abbr></code>
<p></p>
<div class="col-sm-10">
  <h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.</p>
  <h5>par = Parameter</h5>
  <p>Syntax: <code>date</code></p>
  <?php $this->render('help/div_parameter_date');?>
</div>
<hr><h4>Beispiel</h4>
  <code><b>https://mobil.mietkamera.de/http-api/image/thumb/</b>df34e2/20180531185000</code>
  <p>Der Aufruf liefert die img-Ressource des Thumbnailbildes vom 31.05.2018 von 18:50:00 Uhr der Kamera mit 
  dem Shorttag df34e2.</p>
