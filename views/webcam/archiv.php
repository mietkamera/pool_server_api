<?php
  require_once('libs/cls_apitype.php');
  require_once('libs/cls_imageprofile.php');
  require_once('libs/cls_imageiteration.php');
?>
  <div class="container-fluid container-archiv" id="ca_<?php echo $this->shorttag;?>">
    <div class="row">
      <div class="col-12 <?php echo $this->print_information==1?'col-lg-7':'';?> px-0 mx-0">
      	<div class="control-bar-white p-1 collapse show controller">
          <div class="row">
            <div class="col-12">
              <div class="btn-group btn-block">
                <a href="#" class="picture-btn-download btn btn-sm btn-outline-warning rounded mr-2"><i class="fas fa-save"></i></a>
                <button class="time-left-btn change-time-controller btn btn-sm btn-outline-secondary rounded mr-2"><i class="fas fa-caret-left"></i></button>
                <input type="range" class="time-range change-time-controller custom-range mt-1 mr-2 d-none d-sm-inline-block">
                <button class="time-right-btn change-time-controller btn btn-sm btn-outline-secondary rounded mr-2"><i class="fas fa-caret-right"></i></button>
                <button class="time-last-btn change-time-controller btn btn-sm btn-outline-danger rounded mr-2"><i class="fas fa-angle-double-right"></i></button>
                <button class="dayStr btn btn-sm btn-outline-primary rounded mr-2 font-weight-bold"
                        data-toggle="modal" 
                        data-target="#modal_archiv_<?php echo $this->shorttag;?>">00.00.0000</button>
                <div class="timeStr btn btn-sm btn-outline-secondary rounded font-weight-bold">00:00</div>
              </div>
            </div>
          </div>
        </div>
        <img  
             class="picture img img-fluid auto-scale"
             data-toggle="collapse"
             data-target=".controller"
             src="<?php echo _URL_STUB_.'/image/last/'.$this->shorttag.'/.'.($this->data['router_type']=='virtual'?'':ImageProfile::best_fitting_profile($this->data['api_type'],'1280x720'));?>">
        <div class="control-bar-white curtain h-100" id="loading-div">
          <div class="d-flex align-items-center justify-content-center h-100">
            <div class="d-flex flex-column">
              <h5 class="text align-self-center">Einen Augenblick Geduld...</h5>
              <p>Lade Daten vom <span class="dayStr"></span></p>
              <div class="btn-group ">
                <button class="btn btn-info align-self-center p-2" type="button" name="button">
                  <span class="spinner-border spinner-border-sm"></span>&nbsp;
                  <span class="img-loaded"></span> / <span class="img-max"></span>
                </button>
                <a href="javascript:window.location.reload();" class="btn btn-danger col-3">
                  <i class="fas fa-sync-alt"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        
        <div class="row py-0 px-0 mx-0 bg-secondary text-white border">
          <div class="col-day-counter col-4 d-none d-md-inline-block" id="col-info-1">
            
          </div>
          <div class="col-online-status col-4 col-md-2" align="center">
            
          </div>
          <div class="col-loading-spinner col-2 col-md-1" align="center">
            
          </div>
          <div class="col-image-counter col-6 col-md-5 items-align-right">
            
          </div>
        </div>
        

      </div>
      
<?php if (isset($this->print_information) && $this->print_information===1) {       
        $this->caption = 'Bildarchiv | &Uuml;bersicht';
        $this->render('webcam/information-panel');
      } ?>    

    </div>
  
  <!-- Dialog zur Auswahl des Datums -->
  <div class="modal fade mx-auto" id="modal_archiv_<?php echo $this->shorttag;?>">
    <div class="modal-dialog d-flex">
      <div class="modal-content flex-shrink-1 w-auto mx-auto">

        <div class="modal-header">
          <h5 class="modal-title dayStr"></h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-12  px-0 mx-0">
              <div class="control-bar-white">
                <div class="row">
                  <div class="col-12">
                    <div class="btn-group btn-block">
                      <button class="day-left-btn btn btn-sm btn-outline-secondary ml-1 mr-2"><i class="fas fa-caret-left"></i></button>
                      <input id="day" type="range" class="day-range custom-range mt-1 mr-2">
                      <button class="day-right-btn btn btn-sm btn-outline-secondary mr-1"><i class="fas fa-caret-right"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <img class="day-thumb-img img img-fluid auto-scale goto-day-btn">
              <button type="button" class="btn btn-info btn-block goto-day-btn" data-dismiss="modal">Setzen und Schlie&szlig;en</button>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <div class="btn-group btn-group-sm">
            
            <button type="button" class="btn btn-warning" data-dismiss="modal">Schlie&szlig;en</button>
          </div>
        </div>

      </div>
    </div>
  </div>

  </div>  <!-- container -->
