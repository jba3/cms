<?php
	$pageheader = "Delete Group";
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.inc.php";



	dbOpen();
		$qryPath = mysql_query("select groupFolder from `cms_groups` g where groupID=" . $_GET["groupID"]) or die(mysql_error());
		mysql_query("delete from cms_groups where groupID=" . $_GET["groupID"]) or die(mysql_error());
	dbClose();



	$dirBase = $_SERVER["DOCUMENT_ROOT"] . "/content/" . mysql_result($qryPath, 0, 0);

	rmdir($dirBase) or die("Unable to delete the folder " . $dirBase);



	echo '<p align="center">Group deleted!</p>';
	echo '<p align="center"><a href="/admin/sitemap/index.php">Site Content</a></p>';

	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/footer.inc.php";
?>
