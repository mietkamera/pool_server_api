<p class="lead">Ausgabe des letzten Bildes aus einem bestimmten Datumsbereich.</p>
<h4>URL-Syntax</h4>
<code><span class="text-success">https://mobil.mietkamera.de/http-api/image/last/</span><abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr>/<abbr title="Parameter der Methode"><b><em>par</em></b></abbr></code>
<p></p>
<div class="col-sm-10">
  <h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.</p>
  <h5>par = Parameter</h5>
  <p>Syntax: <code>date[.size]</code></p>
  <?php $this->render('help/div_parameter_date');?>
  <?php $this->render('help/div_parameter_size');?>
</div>
<hr><h4>Beispiel</h4>
<code><b>https://mobil.mietkamera.de/http-api/image/last/</b>df34e2/201805.512x384</code>
<p>Der Aufruf liefert die img-Ressource des letzten Bildes vom Mai 2018 f&uuml;r den
  Kamera-Shorttag df34e2 in einer Aufl&ouml;sung von 512x384 Pixeln.</p>
