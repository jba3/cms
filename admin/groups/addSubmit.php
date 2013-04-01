<?php
	require $_SERVER["DOCUMENT_ROOT"] . "/phpincludes/functions.inc.php";



	// database entry
	dbOpen();
		dbInsert("cms_groups(
			groupFolder,
			groupName,
			groupSortOrder,
			groupDateCreated,
			groupDateUpdated
		) VALUES(
			'" . $_POST["groupFolder"] . "',
			'" . $_POST["groupName"] . "',
			" . $_POST["groupSortOrder"] . ",
			CURDATE(),
			CURDATE()
		)");
	dbClose();

	// create the folder
	$dirNew = $_SERVER["DOCUMENT_ROOT"] . "/content/" . $_POST["groupFolder"];
	mkdir($dirNew) or die("Failed to create directory! (" . $dirNew . ")");

	dspSavedMessage("Group Added");
?>
