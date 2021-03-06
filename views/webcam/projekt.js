/* Ermittle den aktuellen Shorttag aus der URL: er befindet sich immer an der 
   vierten Stelle (die erste Stelle des Arrays enthält einen leeren String) */
let myLocationArray = window.location.pathname.split('/'); 
let mySt = myLocationArray[4];

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
  
  getImageURI: function (dI, fI) {
  	return url_stub + '/image/get/' + mySt + '/' + this.days[dI] + this.files[dI][fI];
  },
  
  getImageThumbURI: function (dI, fI) {
  	return url_stub + '/image/thumb/' + mySt + '/' + this.days[dI] + this.files[dI][fI];
  },
  
  getDayThumbURI: function (dI) {
  	fI = Math.ceil((this.files[dI].length-1) / 2);
    return url_stub + '/image/thumb/' + mySt + '/' + this.days[dI] + this.files[dI][fI];
  },
  
  cacheDayThumbs: function () {
    this.days.forEach( (val, index) => {
      var image = $('<img/>').attr('src', this.getImageThumbURI(index));
      loadedDayThumbs++;
      if (loadedDayThumbs==$("#day").attr('max')) {
      	/* Loading of image thumbs completed */
        $("#day").prop('disabled', false);
      }
    })
  },
  
  cacheDayImageThumbs: function (dI) {
    this.files[dI].forEach( (val, index) => {
      var image = $('<img/>').attr('src', this.getImageThumbURI(dI, index))
             .on('load', function() {
               if (!this.complete || typeof this.naturalWidth == "undefined" || this.naturalWidth == 0) {
                 console.log('ImageThumb:load failed');
               }
               loadedImageThumbs++;
               if (loadedImageThumbs==$("#time").attr('max')) {
               	 /* Loading of day thumbs completed */
                 $("#time").prop('disabled', false);
                 /* $("#info").html('<p>' + loadedImageThumbs + ' Thumbs geladen</p>'); */
               }
             });
 //     console.log('cacheImageThumbURI: ' + this.getImageThumbURI(dI, index));
    })
  },
  
  cacheDayImages: function (dI) {
    this.files[dI].forEach( (val, index) => {
      var image = $('<img/>').attr('src', this.getImageURI(dI, index));
//      console.log('cacheDayImages: ' + this.getImageURI(dI, index));
    })
  },
  
  numImages: function (dI) {
    return this.files[dI].length;
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
  }
  
}

let loadedDayThumbs = 0;
let loadedImageThumbs = 0;

let allVideos = {
  all: '',
  kw: [],
  
  loadData: function (data) {
  	this.all = data.all;
    $.each(data.kw, (key, val) => {
 	  this.kw[key] = val; 
  	});
  	this.kw.shift();
  	console.log(this.all);
    console.log(this.kw);
  },
  
  numKW: function () {
    return this.kw.length;
  },
  
  numComplete: function() {
    if (this.all == '')
      return 0
     else
      return 1;
  },
  
  getCompleteURI: function () {
    return this.all;
  },
  
  getKwURI: function (index) {
  	return this.kw[index];
  }
}

$('document').ready(function() {

  $.getJSON(url_stub + '/video/json/' + mySt, function(data) {
  	setTimeout(allVideos.loadData(data),0);
  	if ((allVideos.numComplete() + allVideos.numKW())==0) {
  	  $("#video").hide();
  	  $("#nav_video").hide();
  	} else {
  	  if (allVideos.numComplete()>0)
  	    $("#videoPlaylist").append('<li class="btn btn-sm btn-outline-primary active btn-block my-2" movie="all">Video &uuml;ber die gesammte Zeit</li>');
  	  for (var i = 0; i<allVideos.numKW(); i++) {
  	    $("#videoPlaylist").append('<li class="btn btn-sm btn-outline-secondary mr-1 mb-1" movie="kw.' + allVideos.getKwURI(i) + '">' + allVideos.getKwURI(i) + '</li>');
  	  }
  	  $("#videoClip").attr({
         "src": url_stub + '/video/mp4/' + mySt + ($("#switchHD").is(":checked") ? '/hd.' : '/vgax.') + $("#videoPlaylist li").eq(0).attr("movie"),
         "poster": url_stub + '/video/jpeg/' + mySt + ($("#switchHD").is(":checked") ? '/hd.' : '/vgax.') + $("#videoPlaylist li").eq(0).attr("movie")
      });
      $('#videoDownload').attr('href', url_stub + '/video/download/' + mySt + '/vgax.all');
   /*   $("#clipSrc").attr('src', url_stub + '/video/mp4/' + mySt + '/vgax');
      $('#clip').get(0).load();
      $('#clip').attr('poster', url_stub + '/video/jpeg/' + mySt + '/vgax');
      $('#videoDownload').attr('href', url_stub + '/video/download/' + mySt + '/vgax');	*/
  	}
  });

  $.getJSON(url_stub + '/status/information/' + mySt, function(data) {
    $("#info-projekt").html(data.projekt);
    $("#info-kamera").html(data.name);
    $("#info-beschreibung").html(' [ ' + data.beschreibung + ' ]');
    if (data.aktiv && data.monitor) {
      $("#mrtgDayChart").attr('src', url_stub + '/status/chart/' + mySt + '/day');
      $.getJSON(url_stub + '/status/json/' + mySt, function(response) { $("#camBtn").html(createStatusButton(response)) });
    } else {
      $("#camStatus").hide();
      $("#live").hide();
      $("#nav_live").hide();
    }
    if (Object.keys(data.other).length !== 0) {
      
    //  $("#other").append('<div class="col-12 d-none d-lg-inline-block py-2"><span class="btn btn-sm btn-outline-info btn-block">Andere Perspektiven</span></div>');
      $.each(data.other, (key,val) => { 
      	$("#other").append('<div class="col-6 col-sm-4 col-lg-12">' +
      	     '<div class="col-12 m-0 p-0">' +
      	     '<a href="' + url_stub + '/webcam/projekt/' + val + '">' +
      	     '<div class="imgTag"><btn class="btn btn-block p-1 text-white"><i class="fas fa-external-link-alt"></i><span id="txt-' + val + '"></span></btn></div>' +  
      	     '<img class="img-fluid rounded" src="' + 
      	         url_stub + '/image/last/' + val +'/.cif"></a></div>' + 
      	     '</div>');
      	$.getJSON(url_stub + '/webcam/information/' + val, function(data) {
      	  $("#txt-" + val).html('&nbsp;' + data.name);
      	});
        console.log('st: ' + url_stub + '/image/last/' + val +'/.cif');
      });
    } else {
      $("#other").append('<div class="col-12 d-none d-lg-inline-block py-2"><span class="btn btn-sm btn-outline-danger btn-block">Keine anderen Perspektiven</span></div>');
    }
  });
  
  $.getJSON(url_stub + '/image/json/' + mySt, function(data) {
  	allPictures.loadData(data);
  	if (allPictures.numDays()>0) {
  	  $("#day").prop('disabled', true);
  	  day = allPictures.numDays()-1;
  	  $("#dayStr").html(allPictures.getDayString(day));
  	  $("#dayStr2").html(allPictures.getDayString(day));
  	  $("#day").attr('min', 0);
  	  $("#day").attr('max', day);
  	  $("#day").val(day);
  	  $("#dayThumb").attr('src', allPictures.getDayThumbURI(day));
  	  $("#time").prop('disabled', true);
  	  time = allPictures.numImages(day) -1;
  	  $("#timeStr").html(allPictures.getTimeString(day,time));
  	  $("#time").attr('min', 0);
  	  $("#time").attr('max', time);
  	  $("#time").val(time);
  	  $("#picture").attr('src', allPictures.getImageURI(day,time));
  	  $("#btn-download").attr('href', url_stub + '/image/download/' + mySt + '/' + allPictures.getImageURIParameter(day,time));
  	  allPictures.cacheDayThumbs();
  	  allPictures.cacheDayImageThumbs(day);
  	  //allPictures.cacheDayImages(day);
  	}
  });
  
  
  var refreshData = setInterval( function() {
    var d = new Date();
    var today = d.getFullYear().toString()+("0" + (d.getMonth()+1).toString()).slice(-2)+("0" + d.getDate().toString()).slice(-2);
    console.log('refreshData: ' + today);
    $.getJSON(url_stub + '/image/json/' + mySt + '/' + today, function(data) {
      if (Object.keys(data).length !== 0) {
        var updated = allPictures.refreshData(data);
        if (updated) {
          console.log('updated==true');
          if ($("#day").attr('max')<(allPictures.numDays()-1)) {
            day = allPictures.numDays()-1;
            $("#day").attr('max', day);
            loadedDayThumbs = 0;
  	        allPictures.cacheDayThumbs();
          } else {
          	day = $("#day").val()
            if (day == $("#day").attr('max')) {
              time = $("#time").val();
              if (time == $("#time").attr('max')) {
              	time = allPictures.numImages(day) -1;
              	$("#timeStr").html(allPictures.getTimeString(day,time));
                $("#time").attr('max', time);
  	            $("#time").val(time);
  	            $("#picture").attr('src', allPictures.getImageURI(day,time));
  	            $("#btn-download").attr('href', url_stub + '/image/download/' + mySt + '/' + allPictures.getImageURIParameter(day,time));
  	            console.log('time-range angepasst');
              } else {
                $("#time").attr('max', allPictures.numImages(day)-1);
              }
            }
          }
        } else {
          console.log('updated==false')
        }
      }	
    });
  }, 1000*60);
  
  var refreshMonitor = setInterval( function() {
  	if ($("#camStatus").is(":visible")) {
      $.getJSON(url_stub + '/status/json/' + mySt , function(data) {
        if (Object.keys(data).length !== 0) {
          $("#mrtgDayChart").attr('src', url_stub + '/status/chart/' + mySt + '/day.' + Math.random());
          $("#camBtn").html(createStatusButton(data));
        } else {
          console.log('no status data available')
        }
      });
  	}
  }, 1000*60*2);
  
  return false;

});

$(document).on('input change', '#day', function() {
  day = $(this).val();
  $("#dayStr2").html(allPictures.getDayString(day));
  $("#dayThumb").attr('src',allPictures.getDayThumbURI( day ));
  
});

$(document).on('input change', '#time', function() {
  day = $("#day").val();
  time = $(this).val();
  $("#timeStr").html(allPictures.getTimeString(day,time));
  $("#picture").attr('src',allPictures.getImageThumbURI(day, time));
});

$(document).on('mouseup touchend', '#day', function () {
  setTimeout( function() {
  	// setTimeout(function() {$("#day").attr('src', '/http-api/public/images/btn-ajax-loader.gif')}, 0);
  	loadedImageThumbs = 0;
  	day = $("#day").val();
  	$("#dayStr").html(allPictures.getDayString(day));
  	$("#dayStr2").html(allPictures.getDayString(day));
  	$("#time").prop('disabled', true);
  	if (day==$("#day").attr('max')) 
  	  time = allPictures.numImages(day)-1;
  	 else
  	  time = Math.ceil((allPictures.numImages(day)-1)/2);
  	$("#timeStr").html(allPictures.getTimeString(day,time));
	$("#time").attr('min', 0);
  	$("#time").attr('max', allPictures.numImages(day)-1);
  	$("#time").val(time);
  	$("#picture").attr('src', allPictures.getImageURI(day,time));
  	$("#btn-download").attr('href', url_stub + '/image/download/' + mySt + '/' + allPictures.getImageURIParameter(day,time));
  	allPictures.cacheDayImageThumbs(day);
  	//allPictures.cacheDayImages(day);
  }, 0);
});

$(document).on('mouseup touchend', '#time', function () {
  setTimeout( function() { 
  	day = $("#day").val();
  	time = $("#time").val();
  	$("#timeStr").html(allPictures.getTimeString(day,time));
  	$("#picture").attr('src',allPictures.getImageURI( day, time ));
  	$("#btn-download").attr('href', url_stub + '/image/download/' + mySt + '/' + allPictures.getImageURIParameter(day,time));
  }, 0);
});

$('#mytab-list a').on('click', function (e) {
  e.preventDefault();
  $(this).tab('show');
});

$("#dayLeft").on('click', function () {
  var day = parseInt($("#day").val()) - 1;
  if (day >= 0) {
    $("#day").val(day);
    var e = $.Event( "mouseup", { which: 1 } );
    $("#day").trigger(e);
  }	
});

$("#dayRight").on('click', function () {
  var day = parseInt($("#day").val()) + 1;
//  alert('max:' + $("#day").attr('max') + '  val: ' + $("#day").val());
  if (day <= $("#day").attr('max')) {
    $("#day").val(day);
    var e = $.Event( "mouseup", { which: 1 } );
    $("#day").trigger(e);
  }	
});

$("#timeLeft").on('click', function () {
  var time = parseInt($("#time").val()) - 1;
  if (time >= 0) {
    $("#time").val(time);
    var e = $.Event( "mouseup", { which: 1 } );
    $("#time").trigger(e);
  }	
});

$("#timeRight").on('click', function () {
  var time = parseInt($("#time").val()) + 1;
  if (time <= $("#time").attr('max')) {
    $("#time").val(time);
    var e = $.Event( "mouseup", { which: 1 } );
    $("#time").trigger(e);
  }	
});

$("#closeSidebar").on('click', function () {
  toggleSidebar();
});

$("#openSidebar").on('click', function () {
  toggleSidebar();
});

function toggleSidebar() {
  var cookieSidebar;
  var now = new Date();
  now.setTime(now.getTime() + (365 * 24 * 60 * 60 * 1000));
  $("#cam_sidebar").slideToggle(500, function () { 
    cookieSidebar = $("#cam_sidebar").is(":visible") ? '1' : '0';
    document.cookie = "show_sidebar=" + cookieSidebar + "; expires=" + now.toUTCString() + "; path=/; samesite=strict";
    $("#openSidebar").toggle();
  });
}

$("#closeHeader").on('click', function () {
  toggleHeader();
});

$("#openHeader").on('click', function () {
  toggleHeader();
});

$("#getLiveImage").on('click', function () {
  $(this).prop("disabled", true);
  $(this).html(
    `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Lade...`
  );
  var image = $("#liveImage").attr("src", url_stub + '/image/live/' + mySt + '/.' + Math.random())
                .on('load', function() {
                  if (!$(this).complete || typeof $(this).naturalWidth == "undefined" || $(this).naturalWidth == 0) {
                    
                    console.log('Live Image:load failed');
                  }
                  $("#getLiveImage").prop('disabled', false).html('Bild holen');
                  $("#liveInfo").html('<span class="btn btn-lg btn-outline-info">' + (new Date().toLocaleTimeString()) + '</span>');
                })
                .on('error', function() {
                  $("#getLiveImage").prop('disabled', false).html('Bild holen');
                  $(this).attr("src", url_stub + '/public/images/empty.jpg')
                  console.log('Live Image:load failed');
                });
  
});

function toggleHeader() {
  var cookieHeader;
  var now = new Date();
  now.setTime(now.getTime() + (365 * 24 * 60 * 60 * 1000));
  $("#projekt_header").slideToggle(500, function () { 
    cookieSidebar = $("#projekt_header").is(":visible") ? '1' : '0';
    document.cookie = "show_header=" + cookieSidebar + "; expires=" + now.toUTCString() + "; path=/; samesite=strict";
    $("#openHeader").toggle();
  });
}

$("#switchHD").on('click', function () {
  $("#videoClip").get(0).pause();
  $("#videoClip").attr({
         "src": url_stub + '/video/mp4/' + mySt + ($(this).is(":checked") ? '/hd.' : '/vgax.') + $("#videoPlaylist .active").attr("movie"),
         "poster": url_stub + '/video/jpeg/' + mySt + ($(this).is(":checked") ? '/hd.' : '/vgax.') + $("#videoPlaylist .active").attr("movie")
      });
  $('#videoDownload').attr('href', url_stub + '/video/download/' + mySt + ($(this).is(":checked") ? '/hd.' : '/vgax.') + $("#videoPlaylist .active").attr("movie"));
  $("#videoClip").get(0).load();
});


$("#videoPlaylist").on("click", 'li', function() {
	$("#videoPlaylist .active").removeClass('active');
	$(this).addClass('active');
	$("#videoClip").get(0).pause();
    $("#videoClip").attr({
         "src": url_stub + '/video/mp4/' + mySt + ($("#switchHD").is(":checked") ? '/hd.' : '/vgax.') + $(this).attr("movie"),
         "poster": url_stub + '/video/jpeg/' + mySt + ($("#switchHD").is(":checked") ? '/hd.' : '/vgax.') + $(this).attr("movie")
    });
    $('#videoDownload').attr('href', url_stub + '/video/download/' + mySt + ($("#switchHD").is(":checked") ? '/hd.' : '/vgax.') + $(this).attr("movie"));
    $("#videoClip").get(0).load();
    
})

function createStatusButton(data) {
  var html = '';
  html = '<span id="statusButton" class="btn btn-outline-' + data.color + ' btn-block">' + data.status + '<br/><small>' + data.description + '</small></span>';
  return html;
}
/*$('#toggleSidebar').on('click', function (e) {
  e.preventDefault();
  $("#camSidebar").toggle();
}); */
