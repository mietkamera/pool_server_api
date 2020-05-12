<div class="signin-form">
 <div class="container">
  <form class="form-signin" method="post" id="login-form">
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
    <input type="text" class="form-control" style="display:none;" name="shorttag" id="shorttag" value="<?php echo $this->shorttag;?>"/>
   </div>
   <div class="form-group" id="form-e" style="display:none;">
    <input type="email" class="form-control" placeholder="Emailadresse" name="email" id="email" />
    <span id="check-e"></span>
   </div>
   <div class="form-group">
    <input type="password" class="form-control" placeholder="Passwort" name="password" id="password" />
   </div>
   <hr />
   <div class="form-group">
    <button type="submit" class="btn btn-default" name="btn-login" id="btn-login">
      <span class="oi oi-account-login" title="account-login" aria-hidden="true"></span>&nbsp;Anmelden
    </button>
   </div>
   <div class="form-group form-check" id="form-a">
   	 <?php if ($this->shorttag!='') { ?>
   	 <input type="checkbox" class="filled-in form-check-input" name="asadmin" id="asadmin" value="normal">
     <label for="asadmin" class="disabled form-check-label">Als Admin anmelden</label>
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

  normal_validation = {
    rules: {
      password: { 
        required: true
   	  }
    },
      
    messages: {
      password:{
        required: "Bitte geben Sie Ihr Passwort ein"
      }
    },
      
    submitHandler: submitForm 
 
  };
  
  admin_validation = {
    rules: {
      password: { 
        required: true
   	  },
   	  email: {
        required: true,
        email: true
      }
    },
      
    messages: {
      password:{
        required: "Bitte geben Sie Ihr Passwort ein"
      },
      email: "Geben Sie Ihre Emailadresse ein"
    },
      
    submitHandler: submitForm 
 
  };

<?php 
if ($this->shorttag!='') { ?>
  $("#asadmin").change(function(){
  	if(this.checked) {
  	  $("#form-e").show();
  	  $("#form-s").hide();
  	  this.value = "admin";
  	  $("#login-form").validate(admin_validation); 
  	} else {
  	  $("#form-e").hide();
  	  $("#form-s").show();
  	  this.value = "normal";
  	  $("#login-form").validate(normal_validation); 
  	}
  });
  
  $("#login-form").validate(normal_validation);  
  $("#password").focus();
<?php 
} else {
?>
  $("#form-e").show();
  $("#form-s").hide();
  $("#form-a").hide();
  this.value = "admin";
  $("#login-form").validate(admin_validation);
  $("#email").focus();
<?php
}
?>
  /* login submit */
  function submitForm() {
  	var formData = $("#login-form").serialize();
  	var httpRoot = '<?php echo $this->httpRoot;?>';
  	$.ajax({
  		type : 'POST',
  		url  : httpRoot+'ajax/login.php',
  		data : formData,
  		beforeSend: function() { 
  		  $("#error").fadeOut();
  		  $("#btn-login").html('<span class="oi oi-transfer"></span> &nbsp; Sende Anfrage ...');
  		},
  		success : function(response) { 
  		    if(response=="ok") {
  			  $("#btn-login").html('<img src="'+httpRoot+'public/images/btn-ajax-loader.gif" /> &nbsp; Anmelden ...');
  			  <?php if ($this->redirect=='') { ?>
  			  setTimeout('window.location.href = "<?php echo $_SERVER['HTTP_REFERER'];?>";',1000);
  			  <?php } else { ?>
  			  setTimeout('window.location.href = "<?php echo _URL_STUB_.'/'.$this->redirect;?>"; ',1000);
  			  <?php } ?>
  			} else {
  			  $("#error").fadeIn(1000, function(){      
  			    $("#error").html('<div class="alert alert-danger"> <span class="oi oi-info"></span> &nbsp; '+response+' !</div>');
  				$("#btn-login").html('<span class="oi oi-account-login"></span> &nbsp; Anmelden');
  			  });
  			}
  		}
  	});
  	return false;
  }
  /* login submit */
}); /* $('document').ready */
</script>