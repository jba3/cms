<?php
	include_once $_SERVER["DOCUMENT_ROOT"] . "/custom/settings.inc.php";
	include_once $_SERVER["DOCUMENT_ROOT"] . "/phpincludes/functions.inc.php";
	include_once $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/security-check.php";
	include_once $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/image-manipulation.php";



	dbOpen();
		$qryPath = dbSelect("groupFolder,sectionFolder,pageFolder from `cms_groups` g join `cms_sections` s on g.groupid=s.groupid join `cms_pages` p on s.sectionid=p.sectionid where pageID=" . $_POST["pageID"]);
	dbClose();

	// path information
	$dirBase = $_SERVER["DOCUMENT_ROOT"] . "/content/" . mysql_result($qryPath, 0, 0) . "/" . mysql_result($qryPath, 0, 1) . "/" . mysql_result($qryPath, 0, 2);

	$pathLarge = $dirBase . "/large/";
	$pathThumb = $dirBase . "/thumb/";

	// save the file
	$imageRemote = $_POST['remoteURL'];
	$imageLocal  = imagecreatefromjpeg($imageRemote);

	$imageFileName = end(explode("/", $imageRemote));

	imagejpeg($imageLocal, $pathLarge . $imageFileName);
	imagejpeg($imageLocal, $pathThumb . $imageFileName);

	// vars to paths
	$newThumbFile = $pathThumb . $imageFileName;
	$newLargeFile = $pathLarge . $imageFileName;

	// image isn't accessible to apache since it was saved by php .. fix permissions
	chmod($newThumbFile, 0777);
	chmod($newLargeFile, 0777);

	// set image sizes
	$sizeThumb = 120;
	$sizeLarge = 640;

	// fix the thumbnail size
	resizeImageTo($newThumbFile, $newThumbFile, $sizeThumb, $sizeThumb);
	resizeImageTo($newLargeFile, $newLargeFile, $sizeLarge, $sizeLarge);

	// add the database entry
	dbOpen();
		dbInsert("
			cms_pagePhotos(
				imageFilename,
				caption,
				filesize,
				sortOrder,
				photodtsAdd,
				photodtsMod,
				pageID
			)values(
				'" . $imageFileName . "',
				'" . $imageFileName . "',
				" . filesize($newLargeFile) . ",
				0,
				CURDATE(),
				CURDATE(),
				" . $_POST["pageID"] . "
			)
		");		
	dbClose();



	header('Location: /admin/pages/photos/remoteFile.php?pageID=' . $_POST['pageID'] . '&msgType=info&msg=Remote file ' . $imageFileName . ' added to the gallery');
?>
