<?php
	require "../phpincludes/settings.inc.php";

	require "partials/comments-approve-submit.php";

/*
	mysql_connect($application_dbserver, $application_dbuser, $application_dbpass) or die(mysql_error());
	mysql_select_db($application_dbname) or die(mysql_error());

	foreach ($_POST as $key => $value){
		if (substr($key, 0, 6) == 'action'){
			echo $key . ':' . $value . '<br>';

			$id = substr($key, 6);//substr with 3rd argument blank gets remainder of string after starting index

			// ignore the -1, they're "do it later" items
			if ($value == 1){
				mysql_query("update cms_pageComments set isApproved=1 where commentID=" . $id);
			}elseif($value == 0){
				mysql_query("delete from cms_pageComments where commentID=" . $id);
			}
		}
	}

	mysql_close();
*/

	header('Location: /admin/all-pending-comments.php');
?>
