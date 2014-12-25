<?php
	$current=date("Y"); // to track year for OuterTab
	$i=1; //	used to assign tab ID's for Level1-$i tabs

?>
<!DOCTYPE HTML>
<html dir="LTR" lang="en-us">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Description" content="MyStagingBox.com is the perfect staging area for all things hot rod.  If it's a hot rod happening, you'll find it here.">
<meta name="Keywords" content="hot, rod, muscle, car, classic, show, calendar, schedule, cruise, night, all things, hot rod happening, corvette, mustang, camaro, chevelle, roadrunner, charger, challenger, cuda, hemi, ls6, 454, 396, 427, 428, 429, cobra, super sport, boss, club, meeting">
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="7 days">
<script type="text/javascript" src="/js/jquery-ui-1.8.14.dark-hive.min.js"></script>
<script type="text/javascript">
	$(function()
	{
		$("a").click(function ()
		{
			$('#'+this.id+'-more').hide();
			$('#'+this.id+'-less').show();
			return false;
		});

 		$("#OuterTab").tabs();
<?php
	$offset=0;
	while ($i < 6)
	{
		$year=$current+$offset;
		$year==date("Y")?$month=date("m"):$month=1;
echo <<<OUTPUT
 		\$('#Level1-$i').load('calendar/current.php?tab=$i&month=$month&year=$year', function() {\$('#tab$i').tabs();})
OUTPUT;
		echo "\n";
		$i++;
		$offset++;
		$month++;
	}
?>

	});
traffic ();
</script>
</head>
<body>
  <div id="OuterTab">
    <ul>
<?php
	$i=1;
	while ($i < 6)
	{
echo <<<OUTPUT
      <li><a href="#Level1-$i" title="Level1-$i"><span>$current</span></a></li>
OUTPUT;
		$current++;
		$i++;
		echo "\n";
	}
/*
echo <<<OUTPUT
      <li><a href="#Level1-$i" title="Level1-$i"><span>Archive</span></a></li>
OUTPUT;
		echo "\n";
*/
?>
    </ul>
<?php
	$i=1;
	while ($i < 7)
	{
echo <<<OUTPUT
      <div id="Level1-$i"><!-- tab$i --></div>
OUTPUT;
		$i++;
		echo "\n";
	}
?>
  </div>
</body></html>