<?php
session_start();

if((!isset($_POST['opt'])) or (!is_numeric($_POST['opt'])) or (!isset($_SESSION['log'])))
	$_POST['opt'] = 0;

switch ($_POST['opt']){
	case 1:	
		require_once("../model/db.php");
		require_once("../model/acciones.php");

		$m_accion = new Accion();
		$acciones = $m_accion->getAll();
		$pag = '../view/listadoAcciones.html';	
		break;
		
	case 2:
		$pag = '../view/nuevaAccion.html';		
		break;
				
	default:
		if(isset($_SESSION) or (session_id() != ''))
			session_destroy();
		$pag = '../view/index.html';	

}
include "../view/layout.html"

?>