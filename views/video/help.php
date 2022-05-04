  <p class="lead">Das Modul video liefert Videostreams, Vorschaubilder oder Videokataloge der Kameras.</p>
  <h5>URL</h5>
  <code><span class="text-success"><?php echo 'https://'.$_SERVER['SERVER_NAME']._URL_STUB_;?>/video/</span><abbr title="Eine Methode des Moduls"><b><em>meth</em></b></abbr>/<abbr title="Shorttag der Kamera"><b><em>st</em></b></abbr>/<abbr title="Parameter der Methode"><b><em>par</em></b></abbr></code>
  <hr><h5>Methoden</h5>
  <div class="row">
    <div class="col-sm-3"><a href="<?php echo _URL_STUB_.'/video/mp4/help';?>">mp4</a></div>
    <div class="col-sm-8"><p>Streamt ein MP4-encodiertes Video. Die URL kann im video-Tag 
    einer HTML5-Datei verwendet werden.</p></div>
  </div>
  <div class="row">
    <div class="col-sm-3"><a href="<?php echo _URL_STUB_.'/video/jpeg/help';?>">jpeg</a></div>
    <div class="col-sm-8"><p>Vorschaubild f&uuml;r ein bestimmtes Video.</p></div>
  </div>
  <div class="row">
    <div class="col-sm-3"><a href="<?php echo _URL_STUB_.'/video/json/help';?>">json</a></div>
    <div class="col-sm-8"><p>Videokatalog einer Kamera.</p></div>
  </div>
  <!--
  <div class="row">
    <div class="col-sm-3"><a href="<?php echo _URL_STUB_.'/video/player/help';?>">player</a></div>
    <div class="col-sm-8"><p>Komplette Videoplayer-Website.</p></div>
  </div>
  -->
  <div class="row">
    <div class="col-sm-3"><a href="<?php echo _URL_STUB_.'/video/download/help';?>">download</a></div>
    <div class="col-sm-8"><p>Liefert die Videodatei zum Download aus.</p></div>
  </div>
