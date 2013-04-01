<?php
	$pageheader = "Page Photos - Creating and resizing thumbnails";
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.inc.php";
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/image-manipulation.php";

	// lots of thumbnails takes a while
	// lets make the max execution 10 minutes since it's a one-time thing for admin only
	set_time_limit(600);
	$maxThumbnails = 50;

	dbOpen();
		$qryPath = dbSelect("groupFolder,sectionFolder,pageFolder from `cms_groups` g join `cms_sections` s on g.groupid=s.groupid join `cms_pages` p on s.sectionid=p.sectionid where pageID=" . $_GET["pageID"]);
		$qryPhotos = dbSelect("photoID,imageFilename from cms_pagePhotos where hasThumbnail=0 and pageID=" . $_GET["pageID"] . ' LIMIT ' . $maxThumbnails);
		$qryPhotosLeft = dbSelect("photoID from cms_pagePhotos where hasThumbnail=0 and pageID=" . $_GET["pageID"]);

		$dirLarge = $_SERVER["DOCUMENT_ROOT"] . "/content/" . mysql_result($qryPath, 0, 0) . "/" . mysql_result($qryPath, 0, 1) . "/" . mysql_result($qryPath, 0, 2) . "/large/";
		$dirThumb = $_SERVER["DOCUMENT_ROOT"] . "/content/" . mysql_result($qryPath, 0, 0) . "/" . mysql_result($qryPath, 0, 1) . "/" . mysql_result($qryPath, 0, 2) . "/thumb/";

		echo '<p align="center">Creating and resizing thumbnails...' . mysql_num_rows($qryPhotosLeft) . ' need to be created</p>';

		$image = new SimpleImage();
		$imageCount = 0;

		if (mysql_num_rows($qryPhotos) == $maxThumbnails){
			echo '<p align="center"><strong><em>NOTE: There were ' . $maxThumbnails . ' thumbnails created, THERE MAY BE MORE TO MAKE. A maximum of ' . $maxThumbnails . ' is created each time to avoid memory issues. THIS PAGE WILL RELOAD IF THERE ARE MORE TO MAKE!</em></strong></p>';
		}
		while ($rowPhotos = mysql_fetch_assoc($qryPhotos)) {
			$imageCount++;

			echo '#' . $imageCount . ' -- ' . $rowPhotos['imageFilename'] . ' (image ID#' . $rowPhotos['photoID'] . ')...';

			$image->load($dirLarge . $rowPhotos['imageFilename']);
			if ($image->getWidth() < $image->getHeight()){
				$image->resize( 90,120);
			}else{
				$image->resize(120, 90);
			}
			$image->save($dirThumb . $rowPhotos['imageFilename']);
			dbUpdate("cms_pagePhotos set hasThumbnail=1 where photoID=" . $rowPhotos['photoID']);

			echo ' done!<br>';
		}
		if (mysql_num_rows($qryPhotos) == $maxThumbnails){
			echo '<p align="center"><strong><em>NOTE: There were ' . $maxThumbnails . ' thumbnails created, THERE MAY BE MORE TO MAKE. A maximum of ' . $maxThumbnails . ' is created each time to avoid memory issues. THIS PAGE WILL RELOAD IF THERE ARE MORE TO MAKE!</em></strong></p>';
		}

/*
		if ($dh = opendir($dirLarge)) {
			while (($file = readdir($dh)) !== false) {
				if (filetype($dirLarge . $file) == 'file'){
					// check if the thumbnail exists - if it does, skip it
					if (file_exists($dirThumb . $file)){
						// thumbnail exists, do nothing
						echo $file . ' has thumbnail, skipping...<br/>';
					}else{

						$image->load($dirLarge . $file);
						if ($image->getWidth() < $image->getHeight()){
							$image->resize( 90,120);
						}else{
							$image->resize(120, 90);
						}
						$image->save($dirThumb . $file);

						echo 'Done: ' . $file . '<br/>';
					}
				}
			}
			closedir($dh);
		}
*/

	dbClose();

	if (mysql_num_rows($qryPhotos) == $maxThumbnails){
		echo '<script type="text/javascript">';
		echo "	location.href='/admin/pages/photos/thumbnails.php?pageID=" . $_GET["pageID"] . "';";
		echo '</script>';
	}

	echo '<p align="center">';
	echo '	<a href="/admin/pages/photos/index.php?pageID=' . $_GET["pageID"] . '">Back to page photos</a>';
	echo '</p>';

	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/footer.inc.php";
?>
