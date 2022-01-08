<script>

$('document').ready(function() {

  let myLocationArray = window.location.pathname.split('/'); 
  let mySt = myLocationArray[3];
  
  let last = new Last(mySt, 'cla_' + mySt, 'https://' + window.location.hostname + url_stub);
  last.initStage();
  
  <?php if ($this->print_information==1) { ?>
  let info = new Information(mySt, 'ci_' + mySt, 'https://' + window.location.hostname + url_stub);
  info.initPanel();
  <?php } ?>

  return false;

});

</script>