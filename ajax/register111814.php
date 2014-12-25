<?php
/**
 * @author Marijan Šuflaj <msufflaj32@gmail.com>
 * @link http://www.php4every1.com
 */
//	print_r($_POST);
//	exit();
require_once($_SERVER["DOCUMENT_ROOT"]."/lib/mysql.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/lib/system.php");
	$queries=0;
	foreach ($_POST as $k => $v)
	{
//	echo "line 63 $k = $v<br />\n";
		$$k = $v;
		if ($k=='loginid' || $k=='email')
		{
//	echo "line 66 $k = $v<br>";
			$query= 'SELECT * FROM `subscriber` WHERE `'.$k.'` = \''.$v.'\'';
//	echo "line 68 $query<br>";
			$res = q($query);
//check if theres a match
			$rows=nr($res);
//	echo "rows $rows<br>";
			if($rows > 0)
			{
				if ($k == "loginid")
				{
					$return['success'] = false;
					$return['error'] = true;
					$return['msg'] = 'The Login ID you entered is already taken.  Please choose another one.';
					$return['id'] = 'loginid';
					echo json_encode($return);
					return;
				}
				else if ($k == "email")
				{
					$return['success'] = false;
					$return['error'] = true;
					$return['msg'] = 'The email address you entered is already registered.';
					$return['id'] = 'email';
					echo json_encode($return);
					return;
				}
			}
		}
	}
	$subscriberid=next_id("subscriber", "subscriberid");
	$passwordmd5=md5($password1);
	$rtime=date('U');
	$key = $subscriberid.':'.$rtime.':'.md5($loginid).':'.$passwordmd5;
	$joined=date('Y-m-d');
	$expires = $rtime + (3600*24*7);
	$newcookie=$key."_".$expires."_1";
	setcookie('_hrsb_msb',$newcookie, $expires, '/');
	setcookie('loggedin','false',$expires, '/');
	$query="INSERT INTO `subscriber` (`subscriberid`, `loginid`, `password`, `passwordmd5`, `email`, `joined`, `optin`, `online`, `rtime`, `key`) VALUES ('".$subscriberid."','".$loginid."','".$password1."','".$passwordmd5."','".$email."','".$joined."','".$optin."','1','".$rtime."','".$newcookie."')";
//	echo $query;
//	exit();
	$res2 = q($query) or die (mysql_error());

	// subject
	$subject = "MyStagingBox.com Registration Activation";
	$to = $email;
//	$to  = "jt@mystagingbox.com";
$message = '
<html dir="LTR" lang="en-us">
<head>
	<link type="text/css" href="http://'.$_SERVER["SERVER_NAME"].'/css/jquery-ui-1.8.14.dark-hive.css" rel="stylesheet" />
	<link type="text/css" href="http://'.$_SERVER["SERVER_NAME"].'/css/prod.css" rel="stylesheet" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="http://'.$_SERVER["SERVER_NAME"].'/js/jquery-ui-1.8.14.dark-hive.min.js"></script>
	<link type="text/css" href="http://'.$_SERVER["SERVER_NAME"].'/css/tooltip.css" rel="stylesheet" />
	<script type="text/javascript" src="http://'.$_SERVER["SERVER_NAME"].'/js/hrsb.js"></script>
	<script type="text/javascript" src="http://'.$_SERVER["SERVER_NAME"].'/js/jquery.cookies.2.2.0.js"></script>
<title>MyStagingBox.com Registration Confirmation</title>
</head>
<body>
<header>
<dashboard>
</dashboard>
<logo>
<img alt="MyStagingBox.com" src="http://'.$_SERVER["SERVER_NAME"].'/images/msb-logo7.gif" border="0">
</logo>
</header>
<content>
<centercolumn>
<div id="sitenotice" style="display:show;" class="ui-state-default ui-corner-top">
MyStagingBox.com Registration Confirmation</div>
  <p></p>
<table id="content" class="ui-widget" width="240">
    <tr>
      <td>Thank you for registering with MyStagingBox.com, '.$loginid.'.	Click the "Activate My Account" button below to complete the registration process.
      <br><br>You will be automatically logged in and a member in good-standing.
      <br><br>

		MyStagingBox.com is the most technologically advanced event calendar currently on the Web.  Any new event listed is immediately available to all members.  No human intervention of any kind is required once it is listed through the "Add My Event" link on the left navigation column.
		<br><br>
		MyStagingBox.com is completely free.  The site is funded completely from donations and all donations are greatly appreciated.  You can read more about the site by reading the information displayed when you click the "Home" link in the left navigation box.
		<br><br>
		Thank you again for becoming the newest member, and for choosing, MyStagingBox.com as the calendar for all of your automotive-related events.
		<br><br>
      <form action="http://'.$_SERVER["SERVER_NAME"].'" method="POST">
		<input type="hidden" name="action" value="activate" />
		<input type="hidden" name="key" value="'.$key.'" />
		<input type="hidden" name="subscriberid" value="'.$subscriberid.'" />
		<input type="hidden" name="token" value="'.$token.'" />
		<input type="submit" class="ui-button ui-widget ui-state-default ui-corner-all" value="Activate My Account" />
		</form>
		<br><br>
      <form action="http://'.$_SERVER["SERVER_NAME"].'" method="GET">
		<input type="hidden" name="action" value="activate" />
		<input type="hidden" name="key" value="'.$key.'" />
		<input type="hidden" name="subscriberid" value="'.$subscriberid.'" />
		<input type="hidden" name="token" value="'.$token.'" />
		<input type="submit" class="ui-button ui-widget ui-state-default ui-corner-all" value="Activate My Account" />
		</form>
		<br><br>
		JT Atkinson
		<br>
		214-608-2748
      </td>
    </tr>
  </table>
</centercolumn>
</content>
</body>
</html>
';

// Always set content-type when sending HTML email
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// More headers

$headers .= 'To: '.$loginid.' <'.$email.'>' . "\r\n";
$headers .= 'From: JT@MyStagingBox.com <jt@mystagingbox.com>' . "\r\n";
$headers .= 'Bcc: jt@mystagingbox.com' . "\r\n";
//$message=wordwrap($message, 120, "\r\n");

//$result=;
	print_r(error_get_last());
	if (mail($to, $subject, $message, $headers))
	{
//		echo "result: ".$result."\n".$to."\n".$subject."\n".$message."\n".$headers."\n";
//		exit();
		$return['success'] = true;
		$return[error]='false';
		$return[msg]='You are now registered.  Please check your email for your registration confirmation and an activation link to complete the process. Once you click the link, your registration will be complete, and you will automatically be logged in.  Thank you for being the newest member at MyStagingBox.com.';
		$return[id] = 'sitenotice';
		echo json_encode($return);
	}
	else
	{
	//exit();
		echo "result: ".$result."\n".$to."\n".$subject."\n".$message."\n".$headers."\n";
		$return['success'] = false;
		$return['error'] = true;
		$return['msg'] = 'There was an error while processing your registration.';
		$return[id] = 'sitenotice';
		echo json_encode($return);
	}
	//send the email with an email containing the activation link to the supplied email address
	//display the success message

	//echo $query;

?>