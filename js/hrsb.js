function traffic ()
{
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-24054246-2']);
	_gaq.push(['_setDomainName', 'none']);
	_gaq.push(['_setAllowLinker', true]);
	_gaq.push(['_trackPageview']);

(function()
{
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})
();
}

		function logoutindex()
		{
	 		document.cookie = 'loggedin=false';
			document.location.href='/';
			$.unblockUI();
		}
		function logoutlive()
		{
	 		document.cookie = 'loggedin=false';
			document.location.href='/liveindex.php';
			$.unblockUI();
		}
$( "#addevent" ).button();
$( "#schedule" ).button();
$( "#demoaddevent" ).button();
$( "#demoschedule" ).button();

function loadContent(elementSelector, sourceUrl)
{
	$(""+elementSelector+"").load(""+sourceUrl+"");
}

function updateTip( t )
{
	document.getElementById('tip').innerHTML=t;
	$('this').addClass( "ui-state-highlight" );
}

function checkLength( o, n, min, max )
{
	if ( o.val().length > max || o.val().length < min )
	{
		o.addClass( "ui-state-error" );
		updateTip( "Length of " + n + " must be between " + min + " and " + max + "." );
		$('#o').focus();
		return false;
	}
	else
	{
		return true;
	}
}

function areEqual (exp1, exp2)
{
	if(exp1.val() != exp2.val())
	{
		exp1.addClass ("ui-state-error");
		exp2.addClass ("ui-state-error");
		updateTip ( "The passwords entered are not the same." );
		$('#exp1').focus();
		return false;
	}
	else
	{
		return true;
	}
}

function checkRegexp( k, o, regexp, n )
{
	if ( !( regexp.test( o.val() ) ) )
	{
		o.addClass( "ui-state-error" );
		updateTip( n );
		$('#o').focus();
		return false;
	}
	else
	{
		return true;
	}
}

function isblank( o, n, min, max )
{
	if ( o.val().length < min )
	{
		o.addClass( "ui-state-error" );
		updateTip( n + " must be at least " + min + " alphanumeric characters." );
		$('#o').focus();
		return false;
	}
	else
	{
		return true;
	}
}
	$( ".jTip").button(
	{
		icons:
		{primary:"ui-icon-info"},
		text: false
	})

