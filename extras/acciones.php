<?php
session_start();

if(isset($_POST['opt'])){	
	switch($_POST['opt']){
		case 'alta':
			include("../view/altaDetalleOperacion.html");
			break;
       
	   default:
			$error = "La pagina solicitada no existe, intente nuevamente...";
			include("../view/error.html");
			break;
	}	
}
else{
	$error = "La pagina solicitada no existe, intente nuevamente...";
	include("../view/error.html");
	break;
}

?>