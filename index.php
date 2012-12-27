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

		$qrySubpagesSql = 'pageID,pageFolder,sectionFolder,groupFolder,menuText from cms_groups g join cms_sections s on g.groupid=s.groupid join cms_pages p on s.sectionid=p.sectionid where p.parentPageID=' . $qrySubpagesSql_filter . ' order by pageSortOrder';
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
		include('phpincludes/password.php');
	}else{
		include('phpincludes/addPageHit.php');

		echo '<h1>' . $qryPage["pageTitle"] . '</h1>';

		include('phpincludes/music.php');
		include($qryPagePath . '/content.php');
		include('phpincludes/photoGallery.php');
		include('phpincludes/downloads.php');
		include('phpincludes/subpages.php');
		include('phpincludes/comments.php');
	}

	require "phpincludes/layout.footer.inc.php";

	include('phpincludes/debug.php');
?>
