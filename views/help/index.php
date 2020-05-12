<div class="container-fluid">
  <h1>HTTP-API</h1>
  <p class="lead"><i>Die HTTP-API definiert verschiedene Module, die mit Hilfe von 
  Methoden Bild-, Stream- oder Videodaten eines Kamerasystems ausliefern.</i></p>
  <h4>Beschreibung</h4>
  <p>Die Aufgabe der API besteht darin, den Abruf der Daten eines Kamerasystems nach genau festgelegten Regeln 
  zu erm&ouml;glichen. Jedes Kamerasystem wird dabei durch einen sechstelligen Code - den sogenannten Shorttag - 
  identifiziert. Die API kann mit Hilfe dieses Shorttags den Speicherbereich der Kamera finden, pr&uuml;fen
  ob ein Login notwendig ist und anschlie&szlig;end Daten ausliefern. Dadurch ist es m&ouml;glich, den 
  tats&auml;chlichen Speicherpfad zu verbergen und die Web-Anwendung effektiv abzusichern.</p>
  <p>Die API nutzt dar&uuml;ber hinaus einen Mechanismus zum Caching von Metainformationen &uuml;ber die
  Bildserien. So muss nicht bei jedem Aufruf der API die Liste aller Bilder eines bestimmten Jahres, Monats 
  oder Tages durch Abfrage der Verzeichnisse des Dateiservers ermittelt werden. Diese Informationen werden
  nach dem ersten Abruf gespeichert und bei Bedarf aus einer Datei geladen. Dieser Algorithmus liefert
  schnelle Antworten auch bei gro&szlig;en Bildserien.</p>
  <h4>URL-Syntax</h4>
  <p>Der Aufruf der HTTP-API beginnt mit dem URL-Stub <code><?php echo _URL_STUB_.'/';?></code> gefolgt von 
  jeweils durch Slashes getrenntem Modulnamen (mod), dem Methodennamen (meth), dem Kamera-Shorttag (st) und den 
  Parameterwerten der gew&auml;hlten Methode (par). Die Syntax sehen Sie hier:
  </p>
  <code><span class="text-success">https://mobil.mietkamera.de/http-api/</span><abbr 
     title="Name des Modules"><b><em>mod</em></b></abbr>/<abbr 
     title="Eine Methode des Moduls"><b><em>meth</em></b></abbr>/<abbr 
     title="Shorttag der Kamera"><b><em>st</em></b></abbr>/<abbr 
     title="Parameter der Methode"><b><em>par</em></b></abbr>
  </code>
  <p></p>
  <p>Zur besseren Verdeutlichung ein Beispiel: &Uuml;ber die folgende URL wird f&uuml;r den Kamera-Shorttag '44a3f4' 
  das letzte im Mai 2019 gespeicherte Bild im Format 512x384 Pixel zur&uuml;ckgegeben. Diese URL k&ouml;nnte 
  im SRC-Parameter eines &lt;IMG&gt;-Tags verwendet werden. Der Abruf des Bildes ist in diesem Fall 
  zus&auml;tzlich durch ein Passwort gesichert. Sollten Sie dem Link folgen, m&uuml;ssen Sie als Passwort 
  'demo' eingeben:
  <code><a href="https://mobil.mietkamera.de/http-api/image/last/44a3f4/201905.512x384" 
    target="_blank">https://mobil.mietkamera.de/http-api/image/last/44a3f4/201905.512x384</a></code></p>
  <hr><h4>Module</h4>
  <div class="row">
    <div class="col-sm-1"><a href="<?php echo _URL_STUB_.'/image/help';?>">image</a></div>
    <div class="col-sm-8"><p>Ausgabe von Einzelbildern einer Kamera in verschiedenen 
    Gr&ouml;&szlig;en oder Informationen &uuml;ber die gespeicherten Bilder einer 
    Kamera im JSON-Format. Auch ein Livebild kann abgerufen werden, wenn die Kamera 
    aktiv ist.</p></div>
  </div>
  <div class="row">
    <div class="col-sm-1"><a href="<?php echo _URL_STUB_.'/mjpeg/help';?>">mjpeg</a></div>
    <div class="col-sm-8"><p>Ausgabe von MJPEG-Streams die aus den gespeicherten Bildern
    erzeugt werden. Die Aufl&ouml;sung und der Datumsbereich der Bilder aus denen der 
    Stream bestehen soll, k&ouml;nnen angegeben werden.</p></div>
  </div>
  <div class="row">
    <div class="col-sm-1"><a href="<?php echo _URL_STUB_.'/video/help';?>">video</a></div>
    <div class="col-sm-8"><p>Ausgabe von Videos einer Kamera oder Informationen 
    &uuml;ber die vorhandenen Videos einer Kamera im JSON-Format.</p></div>
  </div>
  <div class="row">
    <div class="col-sm-1"><a href="<?php echo _URL_STUB_.'/live/help';?>">live</a></div>
    <div class="col-sm-8"><p>Ausgabe von Playern und Statusinformationen.
    </p></div>
  </div>
  <div class="row">
    <div class="col-sm-1"><a href="<?php echo _URL_STUB_.'/player/help';?>">player</a></div>
    <div class="col-sm-8"><p>Ausgabe eines kompletten JavaScript-basierten HTML-Players
    </p></div>
  </div>
  <hr><h4>Vordefinierte Bildgr&ouml;&szlig;en</h4>
  <p>Die Kamerasysteme speichern die Einzelbilder der Kameras in Abh&auml;ngigkeit vom eingesetzten Kameratyp
  entweder im Format 2018x1536 oder 3072x2048 ab. Beide Formate entsprechen einem Seitenverh&auml;ltnis von
  4:3. Ausgehend von diesem Format k&ouml;nnen weitere 4:3 aber auch 16:9 Formate abgerufen werden. Die Angabe 
  des Formats kann dabei entweder in Pixeln oder in einer Abk&uuml;rzung erfolgen.</p>
  <p>Folgende Formatangaben sind zulässig: <?php $this->help->list_image_sizes();?></p>
  
  <hr><h4>Authentifizierung</h4>
    <p>Wenn Bilder oder Informationen von einer Kamera abgerufen werden sollen, die 
    passwortgesch&uuml;tzt ist, wechselt die HTTP-API automatisch zum Login-Screen. Nach dem
    erfolgreichen Login, wird die urspr&uuml;ngliche URL aufgerufen.</p>
    <p>Es gibt aber auch die Möglichkeit das <a href="<?php echo _URL_STUB_.'/login/help';?>">
    Login-Modul</a> direkt aufzurufen. Es liefert eine auth-Methode, um die Anmeldung 
    durchzuf&uuml;ren.</p>
  </div>