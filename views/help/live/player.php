<p class="lead">Ausgabe eines Live-Bildes.</p>
<h4>URL-Syntax</h4>
<code><span class="text-success">https://mobil.mietkamera.de/http-api/live/player/</span><abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr>/<abbr title="Parameter der Methode"><b><em>par</em></b></abbr></code>
<p></p>
<div class="container-fluid">
  <h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.</p>
  <h5>par = Parameter</h5>
  <p>Syntax: <code>size[.autoplay[.name]]</code></p>
   <div class="row">
    <div class="col-sm-2 col-lg-1"><code>size</code></div>
    <div class="col-sm-8 col-lg-6"><p>Dieser optionale Parameter legt die Gr&ouml;&szlig;e des Bildes fest. 
    Zul&auml;ssige Werte sind 512x383, 768x576, 1024x768 und 2048x1536. Wird der Parameter weggelassen, 
    wird das Bild in 768x576 ausgeliefert.</p></div>
  </div>
  <div class="row">
    <div class="col-sm-2 col-lg-1"><code>autoplay</code></div>
    <div class="col-sm-8 col-lg-6"><p>Dieser Parameter ist entweder 0/false oder 1/true. Standardwert ist 0.</p></div>
  </div>
  <div class="row">
    <div class="col-sm-2 col-lg-1"><code>header</code></div>
    <div class="col-sm-8 col-lg-6"><p>Dieser Parameter ist entweder 0/false oder 1/true. Standardwert ist 1.
    Wenn der Paramaterwert 1 ist, wird der Player in einer kompletten HTML-Seite eingebettet ausgegeben.</p></div>
  </div>
  <div class="row">
    <div class="col-sm-2 col-lg-1"><code>index</code></div>
    <div class="col-sm-8 col-lg-6"><p>Im Normalfall wird der Player in einem &lt;div&gt;-Element mit der id 
    'rowImage' ausgegeben. Wenn der Paramater index angegeben wird, werden die Ids aller &lt;div&gt;-Elemente
    um diesen Index erweitert. So ist es m&ouml;glich mehr als einen Player in eine Seite zu integrieren.</p></div>
  </div>
</div>
<hr><h4>Beispiel</h4>
<code><b>https://mobil.mietkamera.de/http-api/live/player/</b>df34e2/512x384</code>
<p>Der Aufruf liefert die img-Ressource des aktuellen Bildes f&uuml;r den
  Kamera-Shorttag df34e2 in einer Aufl&ouml;sung von 512x384 Pixeln.</p>
<hr>
<div class="row">
  <div class="col-1"><a>live</a></div>
</div>