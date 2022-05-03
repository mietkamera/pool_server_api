  <div class="container-fluid" id="cv_<?php echo $this->shorttag;?>">
    <div class="row">
      <div class="col-12 <?php echo $this->print_information==1?'col-lg-7':'';?> px-0 mx-0">
        <div class="embed-responsive embed-responsive-16by9">
          <video src="" class="video-clip video-fluid z-depth-1 embed-responsive-item shadow-sm" controls muted>
               <!--    <source id="clipSrc" src="#" type="video/mp4"> -->
          </video>
        </div>
      </div>
      <?php if ($this->video_controls) { ?>
      <div id="videoControls" class="col-12">
        <div class="row align-items-center py-2">
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
      </div>
      <?php } ?>
      
    </div>
  </div>
  