<?php
	require $_SERVER["DOCUMENT_ROOT"] . "/phpincludes/functions.inc.php";



	// database
	dbOpen();
		dbUpdate("
			cms_groups
			SET		groupName = '$_POST[groupName]',
					groupSortOrder = '$_POST[groupSortOrder]',
					groupDateUpdated = CURDATE()
			WHERE	groupID=$_POST[groupID]
		");
	dbClose();



	dspSavedMessage("Group Updated");
?>
