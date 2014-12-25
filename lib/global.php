<?php #//v.1.0.0
/**
 * Copyright 2004 Advanced IT All Rights Reserved
 *
 * @version $Id:
 * @author JT Atkinson <jt@advancedit.com>
 *
 */

	//session_save_path("C:/wamp/tmp");
	//session_start();

	require_once($_SERVER["DOCUMENT_ROOT"]."/lib/mysql.php");
//	require_once($_SERVER["DOCUMENT_ROOT"]."/lib/config.php");
// $lang=get_language();
//	require_once("../languages/$lang.php");
	$server=$_SERVER["HTTP_HOST"];
//echo "Line 12 ".$server."<br>";
	$siteurl= "http://".$server."/";
	$adminemail="jt@mystagingbox.com";
	$sitename= "Trophies and Plaques";

//echo "Line 14 ".$siteurl."<br>";
   $includes = "../includes/";
	$upload_path = "../images/";
//echo "upload_path $upload_path<br />";
	$upload_URL = "/uploads/";
	$MAX_UPLOAD_SIZE = 75000;
    $MD5_PREFIX = "mar8l3";

	function upload_file($logo)
	{
		if(!empty($logo))
		{
			######################################################################################
			#// Change made by Gian sept. 11 2002 to solve the open_basedir problem
			#####################################i#################################################

			$TMP = pathinfo($logo);
//	$path_parts = pathinfo($logo);

//echo $path_parts['dirname'], "\n";
//echo $path_parts['basename'], "\n";
//echo $path_parts['extension'], "\n<br />";
			$tmpfile = $TMP[basename];
move_uploaded_file($logo, $_SERVER[DOCUMENT_ROOT]."/images/".$tmpfile);
//echo "uploading...<br />$logo, $_SERVER[DOCUMENT_ROOT]/images/$tmpfile<br />";
			$inf = getimagesize ($_SERVER[DOCUMENT_ROOT]."/images/".$tmpfile);
//echo "0 $inf[0] <br />1 $inf[1] <br />2 $inf[2] <br />3 $inf[3] <br />";

			$er = false;
			// make a check
			if ($inf)
			{
				$inf[2] = intval($inf[2]); // check for uploaded file type
				if ( ($inf[2]!=1) && ($inf[2]!=2) && ($inf[2]!=3) )
				{
					$er = true;
					$ERR = "Images must be GIF, JPG, or PNG";
				}
				else
				{
					// check for file size
					if ( intval($userfile_size) > $MAX_UPLOAD_SIZE )
					{
						$er = true;
						$ERR = "The image is too large.";
					}
				}
			}
			else
			{
				$ERR = "Images must be GIF, JPG, or PNG";
				$er = true;
			}
			if (!$er)
			{
				// really save this file
				if ($inf[2]==1){$ext = ".gif";}
				if ($inf[2]==2){$ext = ".jpg";}
				if ($inf[2]==3){$ext = ".png";}
				$fname = $_SERVER[DOCUMENT_ROOT]."/images/"."logo".$ext;
				$newimage[ext]=$ext;

				if ( file_exists($fname) )
				{
					unlink ($fname);
				}
				copy ( $_SERVER[DOCUMENT_ROOT]."/images/".$tmpfile, $fname );

				$uploaded_filename = "logo".$ext;
				$newimage=resize_image($fname);
//echo "$newimage[width],$newimage[height]<br />";
				$file_uploaded = true;
				$newimage[name]=$uploaded_filename;
				#// Delete temp file
				unlink($_SERVER[DOCUMENT_ROOT]."/images/".$tmpfile);
				#//
			}
			else
			{
				// there is an error
				unset($file_uploaded);
			}

		}
		else
		{
			$ERR = "ERR_602";
			$er = true;
		}
		return ($newimage);
	}

function resize_image($image)
{
//echo "Resizing image: $image<br />";
   // Some configuration variables !
   $localDir = $_SERVER['DOCUMENT_ROOT']."/images/";

   $AutorisedImageType = array ("jpg", "jpeg", "gif", "png", "tmp");


   $ext = substr($image, strpos($image, ".")+1, strlen($image));
//echo "$ext<br />";
   if( in_array($ext, $AutorisedImageType) )
   {

      list($width, $height, $type, $attr) = @getimagesize( $image );

      $xRatio = MAXWIDTH / $width;
      $yRatio = MAXHEIGHT / $height;

      if ( ($width <= MAXWIDTH) && ($height <= MAXHEIGHT) )
      {
        $newWidth = $width;
        $newHeight = $height;
      }
      else if (($xRatio * $height) < MAXHEIGHT)
      {
        $newHeight = ceil($xRatio * $height);
        $newWidth = MAXWIDTH;
      }
      else
      {
        $newWidth = ceil($yRatio * $width);
        $newHeight = MAXHEIGHT;
      }
//echo "width=".MAXWIDTH." <br />height=".MAXHEIGHT." <br />img src =$image <br />width=$newWidth <br />height=$newHeight <br />attr $attr<br />";
   }
   $newimage[width]=$newWidth;
   $newimage[height]=$newHeight;
   return($newimage);
}

	function create_id()
	{
		global $name, $description;
		$continue = true;
		$id = time();
		return $id;
	}

	function get_globals ()
	{
		global $classes, $entries, $firstname, $lastname, $ballot, $adminemail,$siteurl, $MD5_PREFIX, $includes, $images_dir, $upload_path, $upload_URL, $MAX_UPLOAD_SIZE, $ERR, $siteurl;
	}

	function print_money($str)
	{
		return "$ " . number_format($str,2,".",",");
	}

	function print_money_nosymbol($str)
	{
		return number_format($str,2,".",",");
	}

function formatdate($DATE)
{
	//GLOBAL $SETTINGS;

	$F_date = substr($DATE,6,2)."/".
				 substr($DATE,4,2)."/".
				 substr($DATE,0,4);
	return $F_date;
}

//-- Date and time handling functions

	function ActualDate()
	{
		//GLOBAL $SETTINGS;

		$month = date("m");
		switch($month)
		{
			case "01":
				$month = "Jan.&nbsp;";
				break;
			case "02":
				$month = "Feb.&nbsp;";
				break;
			case "03":
				$month = "Mar.&nbsp;";
				break;
			case "04":
				$month = "Apr.&nbsp;";
				break;
			case "05":
				$month = "May&nbsp;";
				break;
			case "06":
				$month = "Jun.&nbsp;";
				break;
			case "07":
				$month = "Jul.&nbsp;";
				break;
			case "08":
				$month = "Aug.&nbsp;";
				break;
			case "09":
				$month = "Sep.&nbsp;";
				break;
			case "10":
				$month = "Oct.&nbsp;";
				break;
			case "11":
				$month = "Nov.&nbsp;";
				break;
			case "12":
				$month = "Dec.&nbsp;";
				break;
		}

		$date = mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));
		//$year = date(" Y, H:i:s");
		return $month."&nbsp;".date("d, Y H:i:s", $date);
	}

	function ArrangeDate($day,$month,$year,$hours,$minutes)
	{

		//GLOBAL $SETTINGS;

		switch($month){
			case "01":
				$M = "Jan.&nbsp;";
				break;
			case "02":
				$M = "Feb.&nbsp;";
				break;
			case "03":
				$M = "Mar.&nbsp;";
				break;
			case "04":
				$M = "Apr.&nbsp;";
				break;
			case "05":
				$M = "May.&nbsp;";
				break;
			case "06":
				$M = "Jun.&nbsp;";
				break;
			case "07":
				$M = "Jul.&nbsp;";
				break;
			case "08":
				$M = "Aug.&nbsp;";
				break;
			case "09":
				$M = "Sep.&nbsp;";
				break;
			case "10":
				$M = "Oct.&nbsp;";
				break;
			case "11":
				$M = "Nov.&nbsp;";
				break;
			case "12":
				$M = "Dec.&nbsp;";
				break;
		}

		$DATE = mktime($hours,$minutes,0,$month,$day,$year);

		$return = $M."&nbsp;".date("d, Y - H:i",$DATE);
		if($hours != 0 && $minutes != 0)
		{
			$return = $M."&nbsp;".date("d, Y - H:i",$DATE);
		}
		else
		{
			$return = $M."&nbsp;".date("d, Y",$DATE);
		}
		return $return;
	}

	function ArrangeDateMesCompleto($day,$month,$year,$hours,$minutes)
	{
		//GLOBAL $SETTINGS;

		switch($month){
			case "01":
				$month = "January&nbsp;";
				break;
			case "02":
				$month = "February&nbsp;";
				break;
			case "03":
				$month = "March&nbsp;";
				break;
			case "04":
				$month = "April&nbsp;";
				break;
			case "05":
				$month = "May&nbsp;";
				break;
			case "06":
				$month = "June&nbsp;";
				break;
			case "07":
				$month = "July&nbsp;";
				break;
			case "08":
				$month = "August&nbsp;";
				break;
			case "09":
				$month = "September&nbsp;";
				break;
			case "10":
				$month = "October&nbsp;";
				break;
			case "11":
				$month = "November&nbsp;";
				break;
			case "12":
				$month = "December&nbsp;";
				break;
		}

		$DATE = mktime($hours,$minutes,0,$month,$day,$year);

		$return = $month."&nbsp;".date("d, Y - H:i",$DATE);
		if($hours && $minutes)
		{
			$return = $month."&nbsp;".date("d, Y - H:i",$DATE);
		}
		else
		{
			$return = $month."&nbsp;".date("d, Y",$DATE);
		}
		return $return;
	}


function count_cats()
{
	global $delete;
	$query = "SELECT * FROM categories ORDER BY cat_name ASC";
//print "Line 15 query = ".$query."<br>";
	$result = mysql_query($query) or die(mysql_error());
	if($result)
	{
	//print "Fire in the hole".mysql_num_rows($result)."<br>";;
		$delete="<a href=\"category.php?action=view\">Delete Category</a>";
	}
	else {$delete="";}
}

function view_categories()
{
	global $TPL_categories_list;
	$query = "SELECT * FROM categories ORDER BY cat_name ASC";
//print "Line 15 query = ".$query."<br>";
	$result = mysql_query($query) or die(mysql_error());
		while($row=mysql_fetch_array($result))
		{
			$cat.="<input type=\"radio\" name=\"category\" value=\"".$row['cat_name']."\">".$row['cat_name']."<br>\n";
		}
	$TPL_categories_list = $cat;
}

function logged_in($id, $pass, $admin)
{
//echo "Line 257 id ".$id." pass ".$pass." admin ".$admin."<br>";
	if($admin && $id && pass)
	{
/*
CREATE TABLE admin (
  admin_id int(11) NOT NULL default '0',
  name varchar(20) NOT NULL default '',
  password varchar(32) NOT NULL default '',
  email varchar(50) NOT NULL default '',
  PRIMARY KEY  (admin_id)
) TYPE=MyISAM;
*/
		$query = "select * from admin where admin_id='".$id."' and password='".md5($MD5_PREFIX.$pass)."' and admin=1";
//echo "Line 284 query ".$query."<br>";
		$res = mysql_query($query);
		//print $query;;
		if(mysql_num_rows($res) > 0)
		{
			$PHPAUCTION_LOGGED_IN_ADMIN = mysql_result($res,0,"admin_id");
			$PHPAUCTION_LOGGED_IN_ADMINNAME = $HTTP_POST_VARS[name];
			session_name($SESSION_NAME);
			session_register("PHPAUCTION_LOGGED_IN_ADMIN","PHPAUCTION_LOGGED_IN_ADMINNAME");
			return true;
		}
		else return false;
	}
//	Header("Location: $HTTP_REFERER");
//	exit;
}
?>