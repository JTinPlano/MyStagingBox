<?php

function protect($string){
	return (trim(strip_tags(addslashes($string))));
}

function makecookie()
{
	session_start();
//	echo "<br />\nprint_r SESSION = ";
//	print_r($_SESSION);
	//time of register (unix)
	$expires=date('U')+(3600*24*7);	 // 1 hour * hours/day * number of days
	$registerTime = date('U');	 // used to create unique key value

	//make a code for our activation key
//	$code = $registerTime.":".md5($username);

	//setcookie ( string $name [, string $value [, int $expire = 0 [, string $path [, string $domain [, bool $secure = false [, bool $httponly = false ]]]]]] )
	$code = date('U');

	//echo $thissession."<br />\n";
	$path='/';
	$domain='.localhost';
	$secure = 'false';
	$httponly = 'false';
/*
	$_COOKIE['name']="_msbox";
	$_COOKIE['value']=$code;
	$_COOKIE['expire']=$expires;
	$_COOKIE['path']=$path;
	$_COOKIE['domain']=$domain;
	$_COOKIE['secure']=$secure;
	$_COOKIE['httponly']=$httponly;
	$_COOKIE['code']= $code.":".md5($loginid);
*/
	if(!setcookie ( "_msbox", $code, $expires, $path, $domain, $secure, $httponly))
	{
	//	echo "session failed<br>";
	}
	else
	{
//	echo "<br />\nprint_r = ";
	//	print_r($_COOKIE);
	$_COOKIE['name']="_msbox";
	$_COOKIE['value']=$code;
	$_COOKIE['expire']=$expires;
	$_COOKIE['path']=$path;
	$_COOKIE['domain']=$domain;
	$_COOKIE['secure']=$secure;
	$_COOKIE['httponly']=$httponly;
	$_COOKIE['code']= $code.":".md5($loginid);
	$_COOKIE['lifetime']= 3600*24*7;
	$_COOKIE['session']=SID;
//	echo "<br />\nprint_r COOKIE = ";
	//	print_r($_COOKIE);
	}

	$thiscookie=session_get_cookie_params();
	//allow sessions to be passed so we can see if the user is logged in
//	echo "<br />\nthiscookie = ";
//	print_r($thiscookie);
/*
	echo "<br />\nprint_r SERVER = ";
		print_r($_SERVER);
	echo "<br />\n";
	print_r($_SESSION);
	echo "<br />\n";
	echo $thissession."<br />\n";
	print_r($_COOKIE);
	echo "<br />\n";
	foreach ($_POST as $k=>$v)
	{
		//	echo "$k=$v<br />\n";
		$$k=$v;
	}
	foreach ($_COOKIE as $k1=>$v1)
	{
			echo "$k1=$v1<br />\n";
		$$k1=$v1;
	}
*/
}

