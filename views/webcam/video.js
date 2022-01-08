let allVideos = {
  all: '',
  kw: [],
  
  loadData: function (data) {
  	if ('all' in data && data.all !== undefined)
  	  this.all = data.all;
  	 else
  	  this.all = '';
    $.each(data.kw, (key, val) => {
 	  this.kw[key] = val; 
  	});
  	//this.kw.shift();
  	console.log(this.all);
    console.log(this.kw);
  },
  
  numKW: function () {
    return this.kw.length;
  },
  
  numComplete: function() {
    if (this.all === '')
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

$("#switchHD").on('click', function () {
  $("#videoClip").get(0).pause();
  $("#videoClip").attr({
         "src": url_stub + '/video/mp4/' + mySt + ($(this).is(":checked") ? '/hd.' : '/vgax.') + $("#videoPlaylist .active").attr("movie"),
         "poster": url_stub + '/video/jpeg/' + mySt + ($(this).is(":checked") ? '/hd.' : '/vgax.') + $("#videoPlaylist .active").attr("movie")
      });
  $('#videoDownload').attr('href', url_stub + '/video/download/' + mySt + ($(this).is(":checked") ? '/hd.' : '/vgax.') + $("#videoPlaylist .active").attr("movie"));
  $("#videoClip").get(0).load();
})


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
