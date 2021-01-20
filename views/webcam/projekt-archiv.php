            <div class="row ">
              <div class="col-md-8 col-lg-9">
                <div class="row px-2 py-2">
                  <div class="col m-0 p-0">
                  	<div class="btn-group btn-block">
            <!--      	  <btn href="#archiv_header" class="btn btn-sm btn-warning" data-toggle="collapse"><i class="fas fa-arrows-alt-v"></i></btn>  -->
                      <span id="dayStr" class="btn btn-sm btn-outline-primary d-none d-lg-inline-block">00.00.0000</span>
                      <span id="timeStr" class="btn btn-sm btn-outline-secondary">00:00</span>
                      <span id="timeLeft" class="btn btn-sm btn-success"><i class="fas fa-caret-left"></i></span>
                      <input id="time" type="range" class="form-control-range ml-2 mr-2">
                      <span id="timeRight" class="btn btn-sm btn-warning"><i class="fas fa-caret-right"></i></span>
                    </div>
                  </div>
                </div>
                <div class="row px-2">
                  <div class="col-12 m-0 p-0">
                    <img id="picture" src="<?php echo _URL_STUB_.'/public/images/empty.jpg';?>" class="img-fluid auto-scale rounded">
                    <div class="controlBar">
                      <div class="btn-group">
                        <a id="btn-download" href="#" class="btn btn-sm btn-outline-warning opacity-5"><i class="fas fa-save"></i> download</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-lg-3">
                <div class="row px-2">
                  <div class="col py-2">
                  	<div class="btn-group btn-block">
                  	  <span id="dayStr2" class="btn btn-sm btn-outline-primary">00.00.0000</span>
                      <input id="day" type="range" class="form-control-range ml-2">
                    </div>
                  </div>
                </div>
                <div class="row px-2">
                  <div class="col ">
                    <img id="dayThumb" class="img-fluid auto-scale rounded">
                  </div>
                </div>
                <div class="row px-2 py-2">
                  <div class="col">
                    <div class="btn-group btn-block">
                      <btn id="dayLeft" class="btn btn-sm btn-success"><i class="fas fa-caret-left"></i></btn>
                      <btn id="dayRight" class="btn btn-sm btn-warning"><i class="fas fa-caret-right"></i></btn>
                    </div>
                  </div>
                </div>
                <div class="row px-2 py-2">
                  <div id="info" class="col">
                  	<div id="camStatus">
                      <img id="mrtgDayChart" src="#" class="img-fluid rounded">
                      <div id="camBtn" class="py-2"></div>
                    </div>
                  </div>
                </div>
                <div class="row px-2">
                  <div id="help" class="col">
                    
                  </div>
                </div>
              </div>
            </div>
