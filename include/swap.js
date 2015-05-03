normal = new Image;
normal.src = "images/send.png";
hover = new Image;
hover.src = "images/send2.png";

function swapImage(nom) {
	document["send_image"].src = eval(nom).src;
}