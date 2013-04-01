function validateFormComment(){
	var frm = document.forms["addComment"];
	var atpos = '';
	var dospos = '';

	email = frm["entryEmail"].value;
	atpos = email.indexOf("@");
	dotpos = email.lastIndexOf(".");

	if (frm["entryName"].value == ""){
		alert('Please enter your name.');
		return false;
	}else if (frm["entryEmail"].value == "" || atpos < 1 || dotpos < (atpos + 2) || (dotpos + 2) >= email.length){
		alert('Please enter your email address.');
		return false;
	}else if (frm["entryComment"].value == ""){
		alert('Please enter your comment in the big text box.');
		return false;
	}else if (frm["captcha_code"].value == ""){
		alert('Please enter the orange text from the image in the validation box underneath it.');
		return false;
	}
}
