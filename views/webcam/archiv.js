if (typeof namespace == "undefined")
  var namespace = { archiv:  {}, info: {}, weather:{} };

$('document').ready(function() {

  namespace.archiv = new Pictures(shorttag, 'ca_' + shorttag, 'https://' + hostName + url_stub);
  namespace.archiv.initStage();
  
  if ($('#ci_' + shorttag)) {
    namespace.info = new Information(shorttag, 'ci_' + shorttag, 'https://' + hostName + url_stub);
    namespace.info.initPanel();
  }

  if ($('#wd_' + shorttag)) {
    namespace.weather = new Weather(shorttag, 'wd_' + shorttag);
    namespace.weather.initPanel();
  }
  
  return false;
  
});
