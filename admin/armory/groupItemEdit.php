<?php
	$pageheader = "Armory Group Item (Edit)";
	require "../includes/header.inc.php";

	dbOpen();
		$qryRecord = mysql_fetch_assoc(dbSelect("* from armory where armoryID=" . $_GET['armoryID']));
		$qryGroup = mysql_fetch_assoc(dbSelect("* from armoryGroups where groupID=" . $_GET['groupID']));
		$qryGroups = dbSelect("* from armoryGroups where categoryID=" . $qryGroup['categoryID'] . " order by groupSort,groupName");
		$qryStatus = dbSelect("* from armoryStatus order by armoryStatus");
		$qrySlots = dbSelect("* from armorySlot order by armorySlotSortOrder");
		$qryMaterials = dbSelect("* from armoryMaterial order by materialSort");
		$qryMakers = dbSelect("* from armoryMaker order by armoryMaker");
	dbClose();
?>

<style type="text/css">
	table.editForm{border:0px none;border-collapse:none;width:800px;margin:0px auto;}
		table.editForm tr th{background-color:#999;padding:10px;}
		table.editForm tr td{background-color:#ccc;padding:10px;}
	input,select,textarea{border:1px solid #000;background-color:#eee;}
</style>

<form action="groupItemEditSave.php" method="post">
	<input type="hidden" name="groupID" value="<?php echo $_GET['groupID'] ?>">
	<input type="hidden" name="armoryID" value="<?php echo $_GET['armoryID'] ?>">
	<input type="hidden" name="categoryID" value="<?php echo $qryGroup['categoryID'] ?>">

	<table class="editForm">
	<tr><th colspan="3">Currently in: <?php echo $qryGroup['groupName'] ?></th></tr>
		<tr>
			<td valign="top" colspan="3">
				<p><strong>Internal Stuff (not public)</strong></p>
				Status:<select name="armoryStatusID">
				<?php
					while ($row = mysql_fetch_assoc($qryStatus)) {
						echo '<option value="' . $row['armoryStatusID'] . '"';
						if ($row['armoryStatusID'] == $qryRecord['armoryStatusID']){
							echo ' selected ';
						}
						echo '>' . $row['armoryStatus'] . '</option>';
					}
				?>
				</select>(only RECEIVED will show up on public page)<br>
				Cost<input type="text" name="cost" size="8" maxlength="8" style="text-align:right" value="<?php echo $qryRecord['cost'] ?>"><br>
				Purchase Date (MM/DD/YYYY)
				<input type="text" name="purchaseDateMM" size="1" style="text-align:right" maxlength="2" value="<?php echo $qryRecord['purchaseDateMM'] ?>">
				<input type="text" name="purchaseDateDD" size="1" style="text-align:right" maxlength="2" value="<?php echo $qryRecord['purchaseDateDD'] ?>">
				<input type="text" name="purchaseDateYYYY" size="2" style="text-align:right" maxlength="4" value="<?php echo $qryRecord['purchaseDateYYYY'] ?>">
				<br>
				Purchase Link<input type="text" name="purchaseLink" size="64" maxlength="512" value="<?php echo $qryRecord['purchaseLink'] ?>"><br>
			</td>
		</tr>
		<tr>
			<td valign="top" colspan="3">
				<input type="text" style="text-align:right" name="sortOrder" size="2" maxlength="3" value="<?php echo $qryRecord['sortOrder'] ?>">Sort Order<br>
			</td>
		</tr>
		<tr>
			<td valign="top" colspan="3">
				Description:<input type="text" name="description" size="64" maxlength="64" value="<?php echo $qryRecord['description'] ?>"><br>
				Group:<select name="groupID">
				<?php
					while ($row = mysql_fetch_assoc($qryGroups)) {
						echo '<option value="' . $row['groupID'] . '"';
						if ($row['groupID'] == $qryRecord['groupID']){
							echo ' selected ';
						}
						echo '>' . $row['groupName'] . '</option>';
					}
				?>
				</select><br>
				Maker:<select name="armoryMakerID">
				<?php
					while ($row = mysql_fetch_assoc($qryMakers)) {
						echo '<option value="' . $row['armoryMakerID'] . '"';
						if ($row['armoryMakerID'] == $qryRecord['armoryMakerID']){
							echo ' selected ';
						}
						echo '>' . $row['armoryMaker'] . '</option>';
					}
				?>
				</select><br>
				Material:<select name="materialID">
				<?php
					while ($row = mysql_fetch_assoc($qryMaterials)) {
						echo '<option value="' . $row['materialID'] . '"';
						if ($row['materialID'] == $qryRecord['materialID']){
							echo ' selected ';
						}
						echo '>' . $row['material'] . '</option>';
					}
				?>
				</select><br>
			</td>
		</tr>
		<tr>
				<td valign="top">
					<input type="text" style="text-align:right" name="style" size="1" maxlength="1" value="<?php echo $qryRecord['century'] ?>">Style (1=English,2=German)<br>
					<input type="text" style="text-align:right" name="century" size="1" maxlength="2" value="<?php echo $qryRecord['style'] ?>">Century (as ##)<br>
					<input type="text" style="text-align:right" name="isGarniture" size="1" maxlength="1" value="<?php echo $qryRecord['isGarniture'] ?>">Garniture Piece (0 or 1)<br>
					<input type="text" style="text-align:right" name="isFunctional" size="1" maxlength="1" value="<?php echo $qryRecord['isFunctional'] ?>">Functional (0 or 1)<br>
					<input type="text" style="text-align:right" name="isHistorical" size="1" maxlength="1" value="<?php echo $qryRecord['isHistorical'] ?>">Historical (0 or 1)<br>
					<input type="text" style="text-align:right" name="weightLbs" size="1" maxlength="2" value="<?php echo $qryRecord['weightLbs'] ?>">
					<input type="text" style="text-align:right" name="weightOz"  size="1" maxlength="2" value="<?php echo $qryRecord['weightOz']  ?>">Weight (lbs)(oz)<br>
				</td>
				<?php
					if ($qryGroup['categoryID'] == 1 || $qryGroup['categoryID'] == 3){// weapons
						echo '<td valign="top" colspan="3">';
						echo 'Weapons Info<br>';
						echo '<input style="text-align:right" type="text" name="lengthOverall" size="3" maxlength="8" value="'.  $qryRecord['lengthOverall'] .'">lengthOverall<br>';
						echo '<input style="text-align:right" type="text" name="lengthBlade" size="3" maxlength="8" value="'.    $qryRecord['lengthBlade'] .'">lengthBlade<br>';
						echo '<input style="text-align:right" type="text" name="widthGuard" size="3" maxlength="8" value="'.     $qryRecord['widthGuard'] .'">widthGuard<br>';
						echo '<input style="text-align:right" type="text" name="widthBlade" size="3" maxlength="8" value="'.     $qryRecord['widthBlade'] .'">widthBlade<br>';
						echo '<input style="text-align:right" type="text" name="thicknessBlade" size="3" maxlength="8" value="'. $qryRecord['thicknessBlade'] .'">thicknessBlade<br>';
					}else if ($qryGroup['categoryID'] == 2 || $qryGroup['categoryID'] == 4){// armor
						echo '<td valign="top">';
						echo '<strong>Armor Protects</strong><br>';
						// terrible method, but it's an admin screen for 1 user .... good enough
						dbOpen();
							while ($row = mysql_fetch_assoc($qrySlots)) {
								$qryIsSlotUsed = dbSelectAssoc("* from armoryItemSlots where armoryID=" . $_GET['armoryID'] . " and armorySlotID=" . $row['armorySlotID']);

								echo '<input type="checkbox" name="armorySlotID[]" value="' . $row['armorySlotID'] . '"';
								if (empty($qryIsSlotUsed) == 0){
									echo ' checked';
								}
								echo '>' . $row['armorySlot'] . '<br>';
							}
							echo '</td>';

							mysql_data_seek($qryGroups, 0);

							echo '<td valign="top">';
							echo '<strong>Belongs to harness(es):</strong><br>';

							while ($rowHarnesses = mysql_fetch_assoc($qryGroups)) {
								$qryIsSlotUsed = dbSelectAssoc("* from armoryHarnesses where armoryID=" . $_GET['armoryID'] . " and armoryGroupID=" . $rowHarnesses['groupID']);

								echo '<input type="checkbox" name="armoryHarnessID[]" value="' . $rowHarnesses['groupID'] . '"';
								if (empty($qryIsSlotUsed) == 0){
									echo ' checked';
								}
								echo '>' . $rowHarnesses['groupName'] . '<br>';
							}
						dbClose();
					}
				?>
			</td>
		</tr>
		<tr><td colspan="3" align="center">Item Notes:<br><textarea style="width:100%;height:240px;" name="notes"><?php echo $qryRecord['notes'] ?></textarea></td></tr>
		<tr><td colspan="3" align="center">Historical Based On:<br><textarea style="width:100%;height:100px;" name="notesHistorical"><?php echo $qryRecord['notesHistorical'] ?></textarea></td></tr>
	</table>

	<p align="center">
		<input type="submit">
	</p>
</form>

<?php
	require "../includes/footer.inc.php";
?>
