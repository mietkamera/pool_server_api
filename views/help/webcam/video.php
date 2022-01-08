<p class="lead">Gibt die erzeugten Videos als Website aus. </p>
<p>Die URL eignet sich sehr gut f&uuml;r die Verwendung in einem iFrame.</p>
<h4>URL-Syntax</h4>
<code><span class="text-success"><?php echo _URL_STUB_.'/'.$this->module.'/'.$this->method.'/';?></span><abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr></code>
<p></p>
<div class="col-sm-10">
  <h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechsstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.</p>
</div>
<hr/><h4>Beispiel</h4>
<code><b>https://<?php echo $_SERVER['SERVER_NAME']._URL_STUB_.'/'.$this->module.'/'.$this->method;?>/</b>44a3f4/</code>
<p>Der Aufruf liefert die Archivbilder f&uuml;r den Shorttag 44a3f4 und die Informationen zum Shorttag.</p>
