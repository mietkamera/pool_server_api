<script>

$('document').ready(function() {

  let myLocationArray = window.location.pathname.split('/'); 
  let mySt = myLocationArray[3];

  let allPictures = new Pictures(mySt, 'ca_' + mySt, 'https://' + window.location.hostname + url_stub);
  allPictures.initStage();
  
  <?php if ($this->print_information==1) { ?>
  let info = new Information(mySt, 'ci_' + mySt, 'https://' + window.location.hostname + url_stub);
  info.initPanel();
  <?php } ?>

  let video = new Video(mySt, 'cv_' + mySt, 'https://' + window.location.hostname + url_stub);
  video.initStage();
  
  let live = new Live(mySt, 'cl_' + mySt, 'https://' + window.location.hostname + url_stub);
  live.initStage();
  
  $('#project-tab-list a').on('click', function (e) {
    e.preventDefault();
    $(this).tab('show');
  });

  
  return false;

});

</script>