  <style>
  	.description{
       position: absolute; 
       top: 0px; 
       left: 0px;
       width: <?php $w=explode('x',$this->resolution);echo $w[0];?>px;
       background-color: green;
       font-family: 'tahoma';
       font-size: 0.9em;
       color: white;
       opacity: 0.5; /* transparency */
       filter: alpha(opacity=50); /* IE transparency */
       display:none;
    }
    .description span {
      margin-top: 5px;
      margin-left: 5px; /* ein span innerhalb des a-Tag bekommt so die richtige Höhe */
    }
    #rowImage:hover .description{
      display: block;
    }
    .controls {
      position: absolute;
      top: <?php list($w,$h)=explode('x',$this->resolution);echo ($h-40);?>px;;
      width: <?php $w=explode('x',$this->resolution);echo $w[0];?>px;
      height: 40px;
      background-color: silver;
      opacity: 0.5;
      filter: alpha(opacity=50); 
    }
    
  </style>
  
  <div class="container-fluid">
    <div class="row" id="rowImage" style="display:block;">
      <div class="col col-12" style="padding:0; margin:0;">
      	<?php $d=explode('x',$this->resolution);?>
        <img id="myImg" class="float-left" width="<?php echo $d[0];?>" 
                                           height="<?php echo $d[1];?>" 
                                           src="<?php echo _URL_STUB_;?>/public/images/btn-ajax-loader.gif">
        <div id="imgDescription" class="description">
          <div id="imgCount"></div>
        </div>
        
          <div data-role="controlgroup" data-type="horizontal" class="controls">
            <button type="button" class="btn btn-secondary" id="btnStart">Start</button>
            <a href="#" id="btnLiveCounter" data-role="button"><span id="imgCounter">20</span></a>
            <button type="button" class="btn btn-secondary" id="btnCount">Test</button>
          </div>
        
      </div>
      
    </div>
  </div>
  
  <script type="text/javascript">
    $('document').ready(function() {
      var shortTag = '<?php echo $this->shorttag;?>';
      var resolution = '<?php echo $this->resolution;?>';
      var autoplay = <?php echo $this->autoplay?'true':'false';?>;
      
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
        var hour = (String(zeit.getHours()).length==1?'0':'')+zeit.getHours();
        var min = (String(zeit.getMinutes()).length==1?'0':'')+zeit.getMinutes();
        var sec = (String(zeit.getSeconds()).length==1?'0':'')+zeit.getSeconds();
        var dateString = hour+':'+min+':'+sec;
        var countString = '<button type="button" class="btn btn-info">'+count+'</button>';
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
      var hour = (String(zeit.getHours()).length==1?'0':'')+zeit.getHours();
      var min = (String(zeit.getMinutes()).length==1?'0':'')+zeit.getMinutes();
      var sec = (String(zeit.getSeconds()).length==1?'0':'')+zeit.getSeconds();
      var dateString = hour+':'+min+':'+sec;
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