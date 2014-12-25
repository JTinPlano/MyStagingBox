<?php
/////////////////////////////////////////////////////////////////
// This is the configuration file for phpCommunityCalendar.    //
// For installation instructions and more information, consult //
// the README file.					       //
// Full documentation is available in the docs directory and   //
// on the web at http://open.appideas.com/                     //
/////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
// LICENSE AGREEMENT                                                      //
// phpCommunityCalendar is Open Source software and may be distributed	  //
// free of charge. AppIdeas.com also sells commercial installation and	  //
// support of the phpCommunityCalendar application.  If you feel so	  //
// inclined, you may offer portions of your profits from sales of this    //
// application to AppIdeas.com to help us continue development of Open    //
// Source apps.								  //
// All installations of phpCommunityCalendar, including those that have   //
// been heavily customized, must include this notice, in its entirety,	  //
// in a file called "common.php". phpCommunityCalendar carries no	  //
// warranty, either stated or implied, for any use.  Furthermore,	  //
// AppIdeas.com will not be responsible for any damage, real or imagined, //
// that occurs as a result of the use of phpCommunityCalendar.  Even	  //
// though this is free software, the images, coding and other material	  //
// herein is copyrighted material. Copyrights are held and maintained by  //
// Christopher Ostmo and/or AppIdeas.com. The right to distribute this	  //
// software may be revoked by the author at any time.  Certain features   //
// may require registration for services from third party vendors or	  //
// companies.  By using this software and these  scripts, you are	  //
// agreeing to these terms.  Please note: AppIdeas.com does not offer	  //
// free technical support for phpCommunityCalendar.  AppIdeas.com staff	  //
// will delete any personal requests for free technical support.	  //
// Technical support for this and other Open Source applications is	  //
// available at:							  //
// http://open.appideas.com/support                                       //
// and discussion forums are available at:				  //
// http://open.appideas.com/phorum					  //
// The current home page address for all of AppIdeas.com's Open Source	  //
// applications is:							  //
// http://open.appideas.com/						  //
//                                                                        //
// You may contact AppIdeas.com for commercial installation and/or        //
// support of phpCommunityCalendar or any other PHP/MySQL web project at: //
// AppIdeas.com                                                           //
// 2305-C Ashland St. #271                                                //
// Ashland, OR 97520                                                      //
// Web: http://www.appideas.com/                                          //
// E-mail: sales@appideas.com                                             //
//                                                                        //
// Be sure to check out our complete list of product offerings at:        //
// http://www.appideas.com/products/                                      //
//                                                                        //
// Finally, a CVS-like system is available (or will be soon) at:	  //
// http://open.appideas.com/						  //
// If you have code to contribute, you can do so there. Updates and	  //
// new add-ons for this application will also be made available at this   //
// site. Check in every once in a while to see if there are any new	  //
// features that you need or desire.					  //
//									  //
//                           ENJOY!                                       //
////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////
// If the comment blocks within this file are read, most of the //
// features should be fairly self-explanatory.			//
//////////////////////////////////////////////////////////////////
//ini_alter("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/tmp");
require_once ($_SERVER["DOCUMENT_ROOT"]."/lib/global.php");
require_once ($_SERVER["DOCUMENT_ROOT"]."/lib/mysql.php");

/*
/////////////////////////////////////////////////////////////////////
// Replace these variables with information for connecting to your //
// database server                                                 //
/////////////////////////////////////////////////////////////////////
$DBHost = "DB_HOST";
$DBUser = "DBUSERNAME";
$DBPass = "DBPASSWORD";
$DBName = "DBNAME";
$db_connect = mysql_connect("$DBHost","$DBUser","$DBPass") or die (mysql_error());
// comment above and uncomment below if your hosting provider
// does not allow persistent database connections.
// mysql_connect("$DBHost","$DBUser","$DBPass");
//echo "$DBHost, $DBUser, $DBPass, $DBName<br>";
mysql_select_db($DBName);
*/
/////////////////////////////////////////////////////////////////////////////////
// The $glbl_WebAddress, $glbl_WebRoot, $glbl_AdminRoot and $glbl_WebAdminRoot //
// variables are used to form URLs for inclusion in e-mail notifications to be //
// sent to admins on public event submission. They should not end with a       //
// trailing forward slash. The other variables are reserved for future use.    //
/////////////////////////////////////////////////////////////////////////////////
require_once ($_SERVER["DOCUMENT_ROOT"]."/includes/defines.php");
$server = WS_ROOT;
$glbl_WebAddress = "http://".$server;
$glbl_UnixPath = WS_ROOT."/";
//print "line 94 calendar webaddress ".$glbl_WebAddress."<br />";
//print "line 95 calendar UnixPath ".$glbl_UnixPath."<br />";
$glbl_WebRoot = $glbl_WebAddress."/";
$glbl_AdminRoot = $glbl_WebRoot."/admin";
$glbl_WebAdminRoot = $glbl_WebRoot."/webadmin";
$glbl_ImagePath = $glbl_UnixPath."/images";
$glbl_ImageRoot = $glbl_WebRoot."/images";
$glbl_MailFrom = "admin@mystagingbox.com";
$glbl_EmailSubject = "Trophies and Plaques Event Calendar";
//echo "$glbl_ImagePath $glbl_ImageRoot<br>";

////////////////////////////////////////////////////////////////////
// The code below places the configuration options from the DB in //
// the global scope so that code doesn't have to be dropped into  //
// every script to get the options.				  //
////////////////////////////////////////////////////////////////////
global $glbl_LocationTitle, $glbl_AllowPublicSubmission, $glbl_ApprovePublicSubmission, $glbl_ApprovalBySiteAdmin,
$glbl_ApprovalByLocationAdmin, $glbl_AllowCrossLocationSubmission, $glbl_DefaultView, $glbl_AllowMonth,
$glbl_AllowWeek, $glbl_AllowDay, $glbl_UseEventLocation, $glbl_TruncateLength, $glbl_SiteTitle, $glbl_AllowEventPrint,
$glbl_AdminEmail;
$result = q("SELECT * FROM events_config") or die(mysql_error());
	while ($row = f($result)) {
	$glbl_LocationTitle = $row[0];
	$glbl_AllowPublicSubmission = $row[1];
	$glbl_ApprovePublicSubmission = $row[2];
	$glbl_ApprovalBySiteAdmin = $row[3];
	$glbl_ApprovalByLocationAdmin = $row[4];
	$glbl_AllowCrossLocationSubmission = $row[5];
	$glbl_DefaultView = $row[6];
	$glbl_AllowMonth = $row[7];
	$glbl_AllowWeek = $row[8];
	$glbl_AllowDay = $row[9];
	$glbl_UseEventLocation = $row[10];
	$glbl_TruncateLength = $row[11];
	$glbl_SiteTitle = $row[12];
	$glbl_AllowEventPrint = $row[13];
	$glbl_AdminEmail = $row[14];
	}
	define("TRUNCATE", $glbl_TruncateLength);
/*  if(strpos($_SERVER[PHP_SELF],"events/"))
  {
  	$header = "/auction/header.php";
  	$search = "../auction/includes/search.inc.php";
  	$nav_events = "../auction/includes/nav_events.inc.php";
  }
*/
//////////////////////////////////////////////////////////////////////
// commonHeader() defines the common site layout elements above and //
// to the left of the calendar content.	To change the site layout,  //
// alter the commonHeader() and commonFooter() functions.	    //
//////////////////////////////////////////////////////////////////////
function commonHeader($title)
{
echo "<?php xml version=\"1.0\" encoding=\"iso-8859-1\"?".">";
/**
 * Copyright 2004 Advanced IT All Rights Reserved
 *
 * @version $Id:
 * @author JT Atkinson <jt@advancedit.com>
 *
 */

?>
<!DOCTYPE HTML>
<html dir="LTR" lang="en-us">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Description" content="MyStagingBox.com is the perfect staging area for all things hot rod.  If it's a hot rod happening, you'll find it here.">
<meta name="Keywords" content="hot, rod, muscle, car, classic, show, calendar, schedule, cruise, night, all things, hot rod happening, corvette, mustang, camaro, chevelle, roadrunner, charger, challenger, cuda, hemi, ls6, 454, 396, 427, 428, 429, cobra, super sport, boss, club, meeting">
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="7 days">
</head>
<style type="text/css">
	a.dp-choose-date {
	float: left;
	width: 16px;
	height: 16px;
	padding: 0;
	margin: 5px 3px 0;
	display: block;
	text-indent: -2000px;
	overflow: hidden;
}
	.icons{
		width:1.2em;
		cursor: pointer;
		list-style: none outside none;
		margin: 2px;
		padding: 1px;
	}

#OuterTab, #Level1-1, #Level1-2, #Level1-3, #Level1-4, #Level1-5, #Level1-6
{
	display: inline;
	padding: 0px;
	float: left;
	width: 750px;
/*	border: 1px solid #0000ff; */
}

#date
{
	text-align: center;
	width: 640px;
	display: block;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
}
.btt, #states
{
	float: right;
	display: block;

}
</style>
<script type="text/javascript" src="/js/jTip.js"></script>
<script type='text/javascript' src='/js/dFilter.js'></script>
<script type='text/javascript' src="/js/jquery.cookie.js"></script>
<script type="text/javascript">
function check(x)
{
  document.getElementById(x).checked=true;
}

$(document).ready(function()
{
		$( ".icons").button(
		{
			icons:
			{primary:"ui-icon-info"},
			text: false
		})
	// Tabs
	$("#tabs").tabs({cache : true,cookie:{expires: 1}});
<?php
// start block - this was attempting to set the selected tab on page reload - it didn't work
	if ($tab!=0)
	{
?>
//get selected element
//	document.getElementById('0').setAttribute("class", "ui-state-default ui-corner-top");
//	document.getElementById('onetime').setAttribute("class", "ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide");
//	document.getElementById('<?php echo $tab; ?>').setAttribute("class", "ui-state-default ui-corner-top ui-tabs-selected ui-state-active");
//	document.getElementById('<?php echo $content; ?>').setAttribute("class", "ui-tabs-panel ui-widget-content ui-corner-bottom");
//	check(<?php echo $id; ?>);
// end block
<?php
}
?>
	var ac_config =
	{
		source: "../../csz.php",
	select: function(event, ui)
	{
		$("#city").val(ui.item.city);
		$("#state").val(ui.item.state);
		$("#zip").val(ui.item.zip);
		$("#zipid").val(ui.item.zipid);
	},
	minLength:2
	};
	$("#zip").autocomplete(ac_config);
	$('#startPicker,#endPicker,#datepicker,#datepicker1').datepicker(
	{
		minDate: 0,
		onSelect: customRange,
		showTrigger: '#calImg'
//			changeMonth: true,
//			changeYear: true
	});
function customRange(dates)
{
    if (this.id == 'startPicker')
    {
		$('#endPicker').datepicker('option', 'minDate', dates[0] || null);
	}
	else
	{
		$('#startPicker').datepicker('option', 'maxDate', dates[0] || null);
	}
}

$("#from, #to").hover(function() {
    $(this).css('cursor', 'pointer');
});
	var dates = $( "#from, #to" ).datepicker(
	{
		minDate: 0,
		maxDate: "+4Y",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
      showAnim: 'slide',
		showOn: "button",
		buttonImage: "/css/images/calendar.gif",
		buttonText: "Click here to select the date.",
		buttonImageOnly: true,
		onSelect: function( selectedDate )
		{
			var option = this.id == "from" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
});

</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php

}

//////////////////////////////////////////////////////////////////////
// commonFooter() defines the common site layout elements below and //
// to the right of the calendar content.			    //
//////////////////////////////////////////////////////////////////////
$showDate="";

function commonFooter()
{
?>
</body>
</html>
<?php
}
///////////////////////////////////////////////////////////////////////
// popUp() defines the size of the javascript popups for event data. //
// These values can (and probably should) be changed from with the   //
// scripts also.						     //
///////////////////////////////////////////////////////////////////////
function popUp($width="300",$height="450")
{ ?>
<script language='javascript'>
<!--
	function openSmallWindow(url)  {
	window.open(url,"smallWindow","width=<?php  echo $width; ?>,height=<?php  echo $height; ?>,scrollbars,resizable");
	return false;
}
// -->
</script>
<?php  }

////////////////////////////////////////////////////////////////////
// getEvent() displays events on the calendar for non-IE browsers //
////////////////////////////////////////////////////////////////////
function getEvent($ID, $AbbrTitle, $Date)
{
	echo "<a href=\"./eventtest.php?ID=$ID&Date=$Date\" onClick=return(openSmallWindow('./eventtest.php?ID=$ID&Date=$Date'))>$AbbrTitle</a>\n\n";
}

////////////////////////////////////////////////////////////////
// getEvent() displays events on the calendar for IE browsers //
// This distinction is made because IE is currently the only  //
// browser on which the javascript mouseover effects work.    //
////////////////////////////////////////////////////////////////
function getEventIE($ID, $LinkTitle, $AbbrTitle, $Date)
{
	$LinkTitle =ereg_replace("'","&#146;",$LinkTitle);
	$AbbrTitle =ereg_replace("'","&#146;",$AbbrTitle);
	echo "<script>
	dLink('./eventtest.php?ID=$ID&Date=$Date','$LinkTitle','$AbbrTitle');
	</script>\n\n";
}

//////////////////////////////////////////////////////////////////
// expandItems() calls a javascript that replaces one string of //
// text with another on mouseover (IE only)		        //
//////////////////////////////////////////////////////////////////
function expandItems()
{
?>
	<script language="JavaScript"><!--
	var no=0;

function mover(object,text)
{
	eval(object + '.innerText = text');
}

function mout(object,text)
{
	eval(object + '.innerText = text');
}

function dLink(href,text,txet)
{
	document.write('<a href="'+href+'" onMouseOut="mout(\'link'+no+'\',\''+txet+'\')" onMouseOver="mover(\'link'+no+'\',\''+text+'\')" id="link'+no+'" onClick=return(openSmallWindow(\''+href+'\'))>'+txet+'<\/a>');
	no+=1;
}
//--></script>
<?php
}

////////////////////////////////////////////////////////////////
// closeButton() is a javascript button for closing the event //
// data screens.					      //
////////////////////////////////////////////////////////////////
function closeButton()
{
?>
	<form name="form1" action="javascript:window.close();" method="post">
	<input type="submit" name="Submit" value="Close Window">
	</form>
<?php
}

/////////////////////////////////////////////////////////////////
// printButton() is a javascript button for printing the event //
// data screens.					       //
/////////////////////////////////////////////////////////////////
function printButton()
{
?>
	<form name="form2" action="javascript:window.print();" method="post" >
	<input type="submit" name="Submit" value="Print This Page">
	</form>
<?php
}

//////////////////////////////////////////////////////////
// altBG() alternates table background colors in menus. //
// To change the alternating background colors, change  //
// the values below. These currently only apply to the  //
// menus in the admin areas.				//
//////////////////////////////////////////////////////////
function altBG($lastColor)
{
	if ($lastColor == 1)
	{
		echo "<tr bgcolor=\"#C9C9C9\">";
	}
	elseif ($lastColor == 0)
	{
		echo "<tr bgcolor=\"#E9E9E9\">";
	}
}

////////////////////////////////////////////////////////////
// sessionGo() is used to track category admin users. For //
// insurance of proper functionality, these users should  //
// have cookies enabled. If your server uses something    //
// other than $PHPSESSID for the session identifier,	  //
// you'll need to reflect that change in the code below.  //
////////////////////////////////////////////////////////////
function sessionGo()
{
	if (!$PHPSESSID)
	{
		global $PHPSESSID;
		ini_alter("session.auto_start","1");
		session_start();
	}
print_r ($PHPSESSID);
}

//////////////////////////////////////////////////////////
// checkAdmin() is used to verify proper privileges for //
// category administration tools.			//
//////////////////////////////////////////////////////////
function checkAdmin($PHPSESSID, $WebAdminRoot, $DBName)
{
// place the LocationID in the global scope
	global $glbl_LocationID;

// see if they're logged in

	$query="SELECT events_adminsessions.AdminUserID, events_adminusers.LocationID
	FROM events_adminsessions, events_adminusers
	WHERE events_adminsessions.SessionID = '$PHPSESSID'
	AND events_adminsessions.AdminUserID = events_adminusers.AdminUserID";
//echo $query;

	$result = mysql_query($query) or die(mysql_error());

	$num = mysql_num_rows($result);
	// if not, send them to the login page
	if ($num < 1)
	{
		Header("Location: ".$WebAdminRoot."/login.php");
		exit;
	// or else they're logged in, get the LocationID
	}
	else
	{
		while ($row = mysql_fetch_row($result))
		{
			$glbl_LocationID = $row[1];
		}
	}
}
?>
