<?php
	error_reporting(E_ALL);
	ini_set('display_errors','On');

	require "custom/settings.inc.php";// site specific settings
	require "phpincludes/functions.inc.php";// global functions
	require "phpincludes/checkmobile.inc.php";// check for mobile device, to change display

	// ********************************************************************************
	// ********************************************************************************
	// url path parsing
	// ********************************************************************************
	// ********************************************************************************
	$requestPath    = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
	$requestGroup   = '';
	$requestSection = '';
	$requestPage    = '';

	// this has some weird thing where the "/" counts as an item, even though it's the
	// delimiter
	if ($requestPath[1] != ''){
		$requestGroup = str_replace("%20", " ", $requestPath[1]);
	}
	if (sizeof($requestPath) > 2 && $requestPath[2] != ''){
		$requestSection = str_replace("%20", " ", $requestPath[2]);
	}
	if (sizeof($requestPath) >= 4 && $requestPath[3] != ''){
		$requestPage = str_replace("%20", " ", $requestPath[3]);
	}

	// ********************************************************************************
	// ********************************************************************************
	// query for the current page info
	// ********************************************************************************
	// ********************************************************************************
	$qryPageSql = "pageDateCreated,pageDateUpdated,pageID,pageTitle,pageFolder,sectionFolder,groupFolder,parentPageID,allowPageComments,hasMusic,passkey from `cms_groups` g join `cms_sections` s on g.groupid=s.groupid join `cms_pages` p on s.sectionid=p.sectionid where groupSortOrder>0 and sectionSortOrder>0 and pageSortOrder>0";

	if ($requestGroup != ''){
		$qryPageSql .= " and groupFolder='" . $requestGroup . "'";
	}
	if ($requestSection != ''){
		$qryPageSql .= " and sectionFolder='" . $requestSection . "'";
	}
	if ($requestPage != ''){
		$qryPageSql .= " and pageFolder='" . $requestPage . "'";
	}
	$qryPageSql .= ' order by groupSortOrder asc, sectionSortOrder asc, pageSortOrder asc';
	$qryPageSql .= ' limit 1'; // short URLs with the full group/section/page need to restrict to only the first record


	dbOpen();
		$qryPage = dbSelectAssoc($qryPageSql);

		$qryPhotoGallerySql = 'imageFilename,caption,filesize from cms_pagePhotos where pageID=' . $qryPage['pageID'] . ' order by sortOrder';
		$qryDownloadsSql = 'filename,downloadText,filesize from cms_pageDownloads where pageID=' . $qryPage['pageID'];

		if ($qryPage["parentPageID"] == "" || $qryPage["parentPageID"] == 0){// if the page is a main/parent page, regular SQL
			$qrySubpagesSql_filter = $qryPage['pageID'];
		}elseif ($qryPage["parentPageID"] > 0){// if the page is a child/sub page, check for other pages with the same parentID
			$qrySubpagesSql_filter = $qryPage['parentPageID'];
		}

		$qrySubpagesSql = 'pageID,pageFolder,sectionFolder,groupFolder,menuText from cms_groups g join cms_sections s on g.groupid=s.groupid join cms_pages p on s.sectionid=p.sectionid where p.parentPageID=' . $qrySubpagesSql_filter;
		$qryCommentsSql = 'entryName,entryEmail,entryEmailHide,entryComment,entryDtsAdd from cms_pageComments where isApproved=1 and pageID=' . $qryPage['pageID'];

		$qryPhotoGallery = dbSelect($qryPhotoGallerySql);
		$qryDownloads = dbSelect($qryDownloadsSql);
		$qrySubpages = dbSelect($qrySubpagesSql);
		$qryComments = dbSelect($qryCommentsSql);
	dbClose();

	$qryPagePath = 'content/' . $qryPage['groupFolder'] . '/' . $qryPage['sectionFolder'] . '/' . $qryPage['pageFolder'];


	// ********************************************************************************
	// ********************************************************************************
	// display page content w/wrapper
	// ********************************************************************************
	// ********************************************************************************
	require "phpincludes/layout.header.inc.php";

	if (empty($qryPage) || sizeof($qryPage) == 0){
		echo 'Cannot find that page in the database - check your bookmark or use the menu.';
	}elseif ($qryPage["passkey"] != "" && !isset($_COOKIE["publicAuth" . $qryPage["pageID"]])){
		echo '<h1>This page is password protected</h1>';
		if (isset($_GET["failed"]) && $_GET["failed"]){
			echo '<p align="center"><strong><em>INVALID PASSWORD</em></strong></p><hr>';
		}
		echo '<p align="center">This page is password protected. Please enter the password below to view it.</p>';
		echo '<form action="/password-check.php" method="post">';
		echo '	<input type="hidden" name="pageID" value="' . $qryPage["pageID"] . '">';
		echo '	<input type="hidden" name="returnToPath" value="/' . $qryPage["groupFolder"] . '/' . $qryPage["sectionFolder"] . '/' . $qryPage["pageFolder"] . '/">';
		echo '	<p align="center">';
		echo '		<input type="text" name="passkey" maxlength="16" length="16">';
		echo '		<input type="submit" value="OK">';
		echo '	</p>';
		echo '</form>';
	}else{
		// page hits by m/d/yy and browser //
		$thisYear    = date('Y');
		$thisMonth   = date('m');
		$thisDay     = date('d');
//		$thisBrowser = substr($_SERVER['HTTP_USER_AGENT'], 0, 256);

		dbOpen();
			dbInsert("
				cms_pageHits(
					pageID,
					hit_month,
					hit_day,
					hit_year
				)values(
					" . $qryPage['pageID'] . ",
					" . $thisMonth . ",
					" . $thisDay . ",
					" . $thisYear . "
				)
			");
		dbClose();

		echo '<h1>' . $qryPage["pageTitle"] . '</h1>';

		if ($qryPage["hasMusic"]){
			echo '<p align="center"><embed src="/'.$qryPagePath.'/music.mp3" width="300" height="32" autostart="true" loop="false"></embed></p>';
		}

//		$pageContent = file_get_contents($qryPagePath . '/content.php');
//		echo $pageContent;
		include($qryPagePath . '/content.php');

		if (mysql_num_rows($qryPhotoGallery) > 0){
			echo '<h2>Photo Gallery</h2>';

			while ($rowPhotoGallery = mysql_fetch_assoc($qryPhotoGallery)) {
				echo '<div class="pagePhoto" style="float:left;margin:5px;">';
				echo '<table class="pagePhoto" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #000;">';
				echo '<tr><td align="center" style="background-color:#000;width:120px;height:120px;"><a rel="lightbox[photoGallery]" title="'.$rowPhotoGallery["caption"].'" href="/' .$qryPagePath . '/large/' . $rowPhotoGallery["imageFilename"] . '"><img src="/' . $qryPagePath . '/thumb/' . $rowPhotoGallery["imageFilename"] . '"></a></td></tr>';
				echo '<tr><td align="center" style="background-color:#000;color:#fff;">' . $rowPhotoGallery["caption"] . '</td></tr>';
				echo '</table>';
				echo '</div>';
			}
			echo '<br style="clear:both;">';
		}

		if (mysql_num_rows($qryDownloads) > 0){
			echo '<h2>Downloads</h2>';
			while ($rowDownloads = mysql_fetch_assoc($qryDownloads)) {
				echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dspIcon("download") . ' <a href="/' . $qryPagePath . '/downloads/' . $rowDownloads["filename"] . '">' . $rowDownloads["downloadText"] . '</a></p>';
			}
		}

		if (mysql_num_rows($qrySubpages) > 0){
			echo '<h2>Other Pages in this Section</h2>';
			while ($rowSubpages = mysql_fetch_assoc($qrySubpages)) {
				if ($rowSubpages["pageID"] != $qryPage["pageID"]){
					echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dspIcon("page") . ' <a href="/' . $rowSubpages["groupFolder"] . '/' . $rowSubpages["sectionFolder"] . '/' . $rowSubpages["pageFolder"] . '/">' . $rowSubpages["menuText"] . '</a></p>';
				}else{
					echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dspIcon("page") . ' ' . $rowSubpages["menuText"] . '</p>';
				}
			}
			if ($qryPage["parentPageID"] > 0){
				echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dspIcon("back") . ' <a href="">Back to parent page</a></p>';
			}
		}

		if ($qryPage["allowPageComments"]){
			echo '<h2>Page Comments</h2>';
			echo '<table class="pageComments">';
			while ($rowComments = mysql_fetch_assoc($qryComments)) {
				echo '<tr>';
				echo '<td class="label" align="left" width="100%"><strong>' . $rowComments["entryName"];
				if ($rowComments["entryEmailHide"] == 1){
					echo ' (' . $rowComments["entryEmail"] . ')';
				}
				echo '</strong></td>';
				echo '<td class="label" align="right" nowrap="nowrap">' . $rowComments["entryDtsAdd"] . '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td colspan="2">' . $rowComments["entryComment"] . '</td>';
				echo '</tr>';
				echo '<tr><td colspan="2" class="transparent">&nbsp;</td></tr>';
			}
			echo '</table>';

			echo '<p style="text-align:center"><button onclick="jQuery(\'#cms-page-comments-form\').toggle();">Add a comment on this page</button></p>';
			echo '<div id="cms-page-comments-form" style="display:none;">';
			echo '<form name="addComment" method="post" action="/comment-submit.php" onsubmit="return validateFormComment();">';
			echo '<input type="hidden" name="pageID" value="' . $qryPage["pageID"] . '">';
			echo '<table class="formComment" align="center">';
			echo '<tr>';
			echo '	<td class="label">Name:</td>';
			echo '	<td><input type="text" name="entryName" maxlength="64" style="width:320px;"></td>';
			echo '</tr>';
			echo '<tr>';
			echo '	<td class="label">Email:</td>';
			echo '	<td>';
			echo '		<input type="text" name="entryEmail" maxlength="128" style="width:320px;"><br/>';
			echo '		<input type="checkbox" name="entryEmailHide" value="1"> Check this box to hide your email address';
			echo '	</td>';
			echo '</tr>';
			echo '<tr>';
			echo '	<td class="label">Comment:</td>';
			echo '	<td><textarea name="entryComment" style="width:320px;"></textarea></td>';
			echo '</tr>';
			echo '<tr>';
			echo '	<td align="center" colspan="2">';
			echo '		<a href="#" onclick="document.getElementById(\'captcha\').src = \'/securimage/securimage_show.php?\' + Math.random(); return false"><img id="captcha" src="/securimage/securimage_show.php" alt="CAPTCHA Image" /></a><br/>';
			echo '		<em>Click the picture for a different image</em>';
			echo '	</td>';
			echo '</tr>';
			echo '<tr>';
			echo '	<td class="label" colspan="2" style="text-align:center;">Enter the orange text from above:</td>';
			echo '</tr>';
			echo '<tr>';
			echo '	<td colspan="2" align="center"><input type="text" name="captcha_code" maxlength="6" /></td>';
			echo '</tr>';
			echo '</table>';
			echo '<p style="text-align:center"><input type="submit" value="Submit Comment"></p>';
			echo '</form>';
			echo '</div>';

			echo '';
		}
	}

	require "phpincludes/layout.footer.inc.php";



	// ********************************************************************************
	// ********************************************************************************
	// local debugging helper
	// ********************************************************************************
	// ********************************************************************************
	if (!strpos($_SERVER['SERVER_NAME'], '.local') == false){// PRODUCTION
		require "custom/settings.db.inc.php";

		echo '<br/><br/><br/>';
		echo '<fieldset>';
		echo '	<legend>Settings Included:</legend>';
		echo '	$application_dbserver = ' . $application_dbserver . '<br>';
		echo '	$application_dbname = ' . $application_dbname . '<br>';
		echo '	$application_dbuser = ' . $application_dbuser . '<br>';
		echo '	$application_dbpass = ' . $application_dbpass . '<br>';
		echo '</fieldset>';
//		echo '<a href="/development/set-mobile-true.php">Set Mobile TRUE</a> | <a href="/development/set-mobile-false.php">Set Mobile FALSE</a><br>';
		echo '<br/>';
		echo 'LOCAL DEBUG >> Including page: /' . $qryPagePath . '/content.php<hr>';
	}
?>
