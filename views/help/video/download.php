<p class="lead">Liefert die f&uuml;r eine Kamera erstellten Videos als Download aus.</p>
<h4>URL-Syntax</h4>
<code><span class="text-success"><?php echo _URL_STUB_.'/'.$this->module.'/'.$this->method.'/';?></span><abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr>/<abbr title="Parameter der Methode"><b><em>par</em></b></abbr></code>
<p></p>
<div class="col-sm-10">
  <h5>st = Shorttag</h5>
  <p>Der Shorttag ist ein sechsstelliger Verweis auf das Kameraverzeichnis. Er muss angegeben werden.</p>
  <h5>par = Parameter</h5>
  <p>Syntax: <code>size[.all|.kw.date]</code></p>
  <div class="row">
    <div class="col-sm-3 col-lg-2"><code>size</code></div>
    <div class="col-sm-8 col-lg-6"><p>Dieser Wert dieses Parameters ist entweder hd (1920x1080) 
    oder vgax (768x432). Beide Formate sind 16:9. Wenn der Wert ausgelassen wird, wird hd als 
    Standard angenommen.</p></div>
  </div>
   <div class="row">
    <div class="col-sm-3 col-lg-2"><code>all|kw</code></div>
    <div class="col-sm-8 col-lg-6"><p>Dieser optionale Parameter legt fest, ob das Video &uuml;ber die
    gesamte Aufnahmezeit oder f&uuml;r eine bestimmte Kalenderwoche ausgeliefert wird. Wird der Parameter 
    nicht angegeben, wird das Gesamtvideo ausgegeben.</p></div>
  </div>
   <div class="row">
    <div class="col-sm-3 col-lg-2"><code>date</code></div>
    <div class="col-sm-8 col-lg-6"><p>Wenn kw als Wert des zweiten Parameters angegeben wurde,
    muss hier die Kalenderwoche im Format YYYYWW spezifiziert werden.</p></div>
  </div>
</div>
<hr><h4>Beispiel</h4>
  <code><b>https://<?php echo $_SERVER['SERVER_NAME']._URL_STUB_.'/'.$this->module.'/'.$this->method.'/';?></b>df34e2/vgax.all</code>
  <p>Der Aufruf liefert die Videodatei &uuml;ber die gesamte Aufnahmezeit in 768x432 Pixeln.</p>
  <code><b>https://<?php echo $_SERVER['SERVER_NAME']._URL_STUB_.'/'.$this->module.'/'.$this->method.'/';?></b>df34e2/hd.kw.201804</code>
  <p>Der Aufruf liefert die Videodatei der vierten Kalenderwoche in 2018 in 1920x1080 Pixeln.</p>
