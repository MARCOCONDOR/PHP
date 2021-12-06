<?php
	// Connect to database
	include("../connection.php");
	$db = new dbObj();
    $connection =  $db->getConnstring();

    $request_method=$_SERVER["REQUEST_METHOD"];

    
    switch($request_method)
	{
		case 'GET':			
				$CODIGO=intval($_GET["CODIGO"]);
				$Alumno=$_GET["NOMBRES_APELLIDOS"];
				$Maestria=$_GET["MAESTRIA"];
				$Esp=$_GET["COD_ESP"];
				$DNI=intval($_GET["DNI"]);
				insertar_usuarios($CODIGO,$Alumno,$Maestria,$Esp,$DNI);
			
			
								
				// obtener_usuarios();
				
            break;
          
        case 'POST':
            // Insertar usuarios
			// $Codigo_Traer=intval($_GET["Codigo_Traer"]);
			// $ayuda=$_GET["ayuda"];

            // obtener_usuarios($Codigo_Traer,$ayuda);

            break;

        case 'PUT':
            // Modificar usuarios
			
			// $CodigoM=intval($_GET["Codigo"]);
			// $ayuda=$_GET["ayuda"];
			// $ayuda1=$_GET["ayuda1"];
            // buscar_usuarios($CodigoM,$ayuda,$ayuda1);
			
            break;

        case 'DELETE':
            $Codigo_Traer=intval($_GET["Codigo_Traer"]);
			$ayuda=$_GET["ayuda"];

            obtener_usuarios($Codigo_Traer,$ayuda);
            break;

		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
    }
    
    function obtener_usuarios($Codigo_Traer,$ayuda){
        global $connection;
        $query="SELECT Codigo  FROM historial";
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
    
    function buscar_usuarios($CodigoM,$ayuda,$ayuda1){
		global $connection;
        $query="SELECT Codigo  FROM historial";
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

    function insertar_usuarios($CODIGO,$Alumno,$Maestria,$Esp,$DNI){
		global $connection;

        $data = json_decode(file_get_contents('php://input'), true);
        
		$query="INSERT INTO `historial`(`Codigo`, `Alumno`, `Maestria`, `Esp`, `DNI`) VALUES ('" .$CODIGO. "','" .$Alumno. "','" .$Maestria. "','" .$Esp. "','" .$DNI. "' )";
		if(mysqli_query($connection, $query ))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'iNGRESO CORRECTO al insertar el registro de usuario.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Fallo al insertar el registro de usuario.'
			);
		}
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
		header('content-type: application/json; charset=utf-8');
		echo json_encode($response);
	}
	
    
    function eliminar_usuario($id){
        global $connection;
        $query="DELETE FROM usuarios WHERE codigo=".$id;
        if(mysqli_query($connection, $query))
        {
            $response=array(
                'status' => 1,
                'status_message' =>'Registro de usuario eliminado correctamente.'
            );
        }
        else
        {
            $response=array(
                'status' => 0,
                'status_message' =>'Fallo al eliminar registro de usuario.'
            );
		}
		
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
		header('content-type: application/json; charset=utf-8');
        echo json_encode($response);
    }

?>