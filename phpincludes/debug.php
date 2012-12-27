<?php
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
