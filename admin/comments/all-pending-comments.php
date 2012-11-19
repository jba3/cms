<?php
	$pageheader = "All Pending Comments";
	require "../includes/header.inc.php";

	dbOpen();
		$qryComments = dbSelect("commentID,entryName,entryEmail,entryEmailHide,entryComment,entryDtsAdd,isApproved from cms_pageComments where isApproved=0 order by isApproved,entryComment");
	dbClose();

	$qryCommentsCount = mysql_num_rows($qryComments);

	echo '<p align="center"><strong>' . $qryCommentsCount . '</strong> comments are pending approval or deletion.</p>';
	echo '<p align="center">Sorting is done based on the comment text - so that we can find patterns to eliminate junk with.</p>';

	$formAction = "all-pending-comments-submit.php";

	require "../partials/comments-approve.php";

	require "../includes/footer.inc.php";
?>
