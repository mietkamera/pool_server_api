<p class="lead">Ausgabe des ersten Bildes aus einem bestimmten Datumsbereich.</p>
<h4>URL-Syntax</h4>
<code><span class="text-success"><?php echo _URL_STUB_.'/'.$this->module.'/'.$this->method.'/';?></span><abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr>/<abbr title="Parameter der Methode"><b><em>par</em></b></abbr></code>
<p></p>
<div class="col-sm-10">
  <h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.
  <small>(Wenn f&uuml;r den Shorttag ein Login notwendig ist und die Anmeldung vor dem Aufruf der URL nicht
  durchgef&uuml;hrt wurde, gibt der Server die Anmeldeseite f&uuml;r den Shorttag aus.)</small></p>
  <h5>par = Parameter</h5>
  <p>Syntax: <code>date[.size]</code></p>
  <?php $this->render('help/div_parameter_date');?>
  <?php $this->render('help/div_parameter_size');?>
</div>
<hr><h4>R&uuml;ckgabewerte</h4>
<p>Es wird ein Bild ausgeliefert. Falls kein Bild aus dem Kameraverzeichnis geliefert werden kann,
   wird ein leeres Bild im angegebenen Format ausgegeben,</p>
<hr><h4>Beispiel</h4>
<code><b>https://<?php echo $_SERVER['SERVER_NAME']._URL_STUB_.'/'.$this->module.'/'.$this->method.'/';?></b>df34e2/201805.512x384</code>
<p>Der Aufruf liefert die img-Ressource des ersten Bildes vom Mai 2018 f&uuml;r den
   Kamera-Shorttag df34e2 in einer Aufl&ouml;sung von 512x384 Pixeln.</p>
