<?php
	if (mysql_num_rows($qryPhotoGallery) > 0){
		echo '<h2>Photo Gallery</h2>';
		////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////
		// css and js for gallery
		echo '<script src="/jscripts/photoGallery.js"></script>';
		echo '<link rel="stylesheet" href="/css/photoGallery.css">';

		////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////
		// build out some javascript stuff
		echo '<script type="text/javascript">';
		echo '	arrGallerySmall = new Array();';
		echo '	arrGalleryLarge = new Array();';
		echo '	arrGalleryCaptions = new Array();';
		$intCounterGallery = 0;
		while ($rowPhotoGallery = mysql_fetch_assoc($qryPhotoGallery)) {
			$thisCaption = str_replace(array("\r\n", "\n"), "", $rowPhotoGallery["caption"]);

			echo 'arrGalleryLarge[' . $intCounterGallery . '] = "/' . $qryPagePath . '/large/' . $rowPhotoGallery["imageFilename"] . '";';
			echo 'arrGallerySmall[' . $intCounterGallery . '] = "/' . $qryPagePath . '/thumb/' . $rowPhotoGallery["imageFilename"] . '";';
			echo 'arrGalleryCaptions[' . $intCounterGallery . '] = "' . $thisCaption . '";';
			$intCounterGallery += 1;
		}
		// have to subtract one since the JS index starts from 0 and not 1
		echo '	intGallerySize = ' . (mysql_num_rows($qryPhotoGallery)-1) . ';';
		echo '</script>';
?>

<script type="text/javascript">
	$(function(){
		var intCountPhotosLoaded = 0;
		$( "#photoPreloader" ).progressbar();
		for (x=0; x <= intGallerySize; x++){
			$("<img />").attr('src', arrGalleryLarge[x]).load(function(){
				intCountPhotosLoaded += 1;
				pct = Math.round((intCountPhotosLoaded / intGallerySize) * 100);
				$("#photoPreloader").progressbar({value: pct});
			});
		}
		$("#photoPreloaderLabel").fadeOut(1500);
		$("#photoPreloader").fadeOut(1500);
   	});
</script>

<?php
		echo '<p id="photoPreloaderLabel">Preloading gallery photos for slideshow....</p>';
		echo '<div id="photoPreloader"></div>';

		////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////
		// popup photo viewer
		echo '<div id="photoGalleryPopup">';
		// reset sql object index
//		mysql_data_seek($qryPhotoGallery, 0);

		// start displaying
/*
		echo '<div id="photoGalleryThumbsContainer">';
		echo '<div id="photoGalleryThumbs">';
		echo '<table border="0" cellspacing="1" cellpadding="0">';
		echo '<tr>';
		while ($rowPhotoGallery = mysql_fetch_assoc($qryPhotoGallery)) {
			echo '<td valign="top">';
			echo '<div class="photo">';
			echo '	<a class="galleryThumbnail" title="'.str_replace('<br>', '', $rowPhotoGallery["caption"]).'"';
			echo '	 href="/' .$qryPagePath . '/large/' . $rowPhotoGallery["imageFilename"] . '">';
			echo '	<img src="/' . $qryPagePath . '/thumb/' . $rowPhotoGallery["imageFilename"] . '"></a>';
			echo '</div>';
			echo '<div class="galleryThumbnailCaption">' . $rowPhotoGallery["caption"] . '</div>';
			echo '</td>';
		}
		echo '</tr>';
		echo '</table>';
		echo '</div>';
		echo '</div>';

		echo '<div id="content-slider"></div>';
*/

		echo '	<div id="photoGalleryPopupNav">';
		echo '		<input type="button" onclick="javascript:galleryPrev();" value="&lt; Prev">';

		echo '		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

		echo '		<input id="btnGallerySlideshowStart" type="button" onclick="javascript:toggleGallerySlideshow();" value="Start Slideshow">';
		echo '		<input id="btnGallerySlideshowStop"  type="button" onclick="javascript:toggleGallerySlideshow();" value="Stop Slideshow">';

		echo '		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

		echo '		<input type="button" onclick="javascript:galleryNext();" value="Next &gt;">';
		echo '		<input id="btnGalleryClose" type="button" onclick="javascript:galleryClose();" value="Close">';
		echo '		<br>';
		echo '	</div>';

		echo '	<div id="photoGalleryImageContainer">';
		echo '		<img id="photoGalleryImage"><img id="photoGalleryImagePreload">';
		echo '	</div>';
		echo '	<div id="photoGalleryImageCaption">&nbsp;</div>';
		echo '</div>';

		////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////
		// reset sql object index
		mysql_data_seek($qryPhotoGallery, 0);

		echo '<p>Click any of the thumbnails below for a full-size image viewer.</p>';
		echo '<p><em>HINT: You can press the ESC key to close the gallery; you can press the LEFT ARROW KEY and RIGHT ARROW KEY to change pictures manually, or click on the <a href="javascript:$("a.galleryThumbnail")[0].click();toggleGallerySlideshow();">START SLIDESHOW</a> button to view an automatic slideshow of all of the pictures in the gallery.</em></p>';
		while ($rowPhotoGallery = mysql_fetch_assoc($qryPhotoGallery)) {
			echo '<a class="galleryThumbnail" title="'.str_replace('<br>', '', $rowPhotoGallery["caption"]).'"';
			echo ' href="/' .$qryPagePath . '/large/' . $rowPhotoGallery["imageFilename"] . '">';
			echo '<img style="float:left;height:90px;margin:0px 1px 1px 0px;" src="/' . $qryPagePath . '/thumb/' . $rowPhotoGallery["imageFilename"] . '"></a>';
		}
		echo '<br style="clear:both;">';
	}
?>
