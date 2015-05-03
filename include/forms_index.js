normal = new Image;
normal.src = "images/send.png";
hover = new Image;
hover.src = "images/send2.png";

function swapImage(nom) {
	document["send_image"].src = eval(nom).src;
}

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
