<?php
//connect to the database so we can check, edit, or insert data to our subscriber table
$con = mysql_connect('localhost', 'root', '') or die(mysql_error());
$db = mysql_select_db('hrsbutt', $con) or die(mysql_error());
session_name('_hrsbutt');
session_start();
include "../includes/functions.php";
include "../lib/system.php";
makecookie();
//include out functions file giving us access to the protect() function
//Check to see if the form has been submitted

//allow sessions to be passed so we can see if the user is logged in
if (!isset($_SESSION))
{
	//allow sessions to be passed so we can see if the user is logged in
	session_start();
}
foreach($_POST as $k => $v)
{
	echo $k." = ".$v,"<br />\n";
		$$k=$v;
}
foreach($_COOKIE as $k => $v)
{
//	echo $k." = ".$v,"<br />\n";
}
/*
foreach($_SESSION as $k => $v)
{
	echo $k." = ".$v,"<br />\n";
}
foreach($_COOKIE as $k => $v)
{
	echo $k." = ".$v,"<br />\n";
}
*/
//print_r($_SESSION);
//print_r($_COOKIE);
//connect to the database so we can check, edit, or insert data to our users table
$con = mysql_connect('localhost', 'root', '') or die(mysql_error());
$db = mysql_select_db('hrsbutt', $con) or die(mysql_error());
//include out functions file giving us access to the protect() function made earlier
//echo md5('other');
//get the key that is being checked and protect it before assigning it to a variable
//		echo $key;
//		$key = protect($_GET['key']);
//		echo $key;
		//check if there was no key found
		if(!$key)
		{
			//if not display error message
			echo "<center>Unfortunatly there was an error there!</center>";
		}
		else
		{
			//otherwise continue the check
			//select all the rows where the accounts are not active
			$sid=explode(":",$key);
			$query= "SELECT * FROM `subscriber` WHERE `active` = '0' and `subscriberid` = $sid[0] ";
			echo "$query<br>";
			$res = mysql_query($query);
			//loop through this script for each row found not active
			while($row = mysql_fetch_array($res))
			{
				//check if the key from the row in the database matches the one from the user
				;
				if($key == $row['key'])
				{
					//if it does then activate their account and display success message
					$query="UPDATE `subscriber` SET `active` = '1', `confirmed` = 1, `online` = 1 WHERE `key` = '".$row['key']."'";
			echo "$query<br>";
					$res1 = mysql_query($query);
					echo "<center>You have successfully activated your account and you are now logged in.</center>";
					$_COOKIE['sid']=$sid[0];
					$_COOKIE['key']=$key;
					$_COOKIE['loggedin']="true";
				}
			}
		}
$filename = "create-account.php";
$handle = fopen($filename, "r+");
$contents = fread($handle, filesize($filename));
fclose($handle);
print $contents;
