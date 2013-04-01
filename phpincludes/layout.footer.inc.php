<?php
	require $_SERVER["DOCUMENT_ROOT"] . "/custom/layout.footer.inc.php";

	if (mysql_num_rows($qryPhotoGallery) > 0){
		echo '<script>';
		echo '	Galleria.loadTheme(\'/galleria/themes/classic/galleria.classic.js\');';
		echo '	Galleria.run(\'#galleria\');';
		echo '	Galleria.configure(\'autoplay\', true);';
		echo '</script>';
	}
?>

</body>
</html>
