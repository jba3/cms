<?php
	require $_SERVER["DOCUMENT_ROOT"] . "/phpincludes/functions.inc.php";



	dbOpen();
		dbUpdate("
			cms_sections
			SET		sectionName = '$_POST[sectionName]',
					sectionSortOrder = '$_POST[sectionSortOrder]',
					sectionDateUpdated = CURDATE()
			WHERE	sectionID=$_POST[sectionID]
		");
	dbClose();



	dspSavedMessage("Section Updated");
?>
