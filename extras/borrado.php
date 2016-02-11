<?php
session_start();
			
if(isset($_POST['opt'])){	
	switch($_POST['opt']){
		case 7:
			include("../view/frmBorrar.html");			
			break;
       
	   default:
			break;
	}
}

?>