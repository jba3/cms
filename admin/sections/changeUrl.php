<?php
	$pageheader = "Change URL (Section)";
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.inc.php";

	dbOpen();
		$qryURL = mysql_fetch_assoc(dbSelect("sectionID, sectionFolder from cms_sections where sectionID=" . $_GET["sectionID"]));
	dbClose();
?>



<form method="post" action="changeUrlSubmit.php" id="frmAdmin">
	<input type="hidden" name="sectionID" value="<?php echo $_GET["sectionID"] ?>">
	<input type="hidden" name="sectionFolder" value="<?php echo $qryURL["sectionFolder"] ?>">

	<table align="center" class="form">
		<tr>
			<td class="label">Current Folder/URL</td>
			<td><?php echo $qryURL["sectionFolder"] ?></td>
		</tr>
		<tr>
			<td class="label">New Folder/URL</td>
			<td class="required"><input type="text" name="sectionFolderNew" maxlength="32" data-bvalidator="required"></td>
		</tr>
	</table>

	<p align="center">
		<?php
			echo dspButtonSave("Update Section URL");
		?>
	</p>
</form>



<?php
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/footer.inc.php";
?>
