class Pictures {

  constructor (st,elementId,apiUrl='') {
  	this.apiUrl = apiUrl;
    this.st = st;
    this.days = [];
    this.files = [];
    this.dayIndex = 0;
    this.fileIndex = 0;
    this.loadedDayThumbs = 0;
    this.loadedImageThumbs = 0;
    // DOM elements
    if($('#' + elementId).length) {
      this.stageDiv = $('#' + elementId);
      this.curtain = $('#' + elementId + ' .curtain');
      this.picture = $('#' + elementId + ' .picture');
      this.pictureBtnDownload = $('#' + elementId + ' .picture-btn-download');
      this.pictureDay = $('#' + elementId + ' .day-thumb-img');
      this.dayControl = $('#' + elementId + ' .day-range');
      this.dayLeftControl = $('#' + elementId + ' .day-left-btn');
      this.dayRightControl = $('#' + elementId + ' .day-right-btn');
      this.timeControl = $('#' + elementId + ' .time-range');
      this.timeLeftControl = $('#' + elementId + ' .time-left-btn');
      this.timeRightControl = $('#' + elementId + ' .time-right-btn');
      this.timeLastControl = $('#' + elementId + ' .time-last-btn');
      this.timeAllController = $('#' + elementId + ' .change-time-controller');
      this.imgLoaded = $('#' + elementId + ' .img-loaded');
      this.imgMax = $('#' + elementId + ' .img-max');
      this.timeStr = $('#' + elementId + ' .timeStr');
      this.dayStr = $('#' + elementId + ' .dayStr');
      this.dayBtn = $('#' + elementId + ' .dayBtn');
      this.dayChangeBtn = $('#' + elementId + ' .goto-day-btn');
      this.loadingSpinner = $('#' + elementId + ' .col-loading-spinner');
      this.dayCounter = $('#' + elementId + ' .col-day-counter');
      this.imgCounter = $('#' + elementId + ' .col-image-counter');
      this.onlineStatus = $('#' + elementId + ' .col-online-status');
      
      var obj = this;
      this.dayControl.on('input change', function() { obj.dayControlInputChange(
      	  obj.dayControl.val()) });
      
      this.dayChangeBtn.on('click', function() { obj.dayChangeBtnClick(
      	  obj.dayControl.val(), obj.timeControl.val()) });
      	  
      this.dayLeftControl.on('click', function() { obj.daySlide(-1, obj.dayLeftControl) });
      	  
      this.dayRightControl.on('click', function() { obj.daySlide(+1, obj.dayRightControl) });
 
      this.timeControl.on('input', function() { obj.timeControlInputChange(
      	  obj.dayControl.val(), obj.timeControl.val()) });
      	  
      this.timeControl.on('mouseup touchend keyup', function () { obj.timeControlMouseupTouchend(
      	  obj.dayControl.val(), obj.timeControl.val()) });
      	  
      this.timeLeftControl.on('click', function() { obj.timeSlide(-1, obj.timeLeftControl) });

      this.timeRightControl.on('click', function() { obj.timeSlide(+1, obj.timeRightControl) });
      
      this.timeLastControl.on('click', function() { obj.gotoLast() });

    }
  }
  
  dayControlInputChange (day) {
    var obj = this;
    $('<img>').on('load', function() {
    	                    obj.pictureDay.attr('src', $(this).attr('src'))
                          })
              .attr('src', this.getDayThumbURI(day));
    this.dayStr.html(this.getDayString(day));
  }
  
  daySlide (step, btn) {
    btn.blur();
    var day = parseInt(this.dayControl.val()) + step;
    if (day >= 0 && day <= this.dayControl.attr('max')) {
      this.dayControl.val(day);
      var e = $.Event( "change", { which: 1 } );
      this.dayControl.trigger(e);
    }	
  }

  // What to do, when this.timeControl changes
  timeControlInputChange (day, time) {
    this.timeStr.html(this.getTimeString(day,time));
    var obj = this;
    setTimeout( function() {
                   $('<img>').on('load', function() {
                                             obj.picture.attr('src', $(this).attr('src'))
                                          })
                             .attr('src', obj.getImageThumbURI(day, time));
    });
  }

  enableControls (day, time) {
  	if (this.numDays()>0) {
      this.loadingSpinner.html('');
      this.dayStr.prop('disabled', this.numDays()>1);
      this.dayBtn.prop('disabled', this.numDays()>1);
      this.timeAllController.prop('disabled', false);
      this.timeLastControl.prop('disabled', parseInt(day)===(this.numDays()-1) && parseInt(time)===(this.numImages(day)-1));
      this.setStatusImageString();
  	}
  }
  
  timeControlMouseupTouchend (day, time) {
    $.each(this.timeAllController, function() { $(this).prop('disabled', true) });
    this.loadingSpinner.html('<div class="spinner-grow spinner-grow-sm text-white"></div>');
    this.timeStr.html(this.getTimeString(day,time));
    this.pictureBtnDownload.attr('href', this.apiUrl + '/image/download/' + this.st + '/' + this.getImageURIParameter(day,time));
    var obj = this;
    $('<img>').on('load', function() {
                    obj.loadingSpinner.html('');
                    obj.enableControls (day, time);
                    obj.picture.attr('src', $(this).attr('src'));
                })
            .attr('src', this.getImageURI( day, time ))
     
  }
  
  dayChangeBtnClick (day) {
  	this.dayBtn.blur();
  	this.loadedImageThumbs = 0;
  	this.dayStr.html(this.getDayString(day));
  	this.timeControl.prop('disabled', true);
  	var time = 0;
  	if (day==this.dayControl.attr('max'))
  	  time = this.numImages(day)-1;
  	 else
  	  time = Math.ceil((this.numImages(day)-1)/2);
  	this.timeStr.html(this.getTimeString(day,time));
	this.timeControl.attr('min', 0);
  	this.timeControl.attr('max', this.numImages(day)-1);
  	this.timeControl.val(time);
  	this.setStatusDayString();
  	this.loadingSpinner.html('<div class="spinner-grow spinner-grow-sm text-danger"></div>');
  	var obj = this;
  	this.picture.attr('src', this.getImageURI(day,time)).on('load', function() { obj.enableControls(); });
  	this.pictureBtnDownload.attr('href', this.apiUrl + '/image/download/' + this.st + '/' + this.getImageURIParameter(day,time));
  	this.curtain.removeClass('d-none');
  	setTimeout(function() {
  	  obj.curtain.addClass('d-none');
  	  obj.setStatusDayString();
      obj.setStatusImageString();
      obj.dayStr.prop('disabled', false);
      obj.timeControl.prop('disabled', false);
  	},10*1000);
  	this.cacheDayImageThumbs(day);
  }  
  
  timeSlide (step, btn) {
    btn.blur();
    var time = parseInt(this.timeControl.val());
    var newtime = parseInt(this.timeControl.val()) + step;
    if (newtime >= 0 && newtime <= parseInt(this.timeControl.attr('max'))) {
      this.timeControl.val(newtime);
      this.setStatusImageString();
      var e = $.Event( "mouseup", { which: 1 } );
      this.timeControl.trigger(e);
    } else {
  	  var day = parseInt(this.dayControl.val()) + step;
  	  if (day>0 && this.numDays()>day) {
        time = step>0?0:this.numImages(day)-1;
        this.dayControl.val(day);
        this.timeControl.val(time);
        this.dayStr.html(this.getDayString(day));
        this.setStatusDayString();
        this.timeStr.html(this.getTimeString(day,time));
        this.timeControl.attr('min', 0);
        this.timeControl.attr('max', this.numImages(day)-1);
        this.timeControlMouseupTouchend(day, time);
  	  }
    }
  }
  
  gotoLast () {
    var day = this.numDays() - 1;
    var time = this.numImages(day) -1;
    this.dayControl.val(day);
    this.timeControl.val(time);
    this.dayStr.html(this.getDayString(day));
    this.setStatusDayString();
    this.timeStr.html(this.getTimeString(day,time));
    this.timeControl.attr('min', 0);
    this.timeControl.attr('max', time);
    this.timeControl.val(time);
    this.loadingSpinner.html('<div class="spinner-grow spinner-grow-sm text-danger"></div>');
    this.timeControlMouseupTouchend(day, time);
  }

  loadData (data) {
 	$.each(data, (key, val) => {
 	  this.days[key] = val.day;
      this.files[key] = val.files; 
  	});
  	this.days.shift();
  	this.files.shift();
  	// console.log(this.days);
    // console.log(this.files);
  }
  
  refreshData (data) {
  	var updated = false; 
    var firstData = this.numDays()===0;
    $.each(data, (key, val) => {
      var i;
      var found = false;
      for (i=0;i<this.days.length;i++) {
        if (this.days[i] == val.day) {
          found = true;
          if (this.files[i].length != val.files.length) {
            this.files[i] = val.files;
            updated = true;
            // console.log('refreshData: files['+i+'] angepasst');
          } else {
            console.log('refreshData: ' + val.day + ' no new images');
          }
        }
      }
      if (!found) {
        this.days[i] = val.day;
        this.files[i] = val.files;
        updated = true;
        // console.log('refreshData: ' + val.day + ' new day found');
      }
    });
    if (updated) {
      var day = this.numDays()-1;
      var time = this.numImages(day) -1;
      if (!firstData) {
        day = this.dayControl.val();
        time = this.timeControl.val();
        if (this.dayControl.attr('max')<(this.numDays()-1)) {
          day = this.numDays()-1;
          time = this.numImages(day) -1;
        }
      }
      this.dayControl.attr('max', day);
      this.dayControl.val(day);
      this.dayStr.html(this.getDayString(day));
      this.timeControl.attr('max', time);
      this.timeControl.val(time);
      if (day == this.dayControl.attr('max')) {
        time = this.timeControl.val();
        if (time == this.timeControl.attr('max')) {
          time = this.numImages(day)-1;
          this.timeControl.attr('max', time);
          this.timeControl.val(time);
          this.loadingSpinner.html('<div class="spinner-grow spinner-grow-sm text-danger"></div>');
          var obj = this;
          $('<img>').on('load', function() {
                                   obj.loadingSpinner.html('')
                                   obj.picture.attr('src', $(this).attr('src'))
                                })
                    .attr('src', this.getImageURI(day,time))
          this.pictureBtnDownload.attr('href', this.apiUrl + '/image/download/' + this.st + '/' + this.getImageURIParameter(day,time));
          this.timeStr.html(this.getTimeString(day,time));
          this.setStatusDayString();
          this.setStatusImageString();
  	      this.curtain.addClass('d-none');
  	      console.log('time-range angepasst');
        } else {
          this.timeControl.attr('max', this.numImages(day)-1);
          this.timeStr.html(this.getTimeString(day,time));
          this.setStatusDayString();
          this.setStatusImageString();
        }
      }
      
    }
    return updated;
  }
  
  numDays () {
    return this.days.length;
  }
  
  numImages (dI) {
    return this.files[dI].length;
  }
  
  numAllImages () {
  	let sum = 0;
  	this.days.forEach((val, index) => {
          sum += this.numImages(index);
        })
  	  
    return sum;
  }

  getImageURI (dI, fI) {
  	return this.apiUrl + '/image/get/' + this.st + '/' + this.days[dI] + this.files[dI][fI];
  }
  
  getImageThumbURI (dI, fI) {
  	return this.apiUrl + '/image/thumb/' + this.st + '/' + this.days[dI] + this.files[dI][fI];
  }
  
  getDayThumbURI (dI) {
  	var fI = Math.ceil((this.files[dI].length-1) / 2);
    return this.apiUrl + '/image/thumb/' + this.st + '/' + this.days[dI] + this.files[dI][fI];
  }
  
  cacheDayThumbs () {
    this.days.forEach( (val, index) => {
      var image = $('<img/>').attr('src', this.getDayThumbURI(index));
      this.loadedDayThumbs++;
      
      if (this.loadedDayThumbs==this.dayControl.attr('max')) {
      	console.log(this.loadedDayThumbs.toString() + ' Tage in Cache geladen')
      	/* Loading of image thumbs completed */
        this.dayControl.prop('disabled', false);
      }
    })
  }
  
  onThumbLoad() {
    this.loadedImageThumbs++;
    this.imgLoaded.html(this.loadedImageThumbs.toString());
    if (this.loadedImageThumbs >= this.timeControl.attr('max')) {
      this.curtain.addClass('d-none');
      this.setStatusDayString();
      this.setStatusImageString();
      /* Loading of day thumbs completed */
      this.timeControl.prop('disabled', false);
      this.dayStr.prop('disabled', false);
    }
  }
  
  cacheDayImageThumbs (dI) {
    if (this.files[dI] !== undefined) {
  	  this.imgMax.html((Number(this.timeControl.attr('max'))+1).toString());
      this.files[dI].forEach( (val, index) => {
        var obj = this;
        var image = $('<img/>')
             .attr('src', this.getImageThumbURI(dI, index))
             .on('load', function() { obj.onThumbLoad() });
      })
    }
  }
  
  cacheDayImages (dI) {
    if (this.files[dI] !== undefined) 
      this.files[dI].forEach( (val, index) => {
        var image = $('<img/>').attr('src', this.getImageURI(dI, index));
      })
    
  }
  
  getDayString (dI) {
  	if (this.days[dI] !== undefined) {
      let d = this.days[dI];
  	  return d.substr(6,2) + '.' + d.substr(4,2) + '.' + d.substr(0,4); 
  	} else
  	  return '00.00.0000';
  }
  
  getTimeString (dI,fI) {
  	if (this.files[dI][fI] !== undefined) {
      let t = this.files[dI][fI];
      return t.substr(0,2) + ':' + t.substr(2,2) + ':' + t.substr(4,2);
  	} else
  	  return '00:00:00'
  }
  
  getImageURIParameter (dI,fI) {
    return this.days[dI] + this.files[dI][fI];
  }
  
  setStatusImageString () {
    let timeString = (Number(this.timeControl.val())+1).toString();
    let dayString  = $(this)[0].numImages(this.dayControl.val()).toString();
    let allString  = $(this)[0].numAllImages().toString();
    this.imgCounter.html(
               	 	'<div class="float-right"><small>#' + timeString + '/' + dayString + '/' + allString  + '<span class="d-none d-md-inline-block">&nbsp;Bilder</span>' +
               	 	'</small></div>'
               	 	);
  }
  
  setStatusDayString () {
    let dayString = (Number(this.dayControl.val()) + 1).toString();
    let allString = $(this)[0].numDays().toString();
    this.dayCounter.html('<small>Tag #' + dayString + '/' + allString + '</small>');
  }
  
  initRefreshStage() {
  	var obj = this;
    this.refreshInterval = setInterval( function() {
          var d = new Date();
          var today = d.getFullYear().toString()+("0" + (d.getMonth()+1).toString()).slice(-2)+("0" + d.getDate().toString()).slice(-2);
          console.log('refreshData: ' + today);
          var timeMs = d.getTime();

          $.getJSON(obj.apiUrl + '/image/json/' + obj.st + '/' + today + '.' + timeMs, function(data) {
          	
            if (Object.keys(data).length !== 0) {
              if (obj.numDays() !== 0) {
                obj.dayStr.prop('disabled', false);
                obj.timeAllController.prop('disabled', false);
              }
              var updated = obj.refreshData(data);
            }
          });
          $.getJSON(obj.apiUrl + '/status/information/' + obj.st, function(data) {
  	        if (data.payload.information.aktiv)
  	          obj.onlineStatus.html('<span class="btn btn-xs btn-' + data.payload.image.color + '">' + data.payload.image.short + '</span>');
  	         else
  	          obj.onlineStatus.html('<span class="btn btn-xs btn-danger">inaktiv</span>');
  	      });
    }, 1000*60);
  }
  
  initStage() {
  	var obj = this;
  	$.getJSON(this.apiUrl + '/image/json/' + this.st, function(data) {
      obj.loadData(data);
      if (obj.numDays()>0) {
  	    obj.dayControl.prop('disabled', true);
  	    var day = obj.numDays()-1;
  	    if (obj.numImages(day)>0) {
  	      var time = obj.numImages(day)-1;
  	      obj.dayStr.html(obj.getDayString(day));
  	      obj.dayControl.attr('min', 0);
  	      obj.dayControl.attr('max', day);
  	      obj.dayControl.val(day);
  	      obj.pictureDay.attr('src', obj.getDayThumbURI(day));
  	      obj.timeControl.prop('disabled', true);
  	      obj.timeStr.html(obj.getTimeString(day,time));
  	      obj.timeControl.attr('min', 0);
          obj.timeControl.attr('max', time);
  	      obj.timeControl.val(time);
  	      obj.pictureBtnDownload.attr('href', obj.apiUrl + '/image/download/' + obj.st + '/' + obj.getImageURIParameter(day,time));
  	      setTimeout(function() {
                       obj.curtain.addClass('d-none');
                       obj.setStatusDayString();
                       obj.setStatusImageString();
                       obj.timeControl.prop('disabled', false);
                     },10*1000);
  	      obj.cacheDayImageThumbs(day);
  	      //this.cacheDayImages(day);
  	      obj.cacheDayThumbs();
  	    } else {
  	      obj.curtain.addClass('d-none');
  	      obj.dayStr.prop('disabled', true);
          obj.timeAllController.prop('disabled', true);
  	    }
      } else {
        obj.curtain.addClass('d-none');
        obj.dayStr.prop('disabled', true);
        obj.timeAllController.prop('disabled', true);
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
