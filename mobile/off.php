<?php
	setcookie("isMobileDevice", "false", time() - 3600, "/");

	header('Location: /');
?>
