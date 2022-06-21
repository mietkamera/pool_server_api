<div class="container-fluid">
  <div class="row">
    <div class="col px-0 mx-0">  
      <div class="card px-0 mx-1 pt-0" style="width:100%">
        <div class="card-header">
  	    	
          <ul class="nav nav-tabs card-header-tabs" id="project-tab-list" role="tablist">
           <li class="nav-item" id="nav_archiv">
              <a class="nav-link active" href="#pane-archiv" role="tab" aria-controls="pane-archiv" aria-selected="true">Bilder</a>
            </li>
            <li class="nav-item" id="nav_video">
              <a class="nav-link" href="#pane-video" role="tab" aria-controls="pane-video" aria-selected="false">Videos</a>
            </li>
<?php if ($this->data['allow_live']=="true") { ?>            
            <li class="nav-item" id="nav_live">
              <a class="nav-link" href="#pane-live" role="tab" aria-controls="pane-live" aria-selected="false">Live</a>
            </li>
<?php } ?>
<!--
            <li class="nav-item" id="nav_weather">
              <a class="nav-link" href="#pane-weather" role="tab" aria-controls="pane-weather" aria-selected="false">Wetter</a>
            </li>
-->
          </ul>
        </div>
        <?php
          $pi = $this->print_information;
          $this->print_information=false;
        ?>
        <div class="card-body mx-1 px-0 py-1">
          <div class="tab-content">
    
            <div class="tab-pane active" id="pane-archiv" role="tabpanel">
            <?php $this->render('webcam/archiv'); ?>          	
            </div> <!-- tab-pane archiv -->
          
            <div class="tab-pane" id="pane-video" role="tabpanel">
            <?php $this->render('webcam/video'); ?>
            </div> <!-- tab-pane video -->
<?php if ($this->data['allow_live']=="true") { ?>          
            <div class="tab-pane" id="pane-live" role="tabpanel">
            <?php $this->render('webcam/live'); ?>
            </div> <!-- tab-pane video -->
<?php } ?>
<!--
			<div class="tab-pane" id="pane-weather" role="tabpanel">
            <?php $this->render('weather/pane'); ?>
            </div>
-->
          </div> <!-- tab-content -->
        </div> <!-- card-body -->
      </div> <!-- card -->
    </div>
    <?php 
      $this->print_information = $pi;
      if (isset($this->print_information) && $this->print_information===1) {       
        $this->caption = 'Projekt | &Uuml;bersicht';
        $this->render('webcam/information-panel');
      } 
    ?>    

    
  </div>
</div>
