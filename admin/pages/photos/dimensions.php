<?php
	$pageheader = "Page Photos - Captions";
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.inc.php";



	dbOpen();
		$qryPhotos = dbSelect("photoID,imageFilename,caption,filesize,sortOrder from cms_pagePhotos where pageID=" . $_GET["pageID"] . " order by sortOrder");
		$qryPath = dbSelect("groupFolder,sectionFolder,pageFolder from `cms_groups` g join `cms_sections` s on g.groupid=s.groupid join `cms_pages` p on s.sectionid=p.sectionid where pageID=" . $_GET["pageID"]);
	dbClose();

	$dirBase = "/content/" . mysql_result($qryPath, 0, 0) . "/" . mysql_result($qryPath, 0, 1) . "/" . mysql_result($qryPath, 0, 2) . "/";
	$dir     = $dirBase . "/thumb/";

	require $_SERVER["DOCUMENT_ROOT"] . '/admin/pages/partials/group-section-page.php';
	includeFile('/admin/pages/partials/photos.php');

	$foundIssues = false;
?>

<?php
	echo '	<ul id="sortable">';
		while ($rowPhotos = mysql_fetch_assoc($qryPhotos)) {
			list($widthThumb, $heightThumb, $type, $attr) = getimagesize($_SERVER["DOCUMENT_ROOT"] . $dirBase . '/thumb/' . $rowPhotos["imageFilename"]);
			list($widthLarge, $heightLarge, $type, $attr) = getimagesize($_SERVER["DOCUMENT_ROOT"] . $dirBase . '/large/' . $rowPhotos["imageFilename"]);

			if ($widthThumb > 120 || $heightThumb > 120 || $widthLarge > 640 || $heightLarge > 640){
				echo '<div style="float:left;border:1px solid #000;margin:1px;padding:0px;height:150px;width:120px;text-align:center;font-size:10px;">';
				echo '	<img src="' . $dir . $rowPhotos["imageFilename"] . '"><br>';
				echo '	Thumb: ' . $widthThumb . ' x ' . $heightThumb . '<br>';
				echo '	Large: ' . $widthLarge . ' x ' . $heightLarge . '<br>';
				echo '</div>';
				$foundIssues = true;
			}
		}
	echo '	</ul>';
?>

<br style="clear:both;">

<?php
	if (!($foundIssues)){
		echo '<p align="center">No photo size issues found; everything is within spec!</p>';
	}

	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/footer.inc.php";
?>
