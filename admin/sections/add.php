<?php
	$pageheader = "Add Section";
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.inc.php";
?>



<form method="post" action="addSubmit.php" id="frmAdmin">
	<input type="hidden" name="groupID" value="<?php echo $_GET["groupID"] ?>">

	<table align="center" class="form">
		<tr>
			<td class="label">Folder/URL</td>
			<td class="required"><input type="text" name="sectionFolder" maxlength="32" data-bvalidator="required"></td>
		</tr>
		<tr>
			<td class="label">Name</td>
			<td class="required"><input type="text" name="sectionName" maxlength="32" data-bvalidator="required"></td>
		</tr>
		<tr>
			<td class="label">Sort Order</td>
			<td class="required"><input type="text" name="sectionSortOrder" maxlength="4" data-bvalidator="required,digit,between[0:9999]"></td>
		</tr>
	</table>

	<p align="center">
		<?php echo dspButtonSave("Add Section") ?>
	</p>
</form>



<?php
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/footer.inc.php";
?>
