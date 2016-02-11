<?php
class Accion{
	
	function getAll(){
		$conn = conectar(); 
		
		if(!$conn)
			return false;
			
		try{		
				$gsent = $conn->prepare('select * from detalles_operaciones');
				$gsent->execute();
				$result = $gsent->fetchAll();
		}
		catch(PDOException $e){
			echo "ERROR obtener Detalle Operacion: " . $e->getMessage();
			$result = false;
		}		
		
		desconectar($conn);
		return $result; 
	}
	
	function search($valor){
		$conn = conectar(); 
		
		if(!$conn)
			return false;
		
		if(($valor=="") or (!isset($valor)))
			return false;
			
		try{		
				$gsent = $conn->prepare('select * from detalles_operaciones where descripcion = ?');
				$valor = strtoupper($valor);
				$gsent->bindParam(1,$valor);
				$gsent->execute();
				$result = $gsent->fetchAll();
		}
		catch(PDOException $e){
			echo "ERROR obtener Detalle Operacion: " . $e->getMessage();
			$result = false;
		}		
		
		desconectar($conn);
		return $result; 
	}
	
	function save($valor){
		$conn = conectar(); 
		
		if(!$conn)
			return false;
			
		if(($valor=="") or (!isset($valor)))
			return false;
		
		$busqueda = $this->search($valor);
		if(($busqueda != false) and (!empty($busqueda)))
			return 'duplicado';
		
		try{		
			$gsent = $conn->prepare('insert into detalles_operaciones(descripcion) values (?)');
			$valor = strtoupper($valor);
			$gsent->bindParam(1,$valor);
			$gsent->execute();
			$result = true;
		}
		catch(PDOException $e){
			echo "ERROR: " . $e->getMessage();
			$result = false;
		}		
		
		desconectar($conn);
		return $result; 
	}	
	
	function delete($valor){
		$conn = conectar(); 
		
		if(!$conn)
			return false;
			
		if(($valor=="") or (!isset($valor)) or (!is_numeric($valor)))
			return false;
				
		try{		
			$gsent = $conn->prepare('delete from detalles_operaciones where id_detalle_operacion = ?');
			$gsent->bindParam(1,$valor);
			$gsent->execute();
			$result = true;
		}
		catch(PDOException $e){
			echo "ERROR: " . $e->getMessage();
			$result = false;
		}		
		
		desconectar($conn);
		return $result; 
	}	
}
?>