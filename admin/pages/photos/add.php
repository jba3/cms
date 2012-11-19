<?php
	$pageheader = "Page Photos";
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.inc.php";

	dbOpen();
		$qryPath = dbSelect("groupFolder,sectionFolder,pageFolder from `cms_groups` g join `cms_sections` s on g.groupid=s.groupid join `cms_pages` p on s.sectionid=p.sectionid where pageID=" . $_GET["pageID"]);

		$dir = $_SERVER["DOCUMENT_ROOT"] . "/content/" . mysql_result($qryPath, 0, 0) . "/" . mysql_result($qryPath, 0, 1) . "/" . mysql_result($qryPath, 0, 2) . "/large/";
		$countAddedPhotos = 0;

		echo '<p align="center">Adding photos for pageID=' . $_GET["pageID"] . ' from &quot;' . $dir . "&quot;...</p>";

		$newPhotos = scandir($dir);

		foreach($newPhotos as $file){
			if (filetype($dir . $file) == 'file'){
				// check for DB entry
				$qryCheckDB = dbSelect("photoID from cms_pagePhotos where pageID=" . $_GET["pageID"] . " and imageFilename='" . $file . "'");

				// add if not found
				if (empty($qryCheckDB) || mysql_num_rows($qryCheckDB) == 0){
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
							'" . $file . "',
							'" . $file . "',
							" . filesize($dir . $file) . ",
							" . ($countAddedPhotos + 1) * 10 . ",
							CURDATE(),
							CURDATE(),
							" . $_GET["pageID"] . "
						)
					");

					$countAddedPhotos += 1;

					echo "Added: $file<br/>";
				}
			}
		}

/*
//		if ($dh = opendir($dir)) {
		if ($dh = scandir($dir)) {
			while (($file = readdir($dh)) !== false) {
//			while (($file = scandir($dh)) !== false) {
				if (filetype($dir . $file) == 'file'){
					// check for DB entry
					$qryCheckDB = dbSelect("photoID from cms_pagePhotos where pageID=" . $_GET["pageID"] . " and imageFilename='" . $file . "'");

					// add if not found
					if (empty($qryCheckDB) || mysql_num_rows($qryCheckDB) == 0){
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
								'" . $file . "',
								'" . $file . "',
								" . filesize($dir . $file) . ",
								" . ($countAddedPhotos + 1) * 10 . ",
								CURDATE(),
								CURDATE(),
								" . $_GET["pageID"] . "
							)
						");

						$countAddedPhotos += 1;

						echo "Added: $file<br/>";
					}
				}
			}
			closedir($dh);
		}
*/

		if ($countAddedPhotos > 0){
			dbUpdate("cms_pages set photoSizeValidated = 0 where pageID=" . $_GET["pageID"]);
		}

	dbClose();

	echo '<p align="center">' . $countAddedPhotos . ' photos added.</p>';

	echo '<p align="center">';
	echo '	<a href="/admin/pages/photos/index.php?pageID=' . $_GET["pageID"] . '">Back to page photos</a>';
	echo '</p>';




	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/footer.inc.php";
?>
