<?php
	$pageheader = "Page Photos - Display Order";
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.inc.php";



	dbOpen();
		$qryPhotos = dbSelect("photoID,imageFilename,caption,filesize,sortOrder from cms_pagePhotos where pageID=" . $_GET["pageID"] . " order by sortOrder");
		$qryPath = dbSelect("groupFolder,sectionFolder,pageFolder from `cms_groups` g join `cms_sections` s on g.groupid=s.groupid join `cms_pages` p on s.sectionid=p.sectionid where pageID=" . $_GET["pageID"]);
	dbClose();

	$dirBase = "/content/" . mysql_result($qryPath, 0, 0) . "/" . mysql_result($qryPath, 0, 1) . "/" . mysql_result($qryPath, 0, 2) . "/";
	$dir     = $dirBase . "/thumb/";
?>



<script>
	function saveOrder(){
		alert($("#frmSortable").serialize());
	}
	$(function() {
		$( "#sortable" ).sortable({
			stop:function(i) {
				$.ajax({
					type: "GET",
					url: "/admin/pages/photos/orderSave.php",
					data: $("#sortable").sortable("serialize")
				});
			}
	    });
	});
</script>



<?php
	require $_SERVER["DOCUMENT_ROOT"] . '/admin/pages/partials/group-section-page.php';
	includeFile('/admin/pages/partials/photos.php');

	echo '<p align="center">Drag and drop the images below to change the display order</p>';

	echo '<br>';

	echo '	<ul id="sortable">';
		while ($rowPhotos = mysql_fetch_assoc($qryPhotos)) {
			echo '<li id="recordsArray_' . $rowPhotos['photoID'] . '">';
			echo '	<img src="' . $dir . $rowPhotos["imageFilename"] . '"><br>';
			echo '	<span style="font-size:9px;color:#fff;">'. $rowPhotos["imageFilename"] . '</span><br>';
			echo '</li>';
		}
	echo '	</ul>';
?>

<br style="clear:both;">

<?php
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/footer.inc.php";
?>
