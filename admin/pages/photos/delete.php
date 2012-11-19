<?php
	$pageheader = "Page Photos - Delete";
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.inc.php";



	dbOpen();
		$qryPhotos = dbSelect("photoID,imageFilename,caption,filesize,sortOrder from cms_pagePhotos where pageID=" . $_GET["pageID"] . " order by sortOrder");
		$qryPath = dbSelect("groupFolder,sectionFolder,pageFolder from `cms_groups` g join `cms_sections` s on g.groupid=s.groupid join `cms_pages` p on s.sectionid=p.sectionid where pageID=" . $_GET["pageID"]);
	dbClose();

	$dirBase = "/content/" . mysql_result($qryPath, 0, 0) . "/" . mysql_result($qryPath, 0, 1) . "/" . mysql_result($qryPath, 0, 2) . "/";
	$dir     = $dirBase . "/thumb/";
?>

<?php
	require $_SERVER["DOCUMENT_ROOT"] . '/admin/pages/partials/group-section-page.php';
	includeFile('/admin/pages/partials/photos.php');
?>

<p align="center">Check the photo(s) you want to delete and click 'Delete Checked Photos'</p>

<form action="/admin/pages/photos/deleteSave.php" method="post">
	<input type="hidden" name="pageID" value="<?php echo $_GET['pageID'] ?>">

	<p align="center"><input type="submit" value="Delete Checked Photos"></p>

	<?php
		while ($rowPhotos = mysql_fetch_assoc($qryPhotos)) {
			echo '<div class="photoThumbnailContainer">';
			echo '<div class="photoThumbnail">';
			echo '<input type="hidden" name="photoID[]" value="' . $rowPhotos['photoID'] . '">';
			echo '<input type="checkbox" name="deleteList[]" value="'.$rowPhotos['photoID'].'"><br>';
			echo '<img src="' . $dir . $rowPhotos["imageFilename"] . '"><br>';
			echo '</div>';
			echo '</div>';
		}
	?>

	<br style="clear:both;">

	<p align="center"><input type="submit" value="Delete Checked Photos"></p>
</form>

<?php
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/footer.inc.php";
?>
