<div id="weather" class="card weather">
        <header class="card-header has-background-link-light">
          <a id="weather-yesterday-link" class="card-header-icon is-size-7">
            ← <span id="weather-yesterday" style="margin-left: 5px">June 14</span>
          </a>
          <p class="card-header-title has-text-grey has-text-centered" style="display: block">
            <span id="weather-today">Wednesday, June 15, 2022</span>
          </p>
          <a id="weather-tomorrow-link" class="card-header-icon is-size-7">
            <span id="weather-tomorrow" style="margin-right: 5px">June 16</span> →
          </a>
        </header>
        <div class="card-content">
          <div id="no-weather-info" class="is-overlay is-vertical-center is-hidden">
            <div class="notification is-warning has-text-centered">
              No data available.
            </div>
          </div>
          <div class="media">
            <div class="media-content">
              <p class="title is-3">
                <span title="Maximum temperature"><span id="weather-max-temp">29.3</span> °C</span>
                <span class="has-text-grey-lighter">· <span title="Minimum temperature"><span id="weather-min-temp">9.6</span> °C</span></span>
              </p>
              <p class="subtitle is-5" title="Weather station name"><span id="weather-station-name">Nürnberg</span></p>
              <div class="weather-details has-text-grey">
                <span title="Maximum hourly precipitation">
                  <i class="wi wi-umbrella"></i><span id="weather-max-precipitation">0.0</span> mm/h
                </span><br>
                <span title="Average wind speed">
                  <i class="wi wi-strong-wind"></i><span id="weather-avg-wind-speed">8.0</span> km/h
                </span><br>
                <span title="Total sunshine duration">
                  <i class="wi wi-day-sunny"></i><span id="weather-total-sunshine">15:07</span> h
                </span><br>
                <span title="Average cloud cover">
                  <i class="wi wi-cloudy"></i><span id="weather-avg-cloud-cover">37</span> %
                </span><br>
                <span title="Average atmospheric pressure, reduced to mean sea level">
                  <i class="wi wi-barometer"></i><span id="weather-avg-pressure">1017.3</span> hPa
                </span><br>
              </div>
            </div>
            <div class="media-right" style="margin: auto 0">
              <figure>
                <i id="weather-day-icon" class="wi wi-day-sunny"></i>
              </figure>
            </div>
          </div>
          <div id="weather-hourly" class="level is-mobile">
          <div class="level-item has-text-centered">
            <div>
              <p class="heading">04:00</p>
              <p>
                <i class="wi wi-cloud"></i><br>
                10 °C 
              </p>
            </div>
          </div>
        
          <div class="level-item has-text-centered">
            <div>
              <p class="heading">08:00</p>
              <p>
                <i class="wi wi-day-sunny"></i><br>
                17 °C 
              </p>
            </div>
          </div>
        
          <div class="level-item has-text-centered">
            <div>
              <p class="heading">12:00</p>
              <p>
                <i class="wi wi-day-sunny"></i><br>
                25 °C 
              </p>
            </div>
          </div>
        
          <div class="level-item has-text-centered">
            <div>
              <p class="heading">16:00</p>
              <p>
                <i class="wi wi-day-cloudy"></i><br>
                29 °C 
              </p>
            </div>
          </div>
        
          <div class="level-item has-text-centered">
            <div>
              <p class="heading">20:00</p>
              <p>
                <i class="wi wi-day-sunny"></i><br>
                27 °C 
              </p>
            </div>
          </div>
        </div>
        </div>
      </div>