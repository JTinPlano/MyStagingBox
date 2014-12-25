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
	$i=0;
	$errors = array(); //To store errors
	$posted = array(); //To store errors
	$start=0;
	$end=0;
	if (isset($_POST['action']))
	{
		foreach($_POST as $k => $v)
		{
//	echo $k." = ".$v,"<br />\n";
			$k = $v;
//			$$k = $v;
			if ($k=='key')
			{
				$subscriber=explode(':',$v);
			$query = 'SELECT * FROM `subscriber` WHERE `subscriberid` = '.$subscriber[0].'';
			}
		}
	}
if (!isset($_POST['action']))
{
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
//				$k=$v;
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
//					$posted[]=$k;
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
}
switch ($_POST['action'])
{
	case 'login':
//print_r($_POST);
		$loginid = $_POST['loginid'];
		$passwordmd5 = md5($password);
		$return[error]='false';
		$return['msg'] = '';
		$query = "SELECT * FROM `subscriber`
		WHERE `loginid` = '".$loginid."'
		and `passwordmd5` = '".$passwordmd5."'";
//echo "line 205 $query<br>";
		$res = q($query) or die (mysql_error());
//check if theres a match
		$rows=nr($res);
		$row=f($res);
//echo "rows $rows<br>";
//exit();
		if($rows == 0)
		{

			if (($row[loginid] != $loginid) && ($row[passwordmd5] != $passwordmd5))
			{
				$return['error'] = true;
				$return['msg'] = 'The loginid and password entered are invalid.  Please double-check them and try again.  Both are case-sensitive.';
			}
			elseif ($row[loginid] != $loginid)
			{
				$return['error'] = true;
				$return['msg'] = 'The loginid entered is invalid.  Please re-enter it and try again.  It\'s case-sensitive.';
			}
			else
			{
				$return['error'] = true;
				$return['msg'] = 'The password entered is invalid.  Please re-enter it and try again.  It\'s case-sensitive.';
			}
		}
		else
		{
			$expires = date('U') + (3600*24*7);
			$query = 'update `subscriber` set `online` = 1, `rtime` = '.$expires.' WHERE `subscriberid` = '.$row[subscriberid].'';
			q($query) or die (mysql_error());
//echo "line 31 $query<br>";
//exit();
/*
			$_COOKIE['name'] = '_hrsb_msb';
			value encoding:  key_expires_active
			$_COOKIE['value'] = $value;
			$_COOKIE['expire'] = $expires;
			$_COOKIE['path']=$path;
*/
			$name = '_hrsb_msb';
			$path='/';
			$server = explode('.',$_SERVER['HTTP_HOST']);
			$server[0]== preg_match('/^mystaging/',$server[0]) || $server[1]==preg_match('/^mystaging/',$server[1])?$domain='.mystagingbox.com':$domain='.localhost';
			$value="".$row[key]."_".$expires."_1";
//echo "line 50 $row[key] + $expires = $value<br>";
//exit ();
			setcookie ($name, $value, $expires, $path);
			setcookie ('loggedin', 'true', $expires, $path);
			$return['error'] = false;
			$return['msg'] = '';
		}
		echo json_encode($return);
		break;

	case 'register':
		$query="select `loginid` from `subscriber` where `loginid` = '".$loginid."'";
		$logins=nr(q($query));
//echo "line 88 query $query<br>";
//echo "line 89 rows $rows<br>";
//exit ();
		$query="select `email` from `subscriber` where `email` = '".$email."'";
		$emails=nr(q($query));
		if ($logins != 0)
		{
			$return['error'] = true;
			$return['msg'] = 'The Login ID you chose already exists.  Please choose another one.';
//echo "line 95 rows $logins<br>";
			echo json_encode($return);
		}
		elseif ($emails != 0)
		{
			$return['error'] = true;
			$return['msg'] = 'That Email Address already exists.  Please enter a different one.';
//echo "line 95 rows $logins<br>";
			echo json_encode($return);
		}
		else
		{
			$subscriberid=next_id('subscriber', 'subscriberid');
			$rtime=date('U');
			$passwordmd5=md5($password1);
			$token=$_COOKIE[token];
			$key = $subscriberid.':'.$rtime.':'.md5($loginid).':'.$passwordmd5;
			$expires = date('U') + (3600*24*7);
			if(!setcookie('_hrsb_msb',$key, $expires))
			{
//				echo "setcookie() failed<br />";
//exit();
			}

//echo $key;
//exit();

		$joined=date('Y-m-d');
		$query="INSERT INTO `subscriber` (`subscriberid`, `loginid`, `password`, `passwordmd5`, `email`, `joined`, `optin`, `online`, `rtime`, `key`) VALUES ($subscriberid,'".$loginid."','".$password1."','".$passwordmd5."','".$email."','".$joined."',$optin,1,'".$rtime."','".$key."')";
//		$_COOKIE[_hrsb_msb]=$key;
//echo $query;
//print_r($_COOKIE);
//exit();
		$res2 = mysql_query($query) or die (mysql_error("line 126".$query.'<br />'));
$to  = "jt@mystagingbox.com, jt@shopoleinc.com";

// subject
	$subject = "MyStagingBox.com Email Confirmation";
	$message = 'Thank you for registering with MyStagingBox.com, ';
	$message .=$loginid;

	$message .='<br \/>Here is your activation key:<br \/><br \/>';

	$message .=$token;
	//echo $token;
	$message .='<br \/><br \/>Copy and paste the activation key into the \"Activate My Account\" text box, then click the button.  You will receive another email verifying that your account is active, and you will be logged in automatically.  Please take a couple of minutes to complete your profile information.
	<br \/><br \/>
	Thank you again for becoming the newest subscriber to MyStagingBox.com, THE perfect staging area for ALL things hot rod.';
	$from = 'From: noreply@mystagingbox.com';
	//echo "to ".$to."<br />subject ".$subject."<br />message ".$message."<br />from ".$from;

	//$result=mail($to, $subject, $message, $from);

	//send the email with an email containing the activation link to the supplied email address
	//display the success message
		$return[error]='false';
		$return[msg]='Registration Successful.';
		$return[key]=$key;
		echo json_encode($return);
//echo $key;
		}
		break;

	case 'activate':
		$return['error'] = '';
		$return['msg'] = '';
		foreach($_POST as $k => $v)
		{
//			$$k=$v;
			if ($k=='token')
			{
				$query = 'SELECT * FROM `subscriber` WHERE `key` = \''.$v.'\'';
//echo "line 125 $query<br>\n";
//print_r($row);
}
//	echo $k." = ".$v,"<br />\n";
//			$k=$v;
//	echo $k." = ".$v,"<br />\n";
//echo "line 127 $query<br>\n";
		}
//echo "line 129 $query<br>\n";
//check if theres a match
		$res = q($query);
		$rows=nr($res);
		$row=f($res);
//echo "line 136 rows $rows<br>\n\n";
//exit();
		if($rows == 0)
		{
			$return['error'] = true;
			$return['msg'] = 'The activation code entered is invalid.  Please double-check your email for the correct code.';
		}
		else
		{
			$uid=$row['subscriberid'];
			$query = 'update `subscriber` set `confirmed` = 1, `active` = 1 WHERE `key` = \''.$v.'\'';
			$res = mysql_query($query) or die (mysql_error());
//echo "line 148 $query<br>";
//exit();
/*
			$_COOKIE['name'] = '_hrsb_msb';
			$_COOKIE['value'] = $value;
			$_COOKIE['expire'] = $expires;
			$_COOKIE['path']=$path;
*/
			$name = '_hrsb_msb';
			$expires = date('U') + (3600*24*7);
/*
value encoding:  key_expires_active
*/
			$value=$v.'_'.$expires.'_1';
			$path='/';
			$server = explode('.',$_SERVER['HTTP_HOST']);
			$server[0]== preg_match('/^mystaging/',$server[0]) || $server[1]==preg_match('/^mystaging/',$server[1])?$domain='.mystagingbox.com':$domain='.localhost';
			$secure = 'false';
			$httponly = 'false';
			setcookie ($name, $value, $expires, $path);
			setcookie ('loggedin', 'true', $expires, $path);
			$return['error'] = false;
			$return['msg'] = '';

		}
		echo json_encode($return);
		break;

	case 'sendmessage':
//	echo "line 172 sendmessage<br />\n";
$message = "Your friend at $fromemail thought you might like this.<br /><br/>$message<br /><br/>.";
$from="noreply@mystagingbox.com";
$subject="Subject";
$result=mail($to, $subject, $message, $from);
echo "result ".$result."<br />";
if ($result==TRUE)
{
		$return['error'] = false;
		$return['msg'] = '';
	}
	else
	{
		$return['error'] = true;
		$return['msg'] = 'Form processing halted for suspicious activity.';
}
		echo json_encode($return);
		break;

	case 'addevent':
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
//			$form_data['posted'] = $posted;
			$i=1;
//			foreach ($errors as $k=>$v)
//			{
//				echo $k." = ".$v,"<br />\n";
//			}
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
//echo "line 441\n";
//		print_r($cookie);
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

//  	build query starts at line 406
			$form_data['success'] = true;
			$form_data['posted'] = 'Data Was Posted Successfully';
		}	  // starts at 406
//		$thiserror =  json.parse($errors);
//		print_r($errors);
//		exit();
		//Return the data back to form.php
//		print_r( json_encode($form_data['errors']));
		echo json_encode($form_data);
			break;

	default:

		//print_r($_GET);
			$return[error]='false';
			$return['msg'] = '';
			$i=0;
			$j=0;
		$proceed = false;
		$seconds = 60*10;
		//echo '<h1>Testing:</h1><p>Cookie: '.$_COOKIE['token'].'<br />Timestamp: '. $_POST['token'].'</p>';
		//print_r($_POST);
		//print_r($_COOKIE['token']);
		//echo "<br>_POST[token] $_POST[token]:_COOKIE[token] $_COOKIE[token]:md5(secret salt._POST[token]) ".md5('secret salt'.$_POST[token])."<br>";
		//exit();
		if(isset($_POST['token']) && isset($_COOKIE['token']) && $_COOKIE['token'] == md5('secret salt'.$_POST['token']))
		{
			$proceed = true;
		}

		if(!$proceed)
		{
			$return['error'] = true;
			$return['msg'] = 'Form processing halted for suspicious activity.';
		}

		if(((int)$_POST['token'] + $seconds) < mktime())
		{
			$return['error'] = true;
			$return['msg'] = 'Too much time elapsed.  Please click \'Register\' again and submit the form in less than 10 minutes, which is the form timeout.';
		}
			$queries=0;
			foreach ($_POST as $k => $v)
			{
		//	echo "line 11 $k = $v<br />\n";
				if ($k=='loginid' || $k=='email')
				{
				//echo "$k = $v<br>";
					$$k = $v;
					$query[$i]= 'SELECT * FROM `subscriber` WHERE `'.$k.'` = '.$v.'';
					$where[$j]=$k;
					$i++;
					$j++;
					$queries++;
				}
				else
				{
					continue;
				}
				//echo "$queries<br>$query[$i]<br>$where[$j]<br>";
							}
					$i=0;
					$j=0;
					while ($i<$queries)
					{
						//echo "line 38 $queries:$query[$i]:$where[$j]<br>";
				$res = q($query[$i]);
				//check if theres a match
						$rows=nr($res);
				//echo "rows $rows<br>";
						if($rows > 0)
						{
					if ($where[$j] == "loginid")
					{
						$return['error'] = true;
						$return['msg'] = 'The Login ID you entered is already taken.  Please choose another one.';
						$return['code'] = 'loginid';
					}
					if ($where[$j] == "email")
					{
						$return['error'] = true;
						$return['msg'] = 'The email address you entered is already registered.';
						$return['code'] = 'email';
					}
				}
				$i++;
				$j++;
			}
			echo json_encode($return);
				break;

}
