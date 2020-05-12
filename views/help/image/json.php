<p class="lead">Ausgabe des Bildkataloges aus einem bestimmten Datumsbereich.</p>
<h4>URL-Syntax</h4>
<code><span class="text-success">https://mobil.mietkamera.de/http-api/image/json/</span><abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr>/<abbr title="Parameter der Methode"><b><em>par</em></b></abbr></code>
<p></p>
<div class="col-sm-10">
  <h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.</p>
  <h5>par = Parameter</h5>
  <p>Syntax: <code>date</code></p>
  <div class="row">
    <div class="col-sm-2 col-lg-1"><code>date</code></div>
    <div class="col-sm-8 col-lg-6"><p>Dieser Parameter bezeichnet einen Datumsbereich. Die ersten vier Stellen bezeichnen 
  das Jahr, die folgenden zwei Stellen den Monat und die darauf folgenden zwei Stellen den
  Tag. L&auml;sst man den Tag weg, werden alle Bilder des Monats verwendet. L&auml;sst man
  den Monat ebenfalls weg, werden alle Bilder des Jahres verwendet. Wird der Parameter 
  komplett ausgelassen, liefert die URL einen Katalog &uuml;ber alle Bilder der Kamera.</p></div>
  </div>
</div>
  <h4>JSON-R&uuml;ckgabewert Beispiel</h4>
  <code>
  	{<br/> 
  	&nbsp;"1": {<br/> 
  	&nbsp;&nbsp;"day": "20180528",<br/>
    &nbsp;&nbsp;"files": ["103002","143002"]<br/>
    &nbsp;},<br/>
    &nbsp;"2": {<br/> 
  	&nbsp;&nbsp;"day": "20180529",<br/>
    &nbsp;&nbsp;"files": ["103502","143502"]<br/>
    &nbsp;}<br/>
    }<br/>
  </code>
  <hr><h4>Beispiel f&uuml;r Aufruf</h4>
  <code><b>https://mobil.mietkamera.de/http-api/image/json/</b>df34e2/201805</code>
  <p>Der Aufruf liefert eine JSON-Ressource, die f&uuml;r jeden Tag im Mai 2018 die Namen
  der Bilddateien liefert.</p>
  <hr>
  <div class="row">
  	<div class="col-1"><a href="<?php echo _URL_STUB_.'/image/first/help';?>">first</a></div>
  	<div class="col-1"><a href="<?php echo _URL_STUB_.'/image/last/help';?>">last</a></div>
  	<div class="col-1"><a href="<?php echo _URL_STUB_.'/image/live/help';?>">live</a></div>
  	<div class="col-1"><a href="<?php echo _URL_STUB_.'/image/get/help';?>">get</a></div>
  	<div class="col-1"><a>json</a></div>
  </div><p></p><h5><a href="<?php echo _URL_STUB_.'/help';?>">HTTP-API Beschreibung</a></h5>