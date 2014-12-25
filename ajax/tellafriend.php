<?php
/**
 * @author Marijan Šuflaj <msufflaj32@gmail.com>
 * @link http://www.php4every1.com
 */
require_once ("../lib/system.php");
require_once ("../lib/mysql.php");
require_once ("../lib/global.php");
get_globals();
	foreach ($_POST as $k => $v)
	{
//	echo "line 63 $k = $v\n";
		$$k = $v;
	}
//	echo "line 16 sendmessage<br />".$message."<br />\n";
	$subject="Your friend at $from thought you might like this.";
//$message .= $subject."<br /><br/>".$message."<br /><br/>.";
//$to=$toemail;
//$from="noreply@mystagingbox.com";
//$subject="Subject";
	$content = "
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
		$subject.$message<br /><br />.
	</td></tr>
	</table>
	</body>
	</html>";

	// Always set content-type when sending HTML email
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$headers .= 'X-Mailer: php';
// More headers

$headers .= 'Bcc: jt@mystagingbox.com' . "\r\n";
$headers .= 'To: '.$to.'' . "\r\n";
$headers .= 'From: '.$from.'' . "\r\n";
$headers .= 'CC: '.$from.'' . "\r\n";

	//send the email with an email containing the activation link to the supplied email address
	//display the success message

	//echo $query;

//echo "result ".$result."<br />";
//echo "to ".$to."<br />";
//echo "subject ".$subject."<br />";
//echo "message ".$content."<br />";
//echo "header: ".$headers."<br />";
//	exit();
if (mail($to, $subject, $message, $headers))
{
	$return['error'] = false;
	$return['msg'] = 'Your email has been sent, and a copy has been sent to you.  Click "Cancel" below to continue.';
	$return[id] = 'thisform';
}
else
{
	$return['error'] = true;
	$return['msg'] = 'Form processing halted for suspicious activity.';
	$return[id] = 'sitenotice';
}
echo json_encode($return);

?>