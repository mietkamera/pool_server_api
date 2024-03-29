<p class="lead">Ausgabe des Bildkataloges aus einem bestimmten Datumsbereich.</p>
<h4>URL-Syntax</h4>
<code><span class="text-success"><?php echo _URL_STUB_.'/'.$this->module.'/'.$this->method.'/';?></span><abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr>/<abbr title="Parameter der Methode"><b><em>par</em></b></abbr></code>
<p></p>
<div class="col-sm-10">
  <h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.
  <small>(Wenn f&uuml;r den Shorttag ein Login notwendig ist und die Anmeldung vor dem Aufruf der URL nicht
  durchgef&uuml;hrt wurde, gibt der Server die Anmeldeseite f&uuml;r den Shorttag aus.)</small></p>
  <h5>par = Parameter</h5>
  <p>Syntax: <code>date</code></p>
  <?php $this->render('help/div_parameter_date');?>
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
  <code><b>https://<?php echo $_SERVER['SERVER_NAME']._URL_STUB_.'/'.$this->module.'/'.$this->method.'/';?></b>df34e2/201805</code>
  <p>Der Aufruf liefert eine JSON-Ressource, die f&uuml;r jeden Tag im Mai 2018 die Namen
  der Bilddateien liefert.</p>
