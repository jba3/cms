<?php
	$pageheader = "Delete Image";
	require "../includes/header.inc.php";



	dbOpen();
		$qryPage = mysql_fetch_assoc(dbSelect("pageFolder,sectionFolder,groupFolder from cms_pages p join cms_sections s on p.sectionid=s.sectionid join cms_groups g on s.groupid=g.groupid where pageID=" . $_GET["pageID"]));
		$qryImage = mysql_fetch_array(dbSelect("filename from cms_pageImages where imageID=" . $_GET["imageID"]));

		dbDelete("cms_pageImages WHERE imageID=$_GET[imageID]");
	dbClose();

	$path = "../../content/" . $qryPage["groupFolder"] . '/' . $qryPage["sectionFolder"] . '/' . $qryPage["pageFolder"] . '/images/';

	unlink($path . $qryImage["filename"]);



	header('Location: /admin/pages/images.php?pageID=' . $_GET["pageID"]);
?>
