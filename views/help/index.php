<div class="container">
  <h1>HTTP-API</h1>
  <p class="lead"><i>Die HTTP-API definiert verschiedene Module, die mit Hilfe von 
  Methoden Bild-, Stream- oder Videodaten eines Kamerasystems ausliefern.</i></p>
  <h4>Beschreibung</h4>
  <p>Die Aufgabe der API besteht darin, den Abruf der Bild- und Videodaten eines Kamerasystems nach festen Regeln 
     zu erm&ouml;glichen. Jedes Kamerasystem wird dabei &uuml;ber einen sechstelligen Code - den sogenannten Shorttag - 
     identifiziert. Mit Hilfe eines HTTP-GET-Requests, der den Shorttag enth&auml;lt, werden Image-, Video-, oder 
     JSON-Ressourcen zur&uuml;ckgegeben.
  </p>
  <p>Wenn Bilder oder Informationen von einer passwortgesch&uuml;tzten Kamera abgerufen werden sollen, 
     wechselt die HTTP-API automatisch zum Login-Screen. Nach dem
     erfolgreichen Login, wird die urspr&uuml;ngliche URL aufgerufen.
  </p>
  <p>Die API liefert auch bei gro&szlig;en Bildserien schnell die gew&uuml;nschten Daten, da sie auf einen
     effizienten Speicherdienst zugreift.
  </p>
  <h4>URL-Syntax</h4>
  <p>Der Aufruf der HTTP-API beginnt mit dem URL-Stub <code><?php echo _URL_STUB_.'/';?></code> gefolgt von 
  jeweils durch Slashes getrenntem Modulnamen (mod), dem Methodennamen (meth), dem Kamera-Shorttag (st) und den 
  Parameterwerten der gew&auml;hlten Methode (par). Die Syntax sehen Sie hier:
  </p>
  <code><span class="text-success">https://<?php echo $_SERVER['SERVER_NAME']._URL_STUB_;?>/</span><abbr 
     title="Name des Modules"><b><em>mod</em></b></abbr>/<abbr 
     title="Eine Methode des Moduls"><b><em>meth</em></b></abbr>/<abbr 
     title="Shorttag der Kamera"><b><em>st</em></b></abbr>/<abbr 
     title="Parameter der Methode"><b><em>par</em></b></abbr>
  </code>
  <p></p>
  <hr><h4>Module</h4>
  <div class="row">
    <div class="col-md-3 col-lg-2"><a href="<?php echo _URL_STUB_.'/image/help';?>">image</a></div>
    <div class="col-md-8 col-lg-9"><p>Ausgabe von Einzelbildern einer Kamera in verschiedenen 
    Gr&ouml;&szlig;en oder Informationen &uuml;ber die gespeicherten Bilder einer 
    Kamera im JSON-Format. Auch ein Livebild kann abgerufen werden, wenn die Kamera 
    aktiv ist.</p></div>
  </div>
  <div class="row">
    <div class="col-md-3 col-lg-2"><a href="<?php echo _URL_STUB_.'/mjpeg/help';?>">mjpeg</a></div>
    <div class="col-md-8 col-lg-9"><p>Ausgabe von MJPEG-Streams die aus den gespeicherten Bildern
    erzeugt werden. Die Aufl&ouml;sung und der Datumsbereich der Bilder aus denen der 
    Stream bestehen soll, k&ouml;nnen angegeben werden.</p></div>
  </div>
  <div class="row">
    <div class="col-md-3 col-lg-2"><a href="<?php echo _URL_STUB_.'/video/help';?>">video</a></div>
    <div class="col-md-8 col-lg-9"><p>Ausgabe von Videos einer Kamera oder Informationen 
    &uuml;ber die vorhandenen Videos einer Kamera im JSON-Format.</p></div>
  </div>
  <div class="row">
    <div class="col-md-3 col-lg-2"><a href="<?php echo _URL_STUB_.'/webcam/help';?>">webcam</a></div>
    <div class="col-md-8 col-lg-9"><p>Ausgabe von kompletten HTML-Seiten mit Archivbildern, Videos und 
    Kombinationen daraus, die der Kunde als Projektseite f&uuml;r den Zugriff auf seine Bilddaten verwenden 
    kann. Die Seiten k&ouml;nnen passwortgesch&uuml;tzt sein.</p></div>
  </div>
  <div class="row">
    <div class="col-md-3 col-lg-2"><a href="<?php echo _URL_STUB_.'/login/help';?>">login</a></div>
    <div class="col-md-8 col-lg-9"><p>Login und Statusinformationen.
    </p></div>
  </div>
  <div class="row">
    <div class="col-md-3 col-lg-2"><a href="<?php echo _URL_STUB_.'/status/help';?>">status</a></div>
    <div class="col-md-8 col-lg-9"><p>Ausgabe von Statusinformationen f&uuml;r eine Kamera im JSON-Format.</p></div>
  </div>
<!--  <div class="row">
    <div class="col-sm-1"><a href="<?php echo _URL_STUB_.'/player/help';?>">player</a></div>
    <div class="col-sm-8"><p>Ausgabe eines kompletten JavaScript-basierten HTML-Players
    </p></div>
  </div> -->
  <hr />
  <hr><h4>Authentifizierung</h4>
    <p>Wenn Bilder oder Informationen von einer Kamera abgerufen werden sollen, die 
    passwortgesch&uuml;tzt ist, gibt es die M&ouml;glichkeit vorab das <a href="<?php echo _URL_STUB_.'/login/help';?>">
    Login-Modul</a> direkt aufzurufen. Es liefert eine auth-Methode, um die Anmeldung 
    durchzuf&uuml;ren.</p>
  <h4>Vordefinierte Bildgr&ouml;&szlig;en</h4>
  <p>Die Kamerasysteme speichern die Einzelbilder der Kameras in Abh&auml;ngigkeit vom eingesetzten Kameratyp
  entweder in einem 4:3-Format von 2018x1536 oder 3072x2048 oder einem 16:9-Formate in 1280x720 oder 1920x1080 
  Pixeln ab. Beim Abruf der Bilder k&ouml;nnen auch andere Formate angegeben werden. Die Angabe des Formats 
  kann dabei entweder in Pixeln oder in einer Abk&uuml;rzung erfolgen.</p>
  <p>Folgende Formatangaben sind zul&auml;ssig: <?php $this->help->list_image_sizes();?></p>
  
  <div class="row">
    <div class="col"><a href="/legal/impressum/help">impressum</a>&nbsp;|&nbsp;<a href="/legal/agb/help">agb</a>&nbsp;|&nbsp;<a href="/legal/datenschutz/help">datenschutz</a></div>
  </div>
</div>
