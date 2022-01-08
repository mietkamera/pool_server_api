let allPictures = {
  days: [],
  files: [],
  dayIndex: 0,
  fileIndex: 0,
  
  loadData: function (data) {
 	$.each(data, (key, val) => {
 	  this.days[key] = val.day;
      this.files[key] = val.files; 
  	});
  	this.days.shift();
  	this.files.shift();
  	console.log(this.days);
    console.log(this.files);
  },
  
  refreshData: function(data) {
  	var updated = false; 
    $.each(data, (key, val) => {
      var i;
      var found = false;
      for (i=0;i<this.days.length;i++) {
        if (this.days[i] == val.day) {
          found = true;
          if (this.files[i].length != val.files.length) {
            this.files[i] = val.files;
            updated = true;
            console.log('refreshData: files['+i+'] angepasst');
          } else {
            console.log('refreshData: ' + val.day + ' no new images');
          }
        }
      }
      if (!found) {
        this.days[i] = val.day;
        this.files[i] = val.files;
        updated = true;
        console.log('refreshData: ' + val.day + ' new day found');
      }
    });
    return updated;
  },
  
  numDays: function () {
    return this.days.length;
  },
  
  numImages: function (dI) {
    return this.files[dI].length;
  },
  
  numAllImages: function () {
  	let sum = 0;
  	this.days.forEach((val, index) => {
          sum += this.numImages(index);
        })
  	  
    return sum;
  },

  getImageURI: function (dI, fI) {
  	return url_stub + '/image/get/' + mySt + '/' + this.days[dI] + this.files[dI][fI];
  },
  
  getDayString: function(dI) {
    d = this.days[dI];
  	return d.substr(6,2) + '.' + d.substr(4,2) + '.' + d.substr(0,4); 
  },
  
  getTimeString: function(dI,fI) {
    t = this.files[dI][fI];
    return t.substr(0,2) + ':' + t.substr(2,2) + ':' + t.substr(4,2);
  },
  
  getImageURIParameter: function(dI,fI) {
    return this.days[dI] + this.files[dI][fI];
  },
  
  setStatusImageString: function() {
    let timeString = (Number($("#time").val())+1).toString();
    let dayString  = allPictures.numImages($("#day").val()).toString();
    let allString  = allPictures.numAllImages().toString();
    $('#col-info-3').html(
               	 	'<div class="float-right">#' + timeString + '/' + dayString + '/' + allString  + '<span class="d-none d-md-inline-block">&nbsp;Bilder</span>' +
               	 	'</div>'
               	 	);
  },
  
  setStatusDayString: function () {
    let dayString = (Number($("#day").val()) + 1).toString();
    let allString = allPictures.numDays().toString();
    $('#col-info-1').html('Tag #' + dayString + '/' + allString);
  }
  
}

let loadedDayThumbs = 0;
let loadedImageThumbs = 0;


$('#day').on('input change', function() {
  day = $(this).val();
  $("#dayThumb").attr('src',allPictures.getDayThumbURI( day ));
  $(".dayStr").html(allPictures.getDayString(day));
  
});

$('#time').on('input change', function() {
  day = $("#day").val();
  time = $(this).val();
  allPictures.setStatusImageString();
  $("#timeStr").html(allPictures.getTimeString(day,time));
  $("#picture").attr('src',allPictures.getImageThumbURI(day, time));
});

$('#time').on('mouseup touchend', function () {
  $('.change-time-controller').prop('disabled', true);
  $('#col-info-spinner').html('<div class="spinner-grow spinner-grow-sm text-white"></div>');
  setTimeout( function() { 
  	day = $("#day").val();
  	time = $("#time").val();
  	$("#picture")
         .on('load', function() { $('#col-info-spinner').html(''); $('.change-time-controller').prop('disabled', false); })
  	     .attr('src',allPictures.getImageURI( day, time ));
  	$("#timeStr").html(allPictures.getTimeString(day,time));
  	$("#btn-download").attr('href', url_stub + '/image/download/' + mySt + '/' + allPictures.getImageURIParameter(day,time));
  }, 0);
});

//$(document).on('mouseup touchend', '#day', function () {
$('.goto-day').on('click', function () {
  setTimeout( function() {
  	// setTimeout(function() {$("#day").attr('src', '/http-api/public/images/btn-ajax-loader.gif')}, 0);
  	$('#dayBtn').blur();
  	loadedImageThumbs = 0;
  	day = $("#day").val();
  	$(".dayStr").html(allPictures.getDayString(day));
  	$("#time").prop('disabled', true);
  	if (day==$("#day").attr('max'))
  	  time = allPictures.numImages(day)-1;
  	 else
  	  time = Math.ceil((allPictures.numImages(day)-1)/2);
  	$("#timeStr").html(allPictures.getTimeString(day,time));
	$("#time").attr('min', 0);
  	$("#time").attr('max', allPictures.numImages(day)-1);
  	$("#time").val(time);
  	allPictures.setStatusDayString();
  	$('#col-info-spinner').html('<div class="spinner-grow spinner-grow-sm text-danger"></div>');
  	$("#picture").attr('src', allPictures.getImageURI(day,time)).on('load', function() {  
                     $('#col-info-spinner').html('');
                   });
  	$("#btn-download").attr('href', url_stub + '/image/download/' + mySt + '/' + allPictures.getImageURIParameter(day,time));
  	$('#loading-div').removeClass('d-none');
  	allPictures.cacheDayImageThumbs(day);
  }, 0);
});

$("#dayLeft").on('click', function () {
  $(this).blur();
  var day = parseInt($("#day").val()) - 1;
  if (day >= 0) {
    $("#day").val(day);
    var e = $.Event( "change", { which: 1 } );
    $("#day").trigger(e);
  }	
});

$("#dayRight").on('click', function () {
  $(this).blur();
  var day = parseInt($("#day").val()) + 1;
  if (day <= $("#day").attr('max')) {
    $("#day").val(day);
    var e = $.Event( "change", { which: 1 } );
    $("#day").trigger(e);
  }	
});

$("#timeLeft").on('click', function () {
  $(this).blur();
  var time = parseInt($("#time").val()) - 1;
  if (time >= 0) {
    $("#time").val(time);
    allPictures.setStatusImageString();
    var e = $.Event( "mouseup", { which: 1 } );
    $("#time").trigger(e);
  }	else {
  	var day = parseInt($("#day").val()) - 1;
    if (day >= 0) {
      $("#day").val(day);
  	  $(".dayStr").html(allPictures.getDayString(day));
  	  $("#time").prop('disabled', true);
  	  time = allPictures.numImages(day)-1;
  	  $("#timeStr").html(allPictures.getTimeString(day,time));
  	  $("#time").attr('max', allPictures.numImages(day)-1);
  	  $("#time").val(time);
  	  allPictures.setStatusDayString();
      $('#col-info-spinner').html('<div class="spinner-grow spinner-grow-sm text-danger"></div>');
      $("#picture").attr('src', allPictures.getImageURI(day,time)).on('load', function() {  
                     $('#col-info-spinner').html('');
                   });
  	  $("#btn-download").attr('href', url_stub + '/image/download/' + mySt + '/' + allPictures.getImageURIParameter(day,time));
  	  $('#loading-div').removeClass('d-none');
  	  allPictures.cacheDayImageThumbs(day);
    }
  }
});

$("#timeRight").on('click', function () {
  $(this).blur();
  var time = parseInt($("#time").val()) + 1;
  if (time <= $("#time").attr('max')) {
    $("#time").val(time);
    allPictures.setStatusImageString();
    var e = $.Event( "mouseup", { which: 1 } );
    $("#time").trigger(e);
  } else {
    var day = parseInt($("#day").val()) + 1;
    if (day <= $("#day").attr('max')) {
      $("#day").val(day);
      $(".dayStr").html(allPictures.getDayString(day));
  	  $("#time").prop('disabled', true);
  	  time = 0;
  	  $("#timeStr").html(allPictures.getTimeString(day,time));
  	  $("#time").attr('max', allPictures.numImages(day)-1);
  	  $("#time").val(time);
  	  allPictures.setStatusDayString();
      $('#col-info-spinner').html('<div class="spinner-grow spinner-grow-sm text-danger"></div>');
      $("#picture").attr('src', allPictures.getImageURI(day,time)).on('load', function() {  
                     $('#col-info-spinner').html('');
                   });
  	  $("#btn-download").attr('href', url_stub + '/image/download/' + mySt + '/' + allPictures.getImageURIParameter(day,time));
  	  $('#loading-div').removeClass('d-none');
  	  allPictures.cacheDayImageThumbs(day);
    }
  }	
});

$("#timeLast").on('click', function () {
  $(this).blur();
  var day = parseInt($("#day").val());
  if (day < $("#day").attr('max')) {
    $("#day").val($("#day").attr('max'));
    var e = $.Event( "mouseup", { which: 1 } );
    $("#day").trigger(e);
    e = $.Event( "click", { which: 1 } );
    $('.goto-day').trigger(e);
  } else {
    var time = parseInt($("#time").attr('max'));
    $("#time").val(time);
    allPictures.setStatusImageString();
    var e = $.Event( "mouseup", { which: 1 } );
    $("#time").trigger(e);
  }	
});
