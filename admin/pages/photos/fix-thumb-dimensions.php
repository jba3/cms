<?php
	$pageheader = "Page Photos - Adjusting size on thumb images";
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.inc.php";
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/image-manipulation.php";

	// lots of thumbnails takes a while
	// lets make the max execution 10 minutes since it's a one-time thing for admin only
	set_time_limit(600);
	$maxImages = 50;

	dbOpen();
		$qryPath = dbSelect("groupFolder,sectionFolder,pageFolder from `cms_groups` g join `cms_sections` s on g.groupid=s.groupid join `cms_pages` p on s.sectionid=p.sectionid where pageID=" . $_GET["pageID"]);
		$qryPhotos = dbSelect("photoID,imageFilename from cms_pagePhotos where validThumb=0 and pageID=" . $_GET["pageID"] . ' LIMIT ' . $maxImages);
		$qryPhotosLeft = dbSelect("photoID from cms_pagePhotos where validThumb=0 and pageID=" . $_GET["pageID"]);

		$dirLarge = $_SERVER["DOCUMENT_ROOT"] . "/content/" . mysql_result($qryPath, 0, 0) . "/" . mysql_result($qryPath, 0, 1) . "/" . mysql_result($qryPath, 0, 2) . "/large/";
		$dirThumb = $_SERVER["DOCUMENT_ROOT"] . "/content/" . mysql_result($qryPath, 0, 0) . "/" . mysql_result($qryPath, 0, 1) . "/" . mysql_result($qryPath, 0, 2) . "/thumb/";

		$image = new SimpleImage();
		$imageCount = 0;

		echo '<p align="center">' . mysql_num_rows($qryPhotosLeft) . ' images to manipulate</p>';

		if (mysql_num_rows($qryPhotos) == $maxImages){
			echo '<p align="center"><strong><em>NOTE: There were ' . $maxImages . ' images to adjust, THERE MAY BE MORE. A maximum of ' . $maxImages . ' is loaded each time to avoid memory issues. THIS PAGE WILL RELOAD IF THERE ARE MORE TO MAKE!</em></strong></p>';
		}
		while ($rowPhotos = mysql_fetch_assoc($qryPhotos)) {
			$imageCount++;

			echo '#' . $imageCount . ' -- ' . $rowPhotos['imageFilename'] . ' (image ID#' . $rowPhotos['photoID'] . ')...';

			$image->load($dirThumb . $rowPhotos['imageFilename']);
			if ($image->getWidth() < $image->getHeight()){
				$image->resize( 90,120);
			}else{
				$image->resize(120, 90);
			}
			$image->save($dirThumb . $rowPhotos['imageFilename']);
			dbUpdate("cms_pagePhotos set validThumb=1 where photoID=" . $rowPhotos['photoID']);

			echo ' done!<br>';
		}
		if (mysql_num_rows($qryPhotos) == $maxImages){
			echo '<p align="center"><strong><em>NOTE: There were ' . $maxImages . ' images to adjust, THERE MAY BE MORE. A maximum of ' . $maxImages . ' is loaded each time to avoid memory issues. THIS PAGE WILL RELOAD IF THERE ARE MORE TO MAKE!</em></strong></p>';
		}
	dbClose();

	if (mysql_num_rows($qryPhotos) == $maxImages){
		echo '<script type="text/javascript">';
		echo "	location.href='/admin/pages/photos/fix-thumb-dimensions.php?pageID=" . $_GET["pageID"] . "';";
		echo '</script>';
	}

	echo '<p align="center">';
	echo '	<a href="/admin/pages/photos/index.php?pageID=' . $_GET["pageID"] . '">Back to page photos</a>';
	echo '</p>';

	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/footer.inc.php";
?>
