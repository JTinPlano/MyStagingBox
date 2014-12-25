<?php
/**
 * @author Marijan Šuflaj <msufflaj32@gmail.com>
 * @link http://www.php4every1.com
 */
require_once ("../lib/system.php");
require_once ("../lib/mysql.php");
require_once ("../lib/global.php");
get_globals();
$i=0;
function reverse ($thisdate)
{
//	echo "line 13 ".$thisdate."\n";;
	$d = explode("%2F",$thisdate);
//print_r($d);
	$thisdate=$d[2]."-".$d[0]."-".$d[1];
//	echo "line 16 ".$thisdate."\n";;
	return ($thisdate);
}

	foreach($_POST as $index => $post)
	{
			$newpost=explode("&", $post);
			foreach($newpost as $index => $nvpair)
			{
//echo "line 16: ".$nvpair."\n";
				$thispost=explode("=",$nvpair);
//echo "line 71: ".$thispost[0]." = ".$thispost[1]."\n";
				$k=$thispost[0];
				$v=$thispost[1];
//echo "line 21: ".$k." = ".$v."\n";
//				$k=$v;
				$$k=$v;
$query.="$k = '$$k', ";
//echo $k." = '".$$k."',";
//echo "line 77: ".$$k." = ".$v."\n";
/*
var fields =[			 var required =[
"password",				 "password",
"new1",					 "new1",
"new2",					 "new2",
"optin",					 "firstname",
"firstname",			 "lastname",
"lastname",				 "gender",
"gender",				 "dob",
"dob",					 "street_address",
"street_address",		 "zip"]
"city",
"state",
"zip",
"phone",
"cphone",
"company"];
*/
//print_r($_COOKIE[_hrsb_msb])."<br /><br />/n";
$passwordcheck=explode("_",$_COOKIE[_hrsb_msb]);
//print_r($passwordcheck)."<br /><br />/n";
$passwordcheck=explode(":",$passwordcheck[0]);
//print_r($passwordcheck)."<br /><br />/n";
	if ($k=="url" && $v!="" AND !preg_match ("/^http:\/\//",$url))
	{
		$url = "http://".$url;
	}
/*
	else
	{
		$url = "";
	}
*/

	if ($k=="password" && $v!="")
	{
//echo	md5($v)."\n";
//echo	$v."\n";
		if ($passwordcheck[3]!=md5($password))
		{
			$errors[]=$k;
			$passworderror[0]="passworderror 1";
			$i++;
		}
		else
		{
			if($_POST[new1] != $_POST[new2])
			{
				$errors[]="new1";
				$i++;
				$errors[]="new2";
				$i++;
				$passworderror[1]="New passwords are not the same";
			}
			else
			{
				 $expires = date('U') + (3600*24*7);
				 $newcookie=$passwordcheck[0].":".$passwordcheck[1].":".$passwordcheck[2].":".md5($password)."_".$expires."_1";
				 setcookie('_hrsb_msb',$newcookie,$expires,'/');
			}
		}
	}
	if ($v =='' && ( $k=="firstname" || $k=="lastname" || $k=="gender" || $k=="dob" || $k=="street_address" || $k=="zip"))
	{
			$errors[]=$k;
			$i++;
	}
//	$posted[]=$k;
//	$i++;
//echo "line 96: ".$k." = ".$v."\n";
}
//	print_r($passworderror);
//	print_r($_COOKIE[_hrsb_msb]);
//	print_r($multiend);
//	print_r($name);
//	print_r($value);
		}
// $where = " where subscriberid = $subscriberid;";
//echo "query: ".$query."\n";
//exit();
$query="update subscriber set optin = '$optin', firstname = '".urldecode($firstname)."', lastname = '".urldecode($lastname)."', gender = '$gender', dob = '".reverse($dob)."', address = '".urldecode($street_address)."', city = '".urldecode(ucwords(strtolower($city)))."', state = '$state', zip = '$zip', phone = '$phone', cphone = '$cphone', company = '".urldecode($company)."', url = '".urldecode($url)."' where subscriberid = $subscriberid;";
q($query) or die ('query error: ' . mysql_error());
$affected=mysql_affected_rows();
//echo "affected ".$affected."\n";
//exit();

		if ($affected != 1)
		{
			$form_data['success'] = 'false';
			$form_data['errors'] = $errors;
		}
		elseif ($errors)
		{
			$form_data['success'] = 'false';
			$form_data['errors'] = $errors;
//			$form_data['posted'] = 'Data Posted';
		}
		else
		{
			$form_data['success'] = 'true';
			$form_data['posted'] = "Your profile information has been saved successfully.";
		}
		echo json_encode($form_data);


// exit();