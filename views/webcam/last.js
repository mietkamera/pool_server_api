if (typeof namespace == "undefined")
  var namespace = { last:  {}, info: {} };

$('document').ready(function() {

  //let myLocationArray = window.location.pathname.split('/'); 
  //let mySt = myLocationArray[3];
  //let hostName = window.location.hostname;

  namespace.last = new Last(shorttag, 'cla_' + shorttag, 'https://' + hostName + url_stub);
  namespace.last.initStage();
  
  if ($("#ci_" + shorttag).length) {
    namespace.info = new Information(shorttag, 'ci_' + shorttag, 'https://' + hostName + url_stub);
    namespace.info.initPanel();
  }

  return false;

});
