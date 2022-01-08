<script>

class Last {

  constructor (st,elementId,apiUrl='') {
  	this.apiUrl = apiUrl;
    this.st = st;
    this.day = '';
    this.time = '';
    // DOM elements
    if($('#' + elementId).length) {
      this.stageDiv = $('#' + elementId);
      this.curtain = $('#' + elementId + ' .curtain');
      this.picture = $('#' + elementId + ' .picture');
      this.pictureBtnDownload = $('#' + elementId + ' .picture-btn-download');
      this.timeStr = $('#' + elementId + ' .timeStr');
      this.dayStr = $('#' + elementId + ' .dayStr');
      this.loadingSpinner = $('#' + elementId + ' .col-loading-spinner');
      this.onlineStatus = $('#' + elementId + ' .col-online-status');
      
      var obj = this;
      this.picture.on('load', function() {
        obj.loadingSpinner.html('');
      })
    }
  }

  getDayString () {
    let d = this.day;
  	return d.substr(6,2) + '.' + d.substr(4,2) + '.' + d.substr(0,4); 
  }
  
  getTimeString () {
    let t = this.time;
    return t.substr(0,2) + ':' + t.substr(2,2) + ':' + t.substr(4,2);
  }
  
  getImageDownloadURI() {
    return this.apiUrl + '/image/download/' + this.st + '/' + this.day + this.time;
  }
  
  getImageURI () {
    return this.apiUrl + '/image/get/' + this.st + '/' + this.day + this.time;
  }

  initRefreshStage() {
  	var obj = this;
    this.refreshInterval = setInterval( function() {
          var d = new Date();
          var today = d.getFullYear().toString()+("0" + (d.getMonth()+1).toString()).slice(-2)+("0" + d.getDate().toString()).slice(-2);
          var timeMs = d.getTime();

          $.getJSON(obj.apiUrl + '/image/json/' + obj.st + '/' + today + '.' + timeMs, function(data) {
            if (Object.keys(data).length !== 0) {
              var lastDay = data[Object.keys(data).length];
              var day = lastDay.day;
              var time = lastDay.files[Object.keys(lastDay.files).length-1];
              if (!(day==obj.day && time==obj.time)) {
              	obj.day = day;
                obj.time = time;
                obj.dayStr.html(obj.getDayString());
  	            obj.timeStr.html(obj.getTimeString());
  	            obj.pictureBtnDownload.attr('href', obj.getImageDownloadURI());
                setTimeout( function() {
                  obj.loadingSpinner.html('<div class="spinner-grow spinner-grow-sm text-danger"></div>');
                  obj.picture
                       .attr('src',obj.getImageURI());
                });
              }
            }
          });
          $.getJSON(this.apiUrl + '/status/information/' + this.st, function(data) {
  	        if (data.payload.information.aktiv)
  	          obj.onlineStatus.html('<span class="btn btn-xs btn-' + data.payload.image.color + '">' + data.payload.image.short + '</span>');
  	         else
  	          obj.onlineStatus.html('<span class="btn btn-xs btn-danger">inaktiv</span>');
  	      });
    }, 1000 * 60);
  }
  
  initStage() {
  	var obj = this;
  	$.getJSON(this.apiUrl + '/image/json/' + this.st, function(data) {
  	  if (Object.keys(data).length>0) {
  	  	var lastDay = data[Object.keys(data).length];
  	    obj.day = lastDay.day;
        obj.time = lastDay.files[Object.keys(lastDay.files).length-1];
  	    obj.dayStr.html(obj.getDayString());
  	    obj.timeStr.html(obj.getTimeString());
  	    obj.pictureBtnDownload.attr('href', obj.getImageDownloadURI());
      }
  	});
  	$.getJSON(this.apiUrl + '/status/information/' + this.st, function(data) {
  	  if (data.payload.information.aktiv) {
  	  	obj.onlineStatus.html('<span class="btn btn-xs btn-' + data.payload.image.color + '">' + data.payload.image.short + '</span>');
  	    obj.initRefreshStage();
  	  } else
  	    obj.onlineStatus.html('<span class="btn btn-xs btn-danger">inaktiv</span>');
  	});
  }
  
}

</script>