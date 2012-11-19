<?php
	$pageheader = "Add Group";
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.inc.php";
?>



<form method="post" action="addSubmit.php" id="frmAdmin">
	<table align="center" class="form">
		<tr>
			<td class="label">Folder/URL</td>
			<td class="required"><input type="text" name="groupFolder" maxlength="64" data-bvalidator="required"></td>
		</tr>
		<tr>
			<td class="label">Name</td>
			<td class="required"><input type="text" name="groupName" maxlength="128" data-bvalidator="required"></td>
		</tr>
		<tr>
			<td class="label">Sort Order</td>
			<td class="required"><input type="text" name="groupSortOrder" maxlength="4" data-bvalidator="required,digit,between[0:9999]"></td>
		</tr>
	</table>

	<p align="center">
		<?php echo dspButtonSave("Add Group") ?>
	</p>
</form>



<?php
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/footer.inc.php";
?>
