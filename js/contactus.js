		$( "#contactus" ).dialog(
		{
				autoOpen: false,
				height: 600,
				width: 700,
				modal: true,
				buttons:
				{
					"Send Message": function()
					{
						$("#submit").removeClass ("ui-state-focus");
						var myemail = $( "#myemail" ),
						mymessage = $( "#mymessage" ),
						contactfields=$( [] ).add( myemail ).add( subject ).add( mymessage ),
						tip = $( "#contactTip" );
						var bValid = true;
						contactfields.removeClass( "ui-state-error" );
					bValid = bValid && checkRegexp( "email", email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "Your Email Address must be a valid format, e.g. yourname@somedomain.com" );
						if (!bValid)
						{
							$("#loginid1").focus();
							return false;
						}
					bValid = bValid && checkRegexp( "email", email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "Your Email Address must be a valid format, e.g. yourname@somedomain.com" );
						if (!bValid)
						{
							$("#password").focus();
							return false;
						}
						if ( bValid )
						{
							var vars = $("form").serialize();

						 // perform other work here ...
							$.ajax(
							{
								type : 'POST',
								cache: false,
								url : '/includes/post.php',
								dataType : 'json',
								data:
								{
									loginid : $('#loginid1').val(),
									password : $('#password').val(),
									action : 'login'
								},
								success : function(data)
								{
									$('#tip').removeClass().addClass((data.error === true) ? 'error' : 'success')
									.text(data.msg).show(500);
									$('#submit').show(500);
									if (data.error == false)
									{
										document.cookie = 'loggedin=true';
										$('#tips').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
			//							document.location.href='/index.php';
										$( this ).dialog( "close" );
										$('#demos').hide();
										$('#accordion').accordion().show();
										$('#loggedin').show();
										$('#visitor').hide();
										loadContent ('#content', '/outer.php');
									}
								},
								error : function(data)
								{
									$('#tip').removeClass().addClass('error')
									.text(data.msg).show(500);
									$('#submit').show(500);
									return false;

								}
      					});
					// unblock when remote call returns
						return false;
						}
					},
					Cancel: function()
					{
						$('#token').remove();
						$( this ).dialog( "close" );
						$("#create-user").removeClass ("ui-state-focus");
					}
				},
				close: function()
				{
				}
			});
<div id="myDialog" class="dialog">
<div id="contactus" title="Contact Us" style"display:none;">
	<span class="validateTip" id="tip">All form fields are required.</span>
	<form>
	<fieldset>
		<label for="myemail">My Email Address</label>
		<input type="text" name="myemail" id="myemail" value="" title="My Email Address" class="text ui-widget-content ui-corner-all" />
		<label for="subject">Subject</label>
		<input type="text" name="subject" id="subject" value="" title="Subject" class="text ui-widget-content ui-corner-all" />
		<label for="MyMessage">Message (<span id="charcount">0</span> characters entered - <span id="remaining2">2000</span> remaining.)</label>
		<textarea class="text ui-widget-content ui-corner-all" name="MyMessage" rows="12" cols="88" wrap onkeyup="CheckFieldLength(MyMessage, 'charcount', 'remaining2', 2000);" onkeydown="CheckFieldLength(MyMessage, 'charcount', 'remaining2', 2000);" onmouseout="CheckFieldLength(MyMessage, 'charcount', 'remaining2', 2000);"><?php  echo $MyMessage; ?></textarea>
	</fieldset>
	</form>
</div>
</div>
