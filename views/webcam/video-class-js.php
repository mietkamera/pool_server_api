<script>

  class Video {
  	
    constructor (st,elementId,apiUrl='') {
  	  this.apiUrl = apiUrl;
      this.st = st;
      this.all = '';
      this.kw = [];
      // DOM elements
      if($('#' + elementId).length) {
      	this.videoDiv = $('#' + elementId);
        this.videoClip = $('#' + elementId + ' .video-clip');
        this.videoPlayList = $('#' + elementId + ' .video-playlist');
        this.videoDownloadBtn = $('#' + elementId + ' .video-download-btn');
        this.switchHD = $('#' + elementId + ' .switch-hd');
        
        var obj = this;
        this.switchHD.on('click', this.onSwitchHD() );
        
        this.videoPlayList.on('click', 'li', function() {
          obj.videoPlayList.find('.active').removeClass('active');
          var li = $(this);
          li.addClass('active');
          obj.videoClip.attr({
            "src": url_stub + '/video/mp4/' + obj.st + (obj.switchHD.is(":checked") ? '/hd.' : '/vgax.') + li.attr("movie"),
            "poster": url_stub + '/video/jpeg/' + obj.st + (obj.switchHD.is(":checked") ? '/hd.' : '/vgax.') + li.attr("movie")
          });
          obj.videoDownloadBtn.attr('href', url_stub + '/video/download/' + obj.st + (obj.switchHD.is(":checked") ? '/hd.' : '/vgax.') + $(this).attr("movie"));
          obj.videoClip.get(0).load();
        });
        
      }
    }

    onSwitchHD () {
      this.videoClip.get(0).pause();
      var active = this.videoPlayList.find('.active').eq(0);
      if (active.length>0 ) {
        this.videoClip.attr({
              "src": url_stub + '/video/mp4/' + this.st + (this.switchHD.is(":checked") ? '/hd.' : '/vgax.') + active.attr("movie"),
              "poster": url_stub + '/video/jpeg/' + this.st + (this.switchHD.is(":checked") ? '/hd.' : '/vgax.') + active.attr("movie")
        });
        this.videoDownloadBtn.attr('href', url_stub + '/video/download/' + this.st + (this.switchHD.is(":checked") ? '/hd.' : '/vgax.') + $("#videoPlaylist .active").attr("movie"));
        this.videoClip.get(0).load();
      }
    }
    
    loadData (data) {
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
    }
  
    numKW () {
      return this.kw.length;
    }
  
    numComplete () {
      if (this.all === '')
        return 0
       else
        return 1;
    }
  
    getCompleteURI () {
      return this.all;
    }
  
    getKwURI (index) {
      return this.kw[index];
    }
 
    initStage () {
      var obj = this;
  	  $.getJSON(this.apiUrl + '/video/json/' + this.st, function(data) {
        setTimeout(obj.loadData(data), 0);
        if ((obj.numComplete() + obj.numKW()) > 0) {
          if (obj.numComplete() > 0)
  	        obj.videoPlayList.append('<li class="btn btn-sm btn-outline-primary active btn-block my-2" movie="all">Video &uuml;ber die gesammte Zeit</li>');
  	      for (var i = 0; i < obj.numKW(); i++) 
  	        obj.videoPlayList.append('<li class="btn btn-sm btn-outline-secondary mr-1 mb-1" movie="kw.' + obj.getKwURI(i) + '">' + obj.getKwURI(i) + '</li>');
  	      obj.videoDownloadBtn.attr('href', url_stub + '/video/download/' + obj.st + '/vgax.all');
  	      obj.videoClip.attr({
              "src": url_stub + '/video/mp4/' + obj.st + (obj.switchHD.is(":checked") ? '/hd.' : '/vgax.') + obj.videoPlayList.find('li').eq(0).attr("movie"),
              "poster": url_stub + '/video/jpeg/' + obj.st + (obj.switchHD.is(":checked") ? '/hd.' : '/vgax.') + obj.videoPlayList.find('li').eq(0).attr("movie")
          });
        }
      });
    }
   
  }
</script>