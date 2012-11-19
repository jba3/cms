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

//echo count($_FILES['upload']);

	//Loop through each file
	for($i=0; $i<count($_FILES['upload']); $i++) {
		//Get the temp file path
		$tmpFilePath = $_FILES['upload']['tmp_name'][$i];

		//Make sure we have a filepath
		if ($tmpFilePath != ""){
			//Setup our new file path
			$newFilePath = $pathLarge . $_FILES['upload']['name'][$i];

			//Upload the file into the temp dir
			if(move_uploaded_file($tmpFilePath, $newFilePath)) {
				//Handle other code here

				//copy as thumbnail
				copy($pathLarge . $_FILES['upload']['name'][$i], $pathThumb . $_FILES['upload']['name'][$i]);

				// save the file
//				$imageRemote = $newFilePath;
//				$imageLocal  = imagecreatefromjpeg($imageRemote);
				$imageFileName = $_FILES['upload']['name'][$i];//end(explode("/", $imageRemote));
//				imagejpeg($imageLocal, $pathLarge . $imageFileName);
//				imagejpeg($imageLocal, $pathThumb . $imageFileName);

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
							" . $_FILES['upload']['size'][$i] . ",
							0,
							CURDATE(),
							CURDATE(),
							" . $_POST["pageID"] . "
						)
					");		
				dbClose();
			}
		}
	}

//	echo '<pre>';
//	print_r($_POST);
//	print_r($_FILES);
//	echo '</pre>';

//	echo '<hr>done';

//	dbOpen();
//		for ($x = 0; $x < count($_POST['photoID']); $x++){
//			dbUpdate("cms_pagePhotos set caption='" . $_POST['comments'][$x] . "' where photoID=" . $_POST['photoID'][$x]);
//		}
//	dbClose();

	header('Location: /admin/pages/photos/index.php?pageID=' . $_POST['pageID'] . '&msgType=info&msg=Photos uploaded, at ' . now());
?>
