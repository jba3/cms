			<br><br><br>
			<div class="fb-like" data-send="true" data-width="450" data-show-faces="false" data-font="verdana"></div>
		</td>
		<td width="200" class="menu" valign="top">
			<?php
				if(!(isset($_COOKIE['isMobileDevice']))){
					echo '<div class="menu-group">Your host, Sir James</div><img src="/img/sidebar.jpg" width="200" height="455"><br><br>';
				}
			?>
			<div class="menu-group">TAGS</div>
			<div class="menu-tags">
				<a href="/tags/mdrf/">MDRF</a>, <a href="/tags/varf/">VARF</a><br>
				<br>
				<a href="/tags/2012/">2012</a>, <a href="/tags/2011/">2011</a>, <a href="/tags/2010/">2010</a>, <a href="/tags/2009/">2009</a>, <a href="/tags/2008/">2008</a><br>
				<br>
				<a href="/tags/merctailor/">MercTailor</a>, <a href="/tags/icefalcon/">IceFalcon</a>, <a href="/tags/madmatt/">Mad Matt</a><br>
				<br>
				<a href="/tags/12th/">12th</a>, <a href="/tags/14th/">14th</a>, <a href="/tags/15th/">15th</a>, <a href="/tags/16th/">16th</a><br>
			</div>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td class="timestamp" align="center">
			<br>
			<?php
				echo 'Page created on ' . $qryPage['pageDateCreated'];
				if ($qryPage['pageDateCreated'] <> $qryPage['pageDateUpdated']){
					echo ', and last updated at ' . $qryPage['pageDateUpdated'];
				}
			?>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr><td colspan="<?php echo $colspan ?>" class="footer1">Email me at: james.anderson.iii (at) gmail (dot) com</td></tr>
	<tr><td colspan="<?php echo $colspan ?>" class="footer2">Copyright &copy;2010-<?php echo date('Y') ?> JBA3</td></tr>
</table>

<div id="setMobile">
	Mobile version:
	<?php
		if(isset($_COOKIE['isMobileDevice'])){
			echo '<a href="/mobile/off.php">Turn Off</a>';
		}else{
			echo '<a href="/mobile/on.php">Turn On</a>';
		}
	?>
</div>
