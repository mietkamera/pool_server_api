<p class="lead">Ausgabe von allgemeinen Status-Informationen.</p>
<h4>URL-Syntax</h4>
<code><span class="text-success"><?php echo _URL_STUB_.'/'.$this->module.'/'.$this->method.'/';?></span><abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr></code>
<p></p>
<div class="col-sm-10">
  <h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.
  <small>(Wenn f&uuml;r den Shorttag ein Login notwendig ist und die Anmeldung vor dem Aufruf der URL nicht
  durchgef&uuml;hrt wurde, gibt der Server die Anmeldeseite f&uuml;r den Shorttag aus.)</small></p>
</div>
<hr><h4>Beispiel</h4>
<code><b>https://<?php echo $_SERVER['SERVER_NAME']._URL_STUB_.'/'.$this->module.'/'.$this->method;?>/</b>df34e2</code>
<p>Der Aufruf liefert ein JSON-Objekt der Form:</p>
<code>
{ "returncode": "200", <br/>
&nbsp;&nbsp;"api_ver": "1.0", <br/>
&nbsp;&nbsp;"message": "Shorttag gefunden",<br/>
&nbsp;&nbsp;"payload": { <br/>
&nbsp;&nbsp;&nbsp;&nbsp;"shorttag": "df34e2",<br/>
&nbsp;&nbsp;&nbsp;&nbsp;"image": {<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"status": "ok",<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"short": "online",<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"description": "Die Kamera liefert Bilder",<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"color": "success"<br/>
&nbsp;&nbsp;&nbsp;&nbsp;},<br/>
&nbsp;&nbsp;&nbsp;&nbsp;"information": {<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"name": "AXIS im Archiv",<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"projekt": "Meine Testkameras",<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"aktiv": "1",<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"monitor": "1",<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"live": "1",<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"other": [ "b38211" ]<br/>
&nbsp;&nbsp;&nbsp;&nbsp;}<br/>
&nbsp;&nbsp;} <br/>
}</code>
