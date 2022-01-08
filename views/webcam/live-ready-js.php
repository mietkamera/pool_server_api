<script>

$('document').ready(function() {

  let myLocationArray = window.location.pathname.split('/'); 
  let mySt = myLocationArray[3];

  <?php if ($this->print_information==1) { ?>
  let info = new Information(mySt, 'ci_' + mySt, 'https://' + window.location.hostname + url_stub);
  info.initPanel();
  <?php } ?>

  let live = new Live(mySt, 'cl_' + mySt, 'https://' + window.location.hostname + url_stub);
  live.initStage();
  
  return false;

});

</script>