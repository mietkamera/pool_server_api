<p class="lead">Ausgabe eines Live-Bildes.</p>
<p>Das Bild wird vom Server von der Kamera abgeholt und als &lt;IMG&gt;-Ressource an den aufrufenden Client
  zur&uuml;ckgegeben.</p>
<h4>URL-Syntax</h4>
<code><span class="text-success"><?php echo _URL_STUB_.'/'.$this->module.'/'.$this->method.'/';?></span><abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr>/<abbr title="Parameter der Methode"><b><em>par</em></b></abbr></code>
<p></p>
<div class="col-sm-10">
  <h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.</p>
  <h5>par = Parameter</h5>
  <p>Syntax: <code>size</code></p>
  <?php $this->render('help/div_parameter_size');?>
</div>
<h4>Beispiel</h4>
  <code><b>https://<?php echo $_SERVER['SERVER_NAME']._URL_STUB_.'/'.$this->module.'/'.$this->method.'/';?></b>df34e2/512x384</code>
  <p>Der Aufruf liefert die img-Ressource des aktuellen Bildes f&uuml;r den
  Kamera-Shorttag df34e2 in einer Aufl&ouml;sung von 512x384 Pixeln.</p>
