<script>

  $('document').ready(function() {

    let myLocationArray = window.location.pathname.split('/'); 
    let mySt = myLocationArray[3];
 
    let allVideos = new Video(mySt, 'cv_' + mySt, 'https://' + window.location.hostname + url_stub );
    allVideos.initStage();
  
    return false;
  });

</script>