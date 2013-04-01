<?php
	$pageheader = "Edit Group";
	require "../includes/header.inc.php";

	dbOpen();
		$qryGroup = mysql_fetch_assoc(dbSelect("groupID,groupName,groupSortOrder from cms_groups where groupID=" . $_GET["groupID"]));
	dbClose();
?>



<form method="post" action="editSubmit.php" id="frmAdmin">
	<input type="hidden" name="groupID" value="<?php echo $_GET["groupID"] ?>">

	<table align="center" class="form">
		<tr>
			<td class="label">Name</td>
			<td class="required"><input type="text" name="groupName" value="<?php echo $qryGroup["groupName"] ?>" maxlength="128" data-bvalidator="required"></td>
		</tr>
		<tr>
			<td class="label">Sort Order</td>
			<td class="required"><input type="text" name="groupSortOrder" value="<?php echo $qryGroup["groupSortOrder"] ?>" maxlength="4" data-bvalidator="required,digit,between[0:9999]"></td>
		</tr>
	</table>

	<p align="center">
		<?php
			echo dspButtonDelete('/admin/groups/delete.php?groupID=' . $_GET["groupID"]);
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo dspButtonSave("Update Group");
		?>
	</p>
</form>



<?php
	require "../includes/footer.inc.php";
?>
