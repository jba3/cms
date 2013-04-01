<?php
	$pageheader = "Page Downloads (Delete)";
	require "../includes/header.inc.php";



	// database
	dbOpen();
		$qryPage = mysql_fetch_assoc(dbSelect("pageFolder,sectionFolder,groupFolder from cms_pages p join cms_sections s on p.sectionid=s.sectionid join cms_groups g on s.groupid=g.groupid where pageID=" . $_GET["pageID"]));
		$qryDownload = mysql_fetch_array(dbSelect("filename from cms_pageDownloads where downloadID=" . $_GET["downloadID"]));

		dbDelete("cms_pageDownloads WHERE downloadID=$_GET[downloadID]");
	dbClose();



	$path = "../content/" . $qryPage["groupFolder"] . '/' . $qryPage["sectionFolder"] . '/' . $qryPage["pageFolder"] . '/downloads/';

	unlink($path . $qryDownload["filename"]);



	header('Location: /admin/pages/downloads.php?pageID=' . $_GET["pageID"]);
?>
