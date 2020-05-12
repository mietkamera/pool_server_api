<div class="container-fluid">
  <h1>HTTP-API</h1><h6><small class="text-muted">Version <?php echo _VERSION_;?></small></h6>
  <?php $this->help->render_breadcrumb("live");?>
  <p class="lead">Das Modul live liefert einen JS-Player aus, den man in einen iFrame einbauen kann.</p>
  <h5>URL</h5>
  <code><span class="text-success">https://mobil.mietkamera.de/http-api/player/</span><abbr title="Eine Methode des Moduls"><b><em>meth</em></b></abbr>/<abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr>/<abbr title="Parameter der Methode"><b><em>par</em></b></abbr></code>
  <hr><h5>Methoden</h5>
  <div class="row">
    <div class="col-sm-1"><a href="<?php echo _URL_STUB_.'/live/player/help';?>">player</a></div>
    <div class="col-sm-8"><p>Live-Bild einer Kamera mit Player.</p></div>
  </div>
  <hr>
  <h5><a href="<?php echo _URL_STUB_.'/help';?>">HTTP-API Beschreibung</a></h5>
</div>