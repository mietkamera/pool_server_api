<p class="lead">Liefert Informationen im JSON-Format &uuml;ber die f&uuml;r eine Kamera erstellten Videos aus.</p>
<h4>URL-Syntax</h4>
<code><span class="text-success"><?php echo _URL_STUB_.'/'.$this->module.'/'.$this->method.'/';?></span><abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr></code>
<p></p>
<div class="col-sm-10">
  <h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechsstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.</p>
</div>
<h4>JSON-R&uuml;ckgabewert Beispiel</h4>
<code>
  {<br/> 
  &nbsp;"all": "complete",<br/>
  &nbsp;"kw": ["201748","201801","201802"]<br/>
  }<br/>
</code>
<hr><h4>Beispiel</h4>
<code><b>https://<?php echo $_SERVER['SERVER_NAME']._URL_STUB_.'/'.$this->module.'/'.$this->method.'/';?></b>df34e2/</code>
<p>Die URL liefert den JSON-Katalog f&uuml;r die Kamera mit dem Shorttag df34e2 aus.</p>
