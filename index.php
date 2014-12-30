<?php
//if(!session_start()){print "session failed<br>";}
//$id=explode("=",SID);
$_COOKIE['session']=$id[1];
//	print_r(SID)."<br /><br />/n";
//	echo "<br />\n";
session_name('_hrsb_msb');
//$id=explode("=",SID);
//allow sessions to be passed so we can see if the user is logged in
include ($_SERVER["DOCUMENT_ROOT"]."/includes/functions.php");
//makecookie();
require($_SERVER["DOCUMENT_ROOT"]."/includes/defines.php");
require($_SERVER["DOCUMENT_ROOT"]."/lib/mysql.php");
require($_SERVER["DOCUMENT_ROOT"]."/lib/system.php");
//	print_r($_SESSION)."<br /><br />/n";
//	exit();
/*
action=activate
subscriberid='.$subscriberid.'
token='.$token.'
echo "GET<br />";
	print_r($_GET);
echo "<br />";
*/
if (isset($_GET))
{
	if ($_GET[action]=="activate")
	{
	/*
echo "_COOKIE<br />\n";
	print_r($_COOKIE);
echo "_GET<br />\n";
	print_r($_GET);
echo "<br />\ncookie<br />\n";
	$cookie=explode('_',$_COOKIE[_hrsb_msb]);
	print_r($cookie);
echo "<br />\ncookie1<br />\n";
	$cookie1=explode(':',$cookie[0]);
	print_r($cookie1);
echo "<br />\n";
	*/
	//	exit();
		if ($_COOKIE[token]==$_GET[token])
		{
			$cookie=explode('_',$_COOKIE[_hrsb_msb]);
			$cookie1=explode(':',$cookie[0]);
	//		echo "successful activation< /br>";

			$expires = date('U') + (3600*24*7);
			$newcookie=$cookie[0]."_".$expires."_1";
			setcookie('_hrsb_msb',$newcookie, $expires, '/');
			setcookie('loggedin', 'true', $expires, '/');
			$expired=date('U') - 3600;
			setcookie('token', '', $expired, '/');
			$query="update subscriber set confirmed='1', active='1', online='1' where subscriberid = $cookie1[0];";
			//echo $query;
			q($query)or die (mysql_error());
			$expires = date('U')-3600;
			setcookie('firsttime','true',$expires,'/');
			Header("Location: index.php?action=success");
		}
		else
		{
			echo "unsuccessful activation< /br>";
		}
	}
//	print_r($_GET);
//	echo "line 68<br />\nGET<br />\n";
	if ($_GET[action]=="success")
	{
//		echo "registrion successfull<br />n";
		$registered="You have activated your account successfully.";
//		exit();
	}
}
$loadthis="";
$leftcolumn="";
//$sitenotice="testing 1 2 3";
//echo isset($_COOKIE[_hrsb_msb]);
//echo isset($_COOKIE[loggedin]);
//exit();
if (($_COOKIE[_hrsb_msb]== NULL && $_COOKIE[loggedin]== NULL) ||
(isset($_COOKIE[_hrsb_msb]) && $_COOKIE[loggedin]== "false") ||
(isset($_COOKIE[_hrsb_msb]) && !isset($_COOKIE[loggedin]))
)
{
//	echo "inside first if statement<br>";
	//	$loadthis="		loadContent ('#logform', '/login.html');\n";
	$loadthis="		loadContent ('#content', 'intro.html');\n";
	$loadthis.="		$('#visitor').show();\n";
	$loadthis.="		$('#loggedin').hide();\n";
	$leftcolumn="		$('#accordion').hide();\n";
	$leftcolumn.="		$('#demos').accordion().show();\n";
}
elseif ($_COOKIE[_hrsb_msb] != NULL && $_COOKIE[loggedin]== "true")
{
//	echo "inside elseif statement<br>";
	$cookie=explode('_',$_COOKIE[_hrsb_msb]);
	//print_r($cookie);
	$cookie1=explode(':',$_COOKIE[_hrsb_msb]);
	//print_r($cookie1);
	if ($_COOKIE[loggedin]=='true')
	{
		if ($cookie[1] < date ('U'))
		{
			$expires = date('U') + (3600*24*7);
			$newcookie=$cookie[0]."_".$expires."_1";
			setcookie('_hrsb_msb',$newcookie, $expires, '/');
			setcookie('loggedin', 'true', $expires, '/');
		}
		$query="select loginid from subscriber where subscriberid = $cookie1[0]";
		//echo $query;
		$row=f(q($query));
		$subscriberid=$cookie1[0];
		$greeting="Hello, ".$row[loginid].".";
		$loadthis="$('#visitor').hide();\n";
		$loadthis.="$('#loggedin').show();\n";
		if ($_COOKIE['firsttime'] == 'true')
		{
			$loadthis.="		loadContent('#content', 'profile/create_account.php');\n";
			$expires = date('U')-3600;
			setcookie('firsttime','',$expires,'/');

		}
		else
		{
			$loadthis.="		loadContent('#content', 'calendar/outer.php');\n";
		}
		$leftcolumn="$('#accordion').accordion().show();\n";
		$leftcolumn.="$('#demos').hide();\n";
	}
	else
	{
		$leftcolumn="$('#accordion').hide();\n";
		$leftcolumn.="$('#demos').accordion().show();\n";
		$loadthis="$('#visitor').show();\n";
		$loadthis.="$('#loggedin').hide();\n";
		$loadthis.="		loadContent ('#content', 'intro.html');\n";
	}
}
?>
<!DOCTYPE HTML>
<html dir="LTR" lang="en-us">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Description" content="MyStagingBox.com, the perfect calendar schedule for all things hot rod.  If it's a hot rod happening, you'll find it here.">
<meta name="Keywords" content="hot rod happening, all things hot rod, classic, muscle, car, show, club, meeting, calendar, schedule, cruise, night, staging, corvette, mustang, chevelle, mopar, roadrunner, charger, challenger, cuda, hemi, ls6, 454, 396, 427, 428, 429, cobra, super sport, boss">
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="7 days">
<title>MyStagingBox.com All Things Hot Rod Home Page</title>
<!--[if lt IE 9]>
        <script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if lt IE 7]>
     <link href="css/ie/ie6.css" rel="stylesheet" type="text/css" />
     <script type="text/javascript" src="js/ie_png.js"></script>
     <script type="text/javascript">
     ie_png.fix('.png, .corner-top-left, .corner-top-right, .border-top, .border-left, .border-right, .border-bot, .box-tail, .corner-bot-left, .corner-bot-right, .ban-top, .ban-bot');
     </script>
<![endif]-->
<!--[if IE]>
      <script type="text/javascript" src="js/html5.js"></script>
<![endif]-->
	<link type="text/css" href="/css/jquery-ui-1.8.14.dark-hive.css" rel="stylesheet" />
	<link type="text/css" href="/css/prod.css" rel="stylesheet" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="/js/jquery-ui-1.8.14.dark-hive.min.js"></script>
	<link type="text/css" href="/css/tooltip.css" rel="stylesheet" />
	<script type="text/javascript" src="/js/hrsb.js"></script>
	<script type="text/javascript" src="/js/jquery.cookies.2.2.0.js"></script>
<!--	<script type="text/javascript" src="/js/jquery.blockUI.js"></script>	  -->
<script type="text/javascript">
	$(document).ready(function()
	{
		var loginid = $( "#loginid" ),
		email = $( "#email12" ),
		optin = $( "#optin" ),
		token = $( "#token" ),
		password1 = $( "#password1" ),
		password2 = $( "#password2" ),
		regFields = $( [] ).add( loginid ).add( email ).add( password1 ).add( password2 ).add( token ).add( optin ),
		loginid1 = $( "#loginid1" ),
		password = $( "#password" ),
		loginfields=$( [] ).add( loginid1 ).add( password ),
		toemail = $( "#toemail" ),
		fromemail = $( "#fromemail" ),
		tellmessage = $( "#tellmessage" ),
		tellfields = $( [] ).add( toemail ).add( fromemail ).add( tellmessage ),
		myemail = $( "#myemail" ),
		contacttypeid = $( "#contacttypeid" ),
		contactmessage = $( "#contactmessage" ),
		contactfields = $( [] ).add( myemail ).add( contacttypeid ).add( contactmessage ),
		tips = $( ".validateTips" );

function updateTips( t )
{
//   alert ("updateTips = "+t);
	  tips.text( t ).addClass( "ui-state-error text ui-widget-content ui-corner-all" );
	  tips.css("display","block");
	setTimeout(function()
	{
		tips.removeClass( "ui-state-highlight", 0 );
	}, 2000 );
}
function checkRegexp( k, o, regexp, n )
{
//   alert ("checkRegexp o= "+o.val()+" k= "+k);
	if ( !( regexp.test( o.val() ) ) )
	{
		o.addClass( "ui-state-error" );
		updateTips( n );
		return false;
	}
	else
	{
		return true;
	}
}

function checkLength( o, n, min, max )
{
//   alert ("checkLength o= "+o.val()+" n= "+n);

	if ( o.val().length > max || o.val().length < min )
	{
		o.addClass( "ui-state-error" );
		updateTips( "Length of " + n + " must be between " + min + " and " + max + "." );
		return false;
	}
	else
	{
		return true;
	}
}

function areEqual (exp1, exp2)
{
//   alert ("areEqual"+exp1.val()+", "+exp2.val());
	if(exp1.val() != exp2.val())
	{
		exp1.addClass ("ui-state-error");
		exp2.addClass ("ui-state-error");
		updateTips ( "The passwords entered are not the same." );
		return false;
	}
	else
	{
		return true;
	}
}
function notEqual (exp1, exp2)
{
//   alert ("notEqual"+exp1.val()+", "+exp2.val());
	if(exp1.val() == exp2.val())
	{
		exp1.addClass ("ui-state-error");
		exp2.addClass ("ui-state-error");
		updateTips ( "The passwords entered are not the same." );
		return false;
	}
	else
	{
		return true;
	}
}

function isrequired (i, n )
{
//alert ("line 269 isrequired data:  "+i.val().length+", "+n+".");
	if ( i.val().length == 0 )
	{
		i.addClass( "ui-state-error" );
		updateTips( n + " is a required field." );
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
		return false;
	}
	else
	{
		return true;
	}
}
function logoutindex()
{
	<?php
		$query="update subscriber set online='0' where subscriberid = $cookie1[0];";
		//echo $query;
		q($query);
	?>
	document.cookie = 'loggedin=false';
	document.location.href='/index.php';
}
<?php echo $loadthis; ?>
<?php echo $leftcolumn; ?>

		// Accordion
		$("#accordion").accordion(
		{
			 autoHeight: false
			//event: "mouseover"
		});
		$("#demos").accordion(
		{
			 autoHeight: true
			//event: "mouseover"
		});
		$( "#about" ).click(function()
		{
			loadContent("#content", 'about.html');
			return false;
		});

		$( "#demoadd" ).click(function()
		{
			loadContent("#content", 'demo/calendar/addItem.php');
			return false;
		});
		$( "#demoevent" ).click(function()
		{
			loadContent("#content", 'demo/calendar/outer.php');
			return false;
		});
		$( "#demoadd1" ).click(function()
		{
			loadContent("#content", 'demo/calendar/addItem.php');
			return false;
		});
		$( "#demoevent1" ).click(function()
		{
			loadContent("#content", 'demo/calendar/outer.php');
			return false;
		});
		$( "#home" ).click(function()
		{
			loadContent("#content", 'intro.html');
			return false;
		});
		$( "#demohome" ).click(function()
		{
			loadContent("#content", 'intro.html');
			return false;
		});
		$( "#register" ).dialog(
		{
			autoOpen: false,
			height: 440,
			width: 380,
			modal: true,
			buttons:
			{
				"Create an account": function()
				{
					$('#submit').removeClass ('ui-state-focus');
					var bValid = true;
					regFields.removeClass( "ui-state-error" );
					tips.removeClass( "ui-state-error" );
					document.getElementById('regtip').innerHTML="";
					$("#loginid").focus();
					bValid = bValid && checkLength( loginid, "Login ID", 6, 12 );
					bValid = bValid && checkRegexp( "loginid", loginid, /^([0-9a-zA-Z_])+$/i, "Login ID may consist of a-z, A-Z, 0-9, underscores, and begin with a letter." );
					if (!bValid)
					{
						$("#loginid").focus();
						return false;
					}
					//bValid = bValid && checkLength( email, "Email", 6, 80 );
					// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
					bValid = bValid && checkRegexp( "Email", email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "Your Email Address must be a valid format, e.g. yourname@somedomain.com" );
					if (!bValid)
					{
						$("#email12").focus();
						return false;
					}

					bValid = bValid && checkLength( password1, "Password", 8, 12 );
					bValid = bValid && checkRegexp( "Password", password1, /^([0-9a-zA-Z])+$/, "Password may consist of a-z, A-Z, 0-9" );
					if (!bValid)
					{
						$("#password1").focus();
						return false;
					}

//					bValid = bValid && checkLength( password2, "Password", 8, 12 );
//					bValid = bValid && checkRegexp( "Password", password2, /^([0-9a-zA-Z])+$/, "Password may consist of a-z, A-Z, 0-9" );
					bValid = bValid && areEqual( password1, password2 );
					if (!bValid)
					{
						$("#password2").focus();
						return false;
					}
					if ( bValid ) //put function here to complete registration
					{
						// perform other work here ...
						$.ajax(
						{
							type : 'POST',
							cache: false,
							url : '/ajax/register.php',
							dataType : 'json',
							data:
							{
								action : 'register',
								token : $('#token').val(),
								optin : $('#optin').val(),
								loginid : $('#loginid').val(),
								email : $('#email12').val(),
								password1 : $('#password1').val()
							},
							success : function(data)
							{
								regFields.removeClass( "ui-state-error" );
								if (data.success == true)
								{
//alert ("line 323 data: "+data.success+" "+data.error+", "+data.msg+", "+data.id+"");
									$('#register').dialog("close")
									document.getElementById('sitenotice').style.border ='1px solid #0000ff';
									document.getElementById('sitenotice').class +="ui-corner-all";
									document.getElementById('sitenotice').innerHTML=data.msg;
									document.getElementById('sitenotice').style.display="block";
									$('#content').fadeOut(3000);
									document.getElementById('content').style.display="none";
								}
								if (data.error == true)
								{
//alert ("line 331 data: "+data.success+", "+data.error+", "+data.msg+", "+data.id+"");
									if (data.id == 'loginid')
									{
//alert ("line 334 data: "+data.success+", "+data.error+", "+data.msg+", "+data.id+"");
										updateTips (data.msg);
//										document.getElementById("regtip").innerHTML=data.msg;
//										document.getElementById('regtip').style.display="block";
										document.getElementById('regtip').class +="ui-corner-all";
										document.getElementById('loginid').class +="ui-state-error ";
//										$(tips).removeClass().addClass('ui-state-error').text(data.msg);
                        		$('#loginid').addClass('ui-state-error').focus();
										$('#submit').show(500);
									}
									if (data.id == 'email')
									{
//alert ("line 341 data: "+data.success+", "+data.error+", "+data.msg+", "+data.id+"");
										updateTips (data.msg);
//										document.getElementById("regtip").innerHTML=data.msg;
//										document.getElementById("regtip").style.display="block";
										document.getElementById('regtip').class +="ui-corner-all";
										document.getElementById('email12').class +="ui-state-error";
//										$(tips).removeClass().addClass('ui-state-error').text(data.msg);
               	         	$('#email12').addClass('ui-state-error').focus();
										$('#submit').show(500);
									}
								}
//alert ("line 337 data: "+data.success+" "+data.error+", "+data.msg+", "+data.id+"");
							},
							error : function(data)
							{
//alert ("line 341 data: "+data.success+" "+data.error+", "+data.msg+", "+data.id+"");
								if (data.error == true)
								{
								$('tips').removeClass().addClass('ui-state-error').text(data.msg);
								$(data.id).addClass( "ui-state-error" ).focus();
								$('#submit').show(500);
								}
							}
				      });
						// unblock when remote call returns
//						return false;
						}
					},
					Cancel: function()
					{
						$('#token').remove();
						$( this ).dialog( "close" );
						$("#create-user").removeClass ('ui-state-focus');
					}
				},
				close: function()
				{
					$('#token').remove();
				}
			});
			$( "#login" ).dialog(
			{
				autoOpen: false,
				height: 300,
				width: 400,
				modal: true,
				buttons:
				{
					"Login": function()
					{
						$("#submit").removeClass ('ui-state-focus');
						var bValid = true;
						loginfields.removeClass( "ui-state-error" );
						bValid = bValid && isblank( loginid1, "Login ID", 6, 12 );
						if (!bValid)
						{
							$("#loginid1").focus();
							return false;
						}
						bValid = bValid && isblank( password, "Password", 8, 12 );
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
								url : '/ajax/login.php',
								dataType : 'json',
								data:
								{
									loginid : $('#loginid1').val(),
									password : $('#password').val(),
									action : 'login'
								},
								success : function(data)
								{
									$('#regtip').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
									$('#submit').show(500);
									if (data.error == false)
									{
										document.location.href='/index.php';
			//							document.cookie = 'loggedin=true';
										$('#logtip').removeClass().addClass((data.error === true) ? 'error' : 'success').text(data.msg).show(500);
										$('#login').dialog( "close" );
			//							$('#demos').hide();
			//							$('#accordion').accordion().show();
			//							$('#loggedin').show();
			//							$('#visitor').hide();
			//							loadContent ('#content', '/outer.php');
									}
									if (data.error == true)
									{
//alert ("line 331 data: "+data.success+", "+data.error+", "+data.msg+", "+data.id+"");
										if (data.id == 'loginid')
										{
//alert ("line 334 data: "+data.success+", "+data.error+", "+data.msg+", "+data.id+"");
											updateTips (data.msg);
//										document.getElementById("logtip").innerHTML=data.msg;
//										document.getElementById('logtip').style.display="block";
											document.getElementById('logtip').class +="ui-corner-all";
											document.getElementById('loginid').class +="ui-state-error ";
//										$(tips).removeClass().addClass('ui-state-error').text(data.msg);
                     	   		$('#loginid').addClass('ui-state-error').focus();
											$('#submit').show(500);
										}
										if (data.id == 'password')
										{
//alert ("line 341 data: "+data.success+", "+data.error+", "+data.msg+", "+data.id+"");
											updateTips (data.msg);
//										document.getElementById("logtip").innerHTML=data.msg;
//										document.getElementById("logtip").style.display="block";
											document.getElementById('logtip').class +="ui-corner-all";
											document.getElementById('password').class +="ui-state-error";
//										$(tips).removeClass().addClass('ui-state-error').text(data.msg);
         	      	         	$('#email12').addClass('ui-state-error').focus();
											$('#submit').show(500);
										}
									}
									},
									error : function(data)
								{
									$('#logtip').removeClass().addClass('error')
									.text(data.msg).show(500);
									$('#submit').show(500);
									return false;
								}
      					});
					// unblock when remote call returns
//						return false;
						}
					},
					Cancel: function()
					{
						$('#token').remove();
						$( this ).dialog( "close" );
						$("#create-user").removeClass ('ui-state-focus');
					}
				},
				close: function()
				{
						$( this ).dialog( "close" );
				}
			});

			$( "#tellafriend" ).dialog(
			{
				autoOpen: false,
				height: 520,
				width: 700,
				modal: true,
				buttons:
				{
					"Send My Message": function()
					{
						$("#submit").removeClass ('ui-state-focus');
						var bValid = true;
						tellfields.removeClass( "ui-state-error" );
						tips.removeClass( "ui-state-error" );
						document.getElementById('telltip').innerHTML="";
						bValid = bValid && isrequired( toemail, "Friend's Email");
					// bValid = bValid && checkLength( email, "Email", 6, 80 );
					// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
					bValid = bValid && checkRegexp( "Friend's Email", toemail, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "Your Email Address must be a valid format, e.g. yourname@somedomain.com" );
						if (!bValid)
						{
							$("#toemail").focus();

							return false;
						}
						bValid = bValid && isrequired( fromemail, "My Email");
					//	bValid = bValid && checkLength( email, "My Email", 6, 80 );
					// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
					bValid = bValid && checkRegexp( "My Email", fromemail, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "Your Email Address must be a valid format, e.g. yourname@somedomain.com" );
						if (bValid && (toemail.val()==fromemail.val()))
						{
							toemail.addClass ("ui-state-error");
							fromemail.addClass ("ui-state-error");
							updateTips("The email addresses cannot be the same.");
							return false;
						}
						bValid = bValid && isrequired( tellmessage, "Message to My Friend", 8, 12 );
						if (!bValid)
						{
							$("#tellmessage").focus();
							return false;
						}
						if ( bValid )
						{
							var vars = $("form").serialize();
//		tellfields=$( [] ).add( toemail ).add( fromemail ).add( tellmessage ),
//		contactfields=$( [] ).add( myemail ).add( subject ).add( contactmessage ),

						 // perform other work here ...
							$.ajax(
							{
								type : 'POST',
								cache: false,
								url : '/ajax/tellafriend.php',
								dataType : 'json',
								data:
								{
									to : $('#toemail').val(),
									from : $('#fromemail').val(),
									message : $('#tellmessage').val(),
									action : 'send'
								},
								success : function(data)
								{
									if (data.error == false)
									{
			//							document.location.href='/index.php';
			//							document.cookie = 'loggedin=true';
										$('#telltip').addClass("ui-state-error").text(data.msg).show(500);
										$(data.id).hide();
			//							$('#demos').hide();
			//							$('#accordion').accordion().show();
			//							$('#loggedin').show();
			//							$('#visitor').hide();
			//							loadContent ('#content', '/outer.php');
										return;
							}
								},
								error : function(data)
								{
									$('#telltip').removeClass().addClass('error')
									.text(data.msg).show(500);
									$('#submit').show(500);
									return false;
								}
      					});
					// unblock when remote call returns
//						return false;
						}
					},
					Cancel: function()
					{
						$( this ).dialog( "close" );
						$("#create-user").removeClass ('ui-state-focus');
					}
				},
				close: function()
				{
						$( this ).dialog( "close" );
				}
			});

			$( "#contactus" ).dialog(
			{
				autoOpen: false,
				height: 520,
				width: 700,
				modal: true,
				buttons:
				{
					"Send My Message": function()
					{
						$("#submit").removeClass ('ui-state-focus');
						var bValid = true;
						contactfields.removeClass( "ui-state-error" );
						tips.removeClass( "ui-state-error" );
						document.getElementById('contacttip').innerHTML="";
						bValid = bValid && isrequired( myemail, "My Email Address");
					// bValid = bValid && checkLength( email, "Email", 6, 80 );
					// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
						bValid = bValid && checkRegexp( "My Email Address", myemail, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "Your Email Address must be a valid format, e.g. yourname@somedomain.com" );
						if (!bValid)
						{
							$("#myemail").focus();

							return false;
						}
						bValid = bValid && isrequired( contacttypeid, "Subject");
						if (!bValid)
						{
							$("#contacttypeid").focus();
							return false;
						}
					// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
						bValid = bValid && isrequired( contactmessage, "Message");
						if (!bValid)
						{
							$("#contactmessage").focus();
							return false;
						}
						if ( bValid )
						{
							var vars = $("form").serialize();
//		tellfields=$( [] ).add( toemail ).add( fromemail ).add( tellmessage ),
//		contactfields=$( [] ).add( myemail ).add( subject ).add( contactmessage ),

						 // perform other work here ...
							$.ajax(
							{
								type : 'POST',
								cache: false,
								url : '/ajax/contactus.php',
								dataType : 'json',
								data:
								{
									from : $('#myemail').val(),
									subject : $('#contacttypeid').val(),
									message : $('#contactmessage').val(),
									action : 'send'
								},
								success : function(data)
								{
									if (data.error == false)
									{
			//							document.location.href='/index.php';
			//							document.cookie = 'loggedin=true';
										$('#contacttip').addClass("ui-state-error ui-corner-all").text(data.msg).show(500);
										$(data.id).hide();
			//							$('#demos').hide();
			//							$('#accordion').accordion().show();
			//							$('#loggedin').show();
			//							$('#visitor').hide();
			//							loadContent ('#content', '/outer.php');
										return;
							}
								},
								error : function(data)
								{
									$('#contacttip').removeClass().addClass('error')
									.text(data.msg).show(500);
									$('#submit').show(500);
									return false;
								}
      					});
					// unblock when remote call returns
//						return false;
						}
					},
					Cancel: function()
					{
						$( this ).dialog( "close" );
						$("#create-user").removeClass ('ui-state-focus');
					}
				},
				close: function()
				{
						$( this ).dialog( "close" );
				}
			});
		$( "#create-user" )
			.button()
			.click(function()
			{
				$(this).removeClass ('ui-state-focus');
				$( "#register" ).dialog( "open" );
				$('.warning').remove();
				$('#token').remove();
				$.get("/includes/token.php",function(txt)
				{
  					$(".secure").append('<input type="hidden" id="token" name="token" value="'+txt+'" />');
				});
			});

		$( "#get-contact" )
			.button()
			.click(function()
			{
				$(this).removeClass ('ui-state-focus');
				$( "#contactus" ).dialog( "open" );
			});
		$( "#get-tellafriend" )
			.button()
			.click(function()
			{
				$(this).removeClass ('ui-state-focus');
				$( "#tellafriend" ).dialog( "open" );
			});
		$( "#get-login" )
			.button()
			.click(function()
			{
				$(this).removeClass ('ui-state-focus');
				$( "#login" ).dialog( "open" );
			});
		$( "#my-profile" )
		.button()
		.click(function()
		{
			$(this).removeClass ('ui-state-focus');
			loadContent('#content', '/profile/create-account.php');
		});
		$( "#rightad" )
		.button()
		.click(function()
		{
			$(this).removeClass ('ui-state-focus');
			loadContent('#content', '/profile/create-account.php');
		});
		$( "#topad" )
		.button()
		.click(function()
		{
			$(this).removeClass ('ui-state-focus');
			loadContent('#content', '/profile/create-account.php');
		});
		$( "#newevent" ).click(function()
		{
			loadContent("#content", 'calendar/addItem.php');
			return false;
		});
		$( "#all" ).click(function()
		{
			loadContent("#content", 'calendar/outer.php');
			return false;
		});
		$( "#get-logout" )
			.button()
			.click(function()
			{
				$("#logout").removeClass ('ui-state-focus');
				logoutindex();
			});

		$(function()
		{
			$("#icons li")
			.mouseenter(function()
			{
				$(this).addClass('ui-state-hover');
			})
			.mouseleave(function()
			{
				$(this).removeClass("ui-state-hover");
			});
		});
<!--
$(function() {
	$( "#logreg" ).dialog({
	height: 100,
	width: 300,
	modal: true
	});
});
-->
}); // end document ready
</script>
<?php
//include ($_SERVER["DOCUMENT_ROOT"]."/includes/tracking.php");
?>
</head>
<body>
<container>
<header>
<dashboard>
	<div id="visitor">
		<a href="#" id="get-login">Log In</a> or  <a href="#" id="create-user">Register</a>
	</div>
<div id="loggedin">
<span id="hello" class="mainbold">
<?php echo $greeting;
if ($registered!="")
{
?>
<div id="success" name="success"><?php echo $registered ?><br /></div>
<?php
}
?>
</span>
<a href="#" id="get-logout">Log Out</a>
<a href="#" id="my-profile">My Profile</a>
</div>
</dashboard>
<push id="push"></push>

<logo> <a href="/"><img title="My Staging Box - The most technologically advanced schedule on the Web." alt="MyStagingBox.com" src="images/msb-logo7.gif" border="0"></a></logo>
<!--
<topbanner>
<div id="headad">
<?php // require_once($_SERVER["DOCUMENT_ROOT"]."/sponsor/index.php"); ?>
<a href="#" id="topad">Advertise Here</a><br />Advertise your business or service here.  You may include a banner ad and text, or one or the other.  There is no cost to place this ad.
</div>
</topbanner>
<sitesearch>
	<form method="post" id="gsearch" action="googlesearch-results.html">
		<input name="q" type="text">
		<button type="submit">Search</button>
	</form>
</sitesearch>
-->
<donate>
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="TRBM3NZYV383C">
<table>
<tr><td align="center"><input type="hidden" name="on0" value="Donation"></td></tr>
<tr><td><select name="os0">
	<option value="Multi-Platinum">Multi-Platinum $199.95</option>
	<option value="Platinum">Platinum $99.95</option>
	<option value="Gold">Gold $49.95</option>
	<option value="Silver">Silver $24.95</option>
	<option value="Bronze">Bronze $9.95</option>
	<option value="Pewter">Pewter $4.95</option>
</select> </td></tr>
</table>
<input type="hidden" name="business" value="paypaltest@mystagingbox.com">
<input type="hidden" name="currency_code" value="USD">
<input type="image" src="/images/paypal_donate_small.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
</form>
</donate>
<likeshare>
<!-- likeshare -->
</likeshare>
</header>
<content>

<leftcolumn>
<div id="demos">
  <h3>
    <span/>
    <a href="#">Demos</a>
  </h3>
  <div>
		<a href="#" id="demohome">Home</a><br>
		<a href="#" id="demoadd">Add Event</a><br>
		<a href="#" id="demoevent">Show Events</a>
  </div>
</div>
<div id="accordion">
  <h3>
    <span/>
    <a href="#">Schedule</a>
  </h3>
  <div>
		<a href="#" id="home">Home</a><br>
		<a href="#" id="newevent">Add My Event</a><br>
		<a href="#" id="all">Show Events</a><br>
<!--		<a href="#" id="auction">Auction/Sale</a><br>
		<a href="#" id="show">Car Show</a><br>
		<a href="#" id="charity">Charity Event</a><br>
		<a href="#" id="meeting">Club Meeting</a><br>
		<a href="#" id="cruise">Cruise Night</a><br>
		<a href="#" id="indoor">Indoor Show</a><br>
		<a href="#" id="multi">Multi-day Event</a><br>
		<a href="#" id="race">Race</a><br>
		<a href="#" id="swap">Swap Meet</a>
-->
  </div>
  <h3>
    <span/>
    <a href="#">Demos</a>
  </h3>
  <div>
		<a href="#" id="demoadd1">Add Event</a><br>
		<a href="#" id="demoevent1">Show Events</a>
  </div>
<!--
  <h3>
    <span/>
    <a href="#">Sponsors</a>
  </h3>
  <div>
		<a href="#" id="">LongLink 4</a>
		<a href="#" id="">LongLink 5</a>
		<a href="#" id="">LongLink 6</a>
  </div>
-->
</div>

  <googleleft id="towerleft">
<?php
// include ($_SERVER['DOCUMENT_ROOT']."/includes/googleleft.php");
?>
</googleleft>
</leftcolumn>

<centercolumn>
<div id="sitenotice" style="display:none;" class="notice ui-state-error ui-corner-top"></div>
<googletop id="top">
<?php
// include ($_SERVER['DOCUMENT_ROOT']."/includes/googletop.php");
?>
</googletop>
<div id="content" class="ui-widget"></div>
<googlebottom id="bottom">
<?php
// include ($_SERVER['DOCUMENT_ROOT']."/includes/googlebottom.php");
?>
</googlebottom>
</centercolumn>

<rightcolumn>
<contacttell>
<tellafriend id="get-tellafriend">Tell A Friend</tellafriend>
<contact id="get-contact">Contact Us</contact>
</contacttell>
<!--
  <sponsorad><a href="#" id="rightad">Advertise Here</a><br />Advertise your business or service here.  You may include a small graphic and text, or one or the other.  There is no cost to place this ad.</sponsorad>
  <googleright id="towerright">
  <?php
 // include ($_SERVER['DOCUMENT_ROOT']."/includes/googleright.php");
  ?>
</googleright>
-->
</rightcolumn>
</content>
<footer>
<corpnav>
<!--
<a href="#" id="about">About MyStagingBox.com</a>
<a href="#" id="tos">TOS</a>
<a href="#" id="faq">FAQ</a>
<a href="#" id="contact">Contact Us</a>
-->
</corpnav>
<copyright>
  &copy; 2012 - <?php echo date('Y'); ?> MyStagingBox.com - All Rights Reserved
</copyright>
</footer>
<div id="actacct" title="Activate my Account" style="display:none;">
<span class="validateTips" id="acttip">You are now registered.  Please check your email inbox for the activation code.<br /><br />Copy it from your email, paste it into the box below, then click "Activate My Account" to complete the registration process.</span>
	<p class="warning">You must have javascript enabled to register.</p>
	<form class="secure">
	<fieldset>
		<label for="token">Activation Code</label>  <a href="tips/activate.html?width=375" class="jTip" id="activatetip" name="Activation Code"></a>
		<input type="text" name="token" id="token" value="" title="Activation Code" class="text ui-widget-content ui-corner-all" />
		<input id="activate" type="submit" value="Activate My Account" class="ui-button ui-widget ui-state-default ui-corner-all">
	</fieldset>
	</form>
</div>
<div id="register" title="Register" style="display:none;">
	<div class="validateTips ui-corner-all" id="regtip">All form fields are required.</div>
	<p class="warning">You must have javascript enabled to register.</p>
<!--	<a href="../tips/tooltip.html?width=375" class="jTip" id="tooltip" name="Tooltip"><span class="icons"></span></a>  -->
	<form class="secure">
	<fieldset>
		<label for="loginid">Login ID</label>  <a href="tips/login.html?width=375" class="jTip" id="loginidtip" name="Login ID"></a>
		<input type="text" name="loginid" id="loginid" value="" title="Login ID" class="text ui-widget-content ui-corner-all" />

		<label for="email">Email</label>  <a href="tips/email.html?width=375" class="jTip" id="emailtip" name="Email Address"></a>
		<input type="text" name="email12" id="email12" value="" title="Email Address" class="text ui-widget-content ui-corner-all" />

		<label for="password1">Password</label>  <a href="tips/password.html?width=375" class="jTip" id="passwordtip" name="Password"></a>
		<input type="password" name="password1" id="password1" value="" title="Password" class="text ui-widget-content ui-corner-all" />

		<label for="password2">Re-Enter Password</label>
		<input type="password" name="password2" id="password2" value="" title="Password" class="text ui-widget-content ui-corner-all" />

      <label for="optin">Newsletter</label>
      <input type="checkbox" name="optin" id="optin" value="1" checked="checked" class="ui-widget-content ui-corner-all">
      <a href="tips/newsletter.html?width=375" class="jTip" id="news" name="Newsletter"></a>
	</fieldset>
	</form>
</div>
<div id="login" title="Log In" style="display:none;">
	<span class="validateTips" id="logtip"></span>
	<form>
	<fieldset>
		<label for="loginid1">Login ID</label>
		<input type="text" name="loginid1" id="loginid1" value="" title="Login ID" class="text ui-widget-content ui-corner-all" />
		<label for="password">Password</label>
		<input type="password" name="password" id="password" value="" title="Password" class="text ui-widget-content ui-corner-all" />
	</fieldset>
	</form>
</div>
<div id="tellafriend" title="Tell A Friend" style="display:none;">
	<div class="validateTips" id="telltip">All form fields are required.</div>
	<form id="thisform">
	<fieldset>
		<label for="toemail">Friend's Email Address</label>
		<input type="text" name="toemail" id="toemail" value="" title="Friend\'s Email Address" class="text ui-widget-content ui-corner-all" />
		<label for="fromemail">My Email Address</label>
<?php
	if ($_COOKIE[loggedin]=='true')
	{
		$email= explode(":", $_COOKIE['_hrsb_msb']);
		$query="select email from subscriber where subscriberid = $email[0]";
		//echo $query;
		$row=f(q($query));
		$from=$row[email];
	}
?>
		<input type="text" name="fromemail" id="fromemail" value="<?php echo $from;?>" title="My Email Address" class="text ui-widget-content ui-corner-all" />
		<label for="tellmessage">Message to Friend (<span id="remaining1">512</span> remaining.)</label>
		<textarea class="text ui-widget-content ui-corner-all" id="tellmessage" name="tellmessage" rows="12" cols="80" wrap onkeyup="CheckFieldLength(tellmessage, 'charcount', 'remaining1', 512);" onkeydown="CheckFieldLength(tellmessage, 'charcount', 'remaining1', 512);" onmouseout="CheckFieldLength(tellmessage, 'charcount', 'remaining1', 512);"><?php  echo $tellmessage; ?></textarea>
	</fieldset>
	</form>
</div>
<div id="contactus" title="Contact Us" style="display:none;">
	<div class="validateTips" id="contacttip">All form fields are required.</div>
	<form>
	<fieldset>
		<label for="myemail">My Email Address</label>
		<input type="text" name="myemail" id="myemail" value="" title="My Email Address" class="text ui-widget-content ui-corner-all" />
		<label for="subject">Subject</label>
<br />
<?php
//sysGetSelect($val_name, $table_name, $empty_item = 1, $select = -1, $display_field = "name", $val_field = "id");
sysGetSelect("contacttypeid", "contacttype", 1, -1, "contacttype", "contacttypeid");
?>
<br />
<br />
		<label for="contactmessage">Message (<span id="remaining2">2000</span> remaining.)</label>
		<textarea class="text ui-widget-content ui-corner-all" id="contactmessage" name="contactmessage" rows="12" cols="88" wrap onkeyup="CheckFieldLength(contactmessage, 'charcount', 'remaining2', 2000);" onkeydown="CheckFieldLength(contactmessage, 'charcount', 'remaining2', 2000);" onmouseout="CheckFieldLength(contactmessage, 'charcount', 'remaining2', 2000);"><?php  echo $contactmessage; ?></textarea>
	</fieldset>
	</form>
</div>
<div id="addeventdemo" title="Add New Event Demo" style="display:none;">
<?php include ($_SERVER['DOCUMENT_ROOT']."/demo/calendar/addItem.php");	?>
</div>
<div id="addevent" title="Add New Event" style="display:none;">
<?php include ($_SERVER['DOCUMENT_ROOT']."/calendar/addItem.php"); ?>
</div>
</container>
</body>
</html>
