<?php
	$pageheader = "Page Images Submit";
	require "../includes/header.inc.php";



	dbOpen();
		$qryPath = mysql_fetch_assoc(dbSelect("pageFolder,sectionFolder,groupFolder from cms_pages p join cms_sections s on p.sectionid=s.sectionid join cms_groups g on s.groupid=g.groupid where p.pageID=" . $_POST["pageID"]));
	dbClose();

	$path = "../../content/" . $qryPath["groupFolder"] . '/' . $qryPath["sectionFolder"] . '/' . $qryPath["pageFolder"] . "/images/";

	if (!file_exists($path)){// yes, PHP uses file_exists for folders too...
		mkdir($path);
		echo 'made new folder for images';
	}

	move_uploaded_file($_FILES["image"]["tmp_name"], $path . $_FILES["image"]["name"]);

	if ($_FILES["image"]["error"] == 1){
		die('<p align="center">UNABLE TO UPLOAD FILE: Uploaded file size exceeds the maximum allowed by the server.</p>');
	}else{
		dbOpen();
			mysql_query("
				insert into cms_pageImages(
					pageID,
					filesize,
					filename,
					imagedtsadd
				)values(
					" . $_POST["pageID"] . ",
					" . $_FILES["image"]["size"] . ",
					'" . $_FILES["image"]["name"] . "',
					CURDATE()
				)
			");
		dbClose();

		header('Location: /admin/pages/images.php?pageID=' . $_POST["pageID"]);
	}
?>
