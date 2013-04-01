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
?>

<style type="text/css">
	div.labelsContainer{
		background-color:#fff;
		font-size:9px;
		padding:0px;
		margin:0px;
		border-collapse:collapse;
		color:#000;
	}
	input.labels{
		border:1px solid #999;padding:0px;margin:0px;font-size:9px;width:118px;color:#000;
	}
</style>

<?php
	echo '	<ul id="sortable">';
		while ($rowPhotos = mysql_fetch_assoc($qryPhotos)) {
			$thisThumb = 'http://www.james-anderson-iii.com' . $dirBase . 'thumb/' . $rowPhotos["imageFilename"];
			$thisLarge = 'http://www.james-anderson-iii.com' . $dirBase . 'large/' . $rowPhotos["imageFilename"];
			echo '<li id="recordsArray_' . $rowPhotos['photoID'] . '">';
			echo '	<div style="height:120px;width:120px;">';
			echo '	<img src="' . $dir . $rowPhotos["imageFilename"] . '"><br>';
			echo '	</div>';
//			echo '	<input type="hidden" name="photoID[]" value="' . $rowPhotos['photoID'] . '">';
//			echo '	<textarea name="comments[]" cols="20" rows="3">' . $rowPhotos["caption"] . '</textarea>';
			echo '	<div class="labelsContainer">';
			echo '	URL:<br><input class="labels" type="text" value="' . $thisLarge . '" onclick="$(this).select();"><br>';
			echo '	IMG:<br><input class="labels" type="text" value="[IMG]' . $thisLarge . '[/IMG]" onclick="$(this).select();"><br>';
			echo '	THUMB:<br><input class="labels" type="text" value="[URL=' . $thisLarge . '][IMG]' . $thisThumb . '[/IMG][/URL]" onclick="$(this).select();"><br>';
			echo '	</div>';
			echo '</li>';
		}
	echo '	</ul>';

	echo '<br style="clear:both;">';

	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/footer.inc.php";
?>
