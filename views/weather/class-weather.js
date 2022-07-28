class Weather {
	
	constructor (st, elementId) {
	  this.apiUrl = 'https://api.brightsky.dev/';
	  this.st = st;
      if($('#' + elementId).length) {
        this.stageDiv = $('#' + elementId);
        this.date = $('#' + elementId + ' .date');
        this.lat = $('#' + elementId + ' .lat');
        this.lon = $('#' + elementId + ' .lon');
        this.weatherYesterdayLink = $('#' + elementId + ' .weather-yesterday-link');
        this.weatherYesterday = $('#' + elementId + ' .weather-yesterday');
        this.weatherToday = $('#' + elementId + ' .weather-today');
        this.weatherTomorrowLink = $('#' + elementId + ' .weather-tomorrow-link');
        this.weatherTomorrow = $('#' + elementId + ' .weather-tomorrow');
        this.noWeatherInfo = $('#' + elementId + ' .no-weather-info');
      }
	}
    

    fetchWeather(lat, lon, date) {
      var obj = this;
      const dateStr = date.toISOString().split('T')[0];
      const url = obj.apiUrl + `weather?lat=${lat}&lon=${lon}&date=${dateStr}&tz=Europe/Berlin`;
      $.getJSON(url, function(data) {
        if (Object.keys(data).length !== 0) {
          if (data.weather && data.weather.length > 0) {
            
          }
        }
        
      })
    }

    initPanel() {
  	  var obj = this;
    }

}