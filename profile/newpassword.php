<?php
//allow sessions to be passed so we can see if the user is logged in
//session_start();
//print_r($_COOKIE['_hrsb_msb']);
	$cookie=explode(':',$_COOKIE[_hrsb_msb]);
	$passwordmd5[0]=$cookie[2];
//	print_r($passwordmd5);
//	exit();
print <<<OUTPUT
<!DOCTYPE HTML>
<html dir="LTR" lang="en-us">
<head>
</head>
<!-- same styling as in minimal setup -->
<link rel="stylesheet" type="text/css" href="../css/form.css">
<!-- override it to have a columned layout -->
<link rel="stylesheet" type="text/css" href="../css/columns.css">
<style>
	#update{
		cursor: pointer;
		margin: 2px;
		padding: 1px;
		font-size: 75%;
	}

div.scroll
{
	//html=<div class="scroll">For TOS output</div>
	height: 200px;
	width: 700px;
	overflow: auto;
	border: 1px solid #666;
	background-color: #ccc;
	padding: 8px;
}

</style>

<script type="text/javascript" src="/js/jquery-ui-1.8.14.dark-hive.min.js"></script>
<!--
<script type="text/javascript" src="../js/profile.js"></script>
<script type="text/javascript" src="/js/hrsb.js"></script>
 -->
<script type="text/javascript" src="/js/jTip.js"></script>
<script type="text/javascript">

tips = $( "#tips" );

function updateTips( t )
{
//	alert ("updateTips = "+t);
	document.getElementById('tips').style.display="inline";
	tips
		.text( t )
		.addClass( "ui-state-highlight" );
	setTimeout(function()
	{
		tips.removeClass( "ui-state-highlight", 0 );
	}, 0 );
}
function checkLength( o, n, min, max )
{
//	alert ("checkLength");

	if ( o.val().length > max || o.val().length < min )
	{
		o.addClass( "ui-state-error" );
		updateTips( "Length of " + n + " must be between " + min + " and " + max + "." );
		$('#o').focus();
		return false;
	}
	else
	{
		return true;
	}
}

function areEqual (exp1, exp2)
{
//	alert ("areEqual: "+exp1.val()+"="+exp2.val());
	if(exp1.val() != exp2.val())
	{
		exp1.addClass ("ui-state-error");
		exp2.addClass ("ui-state-error");
		updateTips ( "The passwords entered are not the same." );
		$('#exp1').focus();
		return false;
	}
	else
	{
		return true;
	}
}

function notEqual (exp1, exp2)
{
//	alert ("areEqual: "+exp1.val()+"="+exp2.val());
	if(exp1.val() == exp2.val())
	{
		exp1.addClass ("ui-state-error");
		exp2.addClass ("ui-state-error");
		updateTips ( "The new password cannot be the same as your currect password." );
		$('#exp1').focus();
		return false;
	}
	else
	{
		return true;
	}
}

function checkRegexp( k, o, regexp, n )
{
//	alert ("checkRegexp");
	if ( !( regexp.test( o.val() ) ) )
	{
		o.addClass( "ui-state-error" );
		updateTips( n );
		$('#o').focus();
		return false;
	}
	else
	{
		return true;
	}
}

function isrequired( o, n)
{
//	alert ("isrequired");
	if ( o.val().length == 0 )
	{
		updateTips( n + " is a required field." );
		$('#o').focus();
		return false;
	}
	else
	{
		return true;
	}
}

function isblank( o, n, min, max )
{
//   alert ("isblank");
	if ( o.val().length < min )
	{
		o.addClass( "ui-state-error" );
		updateTips( n + " must be at least " + min + " alphanumeric characters." );
		$('#o').focus();
		return false;
	}
	else
	{
		return true;
	}
}
function checkdatabase (name, value)
{
//	alert("Checking database.");
	var string = name+"="+value;
//	alert(string);
//	return;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
//	alert("159 Checking database "+xmlhttp.responseText);
			if (xmlhttp.responseText != "success:true")
			{
	alert("161 Checking database "+data.success);
				return false;
			}
			else
			{
	alert("166 Checking database "+xmlhttp.responseText);
				return true;
			}
		}
	}
//	alert("168 Checking database.");
	xmlhttp.open("GET","checkdatabase.php?"+string,true);
	xmlhttp.send();
}


$(document).ready(function()
{

	new1 = $( "#new1" ),
	new2 = $( "#new2" ),
	password1 = $( "#password1" ),
	regFields = $( [] ).add( password1 ).add( new1 ).add( new2 );
	$( "#changepassword" ).submit(function(event)
	{
		$('#submit').removeClass ('ui-state-focus');
		$("#password1").focus();
		var bValid = true;
		regFields.removeClass( "ui-state-error" );

		bValid = bValid && isrequired( password1, "Password");
		if (!bValid)
		{
			$("#password1").addClass( "ui-state-error" )
			return false;
		}
//	$passwordmd5[1]=md5($_POST[password1]);

		bValid = bValid && checkLength( new1, "Password", 8, 12 );
//   alert ("line 201 "+bValid);
		bValid = bValid && checkRegexp( "", new1, /^([0-9a-zA-Z])+$/, "Password may consist of a-z, A-Z, 0-9" );
//   alert ("line 203 "+bValid);
		if (!bValid)
		{
			$("#new1").addClass( "ui-state-error" )
			$("#new1").focus();
//   alert ("line 64");
			return false;
		}
//   alert ("line 67");
		bValid = bValid && areEqual( new1, new2 );
		if (!bValid)
		{
//   alert ("line 214 "+bValid);
			$("#new1").addClass( "ui-state-error" )
			$("#new2").addClass( "ui-state-error" )
			$("#new1").focus();
			return false;
		}
		bValid = bValid && notEqual( pasword1, new1 );
		if (!bValid)
		{
//   alert ("line 214 "+bValid);
			$("#new1").addClass( "ui-state-error" )
			$("#new1").focus();
			return false;
		}

//		alert ("line 220 "+checkdatabase("password", $("#password1").val()));
		bValid = bValid && checkdatabase("password", $("#password1").val());
   alert ("line 221 "+bValid);
		if ( !bValid )
		{
			$("#password1").addClass( "ui-state-error" )
				document.getElementById('tips').innerHTML="Current password does not match our records.  Please re-enter.";
				document.getElementById('tips').style.display="inline";
				$(name).addClass( "ui-state-error" );
				return false;
		}
   alert ("line 230 "+bValid);
		if ( bValid ) //put function here to complete registration
		{
			// perform other work here ...
   alert ("line 234 "+bValid);
			$.ajax(
			{
				type : 'POST',
				cache: false,
				url : '../ajax/mypassword.php',
				dataType : 'json',
				data:
				{
					password : $('#password1').val(),
					new1 : $('#new1').val(),
					new2 : $('#new2').val(),
					action : 'newpassword'
				},
				success : function(data)
				{
					$('#tips').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
					$('#submit').show(500);
   				if (data.error == true)
   				{
   alert ("line 254");
//						o.addClass( "ui-state-error" );
						$(data.id).focus();
//						return false;
						$.unblockUI();
					}
   alert ("line 260");
					if (data.error == false)
					{
						$.ajax (
						{
							type : 'POST',
							cache: false,
							url : '../ajax/mypassword.php',
							dataType : 'json',
							data:
							{
								action : 'new',
								new1 : $('#new1').val(),
								password : $('#password').val()
							},
							success : function(data)
							{
								$('tips').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
	//							loadContent('#register','/profile/activate.html');
	//							document.location.href='/profile/activate.html';
							},
	 						error : function(data)
							{
								$('tips').removeClass().addClass('error')
								.text(data.msg).show(500);
								$('#submit').show(500);
							}
						});
					}
				},
				error : function(data)
				{
					$('tips').removeClass().addClass('error')
					.text(data.msg).show(500);
					$('#submit').show(500);
				}
	      });
		// unblock when remote call returns
		}
 	event.preventDefault(); //Prevent the default submit
	});

	$( ".jTip").button(
	{
		icons:
		{
			primary: "ui-icon-info"
		},
		text: false
	})

});
<!-- traffic (); -->
</script>
<body>
<div title="Change My Password">
 <form name="newpassword"  id="changepassword" method="post">
<div class="text ui-widget ui-widget-content ui-corner-all">
 <table border="0" bordercolor="#0000ff" cellpadding="2" cellspacing="0" width="750">
      <tbody>
      <tr class="ui-widget" width="100%">
         <td class="ui-widget ui-widget-header ui-corner-right ui-corner-left" colspan="3"><h1>Change My Password</h1></td>
      </tr>
      <tr class="ui-widget" width="100%">
         <td colspan="3">
         	<div class="validateTips ui-state-error ui-corner-all" id="tips" style="display:none"></div>
			</td>
      </tr>
      <tr class="ui-widget">
         <td width="25%" class="text ui-widget ui-corner-right ui-corner-left">
		<label for="password1">Current Password</label>
		</td>
         <td width="50%" class="text ui-widget ui-corner-right ui-corner-left">
		<input type="password" name="password1" id="password1" value="" title="Password" class="text ui-widget-content ui-corner-all" />
		</td>
         <td width="25%">&nbsp;</td>
		</tr>
       <tr class="ui-widget">
         <td class="text ui-widget ui-corner-right ui-corner-left">
      <label for="new1">New Password:</label><a href="tips/password.html?width=375" class="jTip" id="passwords" name="Passwords"></a>
		</td>
         <td class="text ui-widget ui-corner-right ui-corner-left">
      <input type="password" name="new1" id="new1" value="" title="Password" class="text ui-widget-content ui-corner-all" />
		</td>
         <td>&nbsp;</td>
		</tr>
      <tr class="ui-widget">
         <td class="text ui-widget ui-corner-right ui-corner-left">
		<label for="new2">Re-Enter New Password</label>
		</td>
         <td class="text ui-widget ui-corner-right ui-corner-left">
		<input type="password" name="new2" id="new2" value="" title="Password" class="text ui-widget-content ui-corner-all" />
		</td>
         <td>&nbsp;</td>
		</tr>
      <tr class="ui-widget">
         <td align="right" class="text ui-widget ui-corner-right ui-corner-left" colspan="3">
      <input id="submit" type="submit" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save New Password >>"></td>
      <input name="action" value="newpassword" type="hidden">
      <input name="subscriberid" value="$cookie[0]" type="hidden">
      </td>
      </tr>
      </tbody>
 </table>
	</form>
</div>
</div>
</body>
	<!-- body_eof //-->
	</html>
<?php
OUTPUT;
?>
