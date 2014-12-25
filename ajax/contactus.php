<?php
/**
 * @author Marijan Šuflaj <msufflaj32@gmail.com>
 * @link http://www.php4every1.com
 */
	require_once ("../lib/system.php");
	require_once ("../lib/mysql.php");
	require_once ("../lib/global.php");
	get_globals();
//print_r($_GET);
	$return[error]='false';
	$return['msg'] = '';
	foreach ($_POST as $k => $v)
	{
//		echo "line 63 $k = $v<br />\n";
	}
	$subject = "MyStagingBox.com Registration Activation";
	$from = $email;
	$message = "
	<!DOCTYPE HTML>
	<html dir='LTR' lang='en-us'>
	<head>
	<title>MyStagingBox.com Registration</title>
		<link type='text/css' href='$_SERVER[HTTP_HOST]/css/jquery-ui-1.8.14.dark-hive.css' rel='stylesheet' />
		<link type='text/css' href='$_SERVER[HTTP_HOST]/css/prod.css' rel='stylesheet' />
		<script type='text/javascript' src='http://code.jquery.com/jquery-1.7.2.min.js'></script>
		<script type='text/javascript' src='$_SERVER[HTTP_HOST]/js/jquery-ui-1.8.14.dark-hive.min.js'></script>
		<link type='text/css' href='$_SERVER[HTTP_HOST]/css/tooltip.css' rel='stylesheet' />
		<script type='text/javascript' src='$_SERVER[HTTP_HOST]/js/hrsb.js'></script>
		<script type='text/javascript' src='$_SERVER[HTTP_HOST]/js/jquery.cookies.2.2.0.js'></script>
		<script type='text/javascript' src='$_SERVER[HTTP_HOST]/js/jquery.blockUI.js'></script>
	<script type='text/javascript' src='$_SERVER[HTTP_HOST]/js/charCount.js'></script>
	<script type='text/javascript' src='$_SERVER[HTTP_HOST]/js/jTip.js'></script>
	</head>
	<body>
	<header>
	<logo><img alt='MyStagingBox.com' src='$_SERVER[HTTP_HOST]/images/hrsb-logo.gif' border='0'></logo>
	</header>
	<table>
	<tr><td>
	<div id='activate' title='Activate My Profile' style='display:inline;'>
		<span class='validateTip' id='logtip'></span>
		<form action='$_SERVER[HTTP_HOST]/profile/activate.php' method='post'>
		<fieldset>
			<input type='hidden' name='key' value='$key'>
			<input type='hidden' name='action' value='activate'>
			<input type='hidden' name='token' value='$token'>
			<input id='actacct' type='submit' class='ui-button ui-widget ui-state-default ui-corner-all' value='Activate My Profile'>
		</fieldset>
		</form>
	</div>
	</td></tr>
	<tr><td>Thank you again for becoming the newest subscriber to MyStagingBox.com, THE perfect staging area for ALL things hot rod.</td></tr>
	</table>
	</body>
	</html>";

	// Always set content-type when sending HTML email
	$headers = 'MIME-Version: 1.0\r\n';
	$headers .= 'Content-type:text/html;charset=UTF-8\r\n';

	// More headers
	$headers .= 'From: <noreply@mystagingbox.com>\r\n';
	$headers .= 'Bcc: jt@mystagingbox.com\r\n';

	$result=mail($to, $subject, $message, $headers);

	//send the email with an email containing the activation link to the supplied email address
	//display the success message

			$return[error]='false';
			$return[msg]='Please check your email for confirmation and an activation link.';
			$return[id] = 'sitenotice';
			echo json_encode($return);
	//echo $query;

?>