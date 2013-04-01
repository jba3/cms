<?php
	$pageheader = "Add Armory Image";
	require "../includes/header.inc.php";



	// path references
	$thisPhotoDir = $_SERVER["DOCUMENT_ROOT"] . '/custom/armory/';

	// grab all files starting with the ID of the item
	$arrayPhotos = glob($thisPhotoDir . $_POST['armoryID'] . "-*.jpg");
	$countPhotos = count($arrayPhotos);

	if (file_exists($thisPhotoDir) && is_writable($thisPhotoDir)) {
	    // do upload logic here
		move_uploaded_file(
			$_FILES["image"]["tmp_name"],
			$_SERVER["DOCUMENT_ROOT"] . "/custom/armory/" . $_POST['armoryID'] . '-' . $countPhotos . '.jpg'
		);
	}
	else {
		if (!(file_exists($thisPhotoDir))){
			echo 'Upload directory does not exist!';
		}
		if (!(is_writable($thisPhotoDir))){
		    echo 'Upload directory is not writable!';
		}
	}



	header('Location: /admin/armory/groupItemImages.php?groupID=' . $_POST["groupID"] . '&armoryID=' . $_POST["armoryID"]);
?>
