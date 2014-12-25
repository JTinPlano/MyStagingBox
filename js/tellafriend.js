
		$( "#tellafriend" ).dialog(
		{
				autoOpen: false,
				height: 550,
				width: 700,
				modal: true,
				buttons:
				{
					"Send Message": function()
					{
						$("#submit").removeClass ("ui-state-focus");
						var toemail = $( "#toemail" ),
						fromemail = $( "#fromemail" ),
						message = $( "#message" ),
						tellfields=$( [] ).add( toemail ).add( fromemail ).add( message ),
						tip = $( "#tellTip" );
						var bValid = true;
						tellfields.removeClass( "ui-state-error" );
					bValid = bValid && isblank( toemail, "Your friend\'s email address", 8, 12 );
					bValid = bValid && checkRegexp( "toemail", toemail, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "Your Email Address must be a valid format, e.g. yourname@somedomain.com" );
					if (!bValid)
					{
						$("#toemail").focus();
						return false;
					}
					bValid = bValid && isblank( fromemail, "Your email address", 8, 12 );
					bValid = bValid && checkRegexp( "fromemail", fromemail, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "Your Email Address must be a valid format, e.g. yourname@somedomain.com" );
					if (!bValid)
					{
						$("#fromemail").focus();
						return false;
					}
					bValid = bValid && isblank( message, "Your message", 8, 12 );
					if (!bValid)
					{
						$("#message").focus();
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
								toemail : $('#toemail').val(),
								fromemail : $('#fromemail').val(),
								message : $('#message').val(),
								action : 'sendmessage'
							},
							success : function(data)
							{
								$('#tip').removeClass().addClass((data.error === true) ? 'error' : 'success')
								.text(data.msg).show(500);
								$('#submit').show(500);
								if (data.error == false)
								{
									$('#tip').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
									document.location.href='/index.php';
			//						$( this ).dialog( "close" );
			//						$('#demos').hide();
			//						$('#accordion').accordion().show();
			//						$('#loggedin').show();
			//						$('#visitor').hide();
			//						loadContent ('#content', '/outer.php');
								}
							},
							error : function(data)
							{
								$('#tip').removeClass().addClass('error')
								.text('There was an friggin error.').show(500);
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
<div id="tellafriend" title="Tell A Friend" style"display:none;">
	<span class="validateTip" id="tip">All form fields are required.</span>
	<form>
	<fieldset>
		<label for="toemail">Friend's Email Address</label>
		<input type="text" name="toemail" id="toemail" value="" title="Friend\'s Email Address" class="text ui-widget-content ui-corner-all" />
		<label for="fromemail">My Email Address</label>
		<input type="text" name="fromemail" id="fromemail" value="" title="My Email Address" class="text ui-widget-content ui-corner-all" />
		<label for="Message">Message to Friend (<span id="charcount">0</span> characters entered - <span id="remaining1">512</span> remaining.)</label>
		<textarea class="text ui-widget-content ui-corner-all" id="message" name="Message" rows="12" cols="80" wrap onkeyup="CheckFieldLength(Message, 'charcount', 'remaining1', 512);" onkeydown="CheckFieldLength(Message, 'charcount', 'remaining1', 512);" onmouseout="CheckFieldLength(Message, 'charcount', 'remaining1', 512);"><?php  echo $Message; ?></textarea>
	</fieldset>
	</form>
</div>
</div>

