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
$message=nl2br($message);
//	echo "line 16 sendmessage<br />".$message."<br />\n";
	$subject="Your friend at $from thought you might like this.";
//$message .= $subject."<br /><br/>".$message."<br /><br/>.";
//$to=$toemail;
//$from="noreply@mystagingbox.com";
//$subject="Subject";
	$content = '
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
	<table>
	<tr><td>
		'.$subject.'<br /><br />'.$message.'<br /><br />
	</td></tr>
	<tr><td>
		<form action = "http://'.$_SERVER["SERVER_NAME"].'">
		<input type="submit" value="Go to MyStagingBox.com" class="ui-button ui-widget ui-state-default ui-corner-all">
		</form>
	</td></tr>

	</table>
	</body>
	</html>';
// echo "content:<br />".$content;
// exit();
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
if (mail($to, $subject, $content, $headers))
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