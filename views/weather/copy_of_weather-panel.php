  <input type="date" id="date" style="display: none;">
  <input type="hidden" id="lat" value="<?php echo $this->data["lat"];?>">
  <input type="hidden" id="lon" value="<?php echo $this->data["lon"];?>">

  <div class="card bg-light mb-3 col-12">
    <div class="card-header text-center">
      <a id="weather-yesterday-link" class="card-header-icon">
        ← <span id="weather-yesterday" style="margin-left: 5px"></span>
      </a>
      <span id="weather-today"></span>
      <a id="weather-tomorrow-link" class="card-header-icon">
        <span id="weather-tomorrow" style="margin-right: 5px"></span> →
      </a>
    </div>
   <div class="card-body">


    <div class="media">

      <div class="media-body">
        
        <h5 class="card-title mb-2">
          <span title="Maximum temperature">
            <span id="weather-max-temp">19.3

            </span> °C
          </span>
          <span class="text-muted">· 
            <span title="Minimum temperature">
              <span id="weather-min-temp">14.3</span>
               °C
            </span>
          </span>
        </h5>
        <h6 class="card-subtitle">
          <p class="font-weight-lighter" title="Weather station name"><span id="weather-station-name">Münster/Osnabrück</span></p>
        </h6>
        <p class="card-text text-muted">
          <span title="Maximum hourly precipitation">
            <i class="wi wi-umbrella mr-2 col-1"></i><span id="weather-max-precipitation">0.4</span> mm/h
          </span><br>
          <span title="Average wind speed">
            <i class="wi wi-strong-wind mr-2 col-1"></i><span id="weather-avg-wind-speed">9</span> km/h
          </span><br>
          <span title="Total sunshine duration">
            <i class="wi wi-day-sunny mr-2 col-1"></i><span id="weather-total-sunshine">6:49</span> h
          </span><br>
          <span title="Average cloud cover">
            <i class="wi wi-cloudy mr-2 col-1"></i><span id="weather-avg-cloud-cover">72</span> %
          </span><br>
          <span title="Average atmospheric pressure, reduced to mean sea level">
            <i class="wi wi-barometer mr-2 col-1"></i><span id="weather-avg-pressure">1022.3</span> hPa
          </span><br>    
        </p>

      </div>
      <div class="ml-3 h-100">
        <figure>
          <i id="weather-day-icon" class="wi wi-day-cloudy" style="font-size:6rem;"></i>
        </figure>
      </div>
    </div>
    <!--<div class="container text-center">-->
        <div id="weather-hourly"></div>
    <!--</div>-->
    <!--<a href="#" class="btn btn-primary">Button</a>-->
      </div>
    </div>
    
    
    
    
    <script type="module">


  const BRIGHTSKY_URL = 'https://api.brightsky.dev/';
  const dateInput = document.getElementById('date')
    const date = new Date();

    let day = date.getDate();
    let month = date.getMonth() + 1;
    let year = date.getFullYear();

    //dateInput.value = `${day}.${month}.${year}`;
    dateInput.valueAsDate = date;

    //console.log(dateInput.value);


    document.getElementById('weather-yesterday-link').addEventListener('click', () => { dateInput.stepDown(); getWeather() });
    document.getElementById('weather-tomorrow-link').addEventListener('click', () => { dateInput.stepUp(); getWeather() });
 
    function mode(arr) {
      return arr.sort((a,b) =>
          arr.filter(v => v===a).length
        - arr.filter(v => v===b).length
      ).pop();
    }

  const ICON_MAPPING = {
      'clear-day': 'wi-day-sunny',
      'clear-night': 'wi-night-clear',
      'partly-cloudy-day': 'wi-day-cloudy',
      'partly-cloudy-night': 'wi-night-cloudy',
      'cloudy': 'wi-cloud',
      'fog': 'wi-fog',
      'wind': 'wi-strong-wind',
      'rain': 'wi-rain',
      'sleet': 'wi-sleet',
      'snow': 'wi-snow',
      'hail': 'wi-hail',
      'thunderstorm': 'wi-thunderstorm',
    }

    function dailyTotal(weather, key) {
      return weather.reduce((total, record) => total + (record[key] || 0), 0.);
    }

    function dailyAvg(weather, key) {
      return dailyTotal(weather, key) / weather.length;
    }

    function dailyMax(weather, key) {
      return weather.reduce((max, record) => record[key] >= (max || record[key]) ? record[key] : max, null);
    }

    function dailyMin(weather, key) {
      return weather.reduce((min, record) => record[key] <= (min || record[key]) ? record[key] : min, null);
    }



  async function getWeather() {
      const lat = Number(document.getElementById('lat').value);
      //const lat = 51.39475931211417;
      //const lon = 11.026275353238331;
      const lon = Number(document.getElementById('lon').value);
      const date = document.getElementById('date').valueAsDate;

      //console.log("date:" + date);

      //console.log(lat);

      //var date = new Date();
      //updateLink(lat, lon, date);
      updateHeader(lat, lon, date); 
      const data = await fetchWeather(lat, lon, date);
      //jsonViewer.showJSON(data, -1, 2);
      if (data.weather && data.weather.length > 0) {
        //data fetched

        //console.log(data);

        //document.getElementById('no-weather-info').classList.add('is-hidden');
        updateSummary(data);
        updateHourly(data);
        //document.querySelectorAll('#response-json pre > ul > li > ul > li > a')[12].click();
      } else {
	//no data fetched


        //document.getElementById('no-weather-info').classList.remove('is-hidden');
      }
  }

    async function fetchWeather(lat, lon, date) {
      const dateStr = date.toISOString().split('T')[0];
      const url = BRIGHTSKY_URL + `weather?lat=${lat}&lon=${lon}&date=${dateStr}&tz=Europe/Berlin`;
      //console.log(url);
      const response = await fetch(url);
      //console.log(response);
      const data = await response.json();
      return data;
    }

    function updateSummary(data) {
      const sourceName = data.sources[0].station_name.replace(
        /\B\w/g,
        (txt) => txt.charAt(0).toLowerCase(),
      );
      const maxTemp = dailyMax(data.weather, 'temperature');
      const minTemp = dailyMin(data.weather, 'temperature');
      const maxPrecipitation = dailyMax(data.weather, 'precipitation');
      const avgWindSpeed = dailyAvg(data.weather, 'wind_speed');
      const totalSunshine = dailyTotal(data.weather, 'sunshine');
      const totalSunshineHours = Math.floor(totalSunshine / 60);
      const totalSunshineMinutes = Math.floor(totalSunshine - 60 * totalSunshineHours);
      const avgCloudCover = dailyAvg(data.weather, 'cloud_cover');
      const avgPressure = dailyAvg(data.weather, 'pressure_msl');
      setProperty('station-name', sourceName);
      setProperty('max-temp', maxTemp.toFixed(1));
      setProperty('min-temp', minTemp.toFixed(1));
      setProperty('max-precipitation', maxPrecipitation.toFixed(1));
      setProperty('avg-wind-speed', avgWindSpeed.toFixed(1));
      setProperty('total-sunshine', `${totalSunshineHours}:${(totalSunshineMinutes < 10 ? '0' : '') + totalSunshineMinutes}`);
      setProperty('avg-cloud-cover', avgCloudCover.toFixed(0));
      setProperty('avg-pressure', avgPressure.toFixed(1));
      const icons = data.weather.map((record) => record.icon.replace('-night', '-day'));
      document.getElementById('weather-day-icon').className = `wi ${ ICON_MAPPING[mode(icons)] }`;
    }

    function updateHourly(data) {
      var hourly = `
        <div class="row mt-2">
      `;
      for (let i = 4; i < data.weather.length - 1; i += 4) {
        var weather = data.weather[i];
        var timestamp = new Date(weather.timestamp).toLocaleTimeString('en-us', {hour12: false, hour: 'numeric', minute: 'numeric'});
        hourly += `
            <div class="col">
              <p class="font-weight-lighter" style="font-size:0.9rem">${ timestamp }</p>
              <p>
                <i class="wi ${ ICON_MAPPING[weather.icon] }" style="font-size:2rem;"></i><br>
                <p class="font-weight-light" style="padding-top:0.1rem;">${ weather.temperature.toFixed(0) } °C </p>
              </p>
            </div>
        `;
      }

      hourly += `
      </div>
      `;

      setProperty('hourly', hourly);
    }


    function setProperty(id, value) {
      const el = document.getElementById(`weather-${id}`);
      el.innerHTML = value;
    }

    function updateHeader(lat, lon, date) {
      
      setProperty('today', date.toLocaleString('de-DE', {weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'}));
      const yesterday = new Date(date);
      yesterday.setDate(date.getDate() - 1);
      const tomorrow = new Date(date);
      tomorrow.setDate(date.getDate() + 1);
      setProperty('yesterday', yesterday.toLocaleString('de-DE', {day: 'numeric', month: 'long'}));
      setProperty('tomorrow', tomorrow.toLocaleString('de-DE', {day: 'numeric', month: 'long'}));
    }

    getWeather();

</script>