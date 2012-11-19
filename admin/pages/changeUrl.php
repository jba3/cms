<?php
	$pageheader = "Change URL (Page)";
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.inc.php";

	dbOpen();
		$qryURL = dbSelect("pageID, pageFolder from cms_pages where pageID=$_GET[pageID]");
	dbClose();
?>



<form method="post" action="changeUrlSubmit.php" id="frmAdmin">
	<input type="hidden" name="pageID" value="<?php echo $_GET["pageID"] ?>">
	<input type="hidden" name="pageFolder" value="<?php echo $qryURL["pageFolder"] ?>">

	<table align="center" class="form">
		<tr>
			<td class="label">Current Folder/URL</td>
			<td><?php echo $qryURL["pageFolder"] ?></td>
		</tr>
		<tr>
			<td class="label">New Folder/URL</td>
			<td class="required"><input type="text" name="pageFolderNew" maxlength="64" data-bvalidator="required"></td>
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
