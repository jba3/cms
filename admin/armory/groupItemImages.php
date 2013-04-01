<?php
	$pageheader = "Armory Item Images";
	require "../includes/header.inc.php";



	// path references
	$thisPhotoDir = $_SERVER["DOCUMENT_ROOT"] . '/custom/armory/';

	// grab all files starting with the ID of the item
	$arrayPhotos = glob($thisPhotoDir . $_GET['armoryID'] . "-*.jpg");
	$countPhotos = count($arrayPhotos);



	echo '<form action="/admin/armory/groupItemImagesSubmit.php" method="post" enctype="multipart/form-data" id="frmAdmin">';
	echo '	<input type="hidden" name="groupID"  value="' . $_GET["groupID"] . '">';
	echo '	<input type="hidden" name="armoryID" value="' . $_GET["armoryID"] . '">';
	echo '	<table align="center" class="form">';
	echo '		<tr>';
	echo '			<td class="label">Image:</td>';
	echo '			<td class="required"><input type="file" name="image"></td>';
	echo '			<td class="transparent">';
	echo dspButtonSave("Upload Image");
	echo '			</td>';
	echo '		</tr>';
	echo '	</table>';
	echo '</form>';

	echo '<p align="center">' . $countPhotos . ' images in path ' . $thisPhotoDir . ' </p>';

	foreach($arrayPhotos as $photoName){
		$arrayPath = explode("/", $photoName);
		echo '<p align="center"><strong>' . end($arrayPath) . '</strong><br><img height="120" width="120" src="/custom/armory/' . end($arrayPath) . '">';
		echo '<br><a href="groupItemImagesDelete.php?filename=' . end($arrayPath);
		echo '&groupID=' . $_GET['groupID'];
		echo '&armoryID=' . $_GET['armoryID'];
		echo '">Delete</a></p> ';
	}



	require "../includes/footer.inc.php";
?>
