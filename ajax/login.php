<?php
/**
 * @author Marijan Šuflaj <msufflaj32@gmail.com>
 * @link http://www.php4every1.com
 */
require_once ("../lib/system.php");
require_once ("../lib/mysql.php");
require_once ("../lib/global.php");
get_globals();
		foreach($_POST as $k => $v)
		{
//	echo "line 13: ".$k." = ".$v."<br />\n";
//			$k = $v;
			$$k = $v;
//	echo "line 15: ".$$k." = ".$v."<br />\n";
			if ($k=='key')
			{
				$subscriber=explode(':',$v);
				$query = 'SELECT * FROM `subscriber` WHERE `subscriberid` = '.$subscriber[0].'';
			}
		}
//print_r($_POST);
		$passwordmd5 = md5($password);
		$return[error]='false';
		$return['msg'] = '';
		$query = "SELECT * FROM `subscriber` WHERE `loginid` = '".$loginid."'";
//echo "line 29 $query<br>";
		$res = q($query) or die (mysql_error());
//exit();
//check if theres a match
		$rows=nr($res);
		$row=f($res);
//echo "rows $rows<br>";

		if($rows == 0)
		{
				$return['error'] = true;
				$return['msg'] = 'The loginid entered is invalid or not registered.  Please re-enter it and try again.  It\'s case-sensitive.';
				$return['id'] = 'loginid';
		}
		elseif ($rows > 0)
		{
			$query = "SELECT * FROM `subscriber` WHERE `loginid` = '".$row[loginid]."' and `passwordmd5` = '".$passwordmd5."'";
//echo "line 29 $query<br>";
			$res = q($query) or die (mysql_error());
//exit();
//check if theres a match
			$rows=nr($res);
			$row=f($res);
//echo "rows $rows<br>";
			if($rows != 1)
			{
				$return['error'] = true;
				$return['msg'] = 'The password entered is invalid.  Please re-enter it and try again.  It\'s  case-sensitive.';
				$return['id'] = 'password';
			}
		else
		{
//		print_r($return);
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
	}
//		print_r($return);
		echo json_encode($return);
?>