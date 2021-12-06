<?php
	// Connect to database
	include("../connection.php");
	$db = new dbObj();
    $connection =  $db->getConnstring();

    $request_method=$_SERVER["REQUEST_METHOD"];

    
    switch($request_method)
	{
		case 'GET':
			// Recuperar usuarios
			
			if(!empty($_GET["TCodigo"]))
			{
				$TCodigo=intval($_GET["TCodigo"]);
				$Concepto=$_GET["Concepto"];
				

				buscar_tablas($TCodigo,$Concepto);
			}
			else{
								
				obtener_tablas();
				}
            break;
            
        case 'POST':
            if(!empty($_GET["codigo"]))
			{
				$id=intval($_GET["id"]);
		    	$codigo = intval($_GET["codigo"]);				
				modificar_interno($id,$codigo);
			}
			else{
				$id=$_GET["id"];
				insertar_internos();
				}
            break;
           

        case 'PUT':
            // Modificar usuarios
// 			$id=intval($_GET["id"]);
// 			$codigo = intval($_GET["codigo"]);
//             modificar_interno($id,$codigo);
            break;

        /*case 'DELETE':
            // Eliminar usuario
            $id=intval($_GET["id"]);
            eliminar_reserva($id);
            break;*/

		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
    }
    
    function obtener_internos(){
        global $connection;
		$query="SELECT Codigo FROM historial ";
		$response=array();
		$result=mysqli_query($connection, $query);
		while($row=mysqli_fetch_assoc($result))
		{
            $response[]=$row;
        }
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
		header('content-type: application/json; charset=utf-8');
        echo json_encode($response);
	}
	
	
    function buscar_tablas($TCodigo,$Concepto){
        global $connection;
        $query="SELECT * FROM tabla WHERE DNI='".$TCodigo."' AND TConcepto='".$Concepto."' ";
        
        $response=array();
        $result=mysqli_query($connection, $query);
        while($row=mysqli_fetch_assoc($result))
        {
            $response[]=$row;
        }
		header('Content-Type: application/json');
        echo json_encode($response);
	}
	function modificar_interno($id,$codigo){
		global $connection;
		$data = json_decode(file_get_contents("php://input"),true);
		//$hora_salida=$data["hora_salida"];
		//$query="UPDATE reserva SET hora_salida='".$hora_salida."' WHERE id=".$id;
		$query="UPDATE internos SET hora_salida=DATE_FORMAT(NOW(),'%H:%i:%S') WHERE Indice='".$id."' AND IntCod='".$codigo."' AND hora_salida IS NULL";
		if(mysqli_query($connection, $query) && mysqli_affected_rows($connection)>0)
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Reserva culminada correctamente.'
			);
		}}
	

    function insertar_internos(){ //modificado
		global $connection;
		
        $data = json_decode(file_get_contents('php://input'), true);
		
		$IntCod=$_GET["id"];
		//$IntCod=$data["id"];
		//$IntCod=intval($_GET["id"]);
		//$IntNom=$data["IntNom"];
		//$IntPat=$data["IntPat"];
		//$IntMat=$data["IntMat"];
		//$IntFac=$data["IntFac"];
		//$vigencia=$data["vigencia"];
		//$hora_ingreso=$data["hora_ingreso"];
		//$hora_salida=$data["hora_salida"];
		//$fecha=$data["fecha"];
		
		$query="INSERT INTO internos (IntCod,Nombres,Modalidad_Contrato,Condicion_Laboral,Edad,Sexo,Celular1,Correo1,Fecha_Nacimiento,Celular2,Correo2,Celular3,Correo3,Correo4,e_Correo,ExtFec,ExtHrIngreso) 
				SELECT Codigo,Nombres,Modalidad_Contrato,Condicion_Laboral,Edad,Sexo,Celular1,Correo1,Fecha_Nacimiento,Celular2,Correo2,Celular3,Correo3,Correo4,e_Correo,DATE_FORMAT(NOW(),'%Y-%m-%d'),DATE_FORMAT(NOW(),'%H:%i:%S') FROM usuarios WHERE codigo = '".$IntCod."'";
		
		//$query="INSERT INTO internos (IntCod,hora_ingreso,IntFec) 
		//VALUES ('".$IntCod."',DATE_FORMAT(NOW(),'%H:%i:%S'),DATE_FORMAT(NOW(),'%Y-%m-%d'))";
		if(mysqli_query($connection, $query ))
		{
			$response=array(
					
				'status' => 1,
				'status_message' =>'Registro de reserva insertado correctamente.'
				
				
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Error al insertar los datos de reserva.'
			);
		}
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
		header('content-type: application/json; charset=utf-8');
		echo json_encode($response);
	}
	
    
    /*function eliminar_reserva($id){
        global $connection;
        $query="DELETE FROM reserva WHERE id=".$id;
        if(mysqli_query($connection, $query))
        {
            $response=array(
                'status' => 1,
                'status_message' =>'Registro de reserva eliminado correctamente.'
            );
        }
        else
        {
            $response=array(
                'status' => 0,
                'status_message' =>'Fallo al eliminar registro de reserva.'
            );
		}
		
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
		header('content-type: application/json; charset=utf-8');
        echo json_encode($response);
    /*}*/

?>