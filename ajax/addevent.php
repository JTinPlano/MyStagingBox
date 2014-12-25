<?php
/**
 * @author Marijan Šuflaj <msufflaj32@gmail.com>
 * @link http://www.php4every1.com
 */
require_once ("../lib/system.php");
require_once ("../lib/mysql.php");
require_once ("../lib/global.php");
get_globals();

function reverse ($thisdate)
{
//	echo "line 13 ".$thisdate."\n";;
	$d = explode("%2F",$thisdate);
//print_r($d);
	$thisdate=$d[2]."-".$d[0]."-".$d[1];
//	echo "line 16 ".$thisdate."\n";;
	return ($thisdate);
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

function compare ($start, $end, $days)
{
	global $starttime, $endtime;
//	print_r($start);
//	print_r($end);
//	echo "days ".$days."\n";
	$i=0;
	$starthour=0;
	$startminute=$starthour+1;
	$startperiod=$startminute+1;
	$endhour=0;
	$endminute=$endhour+1;
	$endperiod=$endminute+1;
	$timeerror=0;
	while ($i<($days))
	{
		if (($start[$starthour]==$end[$endhour]) && ($start[$startminute]==$end[$endminute]) && ($start[$startperiod]==$end[$endperiod]))
		{
			$timeerror++;
			$whichday = ($startperiod+1)/3;
		}
		else
		{
			$starttime[]= formattime ($start[$starthour], $start[$startminute], $start[$startperiod]);
			$endtime[]=	formattime ($end[$endhour],$end[$endminute], $end[$endperiod]);
		}
		$starthour+=3;
		$startminute=$starthour+1;
		$startperiod=$startminute+1;
		$endhour+=3;
		$endminute=$endhour+1;
		$endperiod=$endminute+1;
		$i++;
	}
//	echo "line 67\n";
//	print_r($starttime);
//	print_r($endtime);
	if($timeerror!=0){return (1);}
	else{return (0);}
}

$i=0;
$start=0;
$end=0;
$errors = array(); //To store errors
$posted = array(); //To store errors
foreach($_POST as $index => $post)
{
	$newpost=explode("&", $post);
	foreach($newpost as $index => $nvpair)
	{
//echo "line 69: ".$nvpair."\n";
		$thispost=explode("=",$nvpair);
//echo "line 71: ".$thispost[0]." = ".$thispost[1]."\n";
		$k=$thispost[0];
		$v=$thispost[1];
//echo "line 74: ".$k." = ".$v."\n";
//		$k=$v;
		$$k=$v;
//echo "line 77: ".$$k." = ".$v."\n";
		if ($k=='NumDays'){$days=$v;}
		if ($v =='')
		{
			if ($k=="Address2" || $k=="zipid" || $k=="subscriberid"){continue; }
			if ($k=="startdate") {$errors[]="from"; continue;}
			if ($k=="enddate") {$errors[]="to"; continue;}
			$errors[]=$k;
			$i++;
		}
//		$posted[]=$k;
		$i++;
//echo "days: ".$days."\n";
		if(preg_match("/^day/", substr($k,0)))
		{
			if (preg_match("/Start/", substr($k,5))){$multistart[]=$v;}
			if (preg_match("/End/", substr($k,5))){$multiend[]=$v;}
		}
		if (preg_match("/^Start/", substr($k,0))){$onestart[]=$v;}
		if (preg_match("/^End/", substr($k,0))){$oneend[]=$v;}
//echo "line 96: ".$k." = ".$v."\n";
	}
//	print_r($multistart);
//	print_r($multiend);
//	print_r($name);
//	print_r($value);
}
if ($days>1)
{
	if(compare ($multistart, $multiend, $days))
	{
		$errors[]="timeerror";
	}
//	echo "line 130\n";
//	print_r($starttime);
//	print_r($endtime);
}
else
{
	if(compare ($onestart, $oneend, $days))
	{
		$errors[]="timeerror";
	}
}
//		$posted = array(); //To store errors
$form_data = array(); //Pass back the data to `additem.php`
//		$errors = array(); //To store errors
/*
$i = 0;
foreach($_POST as $k => $v)
{
	echo $k." = ".$v,"<br />\n";
	if ($v =='')
	{
		$errors[$i]=$k;
		$i++;
	}
	else
	{
		$posted[$i]=$k;
		$i++;
	}
}
*/
//	echo "line 369.\n";
//	print_r($errors);

if (!empty($errors))
{ //If errors in validation
	$form_data['success'] = "false";
	$form_data['errors'] = $errors;
//	$form_data['posted'] = $posted;
	$i=1;
//	foreach ($errors as $k=>$v)
//	{
//		echo $k." = ".$v,"<br />\n";
//	}
}
else
{ //If not, build query - ends at line 731
//	$starttime = array(0=>"");
//	$endtime = array(0=>"");
	$i=1;
	$querystring = http_build_query($_POST);
//	echo 	$querystring."<br>";
//	print_r($newpost);
	foreach($newpost as $index => $nvpair)
	{
//echo "line 69: ".$nvpair."\n";
		$thispost=explode("=",$nvpair);
//echo "line 71: ".$thispost[0]." = ".$thispost[1]."\n";
		$k=$thispost[0];
		$$k=$thispost[1];
//echo "line 420: ".$k." = ".$$k."\n";
		if (is_array($StartHour)){print_r($StartHour);}
	}
/*
	foreach ($_POST as $k => $v)
	{
//		echo "$k = $v<br />\n";

		$$k = $v;
//		echo "$$k = $v<br />\n";
	}
*/
//	if (isset($_POST))
//	{ // ends at 303
//		print_r($_POST);

//		$result = mysql_query ("select loginid from subscriber where subscriberid = $cookie1[0]") or die(mysql_error());
//		$row = mysql_fetch_row($result);
//		echo "line 104 ".$demo[1]."<br />";
		$cookie=explode('_',$_COOKIE[_hrsb_msb]);
//	echo "line 441\n";
//	print_r($cookie);
		$cookie1=explode(':',$_COOKIE[_hrsb_msb]);

		$subscriberid = $cookie1[0];
		$fields = "insert into event (";
		$values = "values (";
		switch ($EventType)
		{
    		case "Daily":
				$fields .= "`dayofweek`, ";
				$values .= "".$WeekDays.", ";
       		$Daily=" checked";
		 		$eventtypeid="1";
        	break;

    		case "Weekly":
				$fields .= "`dayofweek`, ";
				$values .= "".$WeekDays.", ";
        		$Weekly=" checked";
		 		$eventtypeid="2";
       	break;

    		case "Monthly":
				$fields .= "`dayofmonth`, ";
				$values .= "".$MonthlyDayOfMonth.", ";
				$Monthly=" checked";
				$eventtypeid="3";
			break;

			case "Yearly":
				$fields .= "`month`, ";
				$values .= "".$YearlyMonth.", ";
				$fields .= "`dayofmonth`, ";
				$values .= "".$YearlyDayOfMonth.", ";
       		$Yearly=" checked";
		 		$eventtypeid="4";
        break;

    		case "MonthlyP":
				$fields .= "`weeknumber`, ";
				$values .= "".$MonthlyPWeekNumber.", ";
				$fields .= "`dayofweek`, ";
				$values .= "".$MonthlyPWeekDays.", ";
       		$MonthlyP=" checked";
		 		$eventtypeid="5";
       	break;

			case "YearlyP":
				$fields .= "`month`, ";
				$values .= "".$YearlyPMonth.", ";
				$fields .= "`dayofweek`, ";
				$values .= "".$YearlyPWeekDays.", ";
				$fields .= "`weeknumber`, ";
				$values .= "".$YearlyPWeekNumber.", ";
       		$YearlyP="checked";
		 		$eventtypeid="6";
       break;

		 default:
       	$Weekly=" checked";
		 	$eventtypeid="2";
		}
//		$startdate = reverse($startdate);
		$tempstart = reverse($startdate);
		$fields .= "`startdate`, ";
		$values .= "'".$tempstart."', ";

//		$enddate = reverse($enddate);
		$tempend = reverse($enddate);
		$fields .= "`enddate`, ";
		$values .= "'".$tempend."', ";

		if ($NumDays > 1)
		{	// ends at 231
			$eventid=next_id('event', 'eventid');
			$i=0;
			$day=1;
//			$fields="";
//			$values="";
/*
CREATE TABLE IF NOT EXISTS `moredays` (
  `indexid` mediumint(3) unsigned NOT NULL AUTO_INCREMENT,
  `eventid` mediumint(3) unsigned NOT NULL,
  `daynumber` tinyint(1) unsigned DEFAULT NULL,
  `starttime` time DEFAULT NULL,
  `endtime` time DEFAULT NULL,
  `cancelled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`indexid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

*/
//	echo "line 531\n";
//		print_r($starttime);
//		echo "<br>";
//		print_r($endtime);
//		echo "<br>";
		while ($i < $NumDays)
		{
			$start = explode(":",$starttime[$i]);
			$end =  explode (":",$endtime[$i]);
//	echo "line 543\n";
//		print_r($starttime);
//		echo "\n";
//		print_r($endtime);
//		echo "\n";
//			echo $_POST['StartHour-day$i'].":".$StartMinute-day.$i.":".$StartPeriod-day.$i."<br>";
//			echo $EndHour-day.$i.":".$EndMinute-day.$i.":".$EndPeriod-day.$i."<br>";
//			$startformat = formattime($start[0],$start[1],$start[2]);
//			$endformat = formattime($end[0],$end[1],$end[2]);
//			echo "starttime 1= ".$starttime[$i]."<br>endtime 1=  ".$endtime[$i]."<br>";
//			$starttime = formattime($_POST['StartHour-day".$i."'],$_POST['StartMinute-day".$i."'],$_POST['StartPeriod-day".$i."']);
//			$endtime = formattime($_POST['EndHour-day".$i."'],$_POST['EndMinute-day".$i."'],$_POST['EndPeriod-day".$i."']);
//			echo "line 550 starttime = ".$starttime."<br>endtime = ".$endtime."<br>";
			$fields1 = "insert into moredays (`eventid`, ";
			$values1 = "values ('".$eventid."', ";
			$fields1 .= "`starttime`, ";
			$values1 .= "'".$starttime[$i]."', ";
			$fields1 .= "`endtime`, ";
			$values1 .= "'".$endtime[$i]."', ";
			$fields1 .= "`daynumber`, ";
			$values1 .= "'".$day."', ";
			$fields1 .= "`cancelled`) ";
			$values1 .= "'0');";
			$query1=$fields1." ".$values1;
			echo "line 570 ".$query1."\n";
//			mysql_query ($query1) or die(mysql_error());
			$i++;
			$day++;
		}

//		echo "line 562\n";
//		print_r($starttime);
//			echo "\n";
//		print_r($endtime);
//			echo "\n";
//		print_r($EndMinute);
//		print_r($EndPeriod);

		} //starts at line 178
		else
		{
			$starttime[] = formattime($StartHour,$StartMinute,$StartPeriod);
//			$starttime = $_POST['StartHour'].":".$_POST['StartMinute']." ".$_POST['StartPeriod'];
			$fields .= "`starttime`, ";
			$values .= "'".$startformat."', ";

			$endtime[] = formattime($_POST['EndHour'],$_POST['EndMinute'],$_POST['EndPeriod']);
//			$endtime = $_POST['EndHour'].":".$_POST['EndMinute']." ".$_POST['EndPeriod'];
			$fields .= "`endtime`, ";
			$values .= "'".$endtime."', ";
		}


		$fields .= "`maplink`, ";
		$values .= "'".urlencode("https://maps.google.com/maps?q=".$address1." ".$city.", ".$state." ".$zip."&oe=utf-8")."', ";

	 	$fields .= "`NumDays`, ";
	 	$values .= "".$NumDays.", ";

	 	$fields .= "`Title`, ";
 		$values .= "'".addslashes(urldecode($Title))."', ";

 		$fields .= "`cancelled`, ";
 		$values .= "'".$cancelled."', ";

	 	$fields .= "`eventcatid`, ";
 		$values .= "".urldecode($eventcatid).", ";

 		$fields .= "`entryfee`, ";
 		$values .= "'".$entryfee."', ";

	 	$fields .= "`Address1`, ";
 		$values .= "'".addslashes(Address1)."', ";

 		$fields .= "`Address2`, ";
 		$values .= "'".addslashes($Address2)."', ";

	 	$fields .= "`city`, ";
 		$values .= "'".addslashes(ucwords(strtolower($city)))."', ";

	 	$fields .= "`state`, ";
 		$values .= "'".$state."', ";

	 	$fields .= "`zip`, ";
 		$values .= "".$zip.", ";

	 	$fields .= "`ContactName`, ";
 		$values .= "'".addslashes($ContactName)."', ";

	 	$fields .= "`ContactPhone`, ";
 		$values .= "'".$ContactPhone."', ";

	 	$fields .= "`ContactEmail`, ";
 		$values .= "'".$ContactEmail."', ";

	if ($ContactWeb AND !preg_match ("/^http:\/\//",$ContactWeb))
	{
		$ContactWeb = "http://".$ContactWeb;
	}

	 	$fields .= "`ContactWeb`, ";
 		$values .= "'".$ContactWeb."', ";

	 	$fields .= "`demo`, ";
 		$values .= "'".$demo."', ";

	 	$fields .= "`Details`, ";
 		$values .= "'".addslashes(urldecode($Details))."', ";

	 	$fields .= "`eventtypeid`, ";
 		$values .= "".$eventtypeid.", ";

	 	$fields .= "`zipid`, ";
 		$values .= "".$zipid.", ";

		$fields .= "`subscriberid`, `active`, `listdate`)";
		$values .= "".$subscriberid.", 1, '".date("Y-m-d")."');";
//		echo "line 640 ".$fields." = ".$values."\n";
//	}  // starts at 104
	$query=$fields." ".$values;
echo "line 640 ".$query."\n";
//		mysql_query ($query) or die(mysql_error());
//	echo "<br />Session<br />";
//	print_r($_SESSION);
//	echo "<br />Cookie<br /> ";
//	print_r($_COOKIE);
//	echo "<br />Post<br /> ";
//	print_r($_POST);
//	exit();
//echo "EventType = ".$EventType."<br />";
	switch ($EventType)
	{
		case "Daily":
      	$Daily=" checked";
			$eventtypeid="1";
      break;

   	case "Weekly":
      	$Weekly=" checked";
		 	$eventtypeid="2";
      break;

      case "Monthly":
      	$Monthly=" checked";
			$eventtypeid="3";
      break;

		case "Yearly":
      	$Yearly=" checked";
			$eventtypeid="4";
      break;

		case "MonthlyP":
      	$MonthlyP=" checked";
			$eventtypeid="5";
      break;

		case "YearlyP":
      	$YearlyP="checked";
			$eventtypeid="6";
      break;

    	default:
      	$Weekly=" checked";
			$eventtypeid="2";
	}

//echo $StartTime."<br />".$EndTime;
//exit();
/*
(1, 'Auction/Sale'),
(2, 'Car Show'),
(3, 'Charity Event'),
(4, 'Club Meeting'),
(5, 'Cruise Night'),
(6, 'Indoor Show'),
(7, 'Multi-day Event');
(8, 'Race'),
(9, 'Swap Meet'),
(10, 'Not Listed')
*/
	$WeeklyDays = array(
	"0" => "Sun",
	"1" => "Mon",
	"2" => "Tue",
	"3" => "Wed",
	"4" => "Thu",
	"5" => "Fri",
	"6" => "Sat");

// build query starts at line 406
	$form_data['success'] = true;
	$form_data['posted'] = 'Data Was Posted Successfully';
}	  // starts at 406
//		$thiserror =  json.parse($errors);
//		print_r($errors);
//		exit();
//Return the data back to form.php
//		print_r( json_encode($form_data['errors']));
echo json_encode($form_data);
?>