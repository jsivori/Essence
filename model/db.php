<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

ini_set ("date.timezone", "America/Argentina/Buenos_Aires");
set_time_limit(0);


/*
Root User: adminjy8YLxm
   Root Password: 18vyBUDUvt-j
   Database Name: essence

Connection URL: mysql://$OPENSHIFT_MYSQL_DB_HOST:$OPENSHIFT_MYSQL_DB_PORT/
*/
function conectar(){
	$dbname='essence';
	$dbhost='//'.$OPENSHIFT_MYSQL_DB_HOST.':'.$OPENSHIFT_MYSQL_DB_PORT.'/';
    $dbuser='adminjy8YLxm';
    $dbpass='18vyBUDUvt-j';
	
	try{
		$conn = new PDO(sprintf('mysql:host=%s;dbname=%s', $dbhost, $dbname), $dbuser, $dbpass);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	}catch(PDOException $e){
		//echo "ERROR: " . $e->getMessage();
		return false;
	}

	return $conn;
}
	
function desconectar ($conn) {
	unset($conn);
}
?>