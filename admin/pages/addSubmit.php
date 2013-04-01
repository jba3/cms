<?php
	function reverse_escape($str){
		$search=array("\\\\","\\0","\\n","\\r","\Z","\'",'\"');
		$replace=array("\\","\0","\n","\r","\x1a","'",'"');
		return str_replace($search,$replace,$str);
	}



	require $_SERVER["DOCUMENT_ROOT"] . "/phpincludes/functions.inc.php";
	require $_SERVER["DOCUMENT_ROOT"] . "/custom/settings.inc.php";



	dbOpen();
		$qrySection = mysql_fetch_array(dbSelect("groupID, sectionFolder from cms_sections where sectionID=" . $_POST["sectionID"]));
		$qryGroup = mysql_fetch_array(dbSelect("groupFolder from cms_groups where groupID=" . $qrySection["groupID"]));

		// create the folder - needs to be done BEFORE file upload!
		//	echo 'section: ' . $_POST["sectionID"] . '<br>';
		//	echo 'group: ' . $qrySection["groupID"] . '<br>';
		//	echo 'created folder: "/ content / ' . $qryGroup["groupFolder"] . ' / ' . $qrySection["sectionFolder"] . ' / ' . $_POST["pageFolder"] . '"';
		$path = "../../content/" . $qryGroup["groupFolder"] . '/' . $qrySection["sectionFolder"] . '/' . $_POST["pageFolder"];

		mkdir($path) or die('Unable to create the folder for this page');

		$content = fopen($path . '/content.php', 'w') or die('Failed to create file!');
		fwrite($content, reverse_escape($_POST["content"]));
		fclose($content);

		echo '<p align="center">Page folder created at ' . $path . '</p>';
	//	echo print_r($_FILES);

		$hasMusic = 0;
		if ($_FILES["music"]["error"] > 0 && $_FILES["music"]["error"] != 4){// empty file is error type 4
			echo "File upload error: " . $_FILES["file"]["error"] . "<br />";
		}elseif ($_FILES["music"]["size"] > 0){
			/*
			echo 'error: "' . $_FILES["music"]["error"] . '"<br>';
			echo 'name: "' . $_FILES["music"]["name"] . '"<br>';
			echo 'type: "' . $_FILES["music"]["type"] . '"<br>';
			echo 'size: "' . $_FILES["music"]["size"] . '"<br>';
			echo 'tmp_name: "' . $_FILES["music"]["tmp_name"] . '"<br>';
			*/

			move_uploaded_file($_FILES["music"]["tmp_name"], "../content/" . $qryGroup["groupFolder"] . '/' . $qrySection["sectionFolder"] . '/' . $_POST["pageFolder"] . "/" . $_FILES["music"]["name"]);

			$hasMusic = 1;
		}

		dbInsert("
			cms_pages(
				parentPageID,
				sectionID,
				allowPageComments,
				pageFolder,
				menuText,
				pageTitle,
				pageSortOrder,
				pageDateCreated,
				pageDateUpdated,
				pageHits,
				hasMusic,
				passkey,
				tags,
				hasPHP
			) VALUES(
				'$_POST[parentPageID]',
				'$_POST[sectionID]',
				'$_POST[allowPageComments]',
				'$_POST[pageFolder]',
				'$_POST[menuText]',
				'$_POST[pageTitle]',
				'$_POST[pageSortOrder]',
				CURDATE(),
				CURDATE(),
				'0',
				'$hasMusic',
				'$_POST[passkey]',
				'$_POST[tags]',
				'$_POST[hasPHP]'
			)
		");
	dbClose();
?>



<p align="center">Page added to section.</p>
<p align="center"><a href="/admin/sitemap/index.php">Site Content</a></p>
