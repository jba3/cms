<?php
	$pageheader = "Edit Section";
	require "../includes/header.inc.php";

	dbOpen();
		$qrySection = mysql_fetch_assoc(dbSelect("sectionID,sectionName,sectionSortOrder from cms_sections where sectionID=" . $_GET["sectionID"]));
	dbClose();
?>



<form method="post" action="editSubmit.php" id="frmAdmin">
	<input type="hidden" name="sectionID" value="<?php echo $_GET["sectionID"] ?>">

	<table align="center" class="form">
		<tr>
			<td class="label">Name</td>
			<td class="required"><input type="text" name="sectionName" maxlength="32" value="<?php echo $qrySection["sectionName"] ?>" data-bvalidator="required"></td>
		</tr>
		<tr>
			<td class="label">Sort Order</td>
			<td class="required"><input type="text" name="sectionSortOrder" maxlength="4" value="<?php echo $qrySection["sectionSortOrder"] ?>" data-bvalidator="required"></td>
		</tr>
	</table>

	<p align="center">
		<?php
			echo dspButtonDelete('/admin/sections/delete.php?sectionID=' . $_GET["sectionID"]);
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo dspButtonSave("Update Section");
		?>
	</p>
</form>



<?php
	require "../includes/footer.inc.php";
?>
