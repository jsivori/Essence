<?php
session_start();

require_once("../model/db.php");
require_once("../model/personas.php");

$a = new Persona();

if(isset($_POST['opt'])){	
	$result = $a->controlaSesion($_POST['dni']);

	if($result != false){
		$result = "success";
	}
	else{
		$result = "deny";
	}				
}
else{
	$result = "deny";
}
echo($result);	
?>