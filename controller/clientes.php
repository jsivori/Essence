<?php
session_start();

if((!isset($_POST['opt'])) or (!is_numeric($_POST['opt'])) or (!isset($_SESSION['log'])))
	$_POST['opt'] = 0;

require_once("../model/db.php");
require_once("../model/personas.php");

switch ($_POST['opt']){
	case 1:	
		$persona = new Persona();
		$clientes = $persona->getClientes();
		$pag = '../view/listado.html';	
		break;
		
	case 2:
		$pag = '../view/clientes.html';		
		break;
	
	case 3:
		if((!isset($_POST['idpersona']))or(!is_numeric($_POST['idpersona']))){
			$error = "No se pudo editar al cliente seleccionado, intente nuevamente";
			$pag = '../view/error.html';	
			break;
		}
		
		$a = new Persona();
		$busqueda = $a->buscarDatosPersona2($_POST['idpersona']);
		
		if(($busqueda == false) or (empty($busqueda))){
			$error = "No se pudo encontrar al cliente seleccionado, intente nuevamente";
			$pag = '../view/error.html';	
			break;
		}
		
		$busqueda = $busqueda[0];
		$pag = '../view/editaClientes.html';		
		break;
		
	case 4:
		if((!isset($_POST['id_persona']))or(!is_numeric($_POST['id_persona']))){
			$error = "No se pudo atender al cliente seleccionado, intente nuevamente";
			$pag = '../view/error.html';	
			break;
		}
		
		$a = new Persona();
		$busqueda = $a->buscarDatosPersona2($_POST['id_persona']);
		
		if(($busqueda == false) or (empty($busqueda))){
			$error = "No se pudo encontrar al cliente seleccionado, intente nuevamente";
			$pag = '../view/error.html';	
			break;
		}
		
		$busqueda = $busqueda[0];
		$atenciones = $a->getAtenciones($busqueda['id_persona']);
		$pag = '../view/atiendeClientes.html';		
		break;
			
	default:
		if(isset($_SESSION) or (session_id() != ''))
			session_destroy();
		$pag = '../view/index.html';	

}

if(!isset($_POST['nolayout'])){
	include "../view/layout.html";
}
else{
	include $pag;
}

?>