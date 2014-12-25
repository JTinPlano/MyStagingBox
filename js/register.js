<script>
$(function()
{
	function register ()
	{
		$("#submit").removeClass ("ui-state-focus");
		var loginid = $( "#loginid" ),
		token = $( "#token" ),
		email = $( "#email" ),
		password1 = $( "#password1" ),
		password2 = $( "#password2" ),
		loginid1 = $( "#loginid1" ),
		password = $( "#password" ),
		regFields = $( [] ).add( loginid ).add( email ).add( password1 ).add( password2 ),
		tips = $( ".regTip" );
		var bValid = true;
		var dbcheck = true;
		regFields.removeClass( "ui-state-error" );

		bValid = bValid && checkLength( loginid, "Login ID", 6, 12 );
		bValid = bValid && checkRegexp( "loginid", loginid, /^([0-9a-zA-Z_])+$/i, "Login ID may consist of a-z, A-Z, 0-9, underscores, and begin with a letter." );
		if (!bValid)
		{
			$("#loginid").focus();
			return false;
		}

		bValid = bValid && checkLength( email, "Email", 6, 80 );
	// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
		bValid = bValid && checkRegexp( "email", email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "Your Email Address must be a valid format, e.g. yourname@somedomain.com" );
		if (!bValid)
		{
			$("#email").focus();
			return false;
		}

		bValid = bValid && checkLength( password1, "Password", 8, 12 );
		bValid = bValid && checkRegexp( "", password1, /^([0-9a-zA-Z])+$/, "Password may consist of a-z, A-Z, 0-9" );
		if (!bValid)
		{
			$("#password1").focus();
			return false;
		}

		bValid = bValid && checkLength( password2, "Password", 8, 12 );
		bValid = bValid && checkRegexp( "", password2, /^([0-9a-zA-Z])+$/, "Password may consist of a-z, A-Z, 0-9" );
		bValid = bValid && areEqual( password1, password2 );
		if (!bValid)
		{
			$("#password2").focus();
			return false;
		}

		if ( bValid ) //put function here to complete registration
		{
			var vars = $("form").serialize();

 // perform other work here ...
			$.blockUI();
			$.ajax(
			{
				type : 'POST',
				cache: false,
				url : '/includes/post.php',
				dataType : 'json',
				data:
				{
					loginid : $('#loginid').val(),
					email : $('#email').val(),
					token : $('#token').val()
				},
				success : function(data)
				{
					$('#tip').removeClass().addClass((data.error === true) ? 'error' : 'success')
					.text(data.msg).show(500);
					$('#submit').show(500);
      			if (data.error == true){$.unblockUI();}
					if (data.error == false)
					{

						$.ajax (
						{
							type : 'POST',
							cache: false,
							url : '/includes/post.php',
							dataType : 'json',
							data:
							{
								action : 'register',
								loginid : $('#loginid').val(),
								email : $('#email').val(),
								password1 : $('#password1').val(),
								optin : $('#optin').val()
							},
							success : function(data)
							{
								$('#tip').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
								loadContent('#regform','/profile/activate.html');
//								document.location.href='/profile/activate.html';
							},
	 						error : function(data)
							{
								$('#tip').removeClass().addClass('error')
								.text('There was an error.').show(500);
								$('#submit').show(500);
							}
						});
					}
				},
				error : function(data)
				{
					$('#tip').removeClass().addClass('error')
					.text('There was an error.').show(500);
					$('#submit').show(500);
				}
      	});
		// unblock when remote call returns
 		$.unblockUI();
		return false;
		}
	}

//	$(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
	$('.warning').remove();
	$.get("/includes/token.php",function(txt){
		$("#regform").append('<input type="hidden" id="token" name="token" value="'+txt+'" />');
	});

   $('#submit').button().click(function()
	{
		register()'
	});
});
	</script>
