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
        this.weatherMaxTemp = $('#' + elementId + ' .weather-max-temp');
        this.weatherMinTemp = $('#' + elementId + ' .weather-min-temp');
        
        this.noWeatherInfo = $('#' + elementId + ' .no-weather-info');
      }
	}
    
    dailyTotal(weather, key) {
      return weather.reduce((total, record) => total + (record[key] || 0), 0.);
    }

    dailyAvg(weather, key) {
      return dailyTotal(weather, key) / weather.length;
    }

    dailyMax(weather, key) {
      return weather.reduce((max, record) => record[key] >= (max || record[key]) ? record[key] : max, null);
    }

    dailyMin(weather, key) {
      return weather.reduce((min, record) => record[key] <= (min || record[key]) ? record[key] : min, null);
    }


    fetchWeather() {
      var obj = this;
      const lat = obj.lat.val();
      const lon = obj.lon.val();
      const dateStr = obj.date.val();
      const url = obj.apiUrl + `weather?lat=${lat}&lon=${lon}&date=${dateStr}&tz=Europe/Berlin`;
      $.getJSON(url, function(data) {
        if (Object.keys(data).length !== 0) {
          if (data.weather && data.weather.length > 0) {
          	const maxTemp = obj.dailyMax(data.weather, 'temperature');
          	obj.weatherMaxTemp.html(maxTemp.toFixed(1));
            
          }
        }
        
      })
    }

    initPanel() {
  	  var obj = this;
  	  obj.fetchWeather();
  	  //obj.dateInput.val(new Date());
  	  //var dateString = obj.dateInput.val().split('-');
    }
    
    

}