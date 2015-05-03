function check() {
	var myform = document.upload;
	var cont = 0;
	if(myform.file.value == '') {
		cont++;
	}
	if(!cont) {
		myform.submit();
	} else {
		window.alert("Please type a valid path...\nSeleziona un file...");
	}
}