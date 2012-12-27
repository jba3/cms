<?php
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
?>
