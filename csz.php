<?php
require($_SERVER["DOCUMENT_ROOT"]."/lib/mysql.php");
// Cleaning up the term
$term = trim(strip_tags($_GET['term']));
if (!$term) return;

include ($_SERVER["DOCUMENT_ROOT"]."/includes/parse.php");
// insert the connection settings to your mysql database here!
/*
$con = mysql_connect('localhost', 'root', '');
if (!$con)
{
  die('Could not connect: ' . mysql_error());
}
mysql_select_db("hrsbutt52", $con);
*/
$term=$_GET['term'];
$index=0;
$query="select city, state, zipcode, zipid from zipcode where zipcode like '$term%' ORDER BY zipcode asc";
//echo $query."<br>\n";
$res = q($query);
//print (nr($res));
$zips=array();
if (nr($res)>0)
{

	while ($row = f($res))
	{
		$zips[$index++]= array("zipid"=>"$row[zipid]", "city"=>"$row[city]", "state"=>"$row[state]", "zip"=>"$row[zipcode]", 'value' => $row['zipcode'], 'label' => "{$row['zipcode']}");
//		echo "'$row[city]'";
//if ($state != "[") { echo ",";}
	}
}
// print_r($zips);

// Rudimentary search
$matches = array();
foreach($zips as $zip)
{
	if(stripos($zip['zip'], $term) !== false)
	{
//	print_r($zips);
//	print_r($zip);
		// Add the necessary "value" and "label" fields and append to result set
// JSON format template
//	code		$zip['value'] = $zip['zip'];
//	output	"value":"75201",
//		$zip['value'] = $zip['zip'];
// JSON format template
//	code		$zip['label'] = "{$zip['city']}, {$zip['state']} {$zip['zipcode']}";
//	output	"label":"Dallas, TX 75201"}]
//		$zip['label'] = "{$zip['city']}, {$zip['state']} {$zip['zip']}";
//		$matches = $zip;
	}
}

// final output  [{"city":"Dallas","state":"TX","zip":"75201","value":"75201","label":"Dallas, TX 75201"}]// Data could be pulled from a DB or other source
// final output   {"city":"COPPELL","state":"TX","zip":"75099","value":"75099","label":"COPPELL, TX 75099"}
// final output  [{"city":"Memphis","state":"TN","zip":"37501","value":"37501","label":"Memphis, TN 37501"}]
// Truncate, encode and return the results
	if (sizeof($zips)==0)
	{
		$zips = array(array('zipid'=>'', 'city'=>'', 'state'=>'', 'zipcode'=>'', $zip['value'] = "", $zip['label'] = "Invalid entry"));
	}
	else
	{
		$zips = array_slice($zips, 0, 20);
	}
print json_encode($zips);
