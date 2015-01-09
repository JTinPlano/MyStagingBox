<?php
/*
Host Name: hrsbutt52.db.5210461.hostedresource.com
Database Name: hrsbutt52
User Name: hrsbutt52
Database Password:  Marble52
*/
$connected = false;
$hostname = "hrsbutt52.db.5210461.hostedresource.com";
$username = "hrsbutt52";
$dbname = "hrsbutt52";
$db_host = "hrsbutt52.db.5210461.hostedresource.com";
$db_name = "hrsbutt52";
$db_login = "hrsbutt52";
$db_pswd = "Marble@52";
//echo "from mysql.php line 13 $db_host,$db_name,$db_login,$db_pswd, $connected<br>";
//exit();

$connected = false;
$db_host = "localhost";
$db_name = "hrsbutt";
$db_login = "root";
$db_pswd = "";


  function c()
  {
      global $db_host, $db_login, $db_pswd;

//      $link = mysql_connect("hrsbutt52.db.5210461.hostedresource.com", "hrsbutt52", "Marble@52") or die (mysql_error());
      $link = mysql_connect($db_host, $db_login, $db_pswd) or die (mysql_error());
		if (!$link)
		{
 //echo "from c() line 21 $db_host,$db_name,$db_login,$db_pswd, $connected<br>";
   		die('Not connected : ' . mysql_error());
		}
      $db_selected = mysql_select_db("hrsbutt",$link);
//      $db_selected = mysql_select_db("hrsbutt52",$link);
		if (!$db_selected) {
echo "from c() line 40 $db_host,$db_name,$db_login,$db_pswd, $connected<br>";
    		die ('Can\'t use foo : ' . mysql_error());
		}
		else
		{
	      $connected = true;
		}
//echo "from c() $db_host,$db_name,$db_login,$db_pswd, $connected<br>";
	return $link;
  }

 function q($q_str)
 {
    global $db_name, $connected;
    if(!$connected)
    {
//echo "line 50 from function q() $q_str<br>";
    	c();
    }

//echo "line 54 from function q() $q_str, $db_name, $connected<br>";
    $r = mysql_query($q_str);
    return $r;
 }

 function d($db)
 {
    @mysql_close($db);
 }

 function e($r)
 {
  if(@mysql_num_rows($r))
   return 0;
  else return 1;
 }

 function f($r)
 {
/* 	$i=0;
  while ($row=mysql_fetch_array($r))
  {
		foreach ($row as $k => $v)
		{
 			echo "line 78 from function f()$k = $v<br>";
 			$k = $v;
		}
	}
echo "line 82 from function f() $r<br>";
*/
	return @mysql_fetch_array($r);
 }

 function nr($r){
  return @mysql_num_rows($r);
 }
?>
