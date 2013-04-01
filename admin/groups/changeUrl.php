<?php
	$pageheader = "Change URL (Group)";
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.inc.php";

	dbOpen();
		$qryURL = mysql_fetch_assoc(dbSelect("groupID, groupFolder from cms_groups where groupID=" . $_GET["groupID"]));
	dbClose();
?>



<form method="post" action="changeUrlSubmit.php" id="frmAdmin">
	<input type="hidden" name="groupID" value="<?php echo $_GET["groupID"] ?>">
	<input type="hidden" name="groupFolder" value="<?php echo $qryURL["groupFolder"] ?>">

	<table align="center" class="form">
		<tr>
			<td class="label">Current Folder/URL</td>
			<td><?php echo $qryURL["groupFolder"] ?></td>
		</tr>
		<tr>
			<td class="label">New Folder/URL</td>
			<td class="required"><input type="text" name="groupFolderNew" maxlength="64" data-bvalidator="required"></td>
		</tr>
	</table>

	<p align="center">
		<?php
			echo dspButtonSave("Update Group URL");
		?>
	</p>
</form>



<?php
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/footer.inc.php";
?>
