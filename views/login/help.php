  <p class="lead">Das Modul login erm&ouml;glicht die Authentifizierung.</p>
  <h4>URL-Syntax</h4>
  <code><span class="text-success"><?php echo 'https://'.$_SERVER['SERVER_NAME']._URL_STUB_;?>/login/<abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr></code>
  <hr><h4>Methoden</h4>
  <div class="row">
    <div class="col-sm-3"><a href="<?php echo _URL_STUB_.'/login/auth/help';?>">auth</a></div>
    <div class="col-sm-8"><p>Rendert einen Login-Bildschirm f&uuml;r einen Shorttags.</p></div>
  </div>
  <div class="row">
    <div class="col-sm-3"><a href="<?php echo _URL_STUB_.'/login/need_validation/help';?>">need_validation</a></div>
    <div class="col-sm-8"><p>R&uuml;ckgabe eines JSON-Objekts mit Informationen, ob f&uuml;r den Zugriff auf die Medien des Shorttags ein Passwort ben&ouml;tigt wird.</p></div>
  </div>
  <div class="row">
    <div class="col-sm-3"><a href="<?php echo _URL_STUB_.'/login/login/help';?>">login</a></div>
    <div class="col-sm-8"><p>Anmelden via POST f&uuml;r einen Shorttag.</p></div>
  </div>
