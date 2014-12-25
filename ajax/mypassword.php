<?php
// print_r($_POST);
require($_SERVER["DOCUMENT_ROOT"]."/lib/mysql.php");
	foreach($_POST as $index => $post)
	{
		$newpost=explode("&", $post);
		foreach($newpost as $index => $nvpair)
		{
//	echo "line 16: ".$nvpair."\n";
			$thispost=explode("=",$nvpair);
//	echo "line 71: ".$thispost[0]." = ".$thispost[1]."\n";
			$k=$thispost[0];
			$v=$thispost[1];
			$$k=$v;
//	echo "line 21: ".$k." = ".$v." = ".$$thispost[0]."\n";
		}
	}
//	$cookie1=explode(':',$_COOKIE[_hrsb_msb]);
//	print_r($cookie1);
//	$cookie=explode('_',$cookie1[3]);
//	print_r($cookie);
	 $expires=date("U") + (3600*24*7);
//    $_COOKIE[_hrsb_msb]=$cookie1[0].":".$cookie1[1].":".$cookie1[2].":".md5($password1)."_".$expires."_1";
// print_r($_COOKIE[_hrsb_msb]);
//    exit();
 setcookie('_hrsb_msb',$_COOKIE[_hrsb_msb],$expires,'/');
	$cookie=explode('_',$_COOKIE[_hrsb_msb]);
	$cookie1=explode(':',$_COOKIE[_hrsb_msb]);
	$rtime=date('U');
	$key = $cookie1[0].':'.$rtime.':'.$cookie1[2].':'.md5($new1);
	$rtime=date('U');
	$expires = $rtime + (3600*24*7);
	$passwordmd5=md5($new1);
	setcookie('_hrsb_msb', $key."_".$cookie[1]."_".$cookie[2],$expires,'/');
	$query="update subscriber set `password` = '$new1', `passwordmd5` = '$passwordmd5', `key` = '$key' where `subscriberid` = $cookie1[0];";
	q($query) or die ('query error: ' . mysql_error());
//	echo "query ".$query."\n";
	$affected=mysql_affected_rows();
//	print "Your new password has been saved.";
//	echo "affected ".$affected."\n";
//	exit();

		if ($affected != 1)
		{
			$form_data['success'] = 'false';
			$form_data['errors'] = "There was a system error.  Please contact the site administrator.;
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
			$form_data['posted'] = "Your new password has been saved.";
		}
		echo json_encode($form_data);
/*************************************************************************
		if ($_COOKIE[loggedin]=='true')
		{
			if ($cookie[1] < date ('U'))
			{
				$expires = date('U') + (3600*24*7);
				$newcookie=$cookie[0]."_".$expires."_1";
				setcookie('_hrsb_msb',$newcookie, $expires, '/');
			}
		}
*************************************************************************/
	//		exit();
?>