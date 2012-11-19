<?php
	require $_SERVER["DOCUMENT_ROOT"] . "/phpincludes/functions.inc.php";



	dbOpen();
		$qryGroup = mysql_fetch_assoc(dbSelect("groupFolder from cms_groups g join cms_sections s on g.groupid=s.groupid where sectionID=$_POST[sectionID]"));

		dbUpdate("cms_sections set sectionFolder='$_POST[sectionFolderNew]' where sectionID=$_POST[sectionID]");
	dbClose();

	$path = $_SERVER["DOCUMENT_ROOT"] . "/content/$qryGroup[groupFolder]/";

	rename($path . $_POST["sectionFolder"], $path . $_POST["sectionFolderNew"]) or die("Unable to rename the folder " . $path);



	dspSavedMessage("Section URL Updated");
?>
