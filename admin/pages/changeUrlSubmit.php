<?php
	require $_SERVER["DOCUMENT_ROOT"] . "/phpincludes/functions.inc.php";



	dbOpen();
		dbUpdate("update cms_pages set pageFolder='$_POST[pageFolderNew]' where pageID=$_POST[pageID]");
		$qryPath = dbSelect("groupFolder,sectionFolder from cms_groups g join cms_sections s on g.groupid=s.groupid join cms_pages p on s.sectionid=p.sectionid where pageID=$_POST[pageID]");
	dbClose();

	$path = "../content/$qryPath[groupFolder]/$qryPath[sectionFolder]/";

	rename($path . $_POST["pageFolder"], $path . $_POST["pageFolderNew"]);



	dspSavedMessage("Page URL Updated");
?>