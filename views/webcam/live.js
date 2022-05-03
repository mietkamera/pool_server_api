if (typeof namespace == "undefined")
  var namespace = { live:  {}, info: {} };

function afterInit() {
  
}

$('document').ready(function() {

  if ($("#ci_" + shorttag).length) {
    namespace.info = new Information(shorttag, 'ci_' + shorttag, 'https://' + hostName + url_stub);
    namespace.info.initPanel();
  } 

  namespace.live = new Live(shorttag, 'cl_' + shorttag, 'https://' + hostName + url_stub);
  namespace.live.initStage(afterInit);
  
  return false;

});
