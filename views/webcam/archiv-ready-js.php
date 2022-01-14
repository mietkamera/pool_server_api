<script>

$('document').ready(function() {

  //let myLocationArray = window.location.pathname.split('/'); 
  //let mySt = myLocationArray[3];
  //let hostName = window.location.hostname;

  let mySt = "<?php echo $this->shorttag;?>";
  let hostName = "<?php echo $_SERVER['SERVER_NAME'];?>";
  
  let allPictures = new Pictures(mySt, 'ca_' + mySt, 'https://' + hostName + url_stub);
  allPictures.initStage();
  
  <?php if ($this->print_information==1) { ?>
  let info = new Information(mySt, 'ci_' + mySt, 'https://' + hostName + url_stub);
  info.initPanel();
  <?php } ?>
  
  return false;
  
});

</script>