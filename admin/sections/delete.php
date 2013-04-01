<?php
	$pageheader = "Page Photos";
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.inc.php";



	dbOpen();
		$qryPath = dbSelect("groupFolder,sectionFolder from `cms_groups` g join `cms_sections` s on g.groupid=s.groupid where sectionID=" . $_GET["sectionID"]);
		dbDelete("cms_sections where sectionID=" . $_GET["sectionID"]) or die(mysql_error());
	dbClose();



	$dirBase = $_SERVER["DOCUMENT_ROOT"] . "/content/" . mysql_result($qryPath, 0, 0) . "/" . mysql_result($qryPath, 0, 1);

	rmdir($dirBase) or die("Unable to delete the folder" . $dirBase);



	echo '<p align="center">Section deleted</p>';

	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/footer.inc.php";
?>
