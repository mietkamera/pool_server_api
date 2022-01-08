<script>

class Live {

  constructor(st,elementId,apiUrl='') {
  	this.apiUrl = apiUrl;
    this.st = st;
    this.day = '';
    this.time = '';
    this._dlBuffer = $('<img>');
    this._isPlaying = false;
    this._count = 20;
    if($('#' + elementId).length) {
      this.stageDiv = $('#' + elementId);
      this.picture = $('#' + elementId + ' .picture');
      this.startBtn = $('#' + elementId + ' .start-btn');
      this.progressBar = $('#' + elementId + ' .progress-bar');
      this.timeStr = $('#' + elementId + ' .timeStr');
      this.dayStr = $('#' + elementId + ' .dayStr');
      this.loadingSpinner = $('#' + elementId + ' .col-loading-spinner');
      this.onlineStatus = $('#' + elementId + ' .col-online-status');
      this.playStatus = $('#' + elementId + ' .col-play-status');
      
      var obj = this;
      this.startBtn.on('click', function() { obj.playLive () });
      
      this._dlBuffer.on('load', function() { obj.loadBuffer () });
      
      this._dlBuffer.on('error', function() { obj.errorBuffer () });
      
    }    
  }
  
  loadBuffer() {
    this.picture.attr("src", this._dlBuffer.attr("src"));
    var d = new Date();
    this.dayStr.html(("0" + d.getDate()).slice(-2) + '.' + 
                     ("0" + d.getMonth()+1).slice(-2) + '.' + 
                     d.getFullYear());
    this.timeStr.html(("0" + d.getHours()).slice(-2) + ':' + 
                      ("0" + d.getMinutes()).slice(-2) + ':' +
                      ("0" + d.getSeconds()).slice(-2) );
    this.startBtn.html(this._count>0?'<i class="fas fa-pause"></i>':'<i class="fas fa-play"></i>');
    if (this._count>0) {
      this._count -= 1;
      this.progressBar
        .attr('style','width:' + (5*this._count).toString() + '%')
        .html(this._count.toString());
      if (this._isPlaying)
        this._dlBuffer.attr('src', this.picture.attr('data-src') + '.' + Math.floor((Math.random() * 1000) + 1));
       else {
        this.loadingSpinner.html('');
        this.startBtn.html('<i class="fas fa-play"></i>');
      }
    } else {
      this.playStatus.html('<span class="btn btn-xs btn-secondary">stopped</span>');
      this._isPlaying = false;
      this._count = 20;
      this.progressBar
        .attr('style', 'width:100%')
        .html(this._count.toString());
      this.loadingSpinner.html('');
    }
    this.startBtn.prop('disabled', false);
  }
  
  errorBuffer() {
    this.loadingSpinner.html('');
    this._isPlaying = false;
  }
  
  playLive() {
  	if (!this._isPlaying) {
  	  this.playStatus.html('<span class="btn btn-xs btn-info">playing...</span>');
      this.startBtn.html('<i class="fas fa-pause"></i>');
      this.loadingSpinner.html('<span class="spinner-grow spinner-grow-sm text-danger"></span>');
      this._isPlaying = true;
      this._dlBuffer
          .attr('src', this.picture.attr('data-src') + '.' + Math.floor((Math.random() * 1000) + 1));
  	} else {
  	  this.playStatus.html('<span class="btn btn-xs btn-secondary">stopped</span>');
  	  this._isPlaying = false;
  	}
  	this.startBtn.prop('disabled', true);
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
          $.getJSON(obj.apiUrl + '/status/information/' + obj.st, function(data) {
  	        if (data.payload.information.aktiv) {
  	          obj.progressBar.prop('disabled', false);
  	          obj.startBtn.prop('disabled', false);
  	          obj.onlineStatus.html('<span class="btn btn-xs btn-' + data.payload.image.color + '">' + data.payload.image.short + '</span>');
  	          if (!obj._isPlaying) {
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
                      setTimeout( function() {
                        obj.loadingSpinner.html('<div class="spinner-grow spinner-grow-sm text-danger"></div>');
                        obj.picture
                             .on('load',obj.loadingSpinner.html(''))
                             .attr('src',obj.getImageURI());
                      });
                    } 
                  }
                });
  	          }
  	        } else {
  	          obj.progressBar.prop('disabled', true);
  	          obj.startBtn.prop('disabled', true);
  	          obj.onlineStatus.html('<span class="btn btn-xs btn-danger">inaktiv</span>');
  	         }
  	      });
    }, 1000*60);
  }

  initStage() {
  	var obj = this;
  	$.getJSON(this.apiUrl + '/status/information/' + this.st, function(data) {
  	  if (data.payload.information.aktiv) {
  	  	obj.onlineStatus.html('<span class="btn btn-xs btn-' + data.payload.image.color + '">' + data.payload.image.short + '</span>');
  	  } else {
  	    obj.progressBar.prop('disabled', true);
  	    obj.startBtn.prop('disabled', true);
  	    obj.onlineStatus.html('<span class="btn btn-xs btn-danger">inaktiv</span>');
  	  }
      obj.initRefreshStage();
  	});
    $.getJSON(this.apiUrl + '/image/json/' + this.st, function(data) {
      if (Object.keys(data).length>0) {
  	    var lastDay = data[Object.keys(data).length];
  	    obj.day = lastDay.day;
        obj.time = lastDay.files[Object.keys(lastDay.files).length-1];
  	    obj.dayStr.html(obj.getDayString());
  	    obj.timeStr.html(obj.getTimeString());
      }
    });
  }
  
  
}

</script>