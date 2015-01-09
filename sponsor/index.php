<?php
// sponsor/index.php

$_COOKIE['session']=$id[1];

session_name('_hrsb_msb');

include ($_SERVER["DOCUMENT_ROOT"]."/includes/functions.php");
require($_SERVER["DOCUMENT_ROOT"]."/includes/defines.php");
require($_SERVER["DOCUMENT_ROOT"]."/lib/mysql.php");
require($_SERVER["DOCUMENT_ROOT"]."/lib/system.php");

/*	sponsor table
  `adid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sponsorid` int(10) unsigned NOT NULL,
  `subscriberid` int(11) unsigned NOT NULL,
  `listdate` date NOT NULL,
  `paid` date NOT NULL,
  `expires` date NOT NULL,
  `views` int(11) NOT NULL,
  `clicks` int(11) NOT NULL,
  `siteurl` varchar(48) NOT NULL,
  `imageurl` varchar(48) NOT NULL,
*/
if (isset ($_GET))
{
	foreach ($_GET as $k -> $v)
	{
		$$k = $v;
	}
//$query = "select * from sponsor where
}
?>