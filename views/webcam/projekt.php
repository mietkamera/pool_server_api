<link rel="stylesheet" href="<?php echo _URL_STUB_.'/views/webcam/projekt.css';?>">
<div class="container-fluid pt-2">
  <div id="projekt_header" class="row<?php echo $this->cookie_show_header==1?'':' collapse';?>">
    <div class="col-md-8 col-lg-9">
      <span id="info-projekt" class="h4 py-0"></span>
      <p class="">
      	<span id="info-kamera" class="h5 text-primary">&nbsp;</span>
      	<span id="info-beschreibung"></span>
      	<btn id="closeHeader" class="btn btn-sm btn-warning py-0"><i class="fas fa-angle-double-up"></i></btn>
      </p>
    </div>
<!--    <div class="col-md-4 col-lg-3 d-none d-md-inline-block d-lg-inline-block text-right">
      <img class="ml-2 float-right" src="/http-api/public/images/favicon-32x32.png">
      <h5 class="py-0"><a href="https://mietkamera.de" class="text-dark text-decoration-none">mietkamera.de</a></h5><small>Webcams f&uuml;r Baustellen mieten</small>
    </div>  -->
  </div>
  
  <div class="row">
  
    <div id="cam_sidebar" class="col-lg-2<?php echo $this->cookie_show_sidebar==1?'':' collapse';?>">
      <div id="other" class="row">
      	<div class="col-lg-12 d-lg-inline-block py-2">
      	  <span id="closeSidebar" class="btn btn-sm btn-outline-info btn-block"><i class="fas fa-angle-double-left"></i>&nbsp;Andere Perspektiven</span>
      	</div>
      </div>
    </div>
    
    <main id="cam_content" class="col">
      
      
      <div class="card pt-0" style="width:100%">
        <div class="card-header">
  	    	
          <ul class="nav nav-tabs card-header-tabs" id="mytab-list" role="tablist">
            <li class="nav-item">
          	  <btn id="openSidebar" class="btn btn-sm btn-info<?php echo $this->cookie_show_sidebar==0?'':' collapse';?>"><i class="fas fa-bars"></i></btn> 
              <btn id="openHeader" class="btn btn-sm btn-warning mr-1<?php echo $this->cookie_show_header==0?'':' collapse';?>"><i class="fas fa-bars"></i></btn>
    <!--          <btn id="toggleSidebar" class="btn btn-sm btn-info"><i class="fas fa-bars"></i></btn> -->
            </li>
            <li class="nav-item" id="nav_archiv">
              <a class="nav-link active" href="#archiv" role="tab" aria-controls="archiv" aria-selected="true">Bilder</a>
            </li>
            <li class="nav-item" id="nav_video">
              <a class="nav-link" href="#video" role="tab" aria-controls="video" aria-selected="false">Videos</a>
            </li>
             <li class="nav-item" id="nav_live">
              <a class="nav-link" href="#live" role="tab" aria-controls="monitor" aria-selected="false">Live</a>
            </li>
          </ul>
        </div>
      
        <div class="card-body bg-white text-dark">
          <div class="tab-content">
    
            <div class="tab-pane active" id="archiv" role="tabpanel">
            <?php $this->render('webcam/projekt-archiv'); ?>          	
            </div> <!-- tab-pane archiv -->
          
            <div class="tab-pane" id="video" role="tabpanel">
            <?php $this->render('webcam/projekt-videos'); ?>
            </div> <!-- tab-pane video -->
          
            <div class="tab-pane" id="live" role="tabpanel">
            <?php $this->render('webcam/projekt-live'); ?>
            </div> <!-- tab-pane video -->

          </div> <!-- tab-content -->
        </div> <!-- card-body -->
      </div> <!-- card -->
    </main>
  </div>
  
  <div class="row">
    <div class="col">
      
    </div>
  </div>
</div>

<script src="<?php echo _URL_STUB_.'/views/webcam/projekt.js';?>"></script>