<?php
	$pageheader = "Add Page";
	require "../includes/header.inc.php";
	require "../includes/wysiwyg.inc.php";
?>

<form method="post" action="addSubmit.php" enctype="multipart/form-data" id="frmAdmin">
	<input type="hidden" name="sectionID" value="<?php echo $_GET["sectionID"] ?>">
	<input type="hidden" name="parentPageID" value="<?php echo $_GET["parentPageID"] ?>">

	<table align="center" class="form">
		<tr>
			<td class="label">Folder/URL</td>
			<td class="required"><input type="text" name="pageFolder" maxlength="64" data-bvalidator="required"></td>
		</tr>

		<tr>
			<td class="label">Menu Text</td>
			<td class="required"><input type="text" name="menuText" maxlength="50" data-bvalidator="required"></td>
		</tr>
		<tr>
			<td class="label">Title</td>
			<td class="required"><input type="text" name="pageTitle" maxlength="128" data-bvalidator="required"></td>
		</tr>

		<tr>
			<td class="label">Sort Order</td>
			<td class="required"><input type="text" name="pageSortOrder" maxlength="4" data-bvalidator="required"></td>
		</tr>

		<tr>
			<td class="label">Comments</td>
			<td class="required">
				<input type="radio" name="allowPageComments" value="1" checked> Yes
				&nbsp;&nbsp;&nbsp;
				<input type="radio" name="allowPageComments" value="0"> No
			</td>
		</tr>
		<tr>
			<td class="label">Music (MP3 format)</td>
			<td class="optional"><input type="file" name="music"></td>
		</tr>
		<tr>
			<td class="label">Password</td>
			<td class="optional"><input type="text" name="passkey" maxlength="16"></td>
		</tr>
		<tr>
			<td class="label">Tags** (see bottom of page)</td>
			<td class="optional"><input type="text" name="tags" value="" style="width:100%"></td>
		</tr>
		<tr>
			<td class="label">Has PHP?</td>
			<td class="optional">
				<input type="radio" name="hasPHP" value="1"> Yes
				&nbsp;&nbsp;&nbsp;
				<input type="radio" name="hasPHP" value="0" checked> No
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><textarea name="content" id="pageContent" style="width:700px;height:400px"></textarea></td>
		</tr>
	</table>

	<p align="center">
		<?php echo dspButtonSave("Add Page") ?>
	</p>

	<p align="center">
		** Tags MUST have a comma in front and comma at the end!<br>
		If you want 3 tags, like "spoon,fork,knife" it should be ",spoon,fork,knife," or the tag search will not work!!
	</p>
</form>

<?php
	require "../includes/footer.inc.php";
?>
