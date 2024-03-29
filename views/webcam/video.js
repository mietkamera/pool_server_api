if (typeof namespace == "undefined")
  var namespace = { video: {}, info: {} };

$('document').ready(function() {

  if ($("#ci_" + shorttag).length) {
    namespace.info = new Information(shorttag, 'ci_' + shorttag, 'https://' + hostName + url_stub);
    namespace.info.initPanel();
  } 

  namespace.video = new Video(shorttag, 'cv_' + shorttag, 'https://' + hostName + url_stub );
  namespace.video.initStage();
  
  return false;
});
