<?php
	require $_SERVER["DOCUMENT_ROOT"] . "/phpincludes/functions.inc.php";



	dbOpen();
		dbUpdate("cms_groups set groupFolder='$_POST[groupFolderNew]' where groupID=$_POST[groupID]");
	dbClose();

	$path = $_SERVER["DOCUMENT_ROOT"] . "/content/";

	rename($path . $_POST["groupFolder"], $path . $_POST["groupFolderNew"]);



	dspSavedMessage("Group URL Updated");
?>