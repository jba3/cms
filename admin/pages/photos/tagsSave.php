<?php
	include_once $_SERVER["DOCUMENT_ROOT"] . "/custom/settings.inc.php";
	include_once $_SERVER["DOCUMENT_ROOT"] . "/phpincludes/functions.inc.php";
	include_once $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/security-check.php";

	dbOpen();
		for ($x = 0; $x < count($_POST['photoID']); $x++){
			dbUpdate("cms_pagePhotos set tags='" . $_POST['tags'][$x] . "' where photoID=" . $_POST['photoID'][$x]);
		}
	dbClose();

	header('Location: /admin/pages/photos/tags.php?pageID=' . $_POST['pageID'] . '&msgType=info&msg=Photo tags saved, at ' . now());
?>
