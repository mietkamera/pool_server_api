  <div class="responsive-wrapper">
    <div id="jp_container_video_1" class="jp-flat-video" role="application" aria-label="media player">
      <div id="jquery_jplayer_video_1" class="jp-jplayer"></div>
      <div class="jp-gui">
      <div class="jp-play-control jp-control">
        <button class="jp-play jp-button" role="button" aria-label="play" tabindex="0"></button>
      </div>
      <div class="jp-bar">
        <div class="jp-seek-bar">
          <div class="jp-play-bar"></div>
          <div class="jp-details"><span class="jp-title" aria-label="title"></span></div>
          <div class="jp-timing"><span class="jp-duration" role="timer" aria-label="duration"></span></div>
        </div>
      </div>
      <div class="jp-screen-control jp-control">
        <button class="jp-full-screen jp-button" role="button" aria-label="full screen" tabindex="0"></button>
      </div>
    </div>
    <div class="jp-no-solution">
       Media Player Fehler<br />
       Update Browser or Flash plugin
    </div>
  </div>
  
  <script type="text/javascript">
    var shortTag = '<?php echo $this->shorttag;?>';
    var resolution = '<?php echo $this->resolution;?>';
    var start = <?php echo $this->start?'true':'false';?>;
    var loop = <?php echo $this->loop?'true':'false';?>;
    var reload = <?php echo $this->reload*1000;?>;
    
    var m4vVideoFile = '<?php echo _URL_STUB_;?>/video/mp4/'+shortTag+'/'+resolution;
    var jpgPosterFile = '<?php echo _URL_STUB_;?>/video/jpeg/'+shortTag+'/'+resolution;
    
    var myPlayer = $("#jquery_jplayer_video_1");
    
    var reloadVideo = function(){
      var dummy = Math.round(new Date().getTime());
      myPlayer.jPlayer("setMedia", {
                   title: "Zeitraffer",
                   m4v: m4vVideoFile+'.'+dummy,
           /*        webmv: webmVideoFile+'.'+dummy, */
                   poster: jpgPosterFile+'.'+dummy
                 }).jPlayer("play");
      setTimeout(reloadVideo, reload); // run again 
    }
    
    $(document).ready(function() {    
      
      myPlayer.jPlayer({
        ready: function(event) {
        	     var dummy = Math.round(new Date().getTime());
                 var $this = $(this).jPlayer("setMedia", {
                   title: "Zeitraffer",
                   m4v: m4vVideoFile+'.'+dummy,
                   poster: jpgPosterFile+'.'+dummy
                 })<?php echo (!$this->start)?';':'.jPlayer("play");';?>
                 

                 // Fix GUI when Full Screen button is hidden.
                 if(event.jPlayer.status.noFullWindow) {
                   var $anc = $($this.jPlayer("option", "cssSelectorAncestor"));
                   $anc.find('.jp-screen-control').hide();
                   $anc.find('.jp-bar').css({"right":"0"});
                 }

                 // Fix the responsive size for iOS and Flash.
                 var fix_iOS_flash = function() {
                   var w = $this.data("jPlayer").ancestorJq.width();
                   var h = w * 9 / 16; 
                   // Change to suit your aspect ratio. Used 16:9 HDTV ratio.
                   $this.jPlayer("option", "size", {
                     width: w + "px",
                     height: h + "px"
                   });
                 };
        
                 var plt = $.jPlayer.platform;
                 if(plt.ipad || plt.iphone || plt.ipod || event.jPlayer.flash.used) {
                   $(window).on("resize", function() {
                     fix_iOS_flash();
                   });
                   fix_iOS_flash();
                  
                 }            
        },
        <?php if ($this->loop) { ?>
        ended: function(event) {
          $(this).jPlayer("play");	
        },
        <?php } ?>
        nativeVideoControls: {
          ipad: /ipad/,
          iphone: /iphone/,
          android: /android/,
          blackberry: /blackberry/,
          iemobile: /iemobile/
        },
        timeFormat: {
          padMin: false
        },
        swfPath: "/public/jplayer",
        supplied: "webmv,  m4v",
        cssSelectorAncestor: "#jp_container_video_1",
        // See the CSS for more info on changing the size.
        size: {
          width: "100%",
          height: "auto",
          cssClass: "responsive-wrapper"
        },
        sizeFull: {
          cssClass: "jp-flat-video-full"
        },
        autohide: {
          full: false,
          restored: false
        },
        play:  function() {
                 $(this).jPlayer("option", "autohide", {
                   full: true,
                   restored: true
                 });
                 // Avoid multiple jPlayers playing together.
                 $(this).jPlayer("pauseOthers");
               },
        // When paused, show the GUI
        pause: function() {
                 $(this).jPlayer("option", "autohide", {
                   full: false,
                   restored: false
                 });
               },
        // Enable clicks on the video to toggle play/pause
        click: function(event) {
                 if(event.jPlayer.status.paused) {
                   $(this).jPlayer("play");
                 } else {
                   $(this).jPlayer("pause");
                 }
               },
        useStateClassSkin: true,
        autoBlur: false,
        smoothPlayBar: !($.jPlayer.browser.msie && $.jPlayer.browser.version < 9), // IE8 did not like the hidden animated progress bar.
        remainingDuration: true,
        keyEnabled: true,
        keyBindings: {
          // Disable some of the default key controls
          loop: null,
          muted: null,
          volumeUp: null,
          volumeDown: null
        }
      });
      
      <?php echo $this->reload>0?"reloadVideo();":"";?>  
    
    });
    

  </script>
