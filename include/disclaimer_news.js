function disclaimer() {
	if(document.getElementById('testo_d').style.display == 'none') {
		document.getElementById('testo_d').style.display='';
		document.getElementById('titolo_d').innerHTML = "Disclaimer";
	} else {
		document.getElementById('testo_d').style.display='none';
		document.getElementById('titolo_d').innerHTML = "[Disclaimer]";
	}
}

function news() {
	if(document.getElementById('testo_n').style.display == 'none') {
		document.getElementById('testo_n').style.display='';
		document.getElementById('titolo_n').innerHTML = "News";
	} else {
		document.getElementById('testo_n').style.display='none';
		document.getElementById('titolo_n').innerHTML = "[News]";
	}
}