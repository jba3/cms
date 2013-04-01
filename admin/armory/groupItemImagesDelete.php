<?php
	$pageheader = "Delete Armory Image";
	require "../includes/header.inc.php";



	unlink($_SERVER["DOCUMENT_ROOT"] . '/custom/armory/' . $_GET["filename"]);



	header('Location: /admin/armory/groupItemImages.php?groupID=' . $_GET["groupID"] . '&armoryID=' . $_GET["armoryID"]);
?>
