<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/includes/defines.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/lib/common.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/lib/mysql.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/lib/system.php");
foreach ($_GET as $k=>$v)
{
//	echo "line 4 $k = $v<br>";
	$$k=$v;
}
//echo "line 7 month $month year $year<br>";
if($year==date("Y"))
{
	$day=1;
	if($month==date("m"))
	{
		$thisdate=date("d");
	}
}
else
{
	$month=1;
	$thisdate=1;
}
//	$year==date("Y")&&$month==date("$month")?$thisdate=date("d"):$thisdate=1;
//echo "line 21 month $month day $thisdate year $year<br>";
function showtime ($thistime)
{
	$temp=explode(":",$thistime);
	if ($temp[0]>12)
	{
		$period="PM";
		$hour=$temp[0]-=12;
	}
	else
	{
		$period="AM";
		$morning=str_replace($temp[0],"","0");
		$temp[0]==12?$hour="00":$hour=$morning;
		$temp[0]<10?$hour=str_replace("0","",$temp[0]):$hour=$temp[0];
	}
	//echo $hour.":".$temp[1]." ".$period;
	$thistime=$hour.":".$temp[1]." ".$period;
	return ($thistime);

}

function showdate ($thisdate)
{
	$temp=explode("-",$thisdate);
	return ($temp[1]."/".$temp[2]."/".$temp[0]);
}

function checklength ($text)
{
	if (strlen($text) > (TRUNCATE))
	{
		$showName = substr($text,0,TRUNCATE)."...&nbsp;&nbsp;<a href=\"#\">More</a>";
	}
	else
	{
		$showName = $text;
	}
	return ($showName);
}

function frequency ($typeid, $catid, $whichweek='', $whichdow='', $whichmonth='', $whichdate='')
{
//exit();
$cat = array(
	1 => 'Auction/Sale',
	2 => 'Car Show',
	3 => 'Charity Event',
	4 => 'Club Meeting',
	5 => 'Cruise Night',
	6 => 'Indoor Show',
	7 => 'Multi-day Event',
	8 => 'Race',
	9 => 'Swap Meet',
	10 => 'Other');
$WeeklyDays = array(
	"0" => "Sun",
	"1" => "Mon",
	"2" => "Tue",
	"3" => "Wed",
	"4" => "Thu",
	"5" => "Fri",
	"6" => "Sat");
$ord = array(
	1=>'st',
	2=>'nd',
	3=>'rd',
	21=>'st',
	22=>'nd',
	23=>'rd',
	31=>'st');
if ($whichweek != ""){$whichweek < '4'?$weekordinal=$ord[$whichweek]:$weekordinal='th';}
if ($whichdate != ""){$whichdate < '4'||$whichdate=='21'||$whichdate=='22'||$whichdate=='23'||$whichdate=='31'?$dateordinal=$ord[$whichdate]:$dateordinal='th';}
	switch($typeid)
	{
		case 1:
			//one-time
			$words = "One-Time ".$cat[$catid]." Today";
//(dayofmonth = '$thisdate' AND month = '$month')  or
			return ($words);
			break;
		case 2:
			//weekly
			$words = "Weekly ".$cat[$catid]." every ".$whichdow.".";
//(dayofweek = '$dow')  or
			return ($words);
			break;

		case 3:
//		Monthly
			$words = "Monthly ".$cat[$catid]." on the ".$whichdate.$dateordinal.".";
//(dayofmonth = '$thisdate')  or
			return ($words);
			break;

		case 4:
//yearly
$thismonth=date('F',mktime(0, 0, 0, $whichmonth, 1, 0));
			$words = "Annual ".$cat[$catid]." on $thismonth $whichdate";
//(dayofmonth = '$thisdate' AND month = '$month') or
			return ($words);
			break;

		case 5:
//		monthly periodical
			$words = "Monthly ".$cat[$catid]." on the ".$whichweek.$weekordinal." ".$whichdow.".";
//(weeknumber = '$weeknum' AND dayofweek = '$dow')  or
			return ($words);
			break;

		case 6:
//		yearly periodical

			$words = "Yearly Periodical Event on the $whichweek.$weekordinal $whichdow of $whichmonth";
//(weeknumber = '$weeknum' AND dayofweek = '$dow' AND month = '$month')
			return ($words);
			break;

		default:
			return ("No data available.");
			break;
/*
$freqquery="SELECT $what
				FROM event
				WHERE $where eventid=$eventid;
				(
					(eventtypeid=1 AND dayofmonth = '$thisdate' AND month = '$month')  or
					(eventtypeid=2 AND dayofweek = '$dow')  or
					(eventtypeid=3 AND dayofmonth = '$thisdate')  or
					(eventtypeid=4 AND dayofmonth = '$thisdate' AND month = '$month') or
					(eventtypeid=5 AND weeknumber = '$weeknum' AND dayofweek = '$dow')  or
					(eventtypeid=6 AND weeknumber = '$weeknum' AND dayofweek = '$dow' AND month = '$month')
				)
				AND ('$queryDate' BETWEEN startdate AND enddate)
				ORDER BY state, city, zip, NumDays, starttime asc";
		$events = mysql_query($freqquery) or die(mysql_error());
*/
	}
}
?>
<!-- <div id="Level1-$i">  -->
<div id="tab<?php echo $tab ?>">
		<ul>
<?php
while ($month<13)
{
	$thismonth= date("M",mktime(0, 0, 0, $month, 1, $year));
echo <<<END
   				<li><a href="#Level2-$month"><span>$thismonth</span></a></li>
END;
	$month++;
	echo "\n";
}
?>
		</ul>
<?php
$year==date("Y")?$month=date("m"):$month=1;
//echo "line 41 month $month day $day year $year<br>";
$days = array(
	"0" => "Sunday",
	"1" => "Monday",
	"2" => "Tuesday",
	"3" => "Wednesday",
	"4" => "Thursday",
	"5" => "Friday",
	"6" => "Saturday");

while ($month<13)
{
	$href="";
echo <<<END
<div class="panel" id="Level2-$month"><a name="top$year$month"></a><div class="hrefdate" id="hrefdate$year$month"></div>
END;
	$year==date("Y")&&$month==date("m")?$thisdate=date("d"):$thisdate=1;;
	$startDay = date("w",mktime(0,0,0,$month,$thisdate,$year));	// starting DOW
//echo "line 105 month $month day $thisdate year $year<br>";
	$index=$thisdate;
	$numDays = date("t",mktime(0,0,0,$month,1,$year));		// number of days in the month
//echo "numDays $numDays<br>";
	$noevents=0;
	$hrefstate="";

	while ($index <= $numDays)
	{
//		echo "$index, ";
		$queryresults = 0;
		// the day = $i, so set a number & query the DB for this day
		//$thisdate < 10 and !preg_match("/^0/",$thisdate)?$thisdate = "0".$thisdate:$thisdate = $rowcount;
		$index < 10?$thisdate = "0".$index:$thisdate = $index;
		$queryresults = 0;	 // query results array index counter
		$queryDate = $year."-".$month."-".$thisdate;
		$dow = date("w", mktime(0,0,0,$month, $thisdate, $year));
//$queryDate = date('Y-m-d');
		$queryDate==date('Y-m-d')?$bkgrnd="bgcolor=\"#ff0000\"":$bkgrnd="";
//echo "line 125 queryDate $queryDate<br>";
// how many of today have happened this month? assume at least one
		$weeknum = ceil ($index/7);
//echo "strt first index = $index: dow $dow, thisdate = $thisdate, dow = $dow, week num = $weeknum, queryDate = $queryDate<br>";
// select events query
		$eventquery="SELECT eventid, dayofweek, dayofmonth, weeknumber, city, state, zip, starttime
		FROM event
		WHERE Active = '1' and demo != '1' and
		(
			(eventtypeid=1 AND dayofmonth = '$thisdate' AND month = '$month')  or
			(eventtypeid=2 AND dayofweek = '$dow')  or
			(eventtypeid=3 AND dayofmonth = '$thisdate')  or
			(eventtypeid=4 AND dayofmonth = '$thisdate' AND month = '$month') or
			(eventtypeid=5 AND weeknumber = '$weeknum' AND dayofweek = '$dow')  or
			(eventtypeid=6 AND weeknumber = '$weeknum' AND dayofweek = '$dow' AND month = '$month')
		)
		AND ('$queryDate' BETWEEN startdate AND enddate)
		ORDER BY state, city, zip, starttime asc";
		$events = mysql_query($eventquery) or die(mysql_error());
//echo "line 139 eventquery ".$eventquery."<br />\n";
//insert result loop
		$backto="";
/*** get distinct city and state to build the state links for each event date	***/
		$locations="SELECT distinct state, city, zip
		FROM event
		WHERE Active = '1' and demo = '0' and
		(
			(eventtypeid=1 AND dayofmonth = '$thisdate' AND month = '$month')  or
			(eventtypeid=2 AND dayofweek = '$dow')  or
			(eventtypeid=3 AND dayofmonth = '$thisdate')  or
			(eventtypeid=4 AND dayofmonth = '$thisdate' AND month = '$month') or
			(eventtypeid=5 AND weeknumber = '$weeknum' AND dayofweek = '$dow')  or
			(eventtypeid=6 AND weeknumber = '$weeknum' AND dayofweek = '$dow' AND month = '$month')
		)
		AND ('$queryDate' BETWEEN startdate AND enddate)
		ORDER BY state, city, zip asc";
		$citystate=q($locations);

		if (nr($citystate)>0)
		{
//			echo "states ".nr($citystate)."<br>";
			while ($thislocation=f($citystate))
			{
				$hrefstate.="<a href=\"#".$thislocation[state].$year.$month.$index."\">".$thislocation[state]."</a>&nbsp;&nbsp;";
//				echo "Line 263 ".$hrefstate."<br>";
			}
//				echo "Line 266 ".$hrefstate."<br>";
		}
//		echo "Line 268 ".$hrefstate."<br>";
/*** end of building state links ************************************************/
		if (nr($events)>0)
		{
			$noevents+=nr($events);
//echo "line 144 num events ".nr($events)."<br />\n";
			if ($index > 1 && $noevents > 1)
			{
				$href.="<a href=\"#".$year.$month.$index."\">".$index."</a> ";
				$backto="<a class=\"btt\" href=\"#top$year$month\">Back to Dates This Month</a><br /><br />";
			}
echo <<<END
						<a name="$year$month$index"></a>
						<!-- start 2-1 content -->
						<div id="date" class="ui-helper-reset ui-state-default ui-corner-all">$days[$dow] $month - $index - $year</div>
					<div class="hrefstate" id="states">Shows today in: $hrefstate</div>
END;
/*********************************************************************
		SELECT * FROM
		(
			SELECT emailID, fromEmail, subject, timestamp, MIN(read) as read
			FROM incomingEmails
			WHERE toUserID = '$userID'
			ORDER BY timestamp DESC
		) AS tmp_table GROUP BY LOWER(fromEmail)'
*********************************************************************/
		while ($row1 = mysql_fetch_row($events))
		{
			$Detailsquery="SELECT *
			FROM event
			WHERE eventid= $row1[0]
			ORDER BY state, city, zip, NumDays, starttime asc";
//echo "line 155 Detail ".$Detailsquery."<br />\n";
			$details = mysql_query($Detailsquery) or die(mysql_error());
//echo "line 157 details ".nr($details)."<br />\n";
			$divid=0;
			while ($detail = mysql_fetch_row($details))
			{
//	echo "event id $detail[0] title $detail[16]<br>";
				$eventid	= $detail[0];
				$active= $detail[1];
				$eventtypeid= $detail[2];
				$eventcatid	= $detail[3];
				$subscriberid= $detail[4];
				$maplink	= $detail[5];
//echo $detail[14]."<br>";
				if ($detail[14] > 1)
				{
					$start[]="";
					$end[]="";
					$moredays="SELECT starttime, endtime
					FROM moredays
					WHERE eventid= $row1[0]";
//					echo "moredays: ".$moredays."\n";
//					$multi=mysql_query() or die(mysql_error());
//					$times = mysql_fetch_array($multi) or die(mysql_error());
					$numrows=0;
					$showtimes="";
					$thisrow=nr(q($moredays));
					$result = q($moredays);
//					echo "thisrow: ".$thisrow."<br>\n";
					while ($times = f($result))
					{
//	echo "numrows: ".$numrows."<br>\n";
//	echo "print_r(times):==========================<br>";
//	print_r($times);
//	echo "============================<br>\n";
//	echo "times[starttime]= ".$times['starttime']."<br>\n";
//	echo "times[endtime]= ".$times['endtime']."<br>\n";
						$showtimes.="<b>Show Time:</b>&nbsp;&nbsp;Day&nbsp;".($numrows+1).":&nbsp;". showtime($times['starttime'])." to ". showtime($times['endtime'])."<br>";
/*		$start.$numrows= showtime($times[$numrows]);
		$endtime.$numrows	= showtime($detail[7]);
		echo "from ".$start.$numrows." to ".$endtime.$numrows."\n";
*/		$numrows++;
					}
				}
				if ($detail[14] == 1)
				{
//	$starttime= showtime($detail[6]);
//	$endtime	= showtime($detail[7]);
	$showtimes="<b>Show Time:</b>&nbsp;&nbsp;". showtime($detail[6])." to ". showtime($detail[7]);
				}
				$startdate= showdate ($detail[8]);
				$enddate	= showdate ($detail[9]);
				$dayofweek= $detail[10];
				$dayofmonth= $detail[11];
				$weeknumber= $detail[12];
//				$month= $detail[13];
				$NumDays= $detail[14];
				$entryfee= urldecode($detail[15]);
				$Title= urldecode($detail[16]);
				$cancelled= $detail[17];
				$cancelreason= $detail[18];
				$Address1= $detail[19];
				if ($detail[20]!=""){$Address2="<div id=\"address2\"><b>Address2:</b>&nbsp;&nbsp;".$detail[20]."</div>";}
				else{$Address2="";}
				$city = $detail[21];
				$state = $detail[22];
				$cityid = $detail[23];
				$stateid	= $detail[24];
				$zip = $detail[25];
				$zipid= $detail[26];
				$pattern=array('/”/','/“/');
				$Details = checklength(urldecode(preg_replace($pattern, '"', $detail[27])));
				$tempDetails = preg_replace($pattern, '"',$detail[27])."  <a href=\"#\">...&nbsp;Less</a>";
				$ContactName = urldecode($detail[28]);
				$detail[29]!=''?$ContactPhone= $detail[29]:$ContactPhone='';
				$detail[30]!=''?$ContactEmail= "<a href=\"mailto:$detail[30]\">Email</a>":$ContactEmail='';
				$ContactWeb	= "<a href=\"$detail[31]\" target=\"_blank\">Website</a>";
				$demo = $detail[32];
				$paid = $detail[33];
				$frequencywording = frequency($eventtypeid, $eventcatid, $weeknum, $days[$dow], $month, $thisdate);
				$subid = explode (":", $_COOKIE['_hrsb_msb']);
				$edit="";
/*				if ($subscriberid == $subid[0])
				{
					$edit="<button><a href=\"#\">Edit</a></button>";
				}	*/

//					$NumDays==1?$day = " day":$day = " days";
//					$state=$events;
//					$row2 = mysql_fetch_row($state);
//					foreach ($row2 as $k=>$v)
//					{
//						echo "$row2[5] ";
//					}
//					reset ($row2);

echo <<<END
							<a name="$state$year$month$index"></a>
							<div><b>Title/Event Name:<span id="title">&nbsp;&nbsp;$Title</span></b></div>
							<div id="address1"><b>Address:</b>&nbsp;&nbsp;$Address1&nbsp;&nbsp;<a href="#" id="map">Map</a></div>
							$Address2
							<div id="csz"><b>$city, $state $zip</b></div>
							<div id="eventcat"><b>Event Type and Frequency:</b> $NumDays-day $frequencywording</div>
							<div id="duration"><div id="fromto">$showtimes</div></div>
							<div id="entryfee"><b>Entry Fee:</b>$entryfee</div>
							<div id="$year$month$thisdate$divid-more"><b>Details:</b>$Details</div>
							<div id="$year$month$thisdate$divid-less" style="display:none;">$tempDetails</div>
							<div id="contact"><b>Contact Info:</b> $ContactName&nbsp;$ContactPhone&nbsp;&nbsp;$ContactEmail&nbsp;&nbsp;$ContactWeb&nbsp;&nbsp;$edit</div>
							<br />
							<br />$backto
END;
					$divid++;
				}
			}
		}
//	echo "end  first index = $index: dow $dow, thisdate = $thisdate, dow = $dow, week num = $weeknum, queryDate = $queryDate<br>";
		$index++;
//		$j++;
		$dow==6?$dow=0:$dow++;
		$rowcount++;
		$hrefstate="";
	}
	if ($noevents<1)
	{
		echo "There are no events on this month's schedule.\n";
		echo "Click \"Add My Event\" from the menu on the left to add your event to the calendar.  It's free.\"\n";
		$noevents=1;
		$datestext="";
		$statetext="";
	}
	if($noevents > 2)
	{
		$datestext="Dates this month: $href";
//		$statetext="Statetext test.";
	}
//echo "2 href $href<br>";
echo <<<END
  		</div>
<script type="text/javascript">
$(document).ready(function()
{
	document.getElementById('hrefdate$year$month').innerHTML='$datestext';

	$( "button" ).button({
		icons: {
		primary: "ui-icon-pencil",
		secondary: "ui-icon-unlocked"
		}
	})
});
</script>
END;
	$month++;
	echo "\n";
}
?>
	</div>
<!-- </div> -->