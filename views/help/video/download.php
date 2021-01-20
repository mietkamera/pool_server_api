  <p class="lead">Liefert die f&uuml;r eine Kamera erstellten Videos als Download aus.</p>
  <h5>URL</h5>
  <code><span class="text-success">https://mobil.mietkamera.de/http-api/video/download/</span><abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr>/<abbr title="Parameter der Methode"><b><em>par</em></b></abbr></code>
  <hr><h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechsstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.</p>
  <h5>par = Parameter</h5>
  <p>Syntax: <code>size[.all|.kw.date]</code></p>
  <div class="row">
    <div class="col-sm-2 col-lg-1"><code>size</code></div>
    <div class="col-sm-8 col-lg-6"><p>Dieser Wert dieses Parameters ist entweder hd (1920x1080) 
    oder vgax (768x432). Beide Formate sind 16:9. Wenn der Wert ausgelassen wird, wird hd als 
    Standard angenommen.</p></div>
  </div>
   <div class="row">
    <div class="col-sm-2 col-lg-1"><code>all|kw</code></div>
    <div class="col-sm-8 col-lg-6"><p>Dieser optionale Parameter legt fest, ob das Video &uuml;ber die
    gesamte Aufnahmezeit oder f&uuml;r eine bestimmte Kalenderwoche ausgeliefert wird. Wird der Parameter 
    nicht angegeben, wird das Gesamtvideo ausgegeben.</p></div>
  </div>
   <div class="row">
    <div class="col-sm-2 col-lg-1"><code>date</code></div>
    <div class="col-sm-8 col-lg-6"><p>Wenn kw als Wert des zweiten Parameters angegeben wurde,
    muss hier die Kalenderwoche im Format YYYYWW spezifiziert werden.</p></div>
  </div>
  <hr><h5>Beispiel</h5>
  <code><b>https://mobil.mietkamera.de/http-api/video/download/</b>df34e2/vgax.all</code>
  <p>Der Aufruf liefert die Videodatei &uuml;ber die gesamte Aufnahmezeit in 768x432 Pixeln.</p>
  <code><b>https://mobil.mietkamera.de/http-api/video/download/</b>df34e2/hd.kw.201804</code>
  <p>Der Aufruf liefert die Videodatei der vierten Kalenderwoche in 2018 in 1920x1080 Pixeln.</p>