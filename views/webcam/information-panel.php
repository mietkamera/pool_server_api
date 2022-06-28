      <div id="ci_<?php echo $this->shorttag;?>" class="col-12 px-0 mx-0">
        <?php if (isset($this->caption)) { ?>
        <h5><?php echo $this->caption;?></h5>
        <?php } ?>
        <div class="form-group row py-1 my-0">
          <label class="col-form-label col-form-label-sm col-4">Name:</label>
          <div class="col-8">
            <input class="form-control form-control-sm" type="text" disabled value="<?php echo htmlentities($this->data['name']);?>">
          </div>
        </div>
        <div class="form-group row py-1 my-0">
          <label class="col-form-label col-form-label-sm col-4">Projekt:</label>
          <div class="col-8">
            <input class="form-control form-control-sm" type="text" disabled value="<?php echo htmlentities($this->data['project_name']);?>">
          </div>
        </div>
        <div class="form-group row py-1 my-0">
          <label class="col-form-label col-form-label-sm col-4">Status:</label>
          <div class="col-8">
          	<div class="row m-0 p-0">
          	  <div class="col m-0 p-0">
          	    <div class="input-group input-group-sm">
          	      <button class="btn btn-sm" type="button" data-toggle="collapse" data-target="#st_<?php echo $this->shorttag;?>Chart" aria-expanded="false" aria-controls="st_<?php echo $this->shorttag;?>Chart">
                     <i class="fas fa-chevron-down"></i></button> 
                  <input class="status-text form-control form-control-sm" type="text" disabled value="...">
          	    </div>
          	  </div>
          	</div>
          	<div class="row m-0 p-0 collapse" id="st_<?php echo $this->shorttag;?>Chart">
          	  <div class="col m-0 p-0">
                <img class="status-chart img img-fluid h-75 d-none"/>
          	  </div>
          	</div>
          </div>
        </div>
        <?php if ($this->data['router_type']!=='virtual') { ?> 
        <div class="form-group row py-1 my-0">
          <label class="col-form-label col-form-label-sm col-4">Bildgr&ouml;&szlig;e:</label>
          <div class="col-8">
            <input class="form-control form-control-sm" type="text" disabled value="<?php echo ImageProfile::size($this->data['image_profile'],$this->data['api_type']);?>">
          </div>
        </div>
        <?php } ?>
        <div class="form-group row py-1 my-0">
          <label class="col-form-label col-form-label-sm col-4">Aufnahmen:</label>
          <div class="col-8">
            <div class="input-group">
              <input class="form-control form-control-sm" type="text" disabled value="<?php echo ImageIteration::description($this->data['image_iteration']).
                              ' '.$this->data['image_start'].':00 - '.$this->data['image_stop'];?>:59">
            </div>
          </div>
        </div>
      </div>
