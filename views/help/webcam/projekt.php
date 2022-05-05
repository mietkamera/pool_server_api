<p class="lead">Gibt eine komplette Website mit Archivbildern und Videos aus.</p>
<h4>URL-Syntax</h4>
<code><span class="text-success">https://<?php echo $_SERVER['SERVER_NAME']._URL_STUB_.'/webcam/projekt/';?></span><abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr>/<abbr title="Parameter der Methode"><b><em>par</em></b></abbr></code>
<p></p>
<div class="col-sm-10">
  <h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechsstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.</p>
  <h5>par = Parameter</h5>
  <p>Syntax: <code>[info]</code></p>
  <div class="row">
    <div class="col-sm-2 col-lg-1"><code>info</code></div>
    <div class="col-sm-8 col-lg-6"><p>Wenn der Parameter 1 ist oder ausgelassen wird, wird zus&auml;tzlich 
      zum Archiv-Widget ein Informationsbereich ausgegeben. Um den Informationbereich abzuschalten und die 
      gesamte Bildschirmbreite zu nutzen, muss der Wert auf 0 gesetzt werden.</p></div>
  </div>
</div>  
<hr/>
<h4>Beispiel</h4>
<code><b>https://<?php echo $_SERVER['SERVER_NAME']._URL_STUB_.'/'.$this->module.'/'.$this->method;?>/</b>44a3f4/</code>
<p>Der Aufruf liefert die Kameraseite f&uuml;r den Shorttag 44a3f4.</p>
