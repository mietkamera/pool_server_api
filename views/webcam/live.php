<?php
  require_once('libs/cls_apitype.php');
  require_once('libs/cls_imageprofile.php');
  require_once('libs/cls_imageiteration.php');
?>
  <div class="container-fluid" id="cl_<?php echo $this->shorttag;?>">
    <div class="row">
      <div class="col-12 <?php echo $this->print_information==1?'col-lg-7':'';?> px-0 mx-0">
      	<div class="control-bar-white p-1 collapse show controller">
          <div class="row">
          	<div class="col-9 col-sm-10 col-lg-8 pr-0">
              <div class="btn-group btn-block">
              	
                <button id="start-btn" class="start-btn col-2 col-sm-1 btn btn-sm btn-outline-secondary rounded">
                  <i class="fas fa-play"></i>
                </button>
                
                <div class="col-10">
                  <div class="row m-0 p-0">
                    <div class="col m-0 p-0">
                      <div class="progress">
                        <div class="progress-bar" style="width:100%">20</div>
                      </div>
                    </div>
                  </div>
                  <div class="row m-0 p-0">
                    <div class="col d-flex m-0 p-0">
                      <div class="row m-0 p-0">
                        <div class="col ml-0 p-0 col-online-status"></div>
                        <div class="col ml-2 p-0 col-play-status"></div>
                        <div class="col ml-2 col-loading-spinner btn btn-xs"></div>
                      </div>
            		</div>
                  </div>
                </div>

              </div>
          	</div>
          	<div class="col-3 col-sm-2 col-lg-4 ml-0 pl-0">
              <div class="btn-group btn-block">
                <div class="dayStr d-none d-lg-inline-block mr-2 btn btn-sm btn-outline-secondary rounded mr-2 font-weight-bold">00.00.0000</div>
                <div class="timeStr ml-0 btn btn-sm btn-outline-secondary rounded font-weight-bold">00:00</div>
              </div>
          	</div>
          </div>
        </div>
        <img id="picture-live" name="picture-live" 
             class="picture img img-fluid auto-scale"
             data-toggle="collapse"
             data-target=".controller"
             data-src="<?php echo $this->live_src;?>"
             data-autostart="<?php echo $this->autostart;?>"
             >

      </div>
      
<?php if (isset($this->print_information) && $this->print_information===1) {       
        $this->caption = 'Live-Bild | &Uuml;bersicht';
        $this->render('webcam/information-panel');
      } ?>    

    </div>
  </div>  <!-- container -->
