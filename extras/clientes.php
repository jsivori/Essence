<?php
session_start();

require_once("../model/db.php");
require_once("../model/personas.php");

$a = new Persona();

if(isset($_POST['opt'])){	
	switch($_POST['opt']){
		case 1:
			$result = $a->save($_POST);

			if($result != false){
				if($result == 1)
					$result = "finCorrecto";
			}
			else{
				$result = "errorAlta";
			}			
			break;
			
		case 3:
			$result = $a->editarPersona($_POST);

			if($result != false){
				$result = "finCorrecto";
			}
			else{
				$result = "errorUpdate";
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