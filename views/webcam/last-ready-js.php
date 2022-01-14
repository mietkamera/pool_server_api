<script>

$('document').ready(function() {

  //let myLocationArray = window.location.pathname.split('/'); 
  //let mySt = myLocationArray[3];
  //let hostName = window.location.hostname;

  let mySt = "<?php echo $this->shorttag;?>";
  let hostName = "<?php echo $_SERVER['SERVER_NAME'];?>";
  
  let last = new Last(mySt, 'cla_' + mySt, 'https://' + hostName + url_stub);
  last.initStage();
  
  <?php if ($this->print_information==1) { ?>
  let info = new Information(mySt, 'ci_' + mySt, 'https://' + hostName + url_stub);
  info.initPanel();
  <?php } ?>

  return false;

});

</script>