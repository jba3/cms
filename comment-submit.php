<?php
	session_start();

	$pageID = $_POST["pageID"];
	$name = $_POST["entryName"];
	$email = $_POST["entryEmail"];
	$emailHide = (isset($_POST["entryEmailHide"]) ? '1' : '0');
	$comment = $_POST["entryComment"];

	// fields validation check
	if ($name == "" || $email == "" || $comment == ""){
		echo '<p align="center">Form field validation failed. You did not enter all the required fields and the javascript validation did not work.</p>';
		echo '<p align="center">Please go <a href=\'javascript:history.go(-1);\'>back</a> and try again.</p>';
		exit;
	}

	require "securimage/securimage.php";

	$securimage = new Securimage();

	// if CAPTCHA validation fails
	if ($securimage->check($_POST['captcha_code']) == false) {
		echo '<p align="center">The security code entered was incorrect.</p>';
		echo '<p align="center">Please go <a href=\'javascript:history.go(-1);\'>back</a> and try again.</p>';
		exit;
	}

	// fields validated, CAPTCHA passed!
	require "phpincludes/settings.inc.php";

	// send email
	$mailTo = $application_email;
	$mailSubject = "New website comment posted";
	$mailContent = "A new comment has been posted on your site and is waiting for approval.\n\n" . "Name: " . $name . "\n\n" ."Email: " . $email . "\n\n" . "Comment: " . $comment;

	mail($mailTo, $mailSubject, $mailContent);

	// db insert
	dbOpen();
		dbInsert("
			cms_pageComments(
				entryName, entryEmail, entryComment, entryEmailHide, entryDtsAdd, isApproved, pageID
			)VALUES(
				'$name', '$email', '$comment', $emailHide, CURDATE(), 0, $pageID
			)
		");
	dbClose();

	echo '<p align="center">Your comment has been received. Please note that it MUST be approved by us before it will appear on the website!</p>';
	echo '<p align="center"><a href=\'javascript:history.go(-1);\'>Back to the page you were on</a></p>';
?>
