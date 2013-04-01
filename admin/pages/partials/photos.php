<?php
	dbOpen();
		$qryPhotos = dbSelect("photoID,imageFilename,caption,filesize,sortOrder from cms_pagePhotos where pageID=" . $_GET["pageID"] . " order by sortOrder");
		$qryPath = dbSelect("groupFolder,sectionFolder,pageFolder from `cms_groups` g join `cms_sections` s on g.groupid=s.groupid join `cms_pages` p on s.sectionid=p.sectionid where pageID=" . $_GET["pageID"]);
	dbClose();

	$dirBase = $_SERVER["DOCUMENT_ROOT"] . "/content/" . mysql_result($qryPath, 0, 0) . "/" . mysql_result($qryPath, 0, 1) . "/" . mysql_result($qryPath, 0, 2) . "/";

	$countThumb = count(glob($dirBase . "thumb/*.jpg"));
	$countLarge = count(glob($dirBase . "large/*.jpg"));;

	echo '<table align="center">';
	echo '<tr>';
	echo '	<td>';
	// --------------------------------------------------------------------------------
	// --------------------------------------------------------------------------------
	// need to have the folders in place before we can do anything else
	// --------------------------------------------------------------------------------
	// --------------------------------------------------------------------------------
	if (!is_dir($dirBase.'thumb') && !is_dir($dirBase.'large')){
		$photoGalleryIsReady = false;
		echo dspMsgWarning('The LARGE and THUMB folders for the photos on this page does not exist');
		echo '<p>To create the folders, <a href="/admin/pages/photos/folders.php?pageID=' . $_GET["pageID"] . '">click here</a></p>';
	}else{
		$photoGalleryIsReady = true;
		echo '[ ';
		echo '<a href="/admin/pages/photos/index.php?pageID=' . $_GET["pageID"] . '" title="Photos main page">Main</a>';
		echo ' | ';

		// if the gallery count doesn't match directory count
		// JBA3 - this isn't working on GoDaddy - works fine locally.........
//		if ($countLarge <> mysql_num_rows($qryPhotos)){
			echo '<a href="/admin/pages/photos/upload.php?pageID=' . $_GET["pageID"] . '" title="Upload files from your computer">Upload</a>';
			echo ' | ';
			echo '<a href="/admin/pages/photos/add.php?pageID=' . $_GET["pageID"] . '" title="Add files uploaded by FTP into the page/database">QuickBuilder</a>';
			echo ' | ';
//		}

		// if the thumb folder count doesn't match large folder count
		if ($countThumb <> $countLarge){
			echo '<a href="/admin/pages/photos/thumbnails.php?pageID=' . $_GET["pageID"] . '" title="Creates thumbnails for this gallery, for large files that were uploaded without any thumbnails">Make thumbnails</a>';
			echo ' | ';
		}
		echo '<a href="/admin/pages/photos/remoteFile.php?pageID=' . $_GET["pageID"] . '" title="Saves a file into the photo gallery from another URL">Save from URL</a>';
		echo ' | ';
		echo '<a href="/admin/pages/photos/dimensions.php?pageID=' . $_GET["pageID"] . '" title="Check dimensions of photos to make sure they are within size specs">Check Dimensions</a>';
		echo ' | ';
		echo '<a href="/admin/pages/photos/fix-large-dimensions.php?pageID=' . $_GET["pageID"] . '" title="Adjust large photos that are not within size specs">Adjust Large</a>';
		echo ' | ';
		echo '<a href="/admin/pages/photos/fix-thumb-dimensions.php?pageID=' . $_GET["pageID"] . '" title="Adjust thumb photos that are not within size specs">Adjust Thumb</a>';
		echo ' | ';
		echo '<a href="/admin/pages/photos/rotate.php?pageID=' . $_GET["pageID"] . '" title="Rotate photos that are in the wrong orientation">Rotate</a>';
		echo ' | ';
		echo '<a href="/admin/pages/photos/order.php?pageID=' . $_GET["pageID"] . '" title="Change the order pictures appear in">Change Order</a>';
		echo ' | ';
		echo '<a href="/admin/pages/photos/captions.php?pageID=' . $_GET["pageID"] . '" title="Set the captions for photos">Captions</a>';
		echo ' | ';
		echo '<a href="/admin/pages/photos/tags.php?pageID=' . $_GET["pageID"] . '" title="Set tag(s) for the photos">Tags</a>';
		echo ' | ';
		echo '<a href="/admin/pages/photos/delete.php?pageID=' . $_GET["pageID"] . '" title="Delete photo(s) from the gallery">Delete</a>';
		echo ' | ';
		echo '<a href="/admin/pages/photos/forums.php?pageID=' . $_GET["pageID"] . '" title="Forums/BB Code copy/paste stuff">Forums/BB</a>';
		echo ' ]';
	}
	echo '</td>';
	echo '</tr>';
	echo '</table>';
?>
