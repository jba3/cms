<?php
	$pageheader = "Page Photos - Main";
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.inc.php";



	dbOpen();
		$qryPhotos = dbSelect("photoID,imageFilename,caption,filesize,sortOrder from cms_pagePhotos where pageID=" . $_GET["pageID"] . " order by sortOrder");
		$qryPath = dbSelect("groupFolder,sectionFolder,pageFolder from `cms_groups` g join `cms_sections` s on g.groupid=s.groupid join `cms_pages` p on s.sectionid=p.sectionid where pageID=" . $_GET["pageID"]);
	dbClose();

	$dirBase = "/content/" . mysql_result($qryPath, 0, 0) . "/" . mysql_result($qryPath, 0, 1) . "/" . mysql_result($qryPath, 0, 2) . "/";
	$dir     = $dirBase . "/thumb/";



	require $_SERVER["DOCUMENT_ROOT"] . '/admin/pages/partials/group-section-page.php';
	require $_SERVER["DOCUMENT_ROOT"] . '/admin/pages/partials/photos.php';

	if ($photoGalleryIsReady){
		while ($rowPhotos = mysql_fetch_assoc($qryPhotos)) {
			echo '<div class="photoThumbnailContainer">';
			echo '<div class="photoThumbnail">';
			echo '<div style="height:120px;width:120px;">';
			echo '<img src="' . $dir . $rowPhotos["imageFilename"] . '"><br>';
			echo '</div>';
			echo '<div class="photoThumbnailCaption">' . $rowPhotos["caption"] . '</div>';
			echo '<div class="photoThumbnailSize">' . number_format($rowPhotos["filesize"]/1024, 0) . ' kb</div>';
			echo '</div>';
			echo '</div>';
		}
	}

	echo '<br style="clear:both;">';

	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/footer.inc.php";
?>
