class Weather {
	
	constructor (st,elementId) {
	  this.apiUrl = 'https://api.brightsky.dev/';
	  this.st = st;
      if($('#' + elementId).length) {
        this.stageDiv = $('#' + elementId);
        this.lat = $('#' + elementId + ' .lat');
        this.lon = $('#' + elementId + ' .lon');
      }
	}
    

    dailyTotal(weather, key) {
      return weather.reduce((total, record) => total + (record[key] || 0), 0.0);
    }

    dailyAvg(weather, key) {
      return this.dailyTotal(weather, key) / weather.length;
    }

    dailyMax(weather, key) {
      return weather.reduce((max, record) => record[key] >= (max || record[key]) ? record[key] : max, null);
    }

    dailyMin(weather, key) {
      return weather.reduce((min, record) => record[key] <= (min || record[key]) ? record[key] : min, null);
    }
 
    mode(arr) {
      return arr.sort((a,b) =>
          arr.filter(v => v===a).length
        - arr.filter(v => v===b).length
      ).pop();
    }

    setProperty(id, value) {
      const el = $('#' + elementId + `.weather-${id}`);
      el.innerHTML = value;
    }

    async function getWeather() {
      const lat = Number(this.lat.val());
      const lon = Number(this.lon.val());
      const date = document.getElementById('date').valueAsDate;
      updateLink(lat, lon, date);
      updateHeader(lat, lon, date); 
      const data = await fetchWeather(lat, lon, date);
      if (data.weather && data.weather.length > 0) {
        document.getElementById('no-weather-info').classList.add('is-hidden');
        updateSummary(data);
        updateHourly(data);
        document.querySelectorAll('#response-json pre > ul > li > ul > li > a')[12].click();
      } else {
        document.getElementById('no-weather-info').classList.remove('is-hidden');
      }
    }

    async function fetchWeather(lat, lon, date) {
      const dateStr = date.toISOString().split('T')[0];
      const url = this.apiUrl + `weather?lat=${lat}&lon=${lon}&date=${dateStr}&tz=Europe/Berlin`;
      const response = await fetch(url);
      const data = await response.json();
      return data;
    }

    function updateLink(lat, lon, date) {
      const dateStr = date.toISOString().split('T')[0];
      document.getElementById('url-lat').innerHTML = lat;
      document.getElementById('url-lon').innerHTML = lon;
      document.getElementById('url-date').innerHTML = dateStr;
      document.getElementById('params-url').href = `${ this.apiUrl }weather?lat=${lat}&lon=${lon}&date=${dateStr}`;
    }

    function updateHeader(lat, lon, date) {
      setProperty('today', date.toLocaleString('en-us', {weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'}));
      const yesterday = new Date(date);
      yesterday.setDate(date.getDate() - 1);
      const tomorrow = new Date(date);
      tomorrow.setDate(date.getDate() + 1);
      setProperty('yesterday', yesterday.toLocaleString('en-us', {day: 'numeric', month: 'long'}));
      setProperty('tomorrow', tomorrow.toLocaleString('en-us', {day: 'numeric', month: 'long'}));
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

    function updateSummary(data) {
      const sourceName = data.sources[0].station_name.replace(
        /\B\w/g,
        (txt) => txt.charAt(0).toLowerCase(),
      );
      const maxTemp = this.dailyMax(data.weather, 'temperature');
      const minTemp = this.dailyMin(data.weather, 'temperature');
      const maxPrecipitation = this.dailyMax(data.weather, 'precipitation');
      const avgWindSpeed = this.dailyAvg(data.weather, 'wind_speed');
      const totalSunshine = this.dailyTotal(data.weather, 'sunshine');
      const totalSunshineHours = Math.floor(totalSunshine / 60);
      const totalSunshineMinutes = Math.floor(totalSunshine - 60 * totalSunshineHours);
      const avgCloudCover = this.dailyAvg(data.weather, 'cloud_cover');
      const avgPressure = this.dailyAvg(data.weather, 'pressure_msl');
      setProperty('station-name', sourceName);
      setProperty('max-temp', maxTemp.toFixed(1));
      setProperty('min-temp', minTemp.toFixed(1));
      setProperty('max-precipitation', maxPrecipitation.toFixed(1));
      setProperty('avg-wind-speed', avgWindSpeed.toFixed(1));
      setProperty('total-sunshine', `${totalSunshineHours}:${(totalSunshineMinutes < 10 ? '0' : '') + totalSunshineMinutes}`);
      setProperty('avg-cloud-cover', avgCloudCover.toFixed(0));
      setProperty('avg-pressure', avgPressure.toFixed(1));
      const icons = data.weather.map((record) => record.icon.replace('-night', '-day'));
      document.getElementById('weather-day-icon').className = `wi ${ ICON_MAPPING[this.mode(icons)] }`;
    }

    function updateHourly(data) {
      var hourly = '';
      for (let i = 4; i < data.weather.length - 1; i += 4) {
        var weather = data.weather[i];
        var timestamp = new Date(weather.timestamp).toLocaleTimeString('en-us', {hour12: false, hour: 'numeric', minute: 'numeric'});
        hourly += `
          <div class="level-item has-text-centered">
            <div>
              <p class="heading">${ timestamp }</p>
              <p>
                <i class="wi ${ ICON_MAPPING[weather.icon] }"></i><br>
                ${ weather.temperature.toFixed(0) } °C 
              </p>
            </div>
          </div>
        `;
      }
      setProperty('hourly', hourly);
    }

    new autoComplete({
      data: {
        src: async () => {
          const resp = await fetch('cities.json');
          const data = await resp.json();
          return data;
        },
        key: ["name"],
        cache: true,
      },
      placeHolder: "Search cities...",
      maxResults: 5,
      resultsList: {
        render: true
      },
      onSelection: function(feedback) {
        const place = feedback.selection.value;
        document.getElementById('autoComplete').blur();
        document.getElementById('autoComplete').value = '';
        document.getElementById('autoComplete').setAttribute('placeholder', place.name);
        document.getElementById('lat').value = place.lat;
        document.getElementById('lon').value = place.lon;
        getWeather();
      },
    });

    const dateInput = document.getElementById('date')
    document.getElementById('lat').addEventListener('input', getWeather);
    document.getElementById('lon').addEventListener('input', getWeather);
    dateInput.addEventListener('input', getWeather);
    dateInput.valueAsDate = new Date();
    document.getElementById('weather-yesterday-link').addEventListener('click', () => { dateInput.stepDown(); getWeather() });
    document.getElementById('weather-tomorrow-link').addEventListener('click', () => { dateInput.stepUp(); getWeather() });

    getWeather();
 
}