
        <div class="container-fluid" id="cw_<?php echo $this->shorttag;?>">
          <div class="row">
            <div class="col-12 px-0 mx-0">
      
              <input type="hidden" class="lat" value="<?php echo "";?>">
              <input type="hidden" class="lon" value="<?php echo "";?>">
        
              <div id="weather_<?php echo $this->shorttag;?>" class="card weather">
          
                <header class="card-header has-background-link-light">
                   <a class="weather-yesterday-link card-header-icon is-size-7">
                  ← <span class="weather-yesterday" style="margin-left: 5px"></span>
                   </a>
                  <p class="card-header-title has-text-grey has-text-centered" style="display: block">
                    <span class="weather-today"></span>
                  </p>
                  <a class="weather-tomorrow-link card-header-icon is-size-7">
                    <span class="weather-tomorrow" style="margin-right: 5px"></span> →
                  </a>
                </header>
          
                <div class="card-content">
                  <div class="no-weather-info is-overlay is-vertical-center is-hidden">
                    <div class="notification is-warning has-text-centered"></div>
                  </div>
                </div>
          
              </div>

            </div>
          </div>
        </div>

