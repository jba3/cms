<?php
	$pageheader = "Page Photos - Tags";
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.inc.php";



	dbOpen();
		$qryPhotos = dbSelect("photoID,imageFilename,tags,filesize,sortOrder from cms_pagePhotos where pageID=" . $_GET["pageID"] . " order by sortOrder");
		$qryPath = dbSelect("groupFolder,sectionFolder,pageFolder from `cms_groups` g join `cms_sections` s on g.groupid=s.groupid join `cms_pages` p on s.sectionid=p.sectionid where pageID=" . $_GET["pageID"]);
	dbClose();

	$dirBase = "/content/" . mysql_result($qryPath, 0, 0) . "/" . mysql_result($qryPath, 0, 1) . "/" . mysql_result($qryPath, 0, 2) . "/";
	$dir     = $dirBase . "/thumb/";
?>

<?php
	require $_SERVER["DOCUMENT_ROOT"] . '/admin/pages/partials/group-section-page.php';
	includeFile('/admin/pages/partials/photos.php');
?>

<form action="/admin/pages/photos/tagsSave.php" method="post">
	<input type="hidden" name="pageID" value="<?php echo $_GET['pageID'] ?>">

	<p align="center"><input type="submit" value="Save Tags"></p>

	<?php
		echo '	<ul id="sortable">';
			while ($rowPhotos = mysql_fetch_assoc($qryPhotos)) {
				echo '<li id="recordsArray_' . $rowPhotos['photoID'] . '">';
				echo '	<img src="' . $dir . $rowPhotos["imageFilename"] . '"><br>';
				echo '	<input type="hidden" name="photoID[]" value="' . $rowPhotos['photoID'] . '">';
				echo '	<textarea name="tags[]" cols="20" rows="3">' . $rowPhotos["tags"] . '</textarea>';
				echo '</li>';
			}
		echo '	</ul>';
	?>

	<br style="clear:both;">

	<p align="center"><input type="submit" value="Save Tags"></p>
</form>

<?php
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/footer.inc.php";
?>
