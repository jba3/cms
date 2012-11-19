<?php
	$pageheader = "Page Downloads (Submit)";
	require "../includes/header.inc.php";



	dbOpen();
		dbInsert("
			cms_pageDownloads(
				pageID,
				filesize,
				downloadText,
				filename,
				filedtsadd,
				filedtsmod
			)values(
				" . $_POST["pageID"] . ",
				" . $_FILES["download"]["size"] . ",
				'" . $_POST["downloadText"] . "',
				'" . $_FILES["download"]["name"] . "',
				CURDATE(),
				CURDATE()
			)
		");

		$qryPathSql = "pageFolder,sectionFolder,groupFolder from cms_pages p join cms_sections s on p.sectionid=s.sectionid join cms_groups g on s.groupid=g.groupid where p.pageID=" . $_POST["pageID"];
		$qryPath = mysql_fetch_assoc(dbSelect($qryPathSql));
	dbClose();



	$path = "../../content/" . $qryPath["groupFolder"] . '/' . $qryPath["sectionFolder"] . '/' . $qryPath["pageFolder"] . "/downloads/";

	if (!file_exists($path)){// yes, PHP uses file_exists for folders too...
		mkdir($path);
	}

	move_uploaded_file($_FILES["download"]["tmp_name"], $path . $_FILES["download"]["name"]);



	header('Location: /admin/pages/downloads.php?pageID=' . $_POST["pageID"]);
?>
