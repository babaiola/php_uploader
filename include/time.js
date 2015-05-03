giorni = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
mesi = new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

function visdata() {
	var tempo = new Date();
	var numero = tempo.getDate();
	var mese = tempo.getMonth();
	var anno = tempo.getFullYear();
	var giorno = tempo.getDay();
	var data = numero + " " + mesi[mese]  + " " + anno;
	if(document.all) {
		document.all.giorno.innerHTML = giorni[giorno] + " " + data;
	} else if(document.getElementById) {
		document.getElementById('giorno').innerHTML = giorni[giorno] + " " + data;
	} else if(document.layers) {
		document.layers['giorno'].document.write('<span id="giorno">' + giorni[giorno] + " " + data + '</span>');
		document.layers['giorno'].document.close();
	}
}

function visora() {
	var tempo = new Date();
	var ore = tempo.getHours();
	var min = tempo.getMinutes();
	var sec = tempo.getSeconds();
	var ore0  = ((ore < 10) ? "0" : "");
	var min0  = ((min < 10) ? ":0" : ":");
	var sec0  = ((sec < 10) ? ":0" : ":");
	var orario = ore0 + ore + min0 + min + sec0 + sec;
	if(document.all){
		document.all.orario.innerHTML = orario;
	} else if(document.getElementById) {
		document.getElementById('orario').innerHTML = orario;
	} else if(document.layers) {
		document.layers['orario'].document.write('<span id="orario">' + orario + '</span>');
		document.layers['orario'].document.close();
	}
	window.setTimeout("visora()", 1000);
}