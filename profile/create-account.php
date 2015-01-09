<?php
//allow sessions to be passed so we can see if the user is logged in
//session_start();
//print_r($_COOKIE['_hrsb_msb']);
	$cookie=explode('_',$_COOKIE[_hrsb_msb]);
	//print_r($cookie);
	$cookie1=explode(':',$_COOKIE[_hrsb_msb]);
	if ($_COOKIE[loggedin]=='true')
	{
		if ($cookie[1] < date ('U'))
		{
			$expires = date('U') + (3600*24*7);
			$newcookie=$cookie[0]."_".$expires."_1";
			setcookie('_hrsb_msb',$newcookie, $expires, '/');
		}
	}

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

<script type="text/javascript" src="../js/jquery-ui-1.8.14.dark-hive.min.js"></script>
<!-- <script type="text/javascript" src="../js/profile.js"></script> -->
<script type="text/javascript" src="../js/hrsb.js"></script>
<script type="text/javascript" src="/js/jTip.js"></script>
<script type='text/javascript' src='../js/dFilter.js'></script>
<script type="text/javascript">

$(document).ready(function()
{
	$( "#newpassword" )
		.button()
		.click(function()
		{
			loadContent('#content', '/profile/newpassword.php');
		});

 	$('#myprofile').submit(function(event)
 	{ //Trigger on form submit
// 		$('#eventerror').empty(); //Clear the messages first
// 		$('#timeerror').empty(); //Clear the messages first
 		$('#success').empty();
 		var myprofile =
 		{ //Fetch form data
			'post' : $('#myprofile').serialize()
 		};
 		$.ajax({ //Process the form using $.ajax()
 			type 		: 'POST', //Method type
 			url 		: '../ajax/myprofile.php', //Your form processing file url
 			data 		: myprofile,
 			dataType 	: 'json',
 			success 	: function(data)
 			{
//				document.getElementById('eventerror').innerHTML="";
				document.getElementById('dataerror').innerHTML="";
//				document.getElementById('timeerror').innerHTML="";
//				document.getElementById('timeerror').style.display="none";
 				var fields =["optin","firstname","lastname","gender","dob","street_address","city","state","zip","url","phone","cphone","company"];
 				var required =["firstname","lastname","gender","dob","street_address","city","state","zip"];
//				alert (data.errors.length);
				for (var j = 0; j < required.length; j++)
				{
//					alert (required.length);
	    			var name = required[j];
					document.getElementById(name).style.border ='1px solid #cccccc';
//					alert ('1name = '+name);
 				}
//				check_form(myprofile);

 				if (data.success=="false")
 				{ //If fails
					 if (data.errors)
					 {
//						alert('data errors '+data.errors.length);
						for (var i = 0; i < data.errors.length; i++)
						{
    						var name = data.errors[i];
							document.getElementById(name).style.border ='1px solid #ff3333';
//							alert ('2name = '+name);
 						}
					document.getElementById('dataerror').innerHTML="Please check the hightlighted fields below.  Those fields require a value to be entered.";
					document.getElementById('dataerror').style.display="inline";
					}
				}
				else
				{

 					document.getElementById('dataerror').innerHTML=data.posted; //If successful, than throw a success message
 				}
 			}
 		});
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
	$( ".dobicon").button(
	{
		icons:
		{
			primary: "ui-icon-calendar"
		},
		text: false
	})
	$(".dobicon").hover(function()
	{
   	$(this).css('cursor', 'pointer');
	});
	$("#dob").datepicker
	({ showOn: 'button',
		buttonImage: "/css/images/calendar.gif",
		buttonText: "Click here to select the date.",
		buttonImageOnly: true,
		yearRange: "-80:-18",
		changeMonth: true,
		changeYear: true,
      showAnim: '',
		minDate: "-80Y",
		maxDate: "-18Y",
	});

	var ac_config =
	{
		source: "../csz.php",
		select: function(event, ui)
		{
			$("#city").val(ui.item.city);
			$("#state").val(ui.item.state);
			$("#zip").val(ui.item.zip);
			$("#zipid").val(ui.item.zipid);
		},
		minLength:3
	};
	$("#zip").autocomplete(ac_config);
});
<!-- traffic (); -->
</script>
<!--
 <form name="new_account" id="myprofile" method="post" onsubmit="return check_form(new_account);">
-->
 <form name="new_account" id="myprofile" method="post">
 <table border="0" bordercolor="#0000ff" cellpadding="2" cellspacing="0" width="100%">
      <tbody>
      <tr width="100%">
         <td class="ui-widget ui-widget-header ui-corner-right ui-corner-left" colspan="2"><h1> My Profile</h1></td>
      </tr>
 <tr class="ui-widget">
	<td valign="top" width="640">
<div class="text ui-widget ui-widget-content ui-corner-all">
<div id="dataerror" class="ui-state-error ui-corner-all" style="display:none"></div>
<table width="100%" border="0">
     <tr class="ui-widget">
        <td colspan="2"><b>Login Details</b></td>
      </tr>
OUTPUT;
require_once ("../lib/system.php");
//exit();
//	$cookie=explode('_',$_COOKIE[_hrsb_msb]);
	$cookie=explode(':',$_COOKIE[_hrsb_msb]);

	$query = "SELECT * FROM `subscriber` WHERE `subscriberid` = '$cookie[0]'";
	$row=f(q($query));
//print_r($row);
	if ($row[dob]=="0000-00-00")
	{
		$birthdate="";
//		echo "Line 196 birthdate ".$birthdate."/n";
	}
	else
	{
		$dob=explode("-",$row[dob]);
//print_r($dob);
		$birthdate=$dob[1]."/".$dob[2]."/".$dob[0];
//print_r($birthdate);
//		echo "Line 202 birthdate ".$birthdate."/n";
	}
echo <<<OUTPUT
              <tr class="ui-widget-content">
                <td width="160">Login ID:</td>
                <td width="520">$row[loginid]</td>
              </tr>
              <tr>
                <td>Email Address:</td>
                <td>$row[email]</td>
              </tr>
               <tr>
                <td>Newsletter:&nbsp;
OUTPUT;
$row[optin]==1?$checked="checked":$checked="";
echo <<<OUTPUT
                <input name="optin" value="$row[optin]" checked="$checked" type="checkbox"  class="text ui-widget-content ui-corner-all"><a href="/tips/newsletter.html?width=375" class="jTip" id="news" name="Newsletter"><span class="icons"></span></a></td>
                <td>
				       <a href="#" id="newpassword">Change Password</a>
                </td>
              </tr>
</table>
</div>
						</td>
					</tr>
<tr class="ui-widget">
	<td valign="top" width="640">
<div class="ui-widget ui-widget-content ui-corner-all">
<table width="100%" border="0">
      <tr>
            <td colspan="2"><b>Personal Details</b></td>
      </tr>
      <tr>
           <td class="inputRequirement" colspan="2">* Required</td>
          </tr>
              <tr>
                <td width="30%">First Name:<br><input name="firstname" type="text" value="$row[firstname]" id="firstname" class="text ui-widget-content ui-corner-all">&nbsp;<span class="inputRequirement">*</span></td>
<td>Last Name:<br>
   <input name="lastname" type="text" value="$row[lastname]" id="lastname" class="text ui-widget-content ui-corner-all">
   &nbsp;<span class="inputRequirement">*</span>
</td>
</tr>
<tr>
<td width="170">Gender:<a href="/tips/gender.html?width=375" class="jTip" id="sex" name="Gender"><span class="icons"></span></a><br>
<select id="gender" name="gender" class="text ui-widget-content ui-corner-all">
	$gender == "m"?$mselected="selected":$fselected="selected";
	echo "<option value=""> Select One </option>\n";
	echo "<option value="m" $mselected> Male </option>\n";
	echo "<option value="f" $fselected> Female </option>\n";
</select>
	&nbsp;<span class="inputRequirement">*</span>
</td>
<td>Date of Birth:<a href="/tips/dob.html?width=375" class="jTip" id="birthdate" name="Birthdate"></a><br>
	<!-- <input name="dob" type="text" id="dob" /> -->
<input type="text" id="dob" name="dob" size="10" value="$birthdate" class="text ui-widget-content ui-corner-all"/>&nbsp;
	&nbsp;<span class="inputRequirement">*</span>
</td>
</tr>
<tr>
<td colspan="2">Street Address:<br>
   <input name="street_address" type="text" value="$row[address]" size="50" id="street_address" class="text ui-widget-content ui-corner-all">&nbsp;<span class="inputRequirement">*</span></td>
</tr>
<tr>
<td>
<label for="city">City</label><br>
<input name="city" type="text" value="$row[city]" size="20" maxlength="32" id="city" class="autocomplete text ui-widget-content ui-corner-all" readonly />
&nbsp;
</td>
<td width="162">
<label for="state">State &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Zip Code&nbsp;</label><a href="/tips/zipcode.html?width=375" class="jTip" id="zipcode" name="City, State, Zip Code"><span class="icons"></span></a><br>
<input name="state" type="text" value="$row[state]" size="6" maxlength="2" id="state" class="autocomplete text ui-widget-content ui-corner-all" readonly />
&nbsp;&nbsp;&nbsp;
<input name="zip" type="text" value="$row[zip]" size="8" maxlength="5" id="zip" class="autocomplete text ui-widget-content ui-corner-all" />
&nbsp;<span class="inputRequirement">*</span></td>
</tr>
<tr>
  <td colspan="2">Country: United States</td>
</tr>
<tr>
  <td>Phone:<a href="/tips/telephone.html?width=375" class="jTip" id="phone" name="Phone"><span class="icons"></span></a><br>
   <input type="text" value="$row[phone]" size="20" name="phone" onKeyDown="javascript:return dFilter (event.keyCode, this, '###-###-####');" value="$phone" class="text ui-widget-content ui-corner-all" />
   </td>
  <td>Cell:<a href="/tips/cell.html?width=375" class="jTip" id="cphone" name="Cell"><span class="icons"></span></a><br>
  <input type="text" value="$row[cphone]" size="20" name="cphone" onKeyDown="javascript:return dFilter (event.keyCode, this, '###-###-####');" value="$cphone" class="text ui-widget-content ui-corner-all" />
  </td>
</tr>
<tr>
  <td colspan="2"><b>Company Name:</b><a href="/tips/company.html?width=375" class="jTip" id="company" name="Company Name"><span class="icons"></span></a><br>
   <input name="company" value="$row[company]" type="text" size="50" id="company" class="text ui-widget-content ui-corner-all"><br><br>
  </td>
</tr>
<tr>
  <td colspan="2"><b>Company Web Address:</b><a href="/tips/website.html?width=375" class="jTip" id="website" name="Company Web Address"><span class="icons"></span></a><br>
   <input name="url" value="$row[url]" type="text" size="50" id="url" class="text ui-widget-content ui-corner-all"><br><br>
  </td>
</tr>
</table>
</div>
						</td>
					</tr>
<tr class="ui-widget">
	<td valign="top" width="640">
<div class="ui-widget ui-widget-content ui-corner-all">
<table width="100%" border="0">
      <tr>
        <td align="right">
        <input id="submit" type="submit" class="ui-button ui-widget ui-state-default ui-corner-all" value="Update My Profile >>"></td>
        <input name="action" value="update" type="hidden">
        <input name="zipid" value="" type="hidden" id="zipid">
        <input name="subscriberid" value="$cookie[0]" type="hidden">

      </tr>
</table>
</div>
						</td>
					</tr>
</tbody></table>
    </form>
<?php
OUTPUT;
?>
