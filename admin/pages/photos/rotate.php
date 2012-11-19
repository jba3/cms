<?php
	$pageheader = "Page Photos - Rotate";
	// try to force no caching so that rotated images show up as rotated
	// caching seems to make them show non-rotated, even after rotation
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	// resume normal processing
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.inc.php";



	dbOpen();
		$qryPhotos = dbSelect("photoID,imageFilename,caption,filesize,sortOrder from cms_pagePhotos where pageID=" . $_GET["pageID"] . " order by sortOrder");
		$qryPath = dbSelect("groupFolder,sectionFolder,pageFolder from `cms_groups` g join `cms_sections` s on g.groupid=s.groupid join `cms_pages` p on s.sectionid=p.sectionid where pageID=" . $_GET["pageID"]);
	dbClose();

	$dirBase = "/content/" . mysql_result($qryPath, 0, 0) . "/" . mysql_result($qryPath, 0, 1) . "/" . mysql_result($qryPath, 0, 2) . "/";
	$dir     = $dirBase . "/thumb/";

	require $_SERVER["DOCUMENT_ROOT"] . '/admin/pages/partials/group-section-page.php';
	includeFile('/admin/pages/partials/photos.php');
?>

<p align="center">Check the photo(s) you want to rotate and click 'Rotate Checked Photos'</p>

<form action="/admin/pages/photos/rotateSave.php" method="post">
	<input type="hidden" name="pageID" value="<?php echo $_GET['pageID'] ?>">

	<p align="center"><input type="submit" value="Rotate Checked Photos"></p>

	<?php
		while ($rowPhotos = mysql_fetch_assoc($qryPhotos)) {
			echo '<div style="text-align:center;background-color:#ccc;padding:0px;margin:10px;height:140px;width:120px;float:left;position:relative;">';
			echo '	<img src="' . $dir . $rowPhotos["imageFilename"] . '?nocache=' . now() . '"><br>';
	//		echo '	<div style="text-align:center;width:120px;position:absolute;bottom:0px;"><a href="/admin/pages/photos/rotateSave.php?pageID=' . $_GET["pageID"] . '&photoID=' . $rowPhotos['photoID'] . '&anchorPhoto=' . $count . '">Click to Rotate</a></div>';
			echo '	<input type="hidden" name="photoID[]" value="' . $rowPhotos['photoID'] . '">';
			echo '	<div style="text-align:center;width:120px;position:absolute;bottom:0px;"><input type="checkbox" name="rotateList[]" value="'.$rowPhotos['photoID'].'">Rotate image</div>';
			echo '</div>';
		}
	?>

	<br style="clear:both;">

	<p align="center"><input type="submit" value="Rotate Checked Photos"></p>
</form>

<?php
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/footer.inc.php";
?>
