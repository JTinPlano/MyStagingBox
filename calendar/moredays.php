<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>change demo</title>
<style>
div {
color: black;
}
</style>
	<script type="text/javascript" src="../js/jquery-ui-1.8.14.dark-hive.min.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script language="javascript">
function multiday(days)
{
	var str = days.value;

    $.ajax({
        url : 'startstop2.php',
        data: { days: str },
        success: function(response) {
//            $('#').html(response);
				document.getElementById("numdays").innerHTML=response;
//				document.getElementById("myDIV").innerHTML="How are you?";
        }
    });
}
</script>
</head>
<body>
<select id="oneday" name="NumDays" class="text ui-widget-content ui-corner-all" onchange="multiday(this)">
<?php
	for ($i = 1; $i <8; $i++)
	{
		$i == $NumDays?$num="selected":$num="";
		echo "<option value=\"$i\" $num> $i </option>\n";
	}
?>
</select>



<div id="numdays" style="visibility:visible;"> numdays

		<input type="hidden" name="multiday" value="1">
<table width="100%" border="1">
<tr class="ui-widget">
	<td valign="top"><b>Start time:</b>
	</td>
	<td valign="top"><b>End time:</b>
	</td>
</tr>
<tr class="ui-widget">
	<td valign="middle">
		<select name="StartHour" class="text ui-widget-content ui-corner-all">
<?php
	for ($i = 1; $i <= 12; $i++)
	{
		$i == $StartHour?$starthr="selected":$starthr="";
		echo "<option value=\"$i\" $starthr> $i </option>\n";
	}
?>
</select>
&nbsp;:&nbsp;
<select name="StartMinute" class="text ui-widget-content ui-corner-all">
<?php
	for ($i = "00"; $i < 60; $i += 15)
	{
		if ($i < 10 AND !preg_match ("/^0/",$i))
		{
			$i = "0".$i;
		}
		$i == $StartMinute?$startmin="selected":$startmin="";
		echo "<option value=\"$i\" $startmin> $i </option>\n";
	}
?>
														</select>
<select name="StartPeriod" class="text ui-widget-content ui-corner-all">
<?php
	$StartPeriod == "AM"?$stopam="selected":$stoppm="selected";
	echo "<option value=\"AM\" $stopam> AM </option>\n";
	echo "<option value=\"PM\" $stoppm> PM </option>\n";
?>
</select>
			</td>
<td valign="top">
				<select name="EndHour" class="text ui-widget-content ui-corner-all">
<?php
	for ($i = 1; $i <= 12; $i++)
	{
		$i == $EndHour?$endhr="selected":$endhr="";
		echo "<option value=\"$i\" $endhr> $i </option>\n";
	}
?>
</select>
&nbsp;:&nbsp;
<select name="EndMinute" class="text ui-widget-content ui-corner-all">
<?php
	for ($i = "00"; $i < 60; $i += 15)
	{
		if ($i < 10 AND !preg_match ("/^0/",$i))
		{
			$i = "0".$i;
		}
		$i == $EndMinute?$endmin="selected":$endmin="";
		echo "<option value=\"$i\" $endmin> $i </option>\n";
	}
?>
</select>
<select name="EndPeriod" class="text ui-widget-content ui-corner-all">
<?php
	$EndPeriod == "AM"?$stopam="selected":$stoppm="selected";
	echo "<option value=\"AM\" $stopam> AM </option>\n";
	echo "<option value=\"PM\" $stoppm> PM </option>\n";
?>
</select>
	</td>
</tr>
</table>
</div>
</body>
</html>