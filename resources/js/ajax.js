function creaAjax() {
	var objetoAjax=false;
  	try {
   		/*Para navegadores distintos a internet explorer*/
   		objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
  	}
	catch (e) {
		try {
     		/*Para explorer*/
     		objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
		}
     	catch (E) {
     		objetoAjax = false;
   		}
	}
	if (!objetoAjax && typeof XMLHttpRequest!='undefined') {
		objetoAjax = new XMLHttpRequest();
	}
	return objetoAjax;
}

function cargarPaginaDiv(pagina, parametros, valores, div) {
	var ajax = creaAjax();
	ajax.open ('POST', pagina, true);
	ajax.onreadystatechange = function() {
		if ((ajax.readyState == 4) && (ajax.status == 200)) {
			document.getElementById(div).innerHTML = ajax.responseText;
			if(document.getElementById(div).style.display != "block")
				document.getElementById(div).style.display = "block";
		}
	}
	ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	ajax.send(devolverValores(parametros,valores));
	return;
}

function cargarPaginaDivSinc(pagina, parametros, valores) {
    var ajax = creaAjax();
    var parametro= devolverValores(parametros,valores);
	ajax.open ('POST', pagina, false);
	ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	ajax.send(parametro);
	if(ajax.status == 200) {
		return ajax.responseText;
	}
}

function devolverValores(nombres, valores) {
	var cadena="";
	if(nombres != null && nombres != '') {
		for(i=0; i<nombres.length; i++) {
			cadena = cadena+nombres[i]+'='+valores[i]+'&';
		}
		cadena = cadena.substring(0,cadena.length-1);
	}
	return cadena;
}