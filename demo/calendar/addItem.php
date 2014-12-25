<?php
//allow sessions to be passed so we can see if the user is logged in
session_start();
$cookie=explode('_',$_COOKIE[_hrsb_msb]);
//print_r($cookie);
$cookie1=explode(':',$_COOKIE[_hrsb_msb]);
$subscriberid = $cookie1[0];
if ($_COOKIE[loggedin]=='true')
{
	if ($cookie[1] < date ('U'))
	{
		$expires = date('U') + (3600*24*7);
		$newcookie=$cookie[0]."_".$expires."_1";
		setcookie('_hrsb_msb',$newcookie, $expires, '/');
	}
}
require_once($_SERVER["DOCUMENT_ROOT"]."/includes/defines.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/lib/common.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/lib/system.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/lib/mysql.php");
//require($_SERVER["DOCUMENT_ROOT"]."/eventdates.php");
function reverse ($thisdate)
{
	$d = explode("/",$thisdate);
	$thisdate=$d[2]."-".$d[0]."-".$d[1];
//	echo $thisdate;
	return ($thisdate);
}

function formatdatetime ()
{
	$startdate = reverse ($startdate)." ";
	$StartPeriod == "AM"?"":$StartHour += 12;
	$StartHour > 9?"":$StartHour ="0".$StartHour;
	$StartTime .= $StartHour.":".$StartMinute.":00";

	$$enddate = reverse ($enddate)." ";
	$EndPeriod == "AM"?"":$EndHour += 12;
	$EndHour > 9?"":$EndHour =	"0".$EndHour;
	$EndTime .= $EndHour.":".$EndMinute .":00";
}

function formattime ($hour, $minute, $period)
{
	// echo "hour ".$hour.", minute ".$minute.", period ".$period."<br>";
	if ($period == PM AND $hour != 12)
	{
		$hour += 12;
	}
	elseif ($period == AM AND $hour == 12)
	{
		$hour = 0;
	}

	return($hour.":".$minute.":00");
}

function notifyadmin()
{
// do we send a notification and to whom?
	if ($glbl_ApprovePublicSubmission == 1 AND ($glbl_ApprovalBySiteAdmin == 1 OR !$LocationID))
	{
		$MailTo = $glbl_AdminEmail;
		$AddrVar = $glbl_AdminRoot;
	}
	elseif ($glbl_ApprovePublicSubmission == 1)
	{
		$result = mysql_query ("SELECT Email FROM events_adminusers WHERE LocationID = '$LocationID'") or die(mysql_error());
		while ($row = mysql_fetch_row($result))
		{
			$MailTo = $row[0];
		}

		$AddrVar = $glbl_WebAdminRoot;
	}

// what if we still don't have an address?
	if (!$MailTo)
	{
		$MailTo = $glbl_AdminEmail;
		$AddrVar = $glbl_AdminRoot;
	}

	$Message = "
	A request has been generated from your web site for
	a calendar submission to be approved. Visit the address:
	".$glbl_WebAddress.$AddrVar."

	Once logged in, select the \"Pending event administration\" link.

	Thank you.";

//	mail($MailTo, $glbl_EmailSubject, $Message, "From: $glbl_MailFrom", "-f$MailTo");

//	Header("Location: ./thankyou.php?LocationID=$LocationID");
//	exit();

}
	commonHeader($glbl_SiteTitle);
// We've got some data processing to do!
// first check all of the common elements
// check for missing title
	if ($Returned == 1 AND !$Title)
	{
		echo "<font color=\"red\"><b>You did not specify an EVENT NAME OR TITLE. Please complete the form below.</b></font><p>\n\n";
	}	// the common data checks out, lets check our other data
	elseif ($Returned == 1)
	{  //goes to 1285 - set the Active state based on the config option
		$glbl_ApprovePublicSubmission != 1?$Active = 1:$Active = 0;

//===========================================================================================================================
// START CHECKS FOR DAILY EVENTS
		if ($EventType == "Daily")
		{// Compile the dates
			$StartDate = $DailyStartYear."-".$DailyStartMonth."-".$DailyStartDay;
			$StopDate = $DailyStopYear."-".$DailyStopMonth."-".$DailyStopDay;
// END CHECKS FOR DAILY EVENTS
//===========================================================================================================================
// START CHECKS FOR WEEKLY EVENTS
		}
		elseif ($EventType == "Weekly")
		{// Compile the dates
			$DisplayStart = $WeeklyStartYear."-".$WeeklyStartMonth."-".$WeeklyStartDay;
			$DisplayStop = $WeeklyStopYear."-".$WeeklyStopMonth."-".$WeeklyStopDay;
			if ($dateDiff < 0)
			{
// all of our checks on the surface data was good
			}
			elseif ($Stop != 1)
			{// make a string with the days of the week
				$DaysOfWeek = preg_replace("/^\|/","",$DaysOfWeek);
			}
// END CHECKS FOR WEEKLY EVENTS
//===========================================================================================================================
// START CHECKS FOR MONTHLY EVENTS
		}
		elseif ($EventType == "Monthly")
		{
// Compile the dates
			$DisplayStart = $MonthlyStartYear."-".$MonthlyStartMonth."-".$MonthlyStartDay;
			$DisplayStop = $MonthlyStopYear."-".$MonthlyStopMonth."-".$MonthlyStopDay;

			if ($dateDiff < 0)
			{
				// commonheader($glbl_SiteTitle);
				echo "<font color=\"red\"><b>Your END DATE COMES BEFORE YOUR START DATE. Please complete the form below.</b></font><p>\n\n";

// all of our checks on the surface data was good
			}
			elseif ($Stop != 1)
			{

//formattime ();

// we can insert now
//   notifyadmin();

			}
// END CHECKS FOR MONTHLY EVENTS
//===========================================================================================================================
// START CHECKS FOR YEARLY EVENTS
		}
		elseif ($EventType == "Yearly")
		{	// Compile the dates
			$DisplayStart = $YearlyStartYear."-".$YearlyStartMonth."-".$YearlyStartDay;
			$DisplayStop = $YearlyStopYear."-".$YearlyStopMonth."-".$YearlyStopDay;

// somebody was trying to trick by making a stop date
// before it was started
// END CHECKS FOR YEARLY EVENTS
//===========================================================================================================================
// START CHECKS FOR MONTHLY PERIODICAL EVENTS
		}
		elseif ($EventType == "MonthlyP")
		{
// Compile the dates
			$DisplayStart = $MonthlyPStartYear."-".$MonthlyPStartMonth."-".$MonthlyPStartDay;
			$DisplayStop = $MonthlyPStopYear."-".$MonthlyPStopMonth."-".$MonthlyPStopDay;
// somebody was trying to trick by making a stop date before it was started
			if ($dateDiff < 0)
			{	// commonheader($glbl_SiteTitle);
				echo "<font color=\"red\"><b>Your END DATE COMES BEFORE YOUR START DATE. Please complete the form below.</b></font><p>\n\n";
// all of our checks on the surface data was good
			}
			elseif ($Stop != 1)
			{
// make a string with the days of the week
				for ($i = 0; $WeekDays[$i]; $i++)
				{
					if ($MonthlyPWeekDays[$i] == 1)
					{
						$ShowWeekDays .= "|$i";
					}
				}
				$ShowWeekDays = preg_replace("/^\|/","",$ShowWeekDays);
//formattime ();

// we can insert now

// insert event data in "events" to be used to facilitate registration, voting, and ballot counting
// use displaystart and displystop from line 567 and 568 to figure the dates the show will take place
// function setdate is defined in eventdates.php

//setdate($DisplayStart,$DisplayStop, $ShowWeekDays, $MonthlyPWeekNumber, $Title,$Address1,$City,$state, $Zip);

//   notifyadmin();

			}
// END CHECKS FOR MONTHLY PERIODICAL EVENTS
//===========================================================================================================================
// START CHECKS FOR YEARLY PERIODICAL EVENTS
		}
		elseif ($EventType == "YearlyP")
		{
// Compile the dates
			$DisplayStart = $YearlyPStartYear."-".$YearlyPStartMonth."-".$YearlyPStartDay;
			$DisplayStop = $YearlyPStopYear."-".$YearlyPStopMonth."-".$YearlyPStopDay;

// somebody was trying to trick by making a stop date
// before it was started
			if ($dateDiff < 0)
			{
				// commonheader($glbl_SiteTitle);
				echo "<font color=\"red\"><b>Your END DATE COMES BEFORE YOUR START DATE. Please complete the form below.</b></font><p>\n\n";

// all of our checks on the surface data was good
			}
			elseif ($Stop != 1)
			{
// make a string with the days of the week
				for ($i = 0; $WeekDays[$i]; $i++)
				{
					if ($YearlyPWeekDays[$i] == 1)
					{
						$ShowWeekDays .= "|$i";
					}
				}
				$ShowWeekDays = preg_replace("/^\|/","",$ShowWeekDays);
//formattime ();
// we can insert now
//mysql_query($query) or die(mysql_error());

// insert event data in "events" to be used to facilitate registration, voting, and ballot counting
// use displaystart and displystop from line 567 and 568 to figure the dates the show will take place
// function setdate is defined in eventdates.php

//				setdate($DisplayStart,$DisplayStop, $ShowWeekDays, $YearlyPWeekNumber, $Title,$Address1,$City,$state, $Zip);

//   notifyadmin();
			}
// END CHECKS FOR YEARLY PERIODICAL EVENTS
//===========================================================================================================================
		}
// we haven't returned, so do everything else
// starts at 128
//	echo "line 557<br />$query<br />";
				mysql_query ($query) or die(mysql_error());
	}
	else
	{
		// commonheader($glbl_SiteTitle);
	}

popUp(300,200);
?>
<style type="text/css">
#oneday
{
	display:inline;
}

#moredays, #day1, #day2, #day3, #day4, #day5, #day6, #day7
{
	display:none;
}
</style>
<script type="text/javascript" src="/js/charCount.js"></script>
<script type="text/javascript">
function multiday(days)
{
	var str = days.value;
	var i = 1;
	var index = 0;

	if (str > 1)
	{
		document.getElementById('oneday').style.display="none";
		document.getElementById('moredays').style.display='table';
		while (i <= 7)
		{
			document.getElementById('day'+i).style.display='none';
			index++;
			i++;
		}
		index = 0;
		i = 1;
		while (index < str)
		{
			if (i <= str)
			{
				document.getElementById('day'+i).style.display='table-row';
			}
			else
			{
				document.getElementById('day'+i).style.display='none';
			}
			index++;
			i++;
		}

//   $.ajax({
//        url: 'startstop2.php',
//        data: { days: str },
//        success: function(response) {
//            $('#').html(response);
//					document.getElementById("oneday").innerHTML=response;
//					document.getElementById('moredays').innerHTML=response;
//					document.getElementById("myDIV").innerHTML="How are you?";
//					$('#moredays').html(response);
//        }
//    });
	}
	else
	{
		document.getElementById('oneday').style.display="inline";
		document.getElementById('moredays').style.display='none';
//		i = 1;
//		while (i < 8)
//		{
//			document.getElementById('day'+i).style.display='none';
//			i++;
//		}
	}
	return false;
}
</script>
<script type="text/javascript">

$(document).ready(function()
{
 	$('#thisevent').submit(function(event)
 	{ //Trigger on form submit
 		$('#eventerror').empty(); //Clear the messages first
 		$('#timeerror').empty(); //Clear the messages first
 		$('#success').empty();
 		var thisevent =
 		{ //Fetch form data
			'post' : $('#thisevent').serialize()
/*
			'action' 	: $('input[name=action]').val(),
 			'EventType			': $('input[type=radio]:checked'),
 			'WeekDays			': $('input[name=WeekDays]').val(),
 			'MonthlyDayOfMonth': $('input[name=MonthlyDayOfMonth]').val(),
 			'YearlyMonth		': $('input[name=YearlyMonth]').val(),
 			'YearlyDayOfMonth	': $('input[name=YearlyDayOfMonth]').val(),
 			'MonthlyPWeekNumber': $('input[name=MonthlyPWeekNumber]').val(),
 			'MonthlyPWeekDays	': $('input[name=MonthlyPWeekDays]').val(),
 			'YearlyPWeekNumber': $('input[name=YearlyPWeekNumber]').val(),
 			'YearlyPWeekDays	': $('input[name=YearlyPWeekDays]').val(),
 			'YearlyPMonth		': $('input[name=YearlyPMonth]').val(),
 			'startdate			': $('input[name=startdate]').val(),
 			'enddate				': $('input[name=enddate]').val(),
 			'eventcatid			': $('input[name=eventcatid]').val(),
 			'NumDays				': $('input[name=NumDays]').val(),
 			'StartHour			': $('input[name=StartHour]').val(),
 			'StartMinute		': $('input[name=StartMinute]').val(),
 			'StartPeriod		': $('input[name=StartPeriod]').val(),
 			'EndHour				': $('input[name=EndHour]').val(),
 			'EndMinute			': $('input[name=EndMinute]').val(),
 			'EndPeriod			': $('input[name=EndPeriod]').val(),
 			'day1-StartHour	': $('input[name=day1-StartHour]').val(),
 			'day1-StartMinute	': $('input[name=day1-StartMinute]').val(),
 			'day1-StartPeriod	': $('input[name=day1-StartPeriod]').val(),
 			'day1-EndHour		': $('input[name=day1-EndHour]').val(),
 			'day1-EndMinute	': $('input[name=day1-EndMinute]').val(),
 			'day1-EndPeriod	': $('input[name=day1-EndPeriod]').val(),
 			'day2-StartHour	': $('input[name=day2-StartHour]').val(),
 			'day2-StartMinute	': $('input[name=day2-StartMinute]').val(),
 			'day2-StartPeriod	': $('input[name=day2-StartPeriod]').val(),
 			'day2-EndHour		': $('input[name=day2-EndHour]').val(),
 			'day2-EndMinute	': $('input[name=day2-EndMinute]').val(),
 			'day2-EndPeriod	': $('input[name=day2-EndPeriod]').val(),
 			'day3-StartHour	': $('input[name=day3-StartHour]').val(),
 			'day3-StartMinute	': $('input[name=day3-StartMinute]').val(),
 			'day3-StartPeriod	': $('input[name=day3-StartPeriod]').val(),
 			'day3-EndHour		': $('input[name=day3-EndHour	]').val(),
 			'day3-EndMinute	': $('input[name=day3-EndMinute]').val(),
 			'day3-EndPeriod	': $('input[name=day3-EndPeriod]').val(),
 			'day4-StartHour	': $('input[name=day4-StartHour]').val(),
 			'day4-StartMinute	': $('input[name=day4-StartMinute]').val(),
 			'day4-StartPeriod	': $('input[name=day4-StartPeriod]').val(),
 			'day4-EndHour		': $('input[name=day4-EndHour]').val(),
 			'day4-EndMinute	': $('input[name=day4-EndMinute]').val(),
 			'day4-EndPeriod	': $('input[name=day4-EndPeriod]').val(),
 			'day5-StartHour	': $('input[name=day5-StartHour]').val(),
 			'day5-StartMinute	': $('input[name=day5-StartMinute]').val(),
 			'day5-StartPeriod	': $('input[name=day5-StartPeriod]').val(),
 			'day5-EndHour		': $('input[name=day5-EndHour]').val(),
 			'day5-EndMinute	': $('input[name=day5-EndMinute]').val(),
 			'day5-EndPeriod	': $('input[name=day5-EndPeriod]').val(),
 			'day6-StartHour	': $('input[name=day6-StartHour]').val(),
 			'day6-StartMinute	': $('input[name=day6-StartMinute]').val(),
 			'day6-StartPeriod	': $('input[name=day6-StartPeriod]').val(),
 			'day6-EndHour		': $('input[name=day6-EndHour]').val(),
 			'day6-EndMinute	': $('input[name=day6-EndMinute]').val(),
 			'day6-EndPeriod	': $('input[name=day6-EndPeriod]').val(),
 			'day7-StartHour	': $('input[name=day7-StartHour]').val(),
 			'day7-StartMinute	': $('input[name=day7-StartMinute]').val(),
 			'day7-StartPeriod	': $('input[name=day7-StartPeriod]').val(),
 			'day7-EndHour		': $('input[name=day7-EndHour]').val(),
 			'day7-EndMinute	': $('input[name=day7-EndMinute]').val(),
 			'day7-EndPeriod	': $('input[name=day7-EndPeriod]').val(),
 			'Title				': $('input[name=Title]').val(),
 			'entryfee			': $('input[name=entryfee]').val(),
 			'Address1			': $('input[name=Address1]').val(),
 			'Address2			': $('input[name=Address2]').val(),
 			'city					': $('input[name=city]').val(),
 			'state				': $('input[name=state]').val(),
 			'zip					': $('input[name=zip]').val(),
 			'ContactName		': $('input[name=ContactName]').val(),
 			'ContactPhone		': $('input[name=ContactPhone]').val(),
 			'ContactEmail		': $('input[name=ContactEmail]').val(),
 			'ContactWeb			': $('input[name=ContactWeb]').val(),
 			'Details				': $('input[name=Details]').val(),
 			'subscriberid		': $('input[name=subscriberid]').val(),
 			'Returned			': $('input[name=Returned]').val(),
 			'cancelled			': $('input[name=cancelled]').val(),
 			'demo					': $('input[name=demo]').val(),
 			'zipid				': $('input[name=zipid]').val(),
 			'action				': $('input[name=action]').val()
  */
 		};
 		$.ajax({ //Process the form using $.ajax()
 			type 		: 'POST', //Method type
 			url 		: '/ajax/addevent.php', //Your form processing file url
 			data 		: thisevent,
 			dataType 	: 'json',
 			success 	: function(data)
 			{
//				document.getElementById('eventerror').innerHTML="";
				document.getElementById('eventerror').style.display="none";
//				document.getElementById('timeerror').innerHTML="";
				document.getElementById('timeerror').style.display="none";
 				var fields =["from","to","eventcatid","Title","entryfee","Address1","city","state","zip","ContactName","ContactPhone","ContactEmail","ContactWeb","Details"];
//				alert (data.errors.length);
				for (var j = 0; j < fields.length; j++)
				{
//					alert (fields.length);
	    			var name = fields[j];
//					alert (j+' = '+name);
					document.getElementById(name).style.border ='1px solid #cccccc';

 				}
 				if (data.success=="false")
 				{ //If fails
 					if (data.errors)
 					{ //Returned if any error from process.php
						for (var i = 0; i < data.errors.length; i++)
						{
    						var name = data.errors[i];
							document.getElementById(name).style.border ='1px solid #ff3333';
 							if (data.errors[i]=="timeerror")
							{
								document.getElementById('timeerror').innerHTML="<br>Start Time and End Time are the same.";
								document.getElementById('timeerror').style.display="inline";
							}
 						}
					}
					document.getElementById('eventerror').innerHTML="Please check the hightlighted fields below.  Those fields require a value to be entered.";
					document.getElementById('eventerror').style.display="inline";
				}
				else
				{
 					$('#eventerror').fadeIn(1000).append('' + data.posted + ''); //If successful, than throw a success message
 				}
 			}
 		});
 	   event.preventDefault(); //Prevent the default submit
	});
});

</script>
<!--
<form action="buildeventquery.php" method="post">
-->
<form name="newevent" id="thisevent" method="post">
<table border="0" width="100%">
	<tr>
      <td colspan="2" class="ui-widget ui-widget-header ui-corner-right ui-corner-left"><h1>New Event</h1></td>
	</tr>
	<tr>
		<td colspan="2" align="left" valign="top">
		<div id="tabs">
			<ul class="tabs">
<!-- 				<li id="0"><a onclick=check('EventTyped'); href="#onetime">One-Time</a></li> -->
				<li id="2"><a onclick=check('EventTypew'); href="#weekly">Weekly</a></li>
				<li id="3"><a onclick=check('EventTypem'); href="#monthly">Monthly</a></li>
				<li id="4"><a onclick=check('EventTypey'); href="#yearly">Annual</a></li>
				<li id="5"><a onclick=check('EventTypemp'); href="#pmonthly">Monthly Periodic</a></li>
				<li id="6"><a onclick=check('EventTypeyp'); href="#pyearly">Annual Periodic</a></li>
			</ul>
<!--			<div id="onetime"> -->
<!--	 ======================================================================================================================== -->
<!--	 start TABLE FOR One-Time  EVENTS
commented out
<table border="0" width="100%">
	<tr>
		<td valign="top" colspan="2">
				<b>One-Time Events</b>&nbsp;&nbsp;
<a href="/tips/onetime.html?width=375" class="jTip ui-state-default ui-corner-all ui-icon ui-icon-info" id="onetim" name="One-Time Events"></a>
<input type="radio" name="EventType" id="EventTyped" value="Daily" <?php echo $Daily; ?>>&nbsp;
		</td>
	</tr>
</table>
			</div>
end TABLE FOR One-Time  EVENTS
-->
<!-- ======================================================================================================================= -->
<!-- start TABLE FOR WEEKLY EVENTS -->
<div id="weekly" class="tabcontent">
<table width="100%" border="0">
	<tr>
		<td valign="top" colspan="2">
			<b>Weekly Recurring Event</b>&nbsp;&nbsp
			<a href="/tips/weekly.html?width=375" class="jTip" id="wkly" name="Weekly Events"><span class="icons"></span></a>
	</td>
</tr>
<tr>
	<td valign="top" colspan="2" nowrap>
		<input type="radio" name="EventType" id="EventTypew" value="Weekly" <?php echo $Weekly; ?>>
		<input type="hidden" name="eventtypeid" value="2">
<b>This event takes place every</b>&nbsp;
<?php	sysGetDaySelect("WeekDays"); ?>.
		</td>
	</tr>
</table>
<!-- end TABLE FOR WEEKLY EVENTS -->
</div>
<!-- ======================================================================================================================= -->
<!-- start TABLE FOR MONTHLY EVENTS -->
<div id="monthly">
<table width="100%" border="0">
	<tr>
		<td valign="top" colspan="2">
				<b>Monthly Recurring Event</b>&nbsp;&nbsp;
<a href="/tips/monthly.html?width=375" class="jTip" id="mnthly" name="Monthly Events"><span class="icons"></span></a>
	</td>
</tr>
<tr>
	<td valign="top" colspan="2" nowrap>
	<input type="radio" name="EventType" id="EventTypem" value="Monthly" <?php echo $Monthly; ?>>&nbsp;
		<input type="hidden" name="eventtypeid" value="3">
<b>This event takes place on the&nbsp;
<?php
	echo "<select name=\"MonthlyDayOfMonth\" class=\"text ui-widget-content ui-corner-all\">\n";
	for ($i = 1; $i <= 31; $i++)
	{
		if ($i < 10 AND !preg_match ("/^0/",$i))
		{
			$i = "0".$i;
		}
		$showDay = date("jS",mktime(0,0,0,1,$i,date("Y")));
		if ($MonthlyDayOfMonth == $i)
		{
			echo "<option value=\"$i\" SELECTED> $showDay </option>\n";
		}
		else
		{
			echo "<option value=\"$i\"> $showDay </option>\n";
		}
	}
	echo "</select> of every month.</b></td>\n";
?>
										</td>
									</tr>
								</table>
			</div>
<!-- end TABLE FOR MONTHLY EVENTS -->
<!-- ======================================================================================================================= -->
<!-- start TABLE FOR YEARLY EVENTS -->
			<div id="yearly">
<table width="100%" border="0">
	<tr>
		<td valign="top" colspan="2">

				<b>Annually Recurring Event</b>
				&nbsp;&nbsp;
<a href="/tips/yearly.html?width=375" class="jTip" id="yrly" name="Annual Events"><span class="icons"></span></a>
	</td>
</tr>
<tr>
	<td valign="top">
	<input type="radio" name="EventType" id="EventTypey" value="Yearly" <?php echo $Yearly; ?>>&nbsp;
		<input type="hidden" name="eventtypeid" value="4">
<b>This event takes place on
<?php
	echo "<select name=\"YearlyMonth\" class=\"text ui-widget-content ui-corner-all\">\n";
	for ($i = 1; $i <= 12; $i++)
	{
		if ($i < 10 AND !preg_match ("/^0/",$i))
		{
			$i = "0".$i;
		}
		$showMonth = date("F",mktime(0,0,0,$i,1,date("Y")));
		if ($YearlyMonth == $i)
		{
			echo "<option value=\"$i\" SELECTED> $showMonth </option>\n";
		}
		else
		{
			echo "<option value=\"$i\"> $showMonth </option>\n";
		}
	}
	echo "</select>\n";
?>
&nbsp;
<?php
	echo "<select name=\"YearlyDayOfMonth\" class=\"text ui-widget-content ui-corner-all\">\n";
	for ($i = 1; $i <= 31; $i++)
	{
		if ($i < 10 AND !preg_match ("/^0/",$i))
		{
			$i = "0".$i;
		}
		$showDay = date("jS",mktime(0,0,0,1,$i,date("Y")));
		if ($YearlyDayOfMonth == $i)
		{
			echo "<option value=\"$i\" SELECTED> $showDay </option>\n";
		}
		else
		{
			echo "<option value=\"$i\"> $showDay </option>\n";
		}
	}
	echo "</select> every year.</b>\n";
?>
										</td>
									</tr>
								</table>
			</div>
<!-- end TABLE FOR YEARLY EVENTS -->
<!-- ======================================================================================================================= -->
<!-- start TABLE FOR MONTHLY PERIODICAL EVENTS -->
			<div id="pmonthly">

<table width="100%" border="0">
	<tr>
		<td valign="top" colspan="2">

				<b>Monthly Periodic Event</b>&nbsp;&nbsp;
<a href="/tips/monthlyperiodic.html?width=375" class="jTip" id="mnthlyp" name="Monthly Periodic Events"><span class="icons"></span></a>
	</td>
</tr>
<tr>
	<td valign="top" width="300">
	<input type="radio" name="EventType" id="EventTypemp" value="MonthlyP" <?php echo $MonthlyP; ?>>&nbsp;
		<input type="hidden" name="eventtypeid" value="5">
<b>This event takes place on the
<?php
	echo "<select name=\"MonthlyPWeekNumber\" class=\"text ui-widget-content ui-corner-all\">\n";
	for ($i = 1; $i <= 5; $i++)
	{

		$showWeekNum = date("jS",mktime(0,0,0,date("m"),$i,date("Y")));
		if ($MonthlyPWeekNumber == $i)
		{
			echo "<option value=\"$i\" SELECTED> $showWeekNum </option>\n";
		}
		else
		{
			echo "<option value=\"$i\"> $showWeekNum </option>\n";
		}
	}
	echo "</select>\n";
?>

<?php	sysGetDaySelect("MonthlyPWeekDays",0); ?>
									every month.</b></td>
									</tr>
								</table>
			</div>
<!-- end TABLE FOR MONTHLY PERIODICAL EVENTS -->
<!-- ======================================================================================================================= -->
<!-- start TABLE FOR ANNUAL PERIODICAL EVENTS -->
			<div id="pyearly">

<table width="100%" border="0">
	<tr>
		<td valign="top" colspan="2">
				<b>Annual Periodic Event</b>
				&nbsp;&nbsp;
<a href="/tips/yearlyperiodic.html?width=375" class="jTip" id="yrlyp" name="Annual Periodic Events"><span class="icons"></span></a>
	</td>
</tr>
<tr>
	<td valign="top">
	<input type="radio" name="EventType" id="EventTypeyp" value="YearlyP" <?php echo $YearlyP; ?>>&nbsp;
		<input type="hidden" name="eventtypeid" value="6">
<b>This event takes place on the
<?php
echo "<select name=\"YearlyPWeekNumber\" class=\"text ui-widget-content ui-corner-all\">\n";
	for ($i = 1; $i <= 5; $i++)
	{
		$showWeekNum = date("jS",mktime(0,0,0,date("m"),$i,date("Y")));
		if ($YearlyPWeekNumber == $i)
		{
			echo "<option value=\"$i\" SELECTED> $showWeekNum </option>\n";
		}
		else
		{
			echo "<option value=\"$i\"> $showWeekNum </option>\n";
		}
	}
	echo "</select>\n";
sysGetDaySelect("YearlyPWeekDays",0);
	echo "of <select name=\"YearlyPMonth\" class=\"text ui-widget-content ui-corner-all\">\n";
	for ($i = 1; $i <= 12; $i++)
	{
		if ($i < 10 AND !preg_match ("/^0/",$i))
		{
			$i = "0".$i;
		}
		$showMonth = date("M",mktime(0,0,0,$i,1,date("Y")));
		if ($YearlyPMonth == $i)
		{
			echo "<option value=\"$i\" SELECTED> $showMonth </option>\n";
		}
		else
		{
			echo "<option value=\"$i\"> $showMonth </option>\n";
		}
	}
	echo "</select> every year.</b></td>\n";
?>
									</tr>
								</table>
			</div>
<!-- end TABLE FOR ANNUAL PERIODICAL EVENTS -->
<!-- ======================================================================================================================= -->
						</td>
					</tr>
<tr class="ui-widget">
	<td valign="top">
<div class="ui-widget ui-widget-content ui-corner-all">
<div id="eventerror" class="ui-state-error ui-corner-all" style="display:none"></div>
<table bgcolor="" width="100%" border="0">
<tr class="ui-widget">
	<td valign="top" colspan="2"><b>Display this event between:</b>&nbsp;
	<a href="/tips/startfinish.html?width=375" class="jTip" id="startdate" name="Start and End Dates"><span class="icons"></span></a>
	</td>
</tr>
<tr class="ui-widget">
	<td valign="top">
<label for="from"><b>Start date:</b></label>&nbsp;&nbsp;
<input type="text" id="from" name="startdate" size="10" value="<?php echo $startdate ?>" class="text ui-widget-content ui-corner-all" readonly/>&nbsp;
</td>
<td valign="top">
<label for="to"><b>End date:</b></label>&nbsp;&nbsp;
<input type="text" id="to" name="enddate" size="10" value="<?php echo $enddate ?>" class="text ui-widget-content ui-corner-all" readonly/>&nbsp;
&nbsp;
	</td>
</tr>
<tr class="ui-widget">
	<td valign="top"><b>Event Type</b>&nbsp;
	<a href="/tips/eventcat.html?width=375" class="jTip" id="eventcat" name="Event Type"><span class="icons"></span></a>
<br>
<?php sysGetSelect("eventcatid", "eventcat", 1, $select = -1, "eventcat", "eventcatid") ?>
</td>
	<td valign="middle"><b>Number of days:</b>&nbsp;&nbsp;
	<a href="/tips/numdays.html?width=375" class="jTip" id="numdays" name="Number of Days"><span class="icons"></span></a>
<br>
<select id="days" name="NumDays" class="text ui-widget-content ui-corner-all" onchange="multiday(this)">
<?php
	for ($i = 1; $i <8; $i++)
	{
		$i == $NumDays?$num="selected":$num="";
		echo "<option value=\"$i\" $num> $i </option>\n";
	}
?>
</select>
</td></tr>
<tr><td colspan="2">
<!-- start of start and end time- one day -->
<div id="oneday">
<table bgcolor="" width="100%" border="0">
	<tr class="ui-widget">
		<td width="360px" valign="middle"><b>Start time:</b>
		<select name="StartHour" class="text ui-widget-content ui-corner-all">
<?php
	for ($i = 1; $i <= 12; $i++)
	{
		$i == $StartHour?$starthr="selected":$starthr="";
		echo "<option value=\"$i\" $starthr> $i </option>\n";
	}
?>
</select>
<b>:</b>
<select name="StartMinute" class="text ui-widget-content ui-corner-all">
<?php
	for ($i = "00"; $i < 60; $i += 15)
	{
		if ($i < 10 AND !preg_match ("/^0/",$i))
		{
			$i = "0".$i;
		}
		$i == $StartMinute?$startmin="selected":$startmin="";
		echo "<option value=\"$i\" $startmin> $i </option>\n";
	}
?>
														</select>
<select name="StartPeriod" class="text ui-widget-content ui-corner-all">
<?php
	$StartPeriod == "AM"?$stopam="selected":$stoppm="selected";
	echo "<option value=\"AM\" $stopam> AM </option>\n";
	echo "<option value=\"PM\" $stoppm> PM </option>\n";
?>
</select>
			</td>
<td valign="top"><b>End time:</b>
				<select name="EndHour" class="text ui-widget-content ui-corner-all">
<?php
	for ($i = 1; $i <= 12; $i++)
	{
		$i == $EndHour?$endhr="selected":$endhr="";
		echo "<option value=\"$i\" $endhr> $i </option>\n";
	}
?>
</select>
<b>:</b>
<select name="EndMinute" class="text ui-widget-content ui-corner-all">
<?php
	for ($i = "00"; $i < 60; $i += 15)
	{
		if ($i < 10 AND !preg_match ("/^0/",$i))
		{
			$i = "0".$i;
		}
		$i == $EndMinute?$endmin="selected":$endmin="";
		echo "<option value=\"$i\" $endmin> $i </option>\n";
	}
?>
</select>
<select name="EndPeriod" class="text ui-widget-content ui-corner-all">
<?php
	$EndPeriod == "AM"?$stopam="selected":$stoppm="selected";
	echo "<option value=\"AM\" $stopam> AM </option>\n";
	echo "<option value=\"PM\" $stoppm> PM </option>\n";
?>
</select>
	</td>
</tr>
</table>
<!--<div id="timeerror" class="ui-state-error ui-corner-all" style="display:none"></div> -->

</div>
<!-- end of one day start and end time -->
	</td>
</tr>
<tr><td colspan="2">
<!-- start of multi-day start and end time -->
<div id="moredays">
<table bgcolor="" width="734px" border="0">
<tr class="ui-widget">
	<td width="80px" valign="top">&nbsp;</td>
	<td width="275px" valign="top"><b>Start time:</b></td>
	<td valign="top"><b>End time:</b></td>
</tr>
<?php
$index=1;
while ($index <= 7)
{
//echo 'startstop2 value: ' . $ms.'<br>';
//exit();
//echo 'startstop2 index: ' . $index.'<br>';
echo <<<END
<tr id="day$index" class="ui-widget">
	<td class="ui-widget"><b>Day $index</b></td>
	<td class="ui-widget">
		<select name="day$index-StartHour" class="text ui-widget-content ui-corner-all">
END;
	for ($i = 1; $i <= 12; $i++)
	{
		$i == $StartHour?$starthr="selected":$starthr="";
		echo "<option value=\"$i\" $starthr> $i </option>\n";
	}
echo <<<END
</select>
&nbsp;<b>:</b>&nbsp;
<select name="day$index-StartMinute" class="text ui-widget-content ui-corner-all">
END;
	for ($i = "00"; $i < 60; $i += 15)
	{
		if ($i < 10 AND !preg_match ("/^0/",$i))
		{
			$i = "0".$i;
		}
		$i == $StartMinute?$startmin="selected":$startmin="";
		echo "<option value=\"$i\" $startmin> $i </option>\n";
	}
echo <<<END
</select>
<select name="day$index-StartPeriod" class="text ui-widget-content ui-corner-all">
	$StartPeriod == "AM"?$stopam="selected":$stoppm="selected";
	echo "<option value="AM" $stopam> AM </option>\n";
	echo "<option value="PM" $stoppm> PM </option>\n";
</select>
			</td>
<td class="ui-widget">
				<select name="day$index-EndHour" class="text ui-widget-content ui-corner-all">
END;
	for ($i = 1; $i <= 12; $i++)
	{
		$i == $EndHour?$endhr="selected":$endhr="";
		echo "<option value=\"$i\" $endhr> $i </option>\n";
	}
echo <<<END
</select>
&nbsp;<b>:</b>&nbsp;
<select name="day$index-EndMinute" class="text ui-widget-content ui-corner-all">
END;
	for ($i = "00"; $i < 60; $i += 15)
	{
		if ($i < 10 AND !preg_match ("/^0/",$i))
		{
			$i = "0".$i;
		}
		$i == $EndMinute?$endmin="selected":$endmin="";
		echo "<option value=\"$i\" $endmin> $i </option>\n";
	}
echo <<<END
</select>
<select name="day$index-EndPeriod" class="text ui-widget-content ui-corner-all">
	$EndPeriod == "AM"?$stopam="selected":$stoppm="selected";
	echo "<option value="AM" $stopam> AM </option>\n";
	echo "<option value="PM" $stoppm> PM </option>\n";
</select>
	</td>
</tr>
END;
$index++;
}
?>
</table>
</div>
</td></tr>
</table>
<!-- end of multi-day start and end time -->
<div id="timeerror" class="ui-state-error ui-corner-all" style="display:none"></div>
	</td>
</tr>
<!-- Step 2	 ======================================================================================================================== -->
<tr class="ui-widget">
	<td>
<div class="ui-widget ui-widget-content ui-corner-all">
<table bgcolor="" width="100%" border="0">
<tr class="ui-widget">
	<td valign="top" colspan="2"><b>Event Name/Title/Location:</b>&nbsp;
	<a href="/tips/eventname.html?width=375" class="jTip" id="eventname" name="Event Name/Title/Location"><span class="icons"></span></a>
<br>
		<input type="text" size="60" id="Title" name="Title" value="<?php  echo $Title; ?>" class="text ui-widget-content ui-corner-all" />
	</td>
</tr>
<tr class="ui-widget">
<td valign="top" colspan="3"><b>Entry Fee</b>&nbsp;
<a href="/tips/entryfee.html?width=375" class="jTip" id="entry" name="Event Fee"><span class="icons"></span></a>
<br>
		<input type="text" size="30" id="entryfee" name="entryfee" value="<?php  echo $entryfee; ?>" onKeyDown="javascript:return dFilter (event.keyCode, this, '$##.##');" class="text ui-widget-content ui-corner-all" />
	</td>
</tr>
<tr class="ui-widget">
	<td valign="top"><b>Address 1:</b>&nbsp;
	<a href="/tips/address1.html?width=375" class="jTip" id="address1" name="Address 1"><span class="icons"></span></a>
<br>
	<input type="text" size="30" id="Address1" name="Address1" value="<?php  echo $Address1; ?>" class="text ui-widget-content ui-corner-all" />
</td>
<td valign="top"><b>Address 2:</b>&nbsp;
<a href="/tips/address2.html?width=375" class="jTip" id="address2" name="Address 2"><span class="icons"></span></a>
<br>
		<input type="text" size="30" id="Address2" name="Address2" value="<?php  echo $Address2; ?>" class="text ui-widget-content ui-corner-all" />
	</td>
</tr>
<tr class="ui-widget">
	<td valign="top"><b>City:</b><br>
		<input id="city" name="city" type="text" size="20" maxlength="32" value="<?php  echo $city; ?>" class="text ui-widget-content ui-corner-all" readonly />
</td>
<td valign="top"><b>State and Zip Code:</b>&nbsp;
<a href="/tips/zipcode.html?width=375" class="jTip" id="zipcode" name="City, State, Zip"><span class="icons"></span></a>
<br>
<input id="state" name="state" type="text" size="4" maxlength="2" value="<?php  echo $state; ?>" class="text ui-widget-content ui-corner-all" readonly>
&nbsp;&nbsp;
<input id="zip" name="zip" type="text" size="8" maxlength="5" value="<?php  echo $zip; ?>" class="text ui-widget-content ui-corner-all" />
	</td>
</tr>
<tr class="ui-widget">
	<td valign="top"><b>Contact Name:</b><br>
		<input type="text" size="30" id="ContactName" name="ContactName" value="<?php  echo $ContactName; ?>" class="text ui-widget-content ui-corner-all" />
	</td>
	<td valign="top"><b>Contact Phone:</b>&nbsp;
<a href="/tips/phone.html?width=375" class="jTip" id="phone" name="Contact Phone"><span class="icons"></span></a>
<br>
		<input type="text" size="30" id="ContactPhone" name="ContactPhone" onKeyDown="javascript:return dFilter (event.keyCode, this, '###-###-####');" value="<?php  echo $ContactPhone; ?>" class="text ui-widget-content ui-corner-all" />
	</td>
</tr>
<tr class="ui-widget">
	<td valign="top"><b>Contact Email:</b>&nbsp;
	<a href="/tips/email.html?width=375" class="jTip" id="email" name="Contact Email"><span class="icons"></span></a>
<br>
	<input type="text" size="30" id="ContactEmail" name="ContactEmail" value="<?php  echo $ContactEmail; ?>" class="text ui-widget-content ui-corner-all" />
</td>
<td valign="top"><b>Web Site:</b>&nbsp;
<a href="/tips/website.html?width=375" class="jTip" id="website" name="Web Site"><span class="icons"></span></a>
<br>
		<input type="text" size="30" id="ContactWeb" name="ContactWeb" value="<?php  echo $ContactWeb; ?>" class="text ui-widget-content ui-corner-all" />
	</td>
</tr>
<tr class="ui-widget">
	<td valign="top" colspan="2"><b>Details:</b>  (<span id="charcount">0</span> characters entered - <span id="remaining">2000</span> remaining.)<br>
<?php
	$Details = stripslashes($Details);
	$Details = preg_replace("/\"/","&quot;",$Details);
?>
		<textarea class="text ui-widget-content ui-corner-all" id="Details" name="Details" cols="94" rows="14" wrap onkeyup="CheckFieldLength(Details, 'charcount', 'remaining', 2000);" onkeydown="CheckFieldLength(Details, 'charcount', 'remaining', 2000);" onmouseout="CheckFieldLength(Details, 'charcount', 'remaining', 2000);"><?php  echo $Details; ?></textarea>
<br>
	</td>
</tr>
</div>

<tr class="ui-widget">
	<td>
		</td>
	<td align="right">
		<input type="hidden" name="subscriberid" value="<?php echo $subscriberid ?>">
		<input type="hidden" name="Returned" value="1">
		<input type="hidden" name="cancelled" value="0">
		<input type="hidden" name="demo" value="1">
		<input type="hidden" id="zipid" name="zipid" value="<?php  echo $zipid; ?>">
		<input type="hidden" name="action" value="addevent">
		<input id="addevent" type="submit" class="ui-button ui-widget ui-state-default ui-corner-all" value="Add Event >>">
	</td>
</tr>
</table>
</div>
</td>
</tr>
</div>

</table>
</form>
<?php
commonFooter();
?>
<!-- before 2749 -->