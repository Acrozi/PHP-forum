<?php
session_start();
include('inc/header.php');
require_once('captcha.php');
$site_key = $_ENV['SITE_KEY'];
$secret_key = $_ENV['SECRET_KEY'];

 if(!empty($_SESSION['userid']) && $_SESSION['name']) {
   header('Location: index.php');

 }

?>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo - Ajax Based registration form using PHP and MYSQL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
<link rel="stylesheet" href="css/register.css">
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="login-registration.js"></script>

</head>

<body class="text-center">
<main class="form-signin">
	<div id="register-dialog" class="register-class">
		    <h1 class="h3 mb-3 fw-normal">PHP Forum form</h1>
    <form id="register-form" action="" method="post" role="form">


   <span id="first-name-info"></span>
    <div class="form-floating mb-3">
      <input type="text" class="form-control" id="first-name" placeholder="Name" name="first-name" value="">
      <label for="floatingName">Name</label>
    </div>
		<span id="register-email-info"></span>
    <div class="form-floating  mb-3">
      <input type="email" class="form-control" id="register-email-id" placeholder="name@example.com" name="email" value="">
      <label for="floatingEmail">Email address</label>
    </div>
		<span id="register-passwd-info"></span>
    <div class="form-floating  mb-3">
      <input type="password" class="form-control" id="register-password" placeholder="Password" name="register-password" value="">
      <label for="floatingPhone">Password</label>
    </div>
		<span id="confirm-passwd-info"></span>
    <div class="form-floating">
      <input type="password" class="form-control" id="confirm-password" placeholder="Confirm Password" name="confirm-password" value="">
      <label for="floatingPassword">Confirm Password</label>
    </div>
    <div class="form-floating">
       <div class="g-recaptcha" data-theme="light" data-size="normal" data-callback="captchaVerified"
          data-expired-callback="captchaExpired" data-sitekey=<?php echo $site_key; ?>></div>
    </div>
    <div id="g-recaptcha-error"></div>
		<input type="button" class="w-100 btn btn-lg btn-primary disabled" disabled id="registerSubmit" value="Register"
				onclick="ajaxRegistration()">
	</form>

	<div class="success-message" id="register-success-message"
			style="display: none"></div>
	<div class="error-message" id="register-error-message"
			style="display: none"></div>

			<div class="thank-you-registration">
			</div>

			</div>
</main>
</body>

<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous">
</script>

	<script>
	    $(document).ready(function(){
	        $("#registerSubmit").click(function(e){
	            e.preventDefault();
	            let emptyInputCount=0;

	            $("#register-form input").each(function(){
	                var input = $(this);
	                if(input.val() == ''){
	                    input.css('border-color','red');
	                    emptyInputCount = 1;
	                }
	                else{
	                    input.css('border-color','#ced4da');
	                }
	            })
	        })
	    });
</script>

<script>
   // Verification callback function
   function captchaVerified() {
     var submitBtn = document.getElementById('registerSubmit');
     submitBtn.removeAttribute('disabled');
     submitBtn.removeAttribute('aria-disabled');
     submitBtn.classList.remove('btn-outline-info', 'disabled');
     submitBtn.classList.add('btn-primary');
   }
   // Expiration callback function
   function captchaExpired() {
     grecaptcha.reset();
   }
</script>
</html>
