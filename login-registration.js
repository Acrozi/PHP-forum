function validateEmailId(input) {
	var emailFormat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

	if (emailFormat.test(input)) {
		return true;
	} else {
		return false;
	}
}

function pregMatch(input) {
	var regExp = /^[a-zA-Z]*$/;

	if (regExp.test(input)) {
		return true;
	} else {
		return false
	}
}

function ajaxRegistration() {
	$(".error").text("");
	$('#first-name-info').removeClass("error");
	$('#register-email-info').removeClass("error");
	$('#register-passwd-info').removeClass("error");
	$('#confirm-passwd-info').removeClass("error");

	var firstName = $('#first-name').val();
	var emailId = $('#register-email-id').val();
	var password = $('#register-password').val();
	var confirmPassword = $('#confirm-password').val();
	var actionString = 'registration';

	if (firstName == "") {
		$('#first-name-info').addClass("error");
		$(".error").text("krävs");
	} else if (!pregMatch(firstName)) {
		$('#first-name-info').addClass("error");
		$(".error").text('Bara bokstäver tillåtna');
	} else if (emailId == "") {
		$('#register-email-info').addClass("error");
		$(".error").text("krävs");
	} else if (!validateEmailId(emailId)) {
		$('#register-email-info').addClass("error");
		$(".error").text("Inte korrekt inskriven email");
	} else if (password == "") {
		$('#register-passwd-info').addClass("error");
		$(".error").text("krävs");
	} else if (confirmPassword == "") {
		$('#confirm-passwd-info').addClass("error");
		$(".error").text("krävs");
	} else if (password != confirmPassword) {
		$('#confirm-passwd-info').addClass("error");
		$(".error").text("Lösenorden matchar inte.");
	} else {
		$('#loaderId').show();
		$.ajax({
			url : 'ajax-login-registration.php',
			type : 'POST',
			data : {
				firstName : firstName,
				emailId : emailId,
				password : password,
				confirmPassword : confirmPassword,
				action : actionString
			},
			success : function(response) {
				if (response.trim() == 'error') {
					$('#register-success-message').hide();
					$('#ajaxloader').hide();
					$('#register-error-message').html(
							"Ogiltigt försök. Försök Igen.");
					$('#register-error-message').show();
				} else {
					$(".thank-you-registration").show();
					$(".thank-you-registration").text(response);
					setTimeout(function() {
          window.location.href = "login.php";
				}, 3000);
					// setInterval('location.reload()', 2000);

				}
			}

		});
	}// endif
}
