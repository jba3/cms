<?php
	$pageheader = "Edit Page";
	require "../includes/header.inc.php";



	dbOpen();
		$qryPage = mysql_fetch_assoc(dbSelect("pageFolder,allowPageComments,menuText,pageTitle,pageSortOrder,hasMusic,passkey,sectionID,tags,hasPHP from cms_pages where pageID=" . $_GET["pageID"]));
		$qrySection = mysql_fetch_array(dbSelect("groupID,sectionFolder from cms_sections where sectionID=" . $qryPage["sectionID"]));
		$qryGroup = mysql_fetch_array(dbSelect("groupFolder from cms_groups where groupID=" . $qrySection["groupID"]));
		$qryImages = dbSelect("imageID,filesize,filename,imagedtsadd,pageID from cms_pageImages where pageID=" . $_GET["pageID"] . " order by filename");
	dbClose();

	$path = "../../content/" . $qryGroup["groupFolder"] . '/' . $qrySection["sectionFolder"] . '/' . $qryPage["pageFolder"];

	$filename = $path . '/content.php';
	$handle = fopen($filename, "r") or die('Failed to read file!');
	$fileContent = fread($handle, filesize($filename));
	fclose($handle);

	$qryImagesCount = mysql_num_rows($qryImages);



	if ($qryPage["hasPHP"] == 0){
		require "../includes/wysiwyg.inc.php";
	}
?>



<form method="post" action="/admin/pages/editSubmit.php" enctype="multipart/form-data" id="frmAdmin">
	<input type="hidden" name="pageID" value="<?php echo $_GET["pageID"] ?>">

	<table align="center" class="form">
		<tr>
			<td class="label" width="30%">Menu Text</td>
			<td class="required" width="70%"><input type="text" name="menuText" value="<?php echo $qryPage["menuText"] ?>" maxlength="50" style="width:100%"></td>
		</tr>
		<tr>
			<td class="label">Title</td>
			<td class="required"><input type="text" name="pageTitle" value="<?php echo $qryPage["pageTitle"] ?>" maxlength="128" style="width:100%"></td>
		</tr>
		<tr>
			<td class="label">Sort Order</td>
			<td class="required"><input type="text" name="pageSortOrder" value="<?php echo $qryPage["pageSortOrder"] ?>" maxlength="4" style="width:100%"></td>
		</tr>
		<tr>
			<td class="label">Comments</td>
			<td class="required">
				<input type="radio" name="allowPageComments" value="1" <?php if ($qryPage["allowPageComments"] == 1) echo 'checked' ?>> Yes
				&nbsp;&nbsp;&nbsp;
				<input type="radio" name="allowPageComments" value="0" <?php if ($qryPage["allowPageComments"] == 0) echo 'checked' ?>> No
			</td>
		</tr>
		<tr>
			<td class="label">Music (MP3 format)</td>
			<td class="optional">
				<?php
					if ($qryPage["hasMusic"] == 1){
						echo '<input type="checkbox" name="deleteMusic" value="1"> Check this box to delete music from this page';
					}else{
						echo '<input type="file" name="music">';
					}
				?>
			</td>
		</tr>
		<tr>
			<td class="label">Password</td>
			<td class="optional"><input type="text" name="passkey" value="<?php echo $qryPage["passkey"] ?>" maxlength="16" style="width:100%"></td>
		</tr>
		<tr>
			<td class="label">Tags** (see bottom of page)</td>
			<td class="optional"><input type="text" name="tags" value="<?php echo $qryPage["tags"] ?>" style="width:100%"></td>
		</tr>
		<tr>
			<td class="label">Has PHP?</td>
			<td class="optional">
				<input type="radio" name="hasPHP" value="1" <?php if ($qryPage["hasPHP"] == 1) echo 'checked' ?>> Yes
				&nbsp;&nbsp;&nbsp;
				<input type="radio" name="hasPHP" value="0" <?php if ($qryPage["hasPHP"] == 0) echo 'checked' ?>> No
			</td>
		</tr>
		<?php
			if ($qryImagesCount > 0){
				echo '<tr><td class="label" colspan="2" align="center"><em>Click in the text editor where you want to insert the image, then click on the image in the bar below.</em></td></tr>';
				echo '<tr>';
				echo '	<td colspan="2">';
				echo '		<div id="imageBar" style="height:120px;width:692px;border:1px solid #000;overflow:scroll;">';
				while ($rowImages = mysql_fetch_assoc($qryImages)){
					$imgPath = $path . '/images/' . $rowImages["filename"];
					echo '<a href="#" onclick="javascript:$(\'textarea#pageContent\').wysiwyg(\'insertImage\', \'' . $imgPath . '\');"><img src="' . $imgPath . '" height="100" border="0"></a>&nbsp;';
				}
				echo '		</div>';
				echo '	</td>';
				echo '</tr>';
			}
		?>
		<tr>
			<td colspan="2" align="center"><textarea name="content" id="pageContent" style="width:700px;height:400px"><?php echo $fileContent ?></textarea></td>
		</tr>
	</table>

	<p align="center">
		<?php
			echo dspButtonDelete('/admin/pages/delete.php?pageID=' . $_GET["pageID"]);
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo dspButtonSave("Update Page");
		?>
	</p>

	<p align="center">
		** Tags MUST have a comma in front and comma at the end!<br>
		If you want 3 tags, like "spoon,fork,knife" it should be ",spoon,fork,knife," or the tag search will not work!!
	</p>
</form>

<?php
	require "../includes/footer.inc.php";
?>
