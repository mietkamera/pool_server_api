if (typeof namespace == "undefined")
  var namespace = { archiv:  {}, info: {} };

$('document').ready(function() {

  namespace.archiv = new Pictures(shorttag, 'ca_' + shorttag, 'https://' + hostName + url_stub);
  namespace.archiv.initStage();
  
  if ($('#ci_' + shorttag)) {
    namespace.info = new Information(shorttag, 'ci_' + shorttag, 'https://' + hostName + url_stub);
    namespace.info.initPanel();
  }
  
  return false;
  
});
