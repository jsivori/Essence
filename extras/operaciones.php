<?php
session_start();

require_once("../model/db.php");
require_once("../model/acciones.php");

$a = new Accion();
			
if(isset($_POST['opt'])){	
	switch($_POST['opt']){
		case 1:	
			$result = $a->save($_POST['descripcion']);
			if($result != false){
				if($result == 1)
					$result = "finCorrecto";
			}
			else{
				$result = "errorAlta";
			}			
			break;
			
		case 2:
			$result = $a->delete($_POST['id']);
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
	
	echo($result);	
}

?>