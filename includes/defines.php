<?php
/* define("CONSTANT", "Hello world."); */
/* global */
if ($_SERVER['HTTP_HOST']=="hrsb.localhost")
{
	define ("ENV", "dev");
	define ("DBHOST", "localhost");
	define ("DBUSERNAME", "root");
	define ("DBPASSWORD", "");
	define ("DBNAME", "hrsbutt");
}
elseif ($_SERVER['HTTP_HOST']=="prod.localhost")
{
	define ("ENV", "prod");
	define ("DBHOST", "localhost");
	define ("DBUSERNAME", "root");
	define ("DBPASSWORD", "");
	define ("DBNAME", "hrsbutt");
}
elseif ($_SERVER['HTTP_HOST']=="live.localhost")
{
	define ("ENV", "prod");
	define ("DBHOST", "localhost");
	define ("DBUSERNAME", "root");
	define ("DBPASSWORD", "");
	define ("DBNAME", "hrsbutt");
}
else
{
	#	sql205.byethost12.com
	#	b12_7855334
	define ("ENV", "live");
	define ("DBHOST", "sql205.byethost12.com/");
	define ("DBUSERNAME", "b12_7855334");
	define ("DBPASSWORD", "marble52");
	define ("DBNAME", "b12_7855334_hrsbutt");
}
//	_SERVER["DOCUMENT_ROOT"]	/var/chroot/home/content/m/y/s/mystaging/html
//	_ENV["DOCUMENT_ROOT"]	/var/chroot/home/content/m/y/s/mystaging/html
//	_SERVER["TMPDIR"]	/var/chroot/home/content/m/y/s/mystaging/tmp
//	_SERVER["PHPRC"]	/var/chroot/home/content/m/y/s/mystaging/html
//	_SERVER["TEMP"]	/var/chroot/home/content/m/y/s/mystaging/tmp


define ("HOST", $_SERVER["HTTP_HOST"]);
define ("SERVER", $_SERVER["SERVER_NAME"]);
define ("FS_ROOT", $_SERVER["DOCUMENT_ROOT"]);
define ("FS_INCLUDES", FS_ROOT."/includes/");
define ("FS_CSS", FS_ROOT."/css/");
define ("FS_IMAGES", FS_ROOT."/images/");
define ("FS_LIB", FS_ROOT."/lib/");
define ("FS_JS", FS_ROOT."/js/");
define ("FS_TEMP", FS_ROOT."/tmp/");
//	define ("FS_", FS_ROOT."//");
//	define ("FS_", FS_ROOT."//");
define ("WS_ROOT", $_SERVER["HTTP_HOST"]);
define ("WS_INCLUDES", WS_ROOT."/includes/");
define ("WS_CSS", WS_ROOT."/css/");
define ("WS_IMAGES", WS_ROOT."/images/");
define ("WS_LIB", WS_ROOT."/lib/");
define ("WS_JS", WS_ROOT."/js/");
define ("WS_TEMP", WS_ROOT."/tmp/");
//	define ("WS_", WS_ROOT."//");
//	define ("WS_", WS_ROOT."//");

/* OK to here
define ("", "");
echo ."<br />";
*/
?>