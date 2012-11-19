<?php
	if(isset($_COOKIE['isMobileDevice'])){
		$colspan = 2;
	}else{
		$colspan = 3;
	}
?>



<div id="header1">
	<table>
		<tr>
			<td><a href="/"><img border="0" src="/custom/img/shield.png" height="100" width="87"/></a></td>
			<td><a href="/"><img border="0" src="/custom/img/header-left.png" height="100" width="536"/></a></td>
		</tr>
	</table>
</div>

<table id="main">
	<tr><td colspan="<?php echo $colspan ?>" class="header2">&quot;In the sword you shall have trust and belief, so that the blood runs not over the eyes.&quot; ~Master Hans Talhoffer</td></tr>
	<tr>
		<td width="200" class="menu" valign="top">
			<?php
				$old_groupID = '';
				$old_sectionID = '';

				dbOpen();
					$qryMenu = dbSelect("*,IFNULL( pageDateUpdated, pageDateCreated ) as lastUpdate from `cms_groups` g join `cms_sections` s on g.groupid=s.groupid join `cms_pages` p on s.sectionid=p.sectionid where groupSortOrder>0 and sectionSortOrder>0 and pageSortOrder>0 and parentPageID=0 and g.hideFromMenu=0 order by groupSortOrder asc, sectionSortOrder asc, pageSortOrder asc");
				dbClose();

				while ($row = mysql_fetch_assoc($qryMenu)) {
					if (strtotime($row['lastUpdate']) >= strtotime('-1 month')){
						$blnFlagUpdated = true;
					}else{
						$blnFlagUpdated = false;
					}
/*
					if (
						// expand current group - close all others
						(($requestGroup == $row['groupFolder']) || ($requestGroup == '' && $row['groupFolder'] == 'home'))
						// also, force expand if it's a mobile device
						|| (isset($_COOKIE['isMobileDevice']))
					){
*/
						$thisMenuDisplay = "block";
/*
					}else{
						$thisMenuDisplay = "none";
					}
*/

					if ($row["groupID"] <> $old_groupID){
						if ($old_groupID <> 0){
							echo '</div><br>';//<br>
						}
//						echo '<div class="menu-group" onclick="javascript:jQuery(\'#menu-group-' . $row['groupID'] . '\').toggle();">' . $row['groupName'] . '</a></div>';
						echo '<div class="menu-group">' . $row['groupName'] . '</div>';
						echo '<div id="menu-group-' . $row['groupID'] . '" style="display:' . $thisMenuDisplay . '">';
					}

					if (($row['sectionID'] <> $old_sectionID) && !($row["hideLabelInMenu"])){
						echo '<div class="menu-section">' . $row['sectionName'] . '</div>';
					}

					echo '<div class="menu-page';
					if ($blnFlagUpdated){
						echo ' menu-page-updated';
					}
					if ($requestGroup == $row['groupFolder'] && $requestSection == $row['sectionFolder'] && $requestPage == $row['pageFolder']){
						echo ' menu-page-active"';
					}
					echo '" onclick="javascript:location.href=\'/' . $row['groupFolder'] . '/' . $row['sectionFolder'] . '/' . $row['pageFolder'] . '\';">';

					// highlight last 30 days
//					echo '[[' . strtotime($row['pageDateUpdated']) . '||' . strtotime('-1 month') . ']]';
					echo $row['menuText'] . ' ';
					if ($blnFlagUpdated){
						echo '<img src="/img/new_icon_small.jpg" height="14" width="31" border="0" alt="This page has been added or updated in the last month">';
//					}else{
//						echo '<img src="/img/blank.gif" height="14" width="31" border="0">';
					}

					echo '</div>';

					$old_groupID = $row['groupID'];
					$old_sectionID = $row['sectionID'];
				}
			?>
			</div><!-- closes out from the menu above -->
			<br>
		</td>
		<td valign="top" class="content">