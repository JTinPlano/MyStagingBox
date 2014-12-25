<?php
	//	The base64_encode function MUST BE replaced with
	//	crypt(...) UNIX/LINUX .. function!
require_once ($_SERVER["DOCUMENT_ROOT"]."/lib/mysql.php");
require_once ($_SERVER["DOCUMENT_ROOT"]."/includes/defines.php");
//require_once ($_SERVER["DOCUMENT_ROOT"]."/lib/common.php");
if(!isset($_SESSION))
{
//	session_start();
}
/*
	function parse_post()
	{
		foreach ($_POST as $k => $v)
		{
			if (is_numeric($k))
			{
				continue;
			}
			echo "$k = $v<br>";
			$_SESSION[$k] = $v;
		}
	}
	function parse_session()
	{
		foreach ($_SESSION as $k => $v)
		{
			if (is_numeric($k))
			{
				continue;
			}
			echo "$k = $v<br>";
		}
	}

	function buildnav ($table, $target)
	{

	}
*/
	function decode ($separator,$thiscookie)
	{
		$cookie=explode('$separator',$thiscookie);
		return ($cookie);
	}

	function geteventid()
	{
		$query="select eventid from events where showopen=1";
		$event=f(q($query));
		if($event[eventid]=='')
		{
			return (0);
		}
//echo "eventid $event[eventid]<br />";
		return ($event[eventid]);
	}

	function geteventrule()
	{
		$query="select rule from events where showopen=1";
		$event=f(q($query));
		if($event[rule]=='')
		{
			return (0);
		}
//echo "rule $event[rule]<br />";
		return ($event[rule]);
	}

	function makeyear($year="")
	{
		$start=1913;
		$end=date("Y");
		if (date("m")>8)
		{
			$end=$end+1;
		}
		$select="<select name=\"year\">";

		while ($end>$start)
		{
			$year==$end?$selected="selected":$selected="";
			$select.="<option value=\"$end\" $selected>$end</option>\n";
			$end--;
		}
		$select.="</select>";
		return $select;
	}

	function next_id($table, $id)
	{
		$query="select MAX($id) as max from $table";
		$result=f(q($query));
		$id=$result['max'];
//echo "line 96 $id<br>";
		$id++;
//echo "line 98 $id<br>";
		return ($id);
	}
/*
	function makecategory($category="")
	{
		$category==""?$where=" WHERE parentid=0:$where=" WHERE parentid=$category";
		$query_cat = "SELECT catid, parentid , catname FROM vehicle $where";
		$cat = mysql_query($query_cat) or die(mysql_error());

		$select="<select name=\"category\">";

		while ($row_cat = mysql_fetch_array($cat))
		{
			$row_cat[category]==$category?$selected="selected":$selected="";
			$select.="<option value=\"$catid\" $selected>$row_cat[catname]</option>";
			$end--;
		}
		$select.="</select>";
		return $select;
	}
*/
   function sysGetSmallImage($url, $alt = "")
   {
	   global $width, $height;
	   $max_width = 100;

	   if (!($d = @fopen ($url, 'r')))
	   	return;
      else
      {
         fclose($d);
         $size = GetImageSize ($url);
         if ($size[2] == "")
         	return "<img src=$url width=$width height=$height border=0 alt=\"Format is not supported!\">\n";
         else
         {
            if ($size[0] > $max_width)
            {
               $ratio = $size[0] / $max_width;
               $width = $max_width;
               $height = ceil ($size[1] / $ratio);
               return "<img src=$url width=$width height=$height border=0".(($alt=="")?(""):(" alt=\"$alt\"")).">\n";
            }
            else
            {
               $width = $size[0];
               $height = $size[1];
               return "<img src=$url width=$width height=$height border=0".(($alt=="")?(""):(" alt=\"$alt\"")).">\n";
            }
         }
      }
   }
    function sysGetThumbnail($url, $alt = "", $max_width = 100, $max_height = 99)
    {
    global $width, $height;
    $out = array();
    if (!($d = @fopen ($url, 'r'))) return;
        else {
            fclose($d);

            $size = GetImageSize ($url);
            if ($size[2] == "") return "<img src=$url width=$width height=$height border=0 alt=\"Format is not supported!\">\n";
            else {
                if ($max_width >= $max_height)
                {
                if ($size[0] > $max_width){
                    $ratio = $size[0] / $max_width;
                    $width = $max_width;
                    $height = ceil ($size[1] / $ratio);
                    return "<img src=$url width=$width height=$height border=0".(($alt=="")?(""):(" alt=\"$alt\"")).">\n";
                } else {
                    $width = $size[0];
                    $height = $size[1];
                    return "<img src=$url width=$width height=$height border=0".(($alt=="")?(""):(" alt=\"$alt\"")).">\n";
                }
                }
                else
                {
                if ($size[1] > $max_height){
                    $ratio = $size[1] / $max_height;
                    $height = $max_height;
                    $width = ceil ($size[0] / $ratio);
                    return "<img src=$url width=$width height=$height border=0".(($alt=="")?(""):(" alt=\"$alt\"")).">\n";
                } else {
                    $width = $size[0];
                    $height = $size[1];
                    return "<img src=$url width=$width height=$height border=0".(($alt=="")?(""):(" alt=\"$alt\"")).">\n";
                }
                }
            }
        }
    }
    function sysGetThumbnailSized($url, $alt = "", $max_width = 100, $max_height = 100)
    {
    global $width, $height;
    $out = array();
    if (!($d = @fopen ($url, 'r'))) return -1;
        else {
            fclose($d);
            $size = GetImageSize ($url);
            if ($size[2] == "") return -1;
            else {
                if ($max_width >= $max_height)
                {
                if ($size[0] > $max_width){
                    $ratio = $size[0] / $max_width;
                    $width = $max_width;
                    $height = ceil ($size[1] / $ratio);
                } else {
                    $width = $size[0];
                    $height = $size[1];
                }
                }
                else
                {
                if ($size[1] > $max_height){
                    $ratio = $size[1] / $max_height;
                    $height = $max_height;
                    $width = ceil ($size[0] / $ratio);
                } else {
                    $width = $size[0];
                    $height = $size[1];
                }
                }
            }
        }
        $out[0] = $width;
        $out[1] = $height;
        return $out;
    }
	function sysGetMonth($i)
	{
		switch($i)
		{
			case 2:
				return "Feb";
			case 3:
				return "Mar";
			case 4:
				return "Apr";
			case 5:
				return "May";
			case 6:
				return "June";
			case 7:
				return "July";
			case 8:
				return "Aug";
			case 9:
				return "Sep";
			case 10:
				return "Oct";
			case 11:
				return "Nov";
			case 12:
				return "Dec";
			default:
				return "Jan";
		}
	}  //  sysGetMonth

	function sysGetProfileCode($fMemb = 1)
	{
		global $fMember;

		if($fMemb == 1)
		{
			$fMemb = $fMember;
		}

		return strtoupper($fMemb[ login ][ 0 ]).str_repeat("0", 6 - strlen($fMemb[ id ])).$fMemb[ id ];
	}  //  sysGetProfileCode

	function sysGetCheckboxesIn2Cols($val_name, $table_name, $select = 1, $display_field = "name", $val_field = "id")
	{
		$rResult = q("select $display_field, $val_field from $table_name order by $display_field");

		$sTmp = 1;
		$is_selected = "";

		if($select)
		{
			eval("global \$$val_name;");
		}

		$i = 0;
		$was_row = 0;

		while($fRecord = f($rResult))
		{
			$i++;

			if($i == 1)
			{
				echo "<tr>\n";
				$was_row = 0;
			}

			if($select)
			{
				eval("\$sTmp = \$".$val_name."[".$fRecord[ $val_field ]."];");

				$is_selected = "";

				if($sTmp == 1)
				{
					$is_selected = " checked";
				}
			}


			echo "<td><input value=1 type=checkbox name=".$val_name."[".$fRecord[ $val_field ]."]$is_selected> ".$fRecord[ $display_field ]."</td>\n";

			if($i == 2)
			{
				echo "</tr>\n";

				$i = 0;
				$was_row = 1;
			}
		}

		if(!$was_row)
		{
			echo "</tr>\n";
		}

	}  //  sysGetCheckboxes

	function sysGetCheckboxes($val_name, $table_name, $select = 1, $display_field = "name", $val_field = "id")
	{
		$rResult = q("select $display_field, $val_field from $table_name order by $display_field");

		$sTmp = 1;
		$is_selected = "";

		if($select)
		{
			eval("global \$$val_name;");
		}

		while($fRecord = f($rResult))
		{
			if($select)
			{
				eval("\$sTmp = \$".$val_name."[".$fRecord[ $val_field ]."];");

				$is_selected = "";

				if($sTmp == 1)
				{
					$is_selected = " checked";
				}
			}

			echo "<input value=1 type=checkbox name=".$val_name."[".$fRecord[ $val_field ]."]$is_selected> ".$fRecord[ $display_field ]."<br>\n";
		}
	}  //  sysGetCheckboxes

   function sysGetNumberSelect($val_name, $from, $to, $empty_item = 1, $select = -1)
   {
      echo "\n<select class='text ui-widget-content ui-corner-all' name='$val_name'>\n";

      $sTmp = "";

      if($empty_item)
      {
         echo "<option value=''></option>\n";
      }

      if($select == -1)
      {
         eval("global \$$val_name;");
         eval("\$sTmp = \$$val_name;");
      }
      else
      {
          $sTmp = $select;
      }

      if($from < $to)
      {

         for($i = $from; $i <= $to; $i++)
         {
            echo "<option value='$i'".($sTmp == $i ? " selected" : "").">$i</option>\n";
         }
      }
      else
      {
         for($i = $from; $i >= $to; $i--)
         {
            echo "<option value='$i'".($sTmp == $i ? " selected" : "").">$i</option>\n";
         }
      }

      echo "</select>\n";

   }  //  sysGetNumberSelect

   function sysGetDaySelect($val_name, $empty_item = 0, $select = -1)
   {
      $dow=array(
			"0" => "Sun",
			"1" => "Mon",
			"2" => "Tue",
			"3" => "Wed",
			"4" => "Thu",
			"5" => "Fri",
			"6" => "Sat");

      $sTmp = date('w');

		echo "\n<select class='text ui-widget-content ui-corner-all' name='$val_name'>\n";

		if($empty_item)
		{
			echo "<option value=''>Select One</option>\n";
		}

		if($select == -1)
		{
			eval("global \$$val_name;");
			eval("\$sTmp = \$$val_name;");
		}
      else
      {
         $sTmp = $select;
      }

      for($i = 0; $i < 7; $i++)
      {
         echo "<option value='$i'".($sTmp == $i ? " selected" : "").">$dow[$i]</option>\n";
      }
        echo "</select>\n";

   }  //  sysGetDaySelect

	function sysGetSelect($val_name, $table_name, $empty_item = 1, $select = -1, $display_field = "name", $val_field = "id")
	{
//echo "$val_name, $table_name, $empty_item, $select, $display_field, $val_field<br>";
$query="select $display_field, $val_field from $table_name order by $val_field";
//echo "$query<br>";
		echo "\n<select class='text ui-widget-content ui-corner-all' id='$val_name' name='$val_name'>\n";

		$sTmp = "";

		if($empty_item)
		{
			echo "<option value=''>Select One</option>\n";
		}

		if($select == -1)
		{
			eval("global \$$val_name;");
			eval("\$sTmp = \$$val_name;");
		}
        else
        {
            $sTmp = $select;
        }
		$rResult = q($query);
		if(!$rResult){echo "error<br>$query<br>".mysql_error()."<br>";}
		while($fRecord = f($rResult))
		{
			echo "<option value='".$fRecord[$val_field]."'".($sTmp == $fRecord[$val_field] ? " selected" : "").">".$fRecord[$display_field]."</option>\n";
		}

		echo "</select>\n";

	}  //  sysGetSelect

	function sysGetValSelect($val_name, $table_name, $empty_item = 1, $select = -1, $display_field = "name", $val_field = "id")
	{

		echo "\n<select name='$val_name'>\n";

		$sTmp = "";

		if($empty_item)
		{
			echo "<option value=''>Select One</option>\n";
		}

		if($select == -1)
		{
			eval("global \$$val_name;");
			eval("\$sTmp = \$$val_name;");
		}
      else
      {
         $sTmp = $select;
      }

		$rResult = q("select $display_field, $val_field from $table_name order by $display_field");

		while($fRecord = f($rResult))
		{
			echo "<option value='".$fRecord[$display_field]."'".($sTmp == $fRecord[$display_field] ? " selected" : "").">".$fRecord[$display_field]."</option>\n";
		}

		echo "</select>\n";

	}  //sysGetValSelect

function has_user_birthday($profile_id, $date = 0)
{
	if(!$date){ $date = time(); }
	$query = "select birth_day, birth_month, birth_year from dt_profile where id = '$profile_id'";
	$brth = f(q($query));
	$b_day = (int)$brth["birth_day"];
	$b_mon = (int)$brth["birth_month"];
	$t_day = (int)date("d", $date);
	$t_mon = (int)date("m", $date);

	if(($b_day == $t_day) && ($b_mon == $t_mon))
	{
		return true;
	}
	return false;
}

function get_birthday_list($date = 0)
{
	if(!$date){ $date = time(); }
	$b_list = array();
	$brth = f(q($query));
	$t_day = (int)date("d", $date);
	$t_mon = (int)date("m", $date);
	$query = "select * from dt_profile where birth_day = '$t_day' and birth_month = '$t_mon'";
//	echo $query;
	$res = q($query);
	while($row = f($res))
	{
		$b_list[$row["id"]] = $row;
	}
	return $b_list;
}

//copies of function for member management plugin

function sysMGetNumberSelect($name, $from, $to, $def = "")
{
?>
	<select name="<?php  echo $name?>">
		<option value="0" selected>--------
<?php
	for($i = $from; $i < $to + 1; $i++)
	{
		$sel = "";
		if($i == $def) {	$sel = " selected";}
?>
		<option value="<?php  echo $i?>"<?php  echo $sel?>><?php  echo $i?>
<?php
	}
?>
</select>
<?php
}

function sysMGetSelect($name, $table_name, $def_value = "")
{
?>
<select name="<?php  echo $name?>">
		<option value="0" selected>--------
<?php
	$query = "select * from $table_name";
	$rst = q($query);
	while($row = f($rst))
	{
		$sel = "";
		if($def_value == $row["id"]) $sel = " selected";
?>
		<option value="<?php  echo $row["id"]?>"<?php  echo $sel?>><?php  echo $row["name"]?>
<?php
	}
?>
</select>
<?php
}

//and of copies of function for member management plugin

function sysGetMultSelect($name, $table_name, $size=3,  $def_value = array())
{
	if(!(gettype($def_value) == "array"))
		$def_value = array($def_value);
?>
<select name="<?php  echo $name?>[]" multiple size="<?php  echo $size?>">
<?php
	$query = "select * from $table_name";
	$rst = q($query);
	while($row = f($rst))
	{
		$sel = "";
		if(in_array($row["id"], $def_value)) $sel = " selected";
?>
		<option value="<?php  echo $row["id"]?>"<?php  echo $sel?>><?php  echo $row["name"]?>
<?php
	}
?>
</select>
<?php
}


 	function sysCrypt($str)
	{
	 	return base64_encode($str);
	}

	function sysIsTrustedId($sUserId)
	{
		global $admin_id, $nUserId;

		$nRes = 0;

		if($sUserId == $admin_id)
		{
			$nRes = 1;
		}
		else
		{
			//	Checking user ID in the database
			$rUsers = q("select id, status from webDate_bd_users where id='$sUserId'");

			if(!e($rUsers))
			{
				//	User exists
				//	Checking 'status' value:
				//		0 - Normal, access to login will be granted
				//		1 - Access is denied by administrator
				//		2 - System must forward user to change his password to new one.

				$fUser = f($rUsers);

				switch($fUser[ status ])
				{
					case 0:
						$nRes = 1;
						break;

					case 1:
						//	H100 error
						sysH100Error();
						break;

					case 2:
						//	Redirect user to CHANGE PASSWORD page
						$nUserId = $fUser[ id ];
						sysUserChangePassword();
						break;
				}
			}
		}

		return $nRes;
	}

	function sysIsTrustedUser($sUserLogin, $sUserPswd)
	{
		global $admin_login, $admin_pswd, $admin_id;

		$sRes = "";
		$sCryptedPassword = sysCrypt($sUserPswd);

//			$sRes = $admin_id;

		if($sUserLogin == $admin_login && $sCryptedPassword == $admin_pswd)
		{
			//	User is a system administrator
			$sRes = $admin_id;
		}
		else
		{
			//	Check common (not administrator) user in the database

			$rUsers = q("select id from webDate_bd_users where login='$sUserLogin' and pswd='$sCryptedPassword'");
			if(!e($rUsers))
			{
				$fTmpUser = f($rUsers);
				$sRes = $fTmpUser[ id ];
			}
		}

		return $sRes;
	}

	function sysTrustThisUser($sUserAuthString)
	{
		global $bd3Auth, $login, $user;

	 	setcookie("bd3Auth", $sUserAuthString);
		setcookie("bd3AuthDT", strtotime(date("d M Y H:i:s")));

		$bd3Auth = $sUserAuthString;

		$user = f(q("SELECT id, login, log_user, status FROM webDate_bd_users WHERE id='$bd3Auth'"));

		if($user[ login ] == "")
		{
			$user[ login ] = $login;
		}

		sysLogUserEvent(on_login);
	}

	function sysH100Error($l = "")
	{
		global	$login, $pswd, $system_log_file;
	 	header("Location: error.php".($l == "" ? "" : "?login=$l"));
		//sysLogUserEvent(h100, "(entered user name: $login, password: $pswd)", $system_log_file);
	}
	function sysFindModule($sPath)
	{
		if((@$pFile = @fopen($sPath, "r")))
		{
			fclose($pFile);
			return 1;
		}
		else
		{
			return 0;
		}

	}  //  sysFindModule

	function sysActivateService($sServiceName)
	{
	 	global $system_services_path, $sModule;
		global $system_kernel_services_path;
		global $sModuleLoadingStatus, $sLoadModuleRoutineType;
		global $sModuleFullPath;

		//	Variable $sModuleLoadingStatus is global
		//	and defines current status
		//	Then after calling this proc must be Service agent called

		$sFlag = 0;		//	FALSE - module not found.

		//	'sPlacesToFind' array defines full pathes, where engine will
		//	search for the module.

		$sPlacesToFind = array(
			1 => $system_services_path.$sServiceName, 				//	common php module
			2 => $system_services_path.$sServiceName.".xml", 		//	common xml module
			3 => $system_kernel_services_path.$sServiceName, 		//	kernel php module
			4 => $system_kernel_services_path.$sServiceName.".xml" //	kernel php module
		);

		while(list($k, $v) = each($sPlacesToFind))
		{
			if(sysFindModule($v))
			{
			 	//	Loading module through "Services Agent"

				$sModule = $v;
				$sModuleLoadingStatus = access_granted;

				//	Defining 'sLoadModuleRoutineType' for this module
				//	This value will choose what parser mechanism will use
				//	backdoor 3.0

				switch($k)
				{
					case 1:
					case 3:
						$sLoadModuleRoutineType = common;
						break;
					case 2:
					case 4:
						$sLoadModuleRoutineType = xml;
						break;
				}

				$sModuleFullPath = $v;

				return;
			}
		}

	 	//	Module does not exists
		$sModuleLoadingStatus = module_not_found;
	}

	function sysGetLoggedUserName()
	{
		global $nLoggedAsRoot, $user, $admin_login;

		if($nLoggedAsRoot && !$user)
		{
			//	User is an administrator
			return $admin_login;
		}
		else
		{
			//	Single user logged in
			return $user[ login ];
		}

	}  //  sysGetLoggedUserName

	function sysLogUserEvent($sEventType, $sAddInfo = "", $sLogFile = "")
	{
		global $system_log_path, $system_log_format, $system_log_file_extension;
		global $user, $system_log_file, $REMOTE_ADDR, $admin_login, $system_log_h100, $system_logs_error;

		//	Checking input params and configuration
		if($system_log_format == "" || ($user[ login ] == "" && $sLogFile == ""))
		{
			return;
		}

		//	Now checking user's logging configuration
		//	If value doesn't exist in the database then break logging
		//  ---------------------------------------------------------
		//	Cancel to log an adminstrator
		//	Provide system log messages without any checking in the
		//	users database .. no sence.

		if($user[ login ] == $admin_login)
		{
			return;
		}

		$sTmpEvent = $sEventType;

		if($sLogFile == "" && $user[ id ] != "")
		{
			if(!$user[ log_user ])
			{
				return;
			}

			if($sEventType == on_logout)
			{
				$sEventType = on_login;
			}

			$fLogInfo = f(q("select $sEventType from webDate_bd_log where uid='$user[id]'"));

			if(!((int)$fLogInfo[ $sEventType ]))
			{
				return;
			}
		}

		$sEventType = $sTmpEvent;

		//	Gathering path to the future log file to $sLogFile variable
		//	and trying to open it
		$sLogFile = $system_log_path.($sLogFile == "" ? $user[ login ] : $sLogFile).$system_log_file_extension;


		$pHandle = @fopen($sLogFile, "at");

		if(!$pHandle)
		{
			//	Opening log file falied
			//	Saving this error to the system log file.
			sysLogUserEvent(error_on_open_log, "for user: $user[login]", $system_log_file);
			return;
		}

		$sAction = "";

		switch($sEventType)
		{
			case error_on_open_log:
				if(!$system_logs_error)
				{
					return;
				}

				$sAction = "Error to open log file";
				break;

			case h100:
				if(!$system_log_h100)
				{
					return;
				}

				$sAction = "H100. Invalid Login or Password";
				break;

			case on_error:
				$sAction = "Error!";
				break;

		    case on_login:
				$sAction = "Logged in";
		   	    break;

			case on_logout:
				$sAction = "Logged out";
				break;

			case on_create:
				$sAction = "Create record";
				break;

			case on_edit:
				$sAction = "Edit record";
				break;

			case on_search:
				$sAction = "Search for records";
				break;

			case on_delete:
				$sAction = "Delete record";
				break;

			case on_loading_module:
				$sAction = "Launch module";
				break;

			default:
				$sAction = "Unknown event";
		}

		$sLog = $system_log_format;

		$sLog = ereg_replace("{DATE}", date("d.m.y"), $sLog);
		$sLog = ereg_replace("{TAB}", "\t", $sLog);
		$sLog = ereg_replace("{TIME}", date("H:i:s"), $sLog);
		$sLog = ereg_replace("{REMOTE_IP}", $REMOTE_ADDR, $sLog);
		$sLog = ereg_replace("{ACTION}", $sAction, $sLog);
		$sLog = ereg_replace("{ADD_INFO}", $sAddInfo, $sLog);
		$sLog .= "\n";

		fwrite($pHandle, $sLog, strlen($sLog));
		fclose($pHandle);

	}  //  sysLogUserEvent

	function sysGetLogFilenameForUser($sUsername = "")
	{
		global $system_log_path, $system_log_file_extension, $user;
		return $system_log_path.($sUsername == "" ? $user[ login ] : $sUsername).$system_log_file_extension;

	}  //  sysGetLogFilenameForUser

	function sysUserChangePassword()
	{
		global $login, $nUserId;

		$sLink = base64_encode("action=change_password&user_id=$nUserId");

		setcookie("bd3AuthFlag", base64_encode($nUserId));
		header("Location: index.php?$sLink");

	}  //  sysUserChangePassword

	function sysIsBD3AuthFlagTrue()
	{
		global $bd3AuthFlag, $user_id;
		$bd3AuthFlag = base64_decode($bd3AuthFlag);
		return !($bd3AuthFlag == "" || $bd3AuthFlag != $user_id);

	}  //  sysIsBD3AuthFlagTrue

	function sysListDir($sDir)
	{
		$x = 0;

		if(is_dir($sDir))
		{
			$sThisDir = dir($sDir);
			while($sEntry = $sThisDir->read())
			{
				if(($sEntry != '.') && ($sEntry != '..'))
				{
					if(is_dir($sDir.$sEntry))
					{
						$sResult[ $x ] = $sEntry;
						$x++;
					}
				}
			}
		}
		return $sResult;

	}  //  sysListDir

	function sysActivateObject($sObjectName)
	{
		@include "services/objects/$sObjectName.object";

	}  //  sysActivateObject
?>
