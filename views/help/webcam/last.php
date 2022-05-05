<p class="lead">Gibt das letzte gespeicherte Bild auf einer kompletten Website aus.</p>
<p>Das Bild wird automatisch aktualisiert. Die URL eignet sich sehr gut f&uuml;r die Verwendung in einem iFrame.</p>
<h4>URL-Syntax</h4>
<code><span class="text-success"><?php echo _URL_STUB_.'/'.$this->module.'/'.$this->method.'/';?></span><abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr>/<abbr title="Parameter der Methode"><b><em>par</em></b></abbr></code>
<p></p>
<div class="col-sm-10">
  <h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechsstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.</p>
  <h5>par = Parameter</h5>
  <p>Syntax: <code>[info]</code></p>
  <div class="row">
    <div class="col-sm-3 col-lg-2"><code>info</code></div>
    <div class="col-sm-8 col-lg-6"><p>Ausgabe zus&auml;tzlicher Informationen neben oder unter dem Bild-Widget. 
      M&ouml;gliche Werte sind 0 oder 1. Wird der Parameter nicht angegeben, setzt die API den Standardwert 1.
      Um den Informationbereich abzuschalten und die gesamte Bildschirmbreite zu nutzen, muss der Wert auf 0 
      gesetzt werden.</p></div>
  </div>
</div>
<hr />
<h4>Beispiel</h4>
<code><b>https://<?php echo $_SERVER['SERVER_NAME']._URL_STUB_.'/'.$this->module.'/'.$this->method;?>/</b>44a3f4/</code>
<p>Der Aufruf liefert das letzte Archivbild f&uuml;r den Shorttag 44a3f4 und die Informationen zum Shorttag.</p>
