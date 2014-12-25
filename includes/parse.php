<?php

function parse ($which, $print)
{
	if ($which=="get")
	{
		foreach ($_GET as $k => $v)
		{
			$$k=$v;
			if ($print==1)
			{
				echo "$k = $v<br />\n";
			}
		}
	}
	if ($which=="post")
	{
	echo "[";
		foreach ($_POST as $k => $v)
		{
echo "Parsing args.<br>\n";
			$$k=$v;
				echo "$k = $v<br />\n";
			if ($print==1)
			{
				echo '{ "id": "' . $k . '|' . $k . '", "label": "' . $k . '", "value": "' . $k . '"  }';
			}
		}
	echo "]";
	}
	if ($which=="session")
	{	
		foreach ($_SESSION as $k => $v)
		{
			$$k=$v;
			if ($print==1)
			{
				echo "$k = $v<br />\n";
			}
		}
	}
echo "Parsing complete.<br>\n";
}

?>