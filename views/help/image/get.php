<p class="lead">Ausgabe eines anhand des Datums genau spezifizierten Bildes.</p>
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
  <div class="row">
    <div class="col-sm-2 col-lg-1"><code>date</code></div>
    <div class="col-sm-8 col-lg-6"><p>Zeitangabe in der Form YYYYmmddMMHHss. Die ersten vier Stellen 
      bezeichnen das Jahr, die folgenden zwei Stellen den Monat und die darauf folgenden zwei Stellen den 
      Tag. Danach zwei Stellen f&uuml;r die Stunde, zwei f&uuml;r die Minute und zwei f&uuml;r die Sekunde.</p></div>
  </div>  
  <?php $this->render('help/div_parameter_size');?>
</div>
<hr><h4>R&uuml;ckgabewerte</h4>
<p>Es wird ein Bild ausgeliefert. Falls kein Bild aus dem Kameraverzeichnis geliefert werden kann,
   wird ein leeres Bild im angegebenen Format ausgegeben,</p>
<hr><h4>Beispiel</h4>
  <code><b>https://<?php echo $_SERVER['SERVER_NAME']._URL_STUB_.'/'.$this->module.'/'.$this->method.'/';?></b>df34e2/20180531185000.1024x768</code>
  <p>Der Aufruf liefert die img-Ressource des Bildes vom 31.05.2018 von 18:50:00 Uhr der Kamera mit 
  dem Shorttag df34e2 in einer Aufl&ouml;sung von 1024x768 Pixeln.</p>
