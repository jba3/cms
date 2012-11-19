<?php
	require $_SERVER["DOCUMENT_ROOT"] . "/custom/settings.inc.php";
	require $_SERVER["DOCUMENT_ROOT"] . "/custom/settings.db.inc.php";
	require $_SERVER["DOCUMENT_ROOT"] . "/phpincludes/functions.inc.php";



	dbOpen();
		$qryPage = mysql_fetch_assoc(dbSelect("passkey from cms_pages where pageID=" . $_POST["pageID"]));
	dbClose();



	if ($_POST["passkey"] == $qryPage["passkey"]){
		setcookie("publicAuth" . $_POST["pageID"], "true", time() + (1 * 1 * 30 * 60)); // time is days * hours * mins * secs
		header('Location: ' . $_POST["returnToPath"]);
	}else{
		header('Location: ' . $_POST["returnToPath"] . '&failed=true');
	}
?>
