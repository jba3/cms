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


	echo '<table class="data" align="center">';
	echo '<tr><th>File</th><th>Thumb</th><th>Large</th><th>Results</th></tr>';
		while ($rowPhotos = mysql_fetch_assoc($qryPhotos)) {
			list($widthThumb, $heightThumb, $type, $attr) = getimagesize($_SERVER["DOCUMENT_ROOT"] . $dirBase . '/thumb/' . $rowPhotos["imageFilename"]);
			list($widthLarge, $heightLarge, $type, $attr) = getimagesize($_SERVER["DOCUMENT_ROOT"] . $dirBase . '/large/' . $rowPhotos["imageFilename"]);

			echo '<tr>';
				echo '<td>' . $rowPhotos["imageFilename"] . '</td>';
				echo '<td>' . $widthThumb . ' x ' . $heightThumb . '</td>';
				echo '<td>' . $widthLarge . ' x ' . $heightLarge . '</td>';
				echo '</td>';
			if ($widthThumb > 120 || $heightThumb > 120 || $widthLarge > 640 || $heightLarge > 640){
				echo '<td align="center" style="background-color:#f00;"><strong>FAIL!</strong></td>';
				$foundIssues = true;
			}else{
				echo '<td>pass</td>';
			}
			echo '</tr>';
		}
	echo '	</table>';

	if (!($foundIssues)){
		echo '<p align="center">No photo size issues found; everything is within spec!</p>';
	}

	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/footer.inc.php";
?>
