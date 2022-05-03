class Information {

  constructor (st,elementId,apiUrl='') {
  	this.apiUrl = apiUrl;
    this.st = st;
    if($('#' + elementId).length) {
      this.infoDiv = $('#' + elementId);
      this.statusText = $('#' + elementId + ' .status-text');
      this.statusChart = $('#' + elementId + ' .status-chart');
    } 
  }
  
  initPanel() {
  	var obj = this;
    $.getJSON(this.apiUrl + '/status/information/' + this.st, function(data) {
      if (data.payload.information.aktiv) {
        var d = new Date();
        var timeMs = d.getTime();
        obj.statusText.val(data.payload.image.description);
        obj.statusChart.attr('src', obj.apiUrl + '/status/chart/' + obj.st + '/day.' + timeMs).removeClass('d-none');
        obj.refreshInfo = setInterval(function() {
      	  var d = new Date();
          var timeMs = d.getTime();
          $.getJSON(obj.apiUrl + '/status/information/' + obj.st + '/' + timeMs, function(info) {
            var d = new Date();
            var timeMs = d.getTime();
            obj.statusText.val(info.payload.image.description);
          });
        }, 1000*60);
      } else {
        obj.statusText.val('Die Kamera ist nicht mehr aktiv');
        obj.statusChart.addClass('d-none');
      }
    });
    
  }
}
