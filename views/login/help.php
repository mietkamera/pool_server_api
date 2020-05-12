<div class="container-fluid">
  <h1><?php $this->help->render_breadcrumb("login");?></h1>
  <p class="lead">Das Modul login liefert die Methode auth zur Authentifizierung.</p>
  <h5>URL</h5>
  <code><span class="text-success">https://mobil.mietkamera.de/http-api/login/auth/<abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr></code>
  <hr><h5>st = Shorttag</h5>
  <div class="col-sm-8">
    <p>Der Shorttag ist ein sechsstelliger Verweis auf das Kameraverzeichnis. Wenn der
    Shorttag angegeben wird, stellt die API einen Anmeldebildschirm f&uuml;r das Login
    in den Kamerabereich bereit. Dazu wird lediglich ein Passwort ben&ouml;tigt. Wird er
    weggelassen, zeigt die API einen Anmeldebildschirm f&uuml;r den administrativen
    Bereich an.</p>
  </div>
  <hr>
  <h5><a href="<?php echo _URL_STUB_.'/help';?>">HTTP-API Beschreibung</a></h5>
</div>