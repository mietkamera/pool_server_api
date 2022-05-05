<p class="lead">Gibt die erzeugten Videos als Website aus. </p>
<p>Die URL eignet sich sehr gut f&uuml;r die Verwendung in einem iFrame.</p>
<h4>URL-Syntax</h4>
<code><span class="text-success"><?php echo _URL_STUB_.'/'.$this->module.'/'.$this->method.'/';?></span><abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr></code>
<p></p>
<div class="col-sm-10">
  <h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechsstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.</p>
  <p>Syntax: <code>[size][.controls][.info]</code></p>
  <div class="row">
    <div class="col-sm-2 col-lg-1"><code>size</code></div>
    <div class="col-sm-8 col-lg-6"><p>Startet die Videowebsite mit einer bestimmten Videogr&ouml;&szlig;e.
      Der Parameter kann die Werte hd f&uuml;r Videos in der Gr&ouml;&szlig;e 1920x1080 oder vgax f&uuml;r 
      Videos in der Gr&ouml;&szlig;e 768x432) annehmen.Wird der Parameter ausgelassen, wird automatisch hd 
      angenommen.</p></div>
  </div>
  <div class="row">
    <div class="col-sm-2 col-lg-1"><code>controls</code></div>
    <div class="col-sm-8 col-lg-6"><p>Wenn der Parameter 1 ist oder ausgelassen wird, wird der Umschalter
      von HD auf VGAX, der Downloadknopf und eine Liste aller vorhandenen Videos angezeigt. Die Anzeige
      der Steuerelemente und Videos kann mit 0 abgeschaltet werden.</p></div>
  </div>
  <div class="row">
    <div class="col-sm-2 col-lg-1"><code>info</code></div>
    <div class="col-sm-8 col-lg-6"><p>Wenn der Parameter 1 ist oder ausgelassen wird, wird zus&auml;tzlich 
      zum Archiv-Widget ein Informationsbereich ausgegeben. Um den Informationbereich abzuschalten und die 
      gesamte Bildschirmbreite zu nutzen, muss der Wert auf 0 gesetzt werden.</p></div>
  </div>
</div>
<hr/><h4>Beispiel</h4>
<code><b>https://<?php echo $_SERVER['SERVER_NAME']._URL_STUB_.'/'.$this->module.'/'.$this->method;?>/</b>44a3f4/vgax.1.0</code>
<p>Der Aufruf liefert die Zeitraffervideos im Format 768x432 f&uuml;r den Shorttag 44a3f4, eine Liste aller Videos
   aber keine Informationen zum Shorttag.</p>
