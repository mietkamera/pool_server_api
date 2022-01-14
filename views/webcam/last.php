<?php
  require_once('libs/cls_apitype.php');
  require_once('libs/cls_imageprofile.php');
  require_once('libs/cls_imageiteration.php');
?>
  <div class="container-fluid" id="cla_<?php echo $this->shorttag;?>">
    <div class="row">
      <div class="col-12 <?php echo $this->print_information==1?'col-lg-7':'';?> px-0 mx-0">
      	<div class="control-bar-white p-1 collapse show controller">
          <div class="row">
          	<div class="col-4">
              <a href="#" class="picture-btn-download btn btn-sm btn-outline-warning rounded ml-1"><i class="fas fa-save"></i></a>
          	</div>
          	<div class="col-online-status col-2">
          	  
          	</div>
            <div class="col-loading-spinner col-2" align="center">
              <div class="spinner-grow spinner-grow-sm text-danger"></div>
            </div>
            <div class="col-4">
              <div class="btn-group btn-block">
                <div class="dayStr btn btn-sm btn-outline-secondary rounded mr-2">00.00.0000</div>
                <div class="timeStr btn btn-sm btn-outline-secondary rounded">00:00</div>
              </div>
            </div>
          </div>
        </div>
        <img 
             class="picture img img-fluid auto-scale"
             data-toggle="collapse"
             data-target=".controller"
             >

      </div>
      
<?php if (isset($this->print_information) && $this->print_information===1) {       
        $this->caption = 'Letztes Bild | &Uuml;bersicht';
        $this->render('webcam/information-panel');
      } ?>    

    </div>
  </div>  <!-- container -->
  