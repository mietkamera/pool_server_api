<div class="signin-form">
 <div class="container">
  <form class="form-signin" method="post" id="loginForm">
   <img class="float-left" src="/http-api/public/images/favicon-32x32.png">
   <h2 class="form-signin-heading">&nbsp;mietkamera.de</h2><hr />
   <div id="info">
    <!-- show info here -->
   </div>
   <div id="error">
    <!-- error will be shown here ! -->
   </div>
   <div class="form-group" id="form-s">
   	<p>Login f&uuml;r den Shorttag <b><?php echo $this->shorttag;?></b> :</p>
   	<!--<p>REFERER: <?php if (isset($this->redirect)) echo htmlentities($this->redirect);?></p>!-->
    <input name="shorttag" id="shorttag" type="text" class="form-control" style="display:none;" value="<?php echo $this->shorttag;?>"/>
   </div>
   <div class="form-group" id="form-e" style="display:none;">
    <input name="email" id="email" placeholder="Emailadresse" type="text" class="form-control" data-rule="{val}.length==0 || __isEmail({val})">
    <div class="invalid-feedback">Geben Sie eine g&uuml;ltige Emailadresse ein.</div>
   </div>
   <div class="form-group">
    <input type="password" class="form-control" placeholder="Passwort" name="password" id="password" />
   </div>
   <hr />
   <div class="form-group">
    <button type="submit" class="btn btn-default" name="btn-login" id="btn-login">
      <i class="fas fa-sign-in-alt"></i>&nbsp;</span>&nbsp;Anmelden
    </button>
   </div>
   <div class="form-group form-check" id="form-a">
   	 <?php if ($this->shorttag!='') { ?>
   	 <input type="checkbox" class="filled-in form-check-input" name="asadmin" id="asadmin" value="normal">
     <label for="asadmin" class="disabled form-check-label">Als Administrator anmelden</label>
     <?php } else { ?>
     <input type="checkbox" class="disabled filled-in form-check-input" name="asadmin" id="asadmin" value="admin" checked>
     <label for="asadmin" class="disabled form-check-label">Als Admin anmelden</label>
     <?php } ?>
   </div>
  </form>
 </div>
</div>

<script type="text/javascript" >

$('document').ready(function() { 

  $("#loginForm").find("input").each(function () {
    // Diese Funktion befindet sich in my-bootstrap4-validation.js
    __attachValidationHandler($(this));
  });

<?php 
if ($this->shorttag!='') { ?>
  $("#asadmin").change(function(){
  	if(this.checked) {
  	  $("#form-e").show();
  	  $("#form-s").hide();
  	  this.value = "admin";
  	} else {
  	  $("#form-e").hide();
  	  $("#form-s").show();
  	  this.value = "normal";
  	}
  });
  $("#password").focus();
<?php 
} else {
?>
  $("#form-e").show();
  $("#form-s").hide();
  $("#form-a").hide();
  this.value = "admin";
  $("#email").focus();
<?php
}
?>

  $("#loginForm").on("submit", function() {
  	
    $(this).find("input").each(function () {
      __triggerValidationHandler($(this));
    });
    
    var valid = ($(this).find("input.is-invalid").length === 0);
    if (!valid) {
      return false;
    }
    
  	var formData = $("#loginForm").serialize();
  	$.ajax({
  		type : 'POST',
  		url  : url_stub + '/ajax/login_op.php',
  		data : formData,
  		beforeSend: function() { 
  		  $("#error").fadeOut();
  		  $("#btn-login").html('<i class="fas fa-exchange-alt"></i>&nbsp;Sende Anfrage ...');
  		},
  		success : function(response) { 
  		    switch(response.return) {
  		      case 200:
  		      case 202:
  			    $("#btn-login").html('<img src="' + url_stub + '/public/images/btn-ajax-loader.gif" /> &nbsp; Anmelden ...');
  			    <?php if ($this->redirect=='') { ?>
  			    setTimeout('window.location.href = "<?php echo $_SERVER['HTTP_REFERER'];?>";',1000);
  			    <?php } else { ?>
  			    setTimeout('window.location.href = "<?php echo _URL_STUB_.'/'.$this->redirect;?>"; ',1000);
  			    <?php } ?>
  			    break;
  			  case 400:
  			  case 500:
  			    $("#error").fadeIn(1000, function(){      
  			      $("#error").html('<div class="alert alert-danger"><i class="fas fa-info"></i>&nbsp;'+ response.message + ' !</div>');
  				  $("#btn-login").html('<i class="fas fa-sign-in-alt"></i>&nbsp;Anmelden');
  			    });
  			    break;
  			}
  		}
  	});
  	return false;
  });
 
}); /* $('document').ready */
</script>