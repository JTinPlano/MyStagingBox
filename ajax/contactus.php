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
//		echo "line 15 $k = $v<br />\n";
		$$k = $v;
		if (($k=='myemail' || $k== 'contactmessage')  && $v=='')
		{
			$return['success'] = false;
			$return['error'] = true;
			$return['msg'] = 'A blank email address or message cannot be sent.';
			$return['id'] = 'contacttip';
			echo json_encode($return);
			return;
		}

	}
$message=nl2br($message);
//	exit();
$query="select contacttype from contacttype where contacttypeid='$subject'";
//echo $query."<br />";
	$result = f(q($query));
	$subject = $result['contacttype']." - MyStagingBox.com Contact Us Form Submission";
//echo $subject;
//exit();
	$content = '
<html dir="LTR" lang="en-us">
<head>
	<title>MyStagingBox.com Contact Us</title>
	<link type="text/css" href="http://'.$_SERVER["SERVER_NAME"].'/css/jquery-ui-1.8.14.dark-hive.css" rel="stylesheet" />
	<link type="text/css" href="http://'.$_SERVER["SERVER_NAME"].'/css/prod.css" rel="stylesheet" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="http://'.$_SERVER["SERVER_NAME"].'/js/jquery-ui-1.8.14.dark-hive.min.js"></script>
	<link type="text/css" href="http://'.$_SERVER["SERVER_NAME"].'/css/tooltip.css" rel="stylesheet" />
	<script type="text/javascript" src="http://'.$_SERVER["SERVER_NAME"].'/js/hrsb.js"></script>
	<script type="text/javascript" src="http://'.$_SERVER["SERVER_NAME"].'/js/jquery.cookies.2.2.0.js"></script>
	</head>
	<body>
	<header>
<img alt="MyStagingBox.com" src="http://'.$_SERVER["SERVER_NAME"].'/images/msb-logo7.gif" border="0">
	</header>
	<table>
	<tr><td>
		'.$subject.'<br /><br />'.$message.'<br /><br />
	</td></tr>
	</table>
	</body>
	</html>';

	// Always set content-type when sending HTML email
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$headers .= 'X-Mailer: php';
	// More headers
$to='jt@mystagingbox.com';
//$headers .= 'Bcc: jt@mystagingbox.com' . "\r\n";
$headers .= 'To: '.$to.'' . "\r\n";
$headers .= 'From: '.$from.'' . "\r\n";
$headers .= 'CC: '.$from.'' . "\r\n";

//	$result=mail('jt@mystagingbox.com', $subject, $message, $headers);

	//send the email with an email containing the activation link to the supplied email address
	//display the success message
//echo "to ".$to."<br />";
//echo "from ".$from."<br />";
//echo "subject ".$subject."<br />";
//echo "header: ".$headers."<br />";
//echo "message ".$content."<br />";
//exit();
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
	//echo $query;

?>