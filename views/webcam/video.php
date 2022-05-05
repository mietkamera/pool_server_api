<?php
  require_once('libs/cls_apitype.php');
  require_once('libs/cls_imageprofile.php');
  require_once('libs/cls_imageiteration.php');
?>
  <div class="container-fluid container-video" id="cv_<?php echo $this->shorttag;?>">
    <div class="row">
      <div class="col-12 <?php echo $this->print_information===1?'col-lg-7':'';?> px-0 mx-0">
      	<div class="row px-0 mx-0">
          <div class="embed-responsive embed-responsive-16by9">
            <video src="" class="video-clip video-fluid z-depth-1 embed-responsive-item shadow-sm" controls muted>
               <!--    <source id="clipSrc" src="#" type="video/mp4"> -->
            </video>
        </div>
        <?php if ($this->video_controls) { ?>
        <div id="videoControls" class="row px-0 mx-0 pt-2 video-controls">
          <div class="col-12">
            <div class="btn-group btn-group-sm">
              <div class="custom-control custom-switch pt-1">
                <input type="checkbox" class="switch-hd custom-control-input"<?php echo $this->video_size=='hd'?" checked":"";?> id="switchHD">
                <label class="custom-control-label" for="switchHD">HD-Aufl&ouml;sung</label>
              </div>
              <a href="#" class="video-download-btn btn btn-sm btn-outline-warning ml-3 rounded"><i class="fas fa-save"></i></a>
            </div>
            <ul class="video-playlist px-0 mx-0"></ul>
          </div>
        </div>
        <?php } ?>
        </div>
      </div>


<?php if (isset($this->print_information) && $this->print_information===1) {       
        $this->caption = 'Zeitrafferarchiv | &Uuml;bersicht';
        $this->render('webcam/information-panel');
      } ?>    
    </div>
  </div>