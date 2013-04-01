<?php
	include_once $_SERVER["DOCUMENT_ROOT"] . "/custom/settings.inc.php";
	include_once $_SERVER["DOCUMENT_ROOT"] . "/phpincludes/functions.inc.php";
	include_once $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/security-check.php";

	dbOpen();
		$qryPath = dbSelect("groupFolder,sectionFolder,pageFolder from `cms_groups` g join `cms_sections` s on g.groupid=s.groupid join `cms_pages` p on s.sectionid=p.sectionid where pageID=" . $_POST["pageID"]);
	dbClose();

	$dirBase = $_SERVER["DOCUMENT_ROOT"] . "/content/" . mysql_result($qryPath, 0, 0) . "/" . mysql_result($qryPath, 0, 1) . "/" . mysql_result($qryPath, 0, 2) . "/";

	foreach($_POST["rotateList"] as $key=>$value){
		// get filename
		dbOpen();
			$qryPhoto = dbSelect("photoID,imageFilename from cms_pagePhotos where photoID=" . $value);
		dbClose();

		// path info
		$thumb = $dirBase . 'thumb/' . mysql_result($qryPhoto, 0, 1);
		$large = $dirBase . 'large/' . mysql_result($qryPhoto, 0, 1);

		//rotate the thumb
		$source = imagecreatefromjpeg($thumb);
		$rotate = imagerotate($source, 270, 0);
		imagejpeg($rotate, $thumb);

		//rotate the large
		$source = imagecreatefromjpeg($large);
		$rotate = imagerotate($source, 270, 0);
		imagejpeg($rotate, $large);
	}

	header('Location: /admin/pages/photos/rotate.php?pageID=' . $_POST['pageID'] . '&msgType=info&msg=Photos rotated, at ' . now());
?>
