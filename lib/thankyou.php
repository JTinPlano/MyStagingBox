<?php
require("common.php");
commonHeader($glbl_SiteTitle);
?>

<center><p>
<b>Your request has been received. Thank you!</b><p>

<a href="./?LocationID=<?php echo $LocationID; ?>">Click here to return to the calendar</a>
<p></center>

<?php
commonFooter();
?>
