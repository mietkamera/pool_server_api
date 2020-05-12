  <p class="lead">Liefert eine komplette HTML-Seite mit einem HTML5-Player aus. Diese Methode eignet sich sehr gut, 
  um ein Video in einen iFrame einzubetten.</p>
  <h5>URL</h5>
  <code><span class="text-success">https://mobil.mietkamera.de/http-api/video/player/</span>
  <abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr>/<abbr title="Parameter der Methode"><b><em>par</em></b></abbr></code>
  <hr><h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechsstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.</p>
  <h5>par = Parameter</h5>
  <p>Syntax: <code>type[.autostart[.loop[.seconds]]]</code></p>
  <div class="row">
    <div class="col-sm-2 col-lg-1"><code>type</code></div>
    <div class="col-sm-8 col-lg-6"><p>Dieser Wert dieses Parameters ist entweder hd (1920x1080) 
    oder vgax (768x432). Beide Formate sind 16:9. Wenn der Wert ausgelassen wird, wird vgax als 
    Standard angenommen.</p></div>
  </div>
  <div class="row">
    <div class="col-sm-2 col-lg-1"><code>autostart</code></div>
    <div class="col-sm-8 col-lg-6"><p>Dieser optionale Parameter legt fest, ob die Wiedergabe 
    sofort starten soll (1) oder nicht (0).</p></div>
  </div>
  <div class="row">
    <div class="col-sm-2 col-lg-1"><code>loop</code></div>
    <div class="col-sm-8 col-lg-6"><p>Dieser optionale Parameter legt fest, ob das Video nach dem
    Abspielende erneut gestartet werden soll (1) oder nicht (0).</p></div>
  </div>
  <div class="row">
    <div class="col-sm-2 col-lg-1"><code>seconds</code></div>
    <div class="col-sm-8 col-lg-6"><p>Dieser Parameter legt fest, ob das Video nach einer 
    bestimmten Anzahl von Sekunden neu vom Speicher geladen werden soll. Bei einer Pr&auml;sentation in 
    Dauerschleife kann es sinnvoll sein, zum Beispiel alle vier Stunden das Video neu zu laden, da es 
    zwischenzeitlich neu gerendert worden ist. Wenn der Wert 0 ist, wird es nicht 
    neu geladen. </p></div>
  </div>
  <hr><h5>Beispiel</h5>
  <code><b>https://mobil.mietkamera.de/http-api/video/player/</b>df34e2/hd.1.0.3600</code>
  <p>Der Aufruf liefert eine Seite aus, die einen Videoplayer im Vollbildmodus ausgibt.
  Die Wiedergabe beginnt sofort, wird jedoch nicht wiederholt (loopen). Nach einer Stunde
  wird das Video erneut geladen und wiedergegeben.</p>
  <hr>
  <div class="row">
  	<div class="col-1"><a href="<?php echo _URL_STUB_.'/video/mp4/help';?>">mp4</a></div>
  	<div class="col-1"><a href="<?php echo _URL_STUB_.'/video/webm/help';?>">webm</a></div>
  	<div class="col-1"><a href="<?php echo _URL_STUB_.'/video/jpeg/help';?>">jpeg</a></div>
  	<div class="col-1"><a href="<?php echo _URL_STUB_.'/video/json/help';?>">json</a></div>
  	<div class="col-1"><a>player</a></div>
  </div><h5><a href="<?php echo _URL_STUB_.'/help';?>">HTTP-API Beschreibung</a></h5>