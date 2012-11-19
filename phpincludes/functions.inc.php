<?php
	/***************************************************************************************************
	****************************************************************************************************
	tables
	****************************************************************************************************
	***************************************************************************************************/
	function getGroup($groupID){
		return dbSelect("* from `cms_groups` where groupID=" . $groupID);
	}

	function getSection(){
		return dbSelect("* FROM `cms_pages` a JOIN `cms_sections` b on a.sectionID=b.sectionID where sectionID=" . $sectionID);
	}

	function getPage(){
		return dbSelect("* FROM `cms_pages` a JOIN `cms_sections` b on a.sectionID=b.sectionID JOIN `cms_groups` c on b.groupID=c.groupID where pageID=" . $pageID);
	}


	/***************************************************************************************************
	****************************************************************************************************
	date helpers
	****************************************************************************************************
	***************************************************************************************************/
	function now(){
		return date('H:i:s');
	}


	/***************************************************************************************************
	****************************************************************************************************
	file paths
	****************************************************************************************************
	***************************************************************************************************/
	function getGroupPath(){

	}

	function getSectionPath(){

	}

	function getPagePath(){
		
	}


	/***************************************************************************************************
	****************************************************************************************************
	include from root path helper
	****************************************************************************************************
	***************************************************************************************************/
	function includeFile($filepath){
		include($_SERVER["DOCUMENT_ROOT"] . $filepath);
	}


	/***************************************************************************************************
	****************************************************************************************************
	icons / images
	****************************************************************************************************
	***************************************************************************************************/
	function dspIcon($icon){
		return('<img src="/img/icons/' . $icon . '.png" height="16" width="16" border="0" alt="' . $icon . '">');
	}


	/***************************************************************************************************
	****************************************************************************************************
	standard admin messages
	****************************************************************************************************
	***************************************************************************************************/
	function dspMsgInfo($msg){
		return('
			<div class="ui-widget">
				<div class="ui-corner-all" style="padding: 1px 1em;background-color:#9f9 !important;"> 
					<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
					' . $msg . '</p>
				</div>
			</div>
		');
	}
	function dspMsgWarning($msg){
		return('
			<div class="ui-widget">
				<div class="ui-state-error ui-corner-all" style="padding: 1 1em;"> 
					<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
					' . $msg . '</p>
				</div>
			</div>
		');
	}


	/***************************************************************************************************
	****************************************************************************************************
	database
	****************************************************************************************************
	***************************************************************************************************/
	function dbOpen(){
		require $_SERVER["DOCUMENT_ROOT"] . "/custom/settings.db.inc.php";

		mysql_connect($application_dbserver, $application_dbuser, $application_dbpass);
		mysql_select_db($application_dbname);
	}

	function dbSelect($strQuery){
		$tmpQuery = mysql_query("select " . $strQuery) or die(mysql_error());
		return $tmpQuery;
	}

	function dbSelectAssoc($strQuery){
		return mysql_fetch_assoc(dbSelect($strQuery));
	}

	function dbUpdate($strQuery){
		mysql_query("update " .$strQuery) or die(mysql_error());
	}

	function dbDelete($strQuery){
		mysql_query("delete from " .$strQuery) or die(mysql_error());
	}

	function dbInsert($strQuery){
		mysql_query("insert into " .$strQuery) or die(mysql_error());
	}

	function dbClose(){
		mysql_close();
	}

	/***************************************************************************************************
	****************************************************************************************************
	jQuery buttons
	****************************************************************************************************
	***************************************************************************************************/
	function dspButtonSave($label){
		$strButton = '';
		$strButton = $strButton . '<script type="text/javascript">';
		$strButton = $strButton . '	$(function(){';
		$strButton = $strButton . '		$("#btnSave").click(function(event){';
		$strButton = $strButton . '			event.preventDefault();';
		$strButton = $strButton . '			$("#frmAdmin").submit();';
		$strButton = $strButton . '		});';
		$strButton = $strButton . '	});';
		$strButton = $strButton . '</script>';
		$strButton = $strButton . '<button class="btnSave" id="btnSave">' . $label . '</button>';

		return $strButton;
	}

	function dspButtonDelete($url){
		$strButton = '';
		$strButton = $strButton . '<script type="text/javascript">';
		$strButton = $strButton . '	$(function(){';
		$strButton = $strButton . '		$("#btnDelete").click(function(event){';
		$strButton = $strButton . '			event.preventDefault();';
		$strButton = $strButton . '			confirmDelete(\'' . $url . '\');';
		$strButton = $strButton . '		});';
		$strButton = $strButton . '	});';
		$strButton = $strButton . '</script>';
		$strButton = $strButton . '<button class="btnSave" id="btnDelete">Delete</button>';

		return $strButton;
	}

	function dspButtonDeleteWithId($url, $id){
		$strButton = '';
		$strButton = $strButton . '<script type="text/javascript">';
		$strButton = $strButton . '	$(function(){';
		$strButton = $strButton . '		$("#' . $id . '").click(function(event){';
		$strButton = $strButton . '			event.preventDefault();';
		$strButton = $strButton . '			confirmDelete(\'' . $url . '\');';
		$strButton = $strButton . '		});';
		$strButton = $strButton . '	});';
		$strButton = $strButton . '</script>';
		$strButton = $strButton . '<button class="btnSave" id="' . $id . '">Delete</button>';

		return $strButton;
	}

	/***************************************************************************************************
	****************************************************************************************************

	****************************************************************************************************
	***************************************************************************************************/
	function dspSavedMessage($msg){
		$pageheader = $msg;
		include_once $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.inc.php";

		echo '<p align="center">' . $msg . '.</p>';
		echo '<p align="center"><a href="/admin/sitemap/index.php">Go to Site Content</a></p>';

		include_once $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/footer.inc.php";
	}


	/***************************************************************************************************
	****************************************************************************************************
	image functions
	****************************************************************************************************
	***************************************************************************************************/
	function resizeImageTo($orig, $dest, $heightMax, $widthMax) {
		// GET WIDTH AND HEIGHT OF ORIGINAL
		list($widthMaxidth, $heightMaxeight) = getimagesize($orig);

		// CALCULATE NEW WIDTH AND HEIGHT
		if ($widthMaxidth > $heightMaxeight) {

			// LANDSCAPE
			$new_width = $widthMax;
			$new_height = round($heightMaxeight * ($widthMax / $widthMaxidth));
			if ($new_height > $heightMax) {
				$new_height = $heightMax;
				$new_width = round($widthMaxidth * ($heightMax / $heightMaxeight));
			}

		} else {

			// PORTRAIT
			$new_height = $heightMax;
			$new_width = round($widthMaxidth * ($heightMax / $heightMaxeight));
			if ($new_width > $widthMax) {
				$new_width = $widthMax;
				$new_height = round($heightMaxeight * ($widthMax / $widthMaxidth));
			}
		}

		// OPEN IMAGES IN MEMORY
		$source = imagecreatefromjpeg($orig);
		$thumb = imagecreatetruecolor($new_width,$new_height);

		// RESIZE
		imagecopyresized($thumb, $source, 0, 0, 0, 0,
			$new_width, $new_height, $widthMaxidth, $heightMaxeight);

		// SAVE RESIZED
		imagejpeg($thumb, $dest, 90);

		// DESTROY IMAGES IN MEMORY
		imagedestroy($source);
		imagedestroy($thumb);
	}
?>
