<?php
session_start();

require_once("../model/db.php");
require_once("../model/personas.php");
			
$a = new Persona();

if(isset($_POST['opt'])){	
	switch($_POST['opt']){
		case 1:
			$result = $a->saveAtencion($_POST);

			if($result != false){
				$result = "finCorrecto";
			}
			else{
				$result = "errorAlta";
			}			
			break;
			
		case 3:
			require_once("../model/acciones.php");
			$o = new Accion();
			$ops = $o->getAll();
			include("../view/nuevaAtencion.html");
			break;
			
		case 2:
			$result = $a->deleteAtencion($_POST['id']);

			if($result){
				$result = "finCorrecto";
			}
			else{
				$result = "errorBorrar";
			}			
			break;
       
	   default:
			break;
	}

	switch($_POST['opt']){
		case 1:
		case 2:
			echo($result);
			break;
			
	   default:
			break;
	}
		
}

?>
