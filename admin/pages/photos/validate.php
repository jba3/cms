<?php
	set_time_limit(300);

	$pageheader = "Page Photos - Validating photos";
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.inc.php";
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/image-manipulation.php";

	dbOpen();
		$qryPath = dbSelect("groupFolder,sectionFolder,pageFolder from `cms_groups` g join `cms_sections` s on g.groupid=s.groupid join `cms_pages` p on s.sectionid=p.sectionid where pageID=" . $_GET["pageID"]);

	$dirBase = $_SERVER["DOCUMENT_ROOT"] . "/content/" . mysql_result($qryPath, 0, 0) . "/" . mysql_result($qryPath, 0, 1) . "/" . mysql_result($qryPath, 0, 2);
	$dirLarge = $dirBase . "/large/";
	$dirThumb = $dirBase . "/thumb/";

	$image = new SimpleImage();

	$countModified = 0;

	echo '<table class="data" align="center">';
	echo '<tr>';
	echo '<td valign="top">';

	echo '<p align="center">Checking and fixing large photos...<br/>(' . $dirLarge . ')</p>';
	echo '<table align="center" class="data">';
	echo '<tr><th>Filename</th><th>Was</th><th>Now</th></tr>';
	$counter1 = 0;
	if ($dh = opendir($dirLarge)) {
		while ((($file = readdir($dh)) !== false) && ($counter1 < 10)) {
			if (filetype($dirLarge . $file) == 'file'){
				$counter1 += 1;
				$image->load($dirLarge . $file);
				$imgHeight = $image->getHeight();
				$imgWidth  = $image->getWidth();

				echo '<tr>';
					echo '<td>' . $file . '</td>';
					echo '<td>' . $imgWidth . ' x ' . $imgHeight . '</td>';
					if ($imgWidth > 640 || $imgHeight > 640){
						$countModified += 1;
							if ($imgWidth < $imgHeight){
								$image->resize(480,640);
								echo '<td>480 x 640</td>';
							}else{
								$image->resize(640,480);
								echo '<td>640 x 480</td>';
							}
							$image->save($dirLarge . $file);
					}else{
						echo '<td><hr></td>';
					}
				echo '</tr>';
			}
		}
		closedir($dh);
	}
	echo '</table>';

	echo '</td>';
	echo '<td valign="top">';

	echo '<p align="center">Checking and fixing thumbnail photos...<br/>(' . $dirThumb . ')</p>';
	echo '<table align="center" class="data">';
	echo '<tr><th>Filename</th><th>Was</th><th>Now</th></tr>';
	$counter2 = 0;
	if ($dh = opendir($dirThumb)) {
		while ((($file = readdir($dh)) !== false) && ($counter2 < 10)) {
			if (filetype($dirThumb . $file) == 'file'){
				$counter2 += 1;
				$image->load($dirThumb . $file);
				$imgHeight = $image->getHeight();
				$imgWidth  = $image->getWidth();

				echo '<tr>';
					echo '<td>' . $file . '</td>';
					echo '<td>' . $imgWidth . ' x ' . $imgHeight . '</td>';
					if ($imgWidth > 120 || $imgHeight > 120){
						$countModified += 1;
						if ($image->getWidth() < $image->getHeight()){
							$image->resize( 90,120);
							echo '<td>90 x 120</td>';
						}else{
							$image->resize(120,90);
							echo '<td>120 x 90</td>';
						}
						$image->save($dirThumb . $file);
					}else{
						echo '<td><hr></td>';
					}
				echo '</tr>';
			}
		}
		closedir($dh);
	}
	echo '</table>';
	echo '</td>';
	echo '</tr>';
	echo '</table>';

		dbUpdate("cms_pages set photoSizeValidated = 1 where pageID=" . $_GET["pageID"]);
	dbClose();

	echo '<p align="center"><strong>' . $countModified . '</strong> photos modified.</p>';
	echo '<p align="center"><a href="/admin/pages/photos/index.php?pageID=' . $_GET["pageID"] . '">Back to page photos</a></p>';

	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/footer.inc.php";
?>
