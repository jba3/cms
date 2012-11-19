<?php
	include_once $_SERVER["DOCUMENT_ROOT"] . "/custom/settings.inc.php";
	include_once $_SERVER["DOCUMENT_ROOT"] . "/phpincludes/functions.inc.php";
	include_once $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/security-check.php";

	dbOpen();
		foreach($_GET["recordsArray"] as $key=>$value){
			dbUpdate('cms_pagePhotos set sortOrder=' . $key . ' where photoID=' . $value);
		}
	dbClose();

	echo 'Sorting updated';
?>
