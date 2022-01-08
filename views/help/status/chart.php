<p class="lead">Ausgabe von PNG-Bildern, die eine Zeitskala beinhalten, die alle Zeitabschnitte gr&uuml;n 
  einf&auml;rbt, an denen Bilder erfolgreich gespeichert wurden.</p>
<h4>URL-Syntax</h4>
<code><span class="text-success"><?php echo _URL_STUB_.'/'.$this->module.'/'.$this->method.'/';?></span><abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr>/<abbr title="Parameter der Methode"><b><em>par</em></b></abbr></code>
<p></p>
<div class="col-sm-10">
  <h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.
  <small>(Wenn f&uuml;r den Shorttag ein Login notwendig ist und die Anmeldung vor dem Aufruf der URL nicht
  durchgef&uuml;hrt wurde, gibt der Server die Anmeldeseite f&uuml;r den Shorttag aus.)</small>
  </p>
  <h5>par = Parameter</h5>
  <p>Syntax: <code>[scope]</code></p>
  <div class="row">
    <div class="col-sm-2 col-lg-1"><code>scope</code></div>
    <div class="col-sm-8 col-lg-6"><p>Der Scope gibt den Zeitbereich an, f&uuml;r den das Bild erzeugt werden 
      soll. M&ouml;gliche Werte sind day, week, month oder year.</p></div>
  </div>
</div>
<hr><h4>Beispiel</h4>
<code><b>https://<?php echo $_SERVER['SERVER_NAME']._URL_STUB_.'/'.$this->module.'/'.$this->method;?>/</b>df34e2/week</code>
<p>Der Aufruf liefert ein PNG-Bild mit einer Zeitskala der letzten Tage. Die Zeitabschnitte an denen
   Bilder abgerufen und gespeichert werden konnten, sind gr&uuml;n eingef&auml;rbt.</p>
<img src="<?php echo _URL_STUB_.'/public/images/mrtg-week-example.png';?>"
