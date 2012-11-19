<?php
	require $_SERVER["DOCUMENT_ROOT"] . "/phpincludes/functions.inc.php";



	dbOpen();
		dbInsert("
			cms_sections(
				groupID,
				sectionFolder,
				sectionName,
				sectionSortOrder,
				sectionDateCreated,
				sectionDateUpdated
			)VALUES(
				'$_POST[groupID]',
				'$_POST[sectionFolder]',
				'$_POST[sectionName]',
				'$_POST[sectionSortOrder]',
				CURDATE(),
				CURDATE()
			)
		");

		// get path info
		$qryGroup = dbSelect("groupFolder from cms_groups where groupID=" . $_POST["groupID"]);
	dbClose();

	// create the folder
	mkdir($_SERVER["DOCUMENT_ROOT"] . "/content/" . mysql_result($qryGroup, 0, 0) . '/' . $_POST["sectionFolder"]) or die("unable to create the directory");



	dspSavedMessage("Section added to group");
?>
