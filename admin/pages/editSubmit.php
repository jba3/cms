<?php
	function reverse_escape($str){
		$search=array("\\\\","\\0","\\n","\\r","\Z","\'",'\"');
		$replace=array("\\","\0","\n","\r","\x1a","'",'"');
		return str_replace($search,$replace,$str);
	}



	require $_SERVER["DOCUMENT_ROOT"] . "/phpincludes/functions.inc.php";
	require $_SERVER["DOCUMENT_ROOT"] . "/custom/settings.inc.php";



	// database
	dbOpen();
		$qryPage = mysql_fetch_array(dbSelect("sectionID, pageFolder, hasMusic from cms_pages where pageID=" . $_POST["pageID"]));
		$qrySection = mysql_fetch_array(dbSelect("groupID, sectionFolder from cms_sections where sectionID=" . $qryPage["sectionID"]));
		$qryGroup = mysql_fetch_array(dbSelect("groupFolder from cms_groups where groupID=" . $qrySection["groupID"]));
	dbClose();

	$pathToFile = "../../content/" . $qryGroup["groupFolder"] . '/' . $qrySection["sectionFolder"] . '/' . $qryPage["pageFolder"] . '/';

	$content = fopen($pathToFile . 'content.php', 'w') or die('Failed to create file!');
		fwrite($content, reverse_escape($_POST["content"]));
	fclose($content);

	// deleting music
	if (isset($_POST["deleteMusic"]) == 1){
		unlink($pathToFile . 'music.mp3');
		$hasMusic = 0;
	}elseif ($_FILES["music"]["size"] > 0){
		move_uploaded_file($_FILES["music"]["tmp_name"], $pathToFile . "music.mp3");//$_FILES["music"]["name"]
		$hasMusic = 1;
	}else{
		$hasMusic = $qryPage["hasMusic"];
	}

	dbOpen();
		mysql_query("
			UPDATE	cms_pages
			SET		menuText='$_POST[menuText]',
					pageTitle='$_POST[pageTitle]',
					pageSortOrder=$_POST[pageSortOrder],
					allowPageComments=$_POST[allowPageComments],
					passkey='$_POST[passkey]',
					hasMusic=$hasMusic,
					pageDateUpdated = CURDATE(),
					tags = '$_POST[tags]',
					hasPHP = '$_POST[hasPHP]'
			WHERE	pageID=$_POST[pageID]
		");
	dbClose();



	header('Location: /admin/sitemap/index.php');
?>
