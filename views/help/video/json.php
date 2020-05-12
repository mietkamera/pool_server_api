  <p class="lead">Liefert das f&uuml;r eine Kamera erstellte Videovorschaubild aus.</p>
  <h5>URL</h5>
  <code><span class="text-success">https://mobil.mietkamera.de/http-api/video/json/</span><abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr></code>
  <hr><h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechsstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.</p>
  <h5>JSON-R&uuml;ckgabewert Beispiel</h5>
  <code>
  	{<br/> 
  	&nbsp;"all": "complete",<br/>
    &nbsp;"kw": ["201748","201801","201802"]<br/>
    }<br/>
  </code>
  <hr><h5>Beispiel</h5>
  <code><b>https://mobil.mietkamera.de/http-api/video/json/</b>df34e2/</code>
  <p>Die URL liefert den JSON-Katalog f&uuml;r die Kamera mit dem Shorttag df34e2 aus.</p>
  <hr>
  <div class="row">
  	<div class="col-1"><a href="<?php echo _URL_STUB_.'/video/mp4/help';?>">mp4</a></div>
  	<div class="col-1"><a href="<?php echo _URL_STUB_.'/video/webm/help';?>">webm</a></div>
  	<div class="col-1"><a href="<?php echo _URL_STUB_.'/video/jpeg/help';?>">jpeg</a></div>
  	<div class="col-1"><a>json</a></div>
  	<div class="col-1"><a href="<?php echo _URL_STUB_.'/video/player/help';?>">player</a></div>
  </div><h5><a href="<?php echo _URL_STUB_.'/help';?>">HTTP-API Beschreibung</a></h5>