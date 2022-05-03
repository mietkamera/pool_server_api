if (typeof namespace == "undefined")
  var namespace = { archiv: {}, video: {}, live: {}, info: {} };
  
function afterInit() {
  
}

$('document').ready(function() {


  namespace.archiv = new Pictures(shorttag, 'ca_' + shorttag, 'https://' + hostName + url_stub);
  namespace.archiv.initStage();
  
  if ($("#ci_" + shorttag).length) {
    namespace.info = new Information(shorttag, 'ci_' + shorttag, 'https://' + hostName + url_stub);
    namespace.info.initPanel();
  }

  namespace.video = new Video(shorttag, 'cv_' + shorttag, 'https://' + hostName + url_stub);
  namespace.video.initStage();
  
  if ($("#cl_" + shorttag).length) {
    namespace.live = new Live(shorttag, 'cl_' + shorttag, 'https://' + hostName + url_stub);
    namespace.live.initStage(afterInit);
  }
  
  $('#project-tab-list a').on('click', function (e) {
    e.preventDefault();
    $(this).tab('show');
  });

  return false;

});
