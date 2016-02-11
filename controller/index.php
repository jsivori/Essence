<?php
/*error_reporting(E_ALL); 
ini_set("display_errors", 1); 
*/
session_start();

if((!isset($_POST['opt'])) or (!is_numeric($_POST['opt']))){
	$_POST['opt'] = 0;
	if(isset($_SESSION) or (session_id() != ''))
		session_destroy();
	$pag = '../view/login.html';

}

if(!isset($_SESSION) or (session_id() == '')){
	$_POST['opt'] = 0;
}

require_once("../model/db.php");
require_once("../model/personas.php");

switch ($_POST['opt']){
	case 1:	
		$_SESSION['log'] = true;
		$pag = '../view/index.html';	
		break;
	
	case 3:	
		$pag = '../view/login.html';	
		break;
		
	case 2:
		$_SESSION['log'] = false;
		session_destroy();
		$pag = '../view/index.html';
		break;
		
	case 4:	
		$pag = '../view/index.html';	
		break;
		
	default:
		if(isset($_SESSION['log']) or (session_id() != ''))
			session_destroy();
		$pag = '../view/index.html';
}


include "../view/layout.html";

?>