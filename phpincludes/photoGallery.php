<?php
	if (mysql_num_rows($qryPhotoGallery) > 0){
		echo '<h2>Photo Gallery</h2>';
		echo '<br>';
		echo '<div id="galleria">';
		while ($rowPhotoGallery = mysql_fetch_assoc($qryPhotoGallery)) {
			$thisCaption = str_replace('<br>', '', $rowPhotoGallery["caption"]);

			echo '<a href="/' .$qryPagePath . '/large/' . $rowPhotoGallery["imageFilename"] . '">';
			echo '<img';
			echo '	src="/' . $qryPagePath . '/thumb/' . $rowPhotoGallery["imageFilename"] . '"';
			echo '	data-title="' . $thisCaption . '"';
			echo '	data-description="' . $thisCaption . '"';
			echo '>';
			echo '</a>';
		}
		echo '</div>';

		echo '<p align="center">';
		echo '	<strong>';
		echo '		<a href="javascript:$(\'#galleria\').data(\'galleria\').play();">Play</a>';
		echo '		|';
		echo '		<a href="javascript:$(\'#galleria\').data(\'galleria\').pause();">Pause</a>';
		echo '		|';
		echo '		<a href="javascript:$(\'#galleria\').data(\'galleria\').enterFullscreen();">Full Screen view</a>';
		echo '	</strong>';
		echo '</p>';
	}
?>
