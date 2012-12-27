<?php
	exec('find . -name "*.cfm" | while read i;
	do
		mv "$i" "${i%.cfm}.php";
	done
	')
?>
rename done
