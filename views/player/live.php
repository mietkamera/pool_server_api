  <div class="container-fluid">
    <div class="row" id="rowImage" style="display:block;">
      <div class="col col-12" style="padding:0; margin:0;">
      	<?php $d=explode('x',$this->resolution);?>
        <img id="myImg" class="float-left" width="<?php echo $d[0];?>" 
                                           height="<?php echo $d[1];?>" 
                                           src="<?php echo _URL_STUB_;?>/public/images/btn-ajax-loader.gif">
        <div id="imgDescription" class="description">
        	<h5><span id="imgCount"></span></h5>
        </div>
      </div>
      
    </div>
  </div>
  
  <script type="text/javascript">
    $('document').ready(function() {
      var shortTag = '<?php echo $this->shorttag;?>';
      var resolution = '<?php echo $this->resolution;?>';
      var imgUrl = 'https://mobil.mietkamera.de/http-api/image/live/'+shortTag+'/'+resolution;

      var downloadBuffer = $('<img>');
      var imgCountDown = null;
      var isLoading = false;
      var count = 20;
      var reloadBtn = '<a class="btn btn-warning" href="javascript:location.reload(true);">reload</a>';

      downloadBuffer.on('load',function() {
        isLoading = false;
        $('#myImg').attr("src", $(this).attr("src"));
        var zeit = new Date();
        var dateString = zeit.getHours()+':'+zeit.getMinutes()+':'+zeit.getSeconds();
        var countString = '<span class="btn btn-info">'+count+'</span>';
        $('#imgCount').html((count>0?countString:reloadBtn)+' '+dateString);
        if (count<=0) {
          clearInterval(imgCountDown);
        }
      });

      downloadBuffer.on('error',function() {
        $('#myImg').attr('src','<?php echo _URL_STUB_;?>/public/images/btn-ajax-loader.gif');
        isLoading = false;
      });

      downloadBuffer.attr('src',imgUrl+'.'+Math.floor((Math.random() * 1000) + 1));
        var zeit = new Date();
        var dateString = zeit.getHours()+':'+zeit.getMinutes()+':'+zeit.getSeconds();
        var countString = '<span class="btn btn-info">'+count+'</span>';
        $('#imgCount').html(countString+' '+dateString);
        imgCountDown = setInterval(function() {
        if (isLoading===false && count>0) {
      	  downloadBuffer.attr('src',imgUrl+'.'+Math.floor((Math.random() * 1000) + 1));
          isLoading = true;
          count -= 1;
        }
      },1000);

    });
  </script>