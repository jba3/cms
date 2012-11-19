<?php
	$pageheader = "Page Photos";
	require "includes/header.inc.php";

	mysql_connect($application_dbserver, $application_dbuser, $application_dbpass) or die(mysql_error());
	mysql_select_db($application_dbname) or die(mysql_error());

	$qryComments = mysql_query("select commentID,entryName,entryEmail,entryEmailHide,entryComment,entryDtsAdd,isApproved from cms_pageComments where pageID=" . $_GET["pageID"] . " order by isApproved,entryComment");

	mysql_close();

	$qryCommentsCount = mysql_num_rows($qryComments);

	echo '<p align="center"><strong>' . $qryCommentsCount . '</strong> comments on this page.</p>';
	echo '<p align="center">Sorting is done based on the comment text - so that we can find patterns to eliminate junk with.</p>';

	$formAction = "page-comments-submit.php";

	require "partials/comments-approve.php";

	require "includes/footer.inc.php";
?>
