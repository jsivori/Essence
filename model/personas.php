<?php
class Persona{
	
	function getClientes(){
		$conn = conectar(); 
		
		if(!$conn)
			return false;
			
		try{		
				$gsent = $conn->prepare('select * from clientes');
				$gsent->execute();
				$result = $gsent->fetchAll();
		}
		catch(PDOException $e){
			echo "ERROR obtener Clientes: " . $e->getMessage();
			$result = false;
		}		
		
		desconectar($conn);
		return $result; 
	}
	
	function save($valores){
				
        $s= mb_convert_case($valores['sexo'], MB_CASE_LOWER, 'UTF-8');		
		 
		if(($s!='masculino')&&($s!='femenino'))
			 return false;
		 
		if(!$this->ValidarApeNom($valores['nombre']))
            return false;

        if(!$this->ValidarApeNom($valores['apellido']))
            return false;

        if(!$this->validarIngresoMail($valores['email']))
            return false;			
		
		$conn = conectar(); 
		
		$valores['nombre'] = strtoupper($valores['nombre']);
		$valores['apellido'] = strtoupper($valores['apellido']);
		
		if(!$conn)
			return false;
		
		$busqueda = $this->buscarPersona($valores['nombre'],$valores['apellido'],$valores['fecha_nacimiento']);
		
		if(($busqueda != false) and ($busqueda[0]['cantidad']>0))
			return 'duplicado';
			
		try{		
			$gsent = $conn->prepare("insert into clientes (nombre, apellido, sexo, email, fecha_nacimiento, telefono) values (?,?,?,?,?,?)");

			$gsent->bindParam(1,$valores['nombre']);
			$gsent->bindParam(2,$valores['apellido']);
			$gsent->bindParam(3,$valores['sexo']);
			$gsent->bindParam(4,$valores['email']);
			$gsent->bindParam(5,$valores['fecha_nacimiento']);
			$gsent->bindParam(6,$valores['telefono']);
			$result = $gsent->execute();
		}
		catch(PDOException $e){
			echo "ERROR al insertar: " . $e->getMessage();
			$result = false;
		}		
		desconectar($conn);
		return $result; 
	}
	
	function saveAtencion($valores){
				
        if($valores['observaciones']=="")
            return false;

        if($valores['operacion']==0)
            return false;			
		
		$conn = conectar(); 
		
		if(!$conn)
			return false;
					
		try{		
			$gsent = $conn->prepare("insert into operaciones (id_detalle_operacion, observaciones, fecha_hora) values (?,?,?)");

			$gsent->bindParam(1,$valores['operacion']);
			$gsent->bindParam(2,$valores['observaciones']);
			$fechahora = date("Y-m-d H:m");
			$gsent->bindParam(3,$fechahora);
			$result = $gsent->execute();
		}
		catch(PDOException $e){
			echo "ERROR al insertar: " . $e->getMessage();
			$result = false;
		}	

		if($result){
			try{		
				$gsent = $conn->prepare("insert into operaciones_personas (id_operacion, id_persona) values (?,?)");

				$idop = $conn->lastInsertId();
				$gsent->bindParam(1,$idop);
				$gsent->bindParam(2,$valores['idpersona']);
				$result = $gsent->execute();
			}
			catch(PDOException $e){
				echo "ERROR al insertar: " . $e->getMessage();
				$result = false;
			}	
			
		}	
		desconectar($conn);
		return $result; 
	}
	
	function buscarPersona($nombre, $apellido, $fecha){
		
		if($nombre == "")
			 return false;
		 
		if($apellido == "")
			 return false; 
		
		if($fecha == "")
			return false;
		
		$nombre = strtoupper($nombre);
		$apellido = strtoupper($apellido);
		
		$conn = conectar(); 
		
		if(!$conn)
			return false;
			
		try{		
				$gsent = $conn->prepare('select count(1) as cantidad from clientes where nombre =? and apellido = ? and fecha_nacimiento = ?');
				$gsent->bindParam(1,$nombre);
				$gsent->bindParam(2,$apellido);
				$gsent->bindParam(3,$fecha);
				$gsent->execute();
				$result = $gsent->fetchAll();
		}
		catch(PDOException $e){
			//echo "ERROR obtener Provincias: " . $e->getMessage();
			$result = false;
		}		
		
		desconectar($conn);
		return $result; 
	}	
	
	function controlaSesion($dni){
		
		if(($dni == "") or !(is_numeric($dni)))
			 return false;
		 	
		$conn = conectar(); 
		
		if(!$conn)
			return false;
			
		try{		
				$gsent = $conn->prepare('select count(1) as cantidad from usuarios where dni = ?');
				$gsent->bindParam(1,$dni);
				$gsent->execute();
				$result = $gsent->fetchAll();
				
				if($result[0]['cantidad']>=1)
					$result = true;
				else
					$result = false;	
		}
		catch(PDOException $e){
			//echo "ERROR obtener Provincias: " . $e->getMessage();
			$result = false;
		}		
		
		desconectar($conn);
		return $result; 
	}
	
	function getAtenciones($idpersona){
		
		if(($idpersona == "")or(!is_numeric($idpersona)))
			 return false;
		 	
		$conn = conectar(); 
		
		if(!$conn)
			return false;
			
		try{		
				$gsent = $conn->prepare('SELECT 
				operaciones.id_operacion,
				fecha_hora,
				observaciones,
				descripcion 

				FROM operaciones INNER JOIN operaciones_personas ON (operaciones.id_operacion = operaciones_personas.id_operacion)
				INNER JOIN detalles_operaciones ON (detalles_operaciones.id_detalle_operacion = operaciones.id_detalle_operacion)

				WHERE operaciones_personas.id_persona = ?');
				$gsent->bindParam(1,$idpersona);
				$gsent->execute();
				$result = $gsent->fetchAll();
		}
		catch(PDOException $e){
			//echo "ERROR obtener Provincias: " . $e->getMessage();
			$result = false;
		}		
		
		desconectar($conn);
		return $result; 
	}
	
	function editarPersona($valores){
   	    $s= mb_convert_case($valores['sexo'], MB_CASE_LOWER, 'UTF-8');		

		if(($s!='masculino')&&($s!='femenino'))
			 return false;
	 
		if(!$this->ValidarApeNom($valores['nombre']))
            return false;

        if(!$this->ValidarApeNom($valores['apellido']))
            return false;

        if(!$this->validarIngresoMail($valores['email']))
            return false;			
	
		$conn = conectar(); 
		
		$valores['nombre'] = strtoupper($valores['nombre']);
		$valores['apellido'] = strtoupper($valores['apellido']);
		
		if(!$conn)
			return false;
			
		try{		
				$gsent = $conn->prepare('update clientes set nombre = ?, apellido = ?, sexo = ?, email = ?, fecha_nacimiento = ?, telefono = ? where id_persona = ?');
				$gsent->bindParam(1,$valores['nombre']);
				$gsent->bindParam(2,$valores['apellido']);
				$gsent->bindParam(3,$valores['sexo']);
				$gsent->bindParam(4,$valores['email']);
				$gsent->bindParam(5,$valores['fecha_nacimiento']);
				$gsent->bindParam(6,$valores['telefono']);
				$gsent->bindParam(7,$valores['id_persona']);
				$result = $gsent->execute();
		}
		catch(PDOException $e){
			//echo "ERROR obtener Provincias: " . $e->getMessage();
			$result = false;
		}		
		
		desconectar($conn);
		return $result; 
	}
	
	function delete($idpersona){
		$conn = conectar(); 
		
		if(!$conn)
			return false;
			
		try{		
				$gsent = $conn->prepare('delete from clientes where id_persona = ?');
				$gsent->bindParam(1,$idpersona);
				$result = $gsent->execute();
		}
		catch(PDOException $e){
			//echo "ERROR obtener Provincias: " . $e->getMessage();
			$result = false;
		}		
		
		desconectar($conn);
		return $result; 
	}
	
	function deleteAtencion($idop){
		$conn = conectar(); 
		
		if(!$conn)
			return false;
			
		try{		
			$gsent = $conn->prepare('delete from operaciones where id_operacion = ?');
			$gsent->bindParam(1,$idop);
			$result = $gsent->execute();
		}
		catch(PDOException $e){
			//echo "ERROR obtener Provincias: " . $e->getMessage();
			$result = false;
		}	

		try{		
			$gsent = $conn->prepare('delete from operaciones_personas where id_operacion = ?');
			$gsent->bindParam(1,$idop);
			$result = $gsent->execute();
		}
		catch(PDOException $e){
			//echo "ERROR obtener Provincias: " . $e->getMessage();
			$result = false;
		}	
		
		desconectar($conn);
		return $result; 
	}
	
	function buscarDatosPersona2($id){
		$conn = conectar(); 
		
		if(!$conn)
			return false;
			
		try{		
				$gsent = $conn->prepare('select * from clientes where id_persona = ?');
				$gsent->bindParam(1,$id);
				$gsent->execute();
				$result = $gsent->fetchAll();
		}
		catch(PDOException $e){
			//echo "ERROR obtener Provincias: " . $e->getMessage();
			$result = false;
		}		
		
		desconectar($conn);
		return $result; 
	}
	
	public function ValidarApeNom($cadena){

	$esValido = FALSE;

	if(preg_match("/^[A-ZñáéíóúçüÄÑÁÉÍÓÚÜÇâäàåãêëèïîÏìÖÔÒÕôöòõÛÜûùÿ\"' ]{1,150}$/i",$cadena))
		$esValido = TRUE;

	return $esValido;
    }
	
	public function validarIngresoMail($mail){
		
		if(!preg_match('/[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/', $mail))
			 return false;
		 
		return true;
	}
	
}
?>