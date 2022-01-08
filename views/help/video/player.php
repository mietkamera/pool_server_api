<p class="lead">Liefert eine komplette HTML-Seite mit einem HTML5-Player aus. Diese Methode eignet sich sehr gut, 
  um ein Video in einen iFrame einzubetten.</p>
<h4>URL-Syntax</h4>
<code><span class="text-success"><?php echo _URL_STUB_.'/'.$this->module.'/'.$this->method.'/';?></span><abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr>/<abbr title="Parameter der Methode"><b><em>par</em></b></abbr></code>
<p></p>
<div class="col-sm-10">
  <h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechsstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.</p>
  <h5>par = Parameter</h5>
  <p>Syntax: <code>video[.autostart[.loop[.seconds]]]</code></p>
  <div class="row">
    <div class="col-sm-3 col-lg-2"><code>video</code></div>
    <div class="col-sm-8 col-lg-6"><p>Der Wert spezifiziert das abzuspielende Video &auml;hnlich wie bei der Methode
      <a href="<?php echo _URL_STUB_.'/video/mp4/help';?>">/video/mp4</a> mit dem Unterschied, dass die Parameter durch
      einen Doppelpunkt getrennt werden. Die Syntax lautet: <code>[size][:all|kw:week]</code>.</p></div>
  </div>
  <div class="row">
    <div class="col-sm-3 col-lg-2"><code>autostart</code></div>
    <div class="col-sm-8 col-lg-6"><p>Dieser optionale Parameter legt fest, ob die Wiedergabe 
    sofort starten soll (1) oder nicht (0).</p></div>
  </div>
  <div class="row">
    <div class="col-sm-3 col-lg-2"><code>loop</code></div>
    <div class="col-sm-8 col-lg-6"><p>Dieser optionale Parameter legt fest, ob das Video nach dem
    Abspielende erneut gestartet werden soll (1) oder nicht (0).</p></div>
  </div>
  <div class="row">
    <div class="col-sm-3 col-lg-2"><code>seconds</code></div>
    <div class="col-sm-8 col-lg-6"><p>Dieser Parameter legt fest, ob das Video nach einer 
    bestimmten Anzahl von Sekunden neu vom Speicher geladen werden soll. Bei einer Pr&auml;sentation in 
    Dauerschleife kann es sinnvoll sein, zum Beispiel alle vier Stunden das Video neu zu laden, da es 
    zwischenzeitlich neu gerendert worden ist. Wenn der Wert 0 ist, wird es nicht 
    neu geladen. </p></div>
  </div>
</div>
<hr><h4>Beispiel</h4>
<code><b>https://<?php echo $_SERVER['SERVER_NAME']._URL_STUB_.'/'.$this->module.'/'.$this->method.'/';?></b>df34e2/vgax:kw:202148.1.0.3600</code>
<p>Der Aufruf liefert eine Seite aus, die einen Videoplayer im Vollbildmodus ausgibt. Das Video hat eine Gr&ouml;&szlig;e von
  768x432 Pixeln und beinhaltet die Bilder der 48. Kalenderwoche 2021. Die Wiedergabe beginnt sofort, wird jedoch nicht wiederholt. 
  Nach einer Stunde wird das Video erneut geladen und wiedergegeben.</p>
