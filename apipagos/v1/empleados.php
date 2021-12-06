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
			if(!empty($_GET["Codigo"]) )
			{
                $Codigo=$_GET["Codigo"];
               
				buscar_empleado($Codigo);
			}
			else
			{
				obtener_empleados();
			}
            break;
            
        /*case 'POST':
            // Insertar usuarios
            insertar_usuarios();
            break;

        case 'PUT':
            // Modificar usuarios
            $id=intval($_GET["id"]);
            modificar_usuario($id);
            break;

        case 'DELETE':
            // Eliminar usuario
            $id=intval($_GET["id"]);
            eliminar_usuario($id);
            break;*/

		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
    }
    
    function obtener_empleados(){
        global $connection;
        $query="SELECT * FROM empleados";
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
    
    function buscar_empleado($Codigo){
        global $connection;
        $query="SELECT * FROM usuarios WHERE Codigo='".$Codigo."' ";

        $response=array();
        $result=mysqli_query($connection, $query);
        while($row=mysqli_fetch_assoc($result))
        {
            $response[]=$row;
        }
		header('Content-Type: application/json');
        echo json_encode($response);
    }

    /*function insertar_usuarios(){
		global $connection;

        $data = json_decode(file_get_contents('php://input'), true);
        $codigo=$data["codigo"];
		$nombres=$data["nombres"];
		$a_paterno=$data["a_paterno"];
		$a_materno=$data["a_materno"];
		echo $query="INSERT INTO usuarios VALUES (".$codigo. ",'" .$nombres. "','" .$a_paterno. "','" .$a_materno. "')";
		if(mysqli_query($connection, $query ))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Registro de usuario insertado correctamente.'
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
	
    function modificar_usuario($id){
		global $connection;
		$data = json_decode(file_get_contents("php://input"),true);
		$nombres=$data["nombres"];
		$a_paterno=$data["a_paterno"];
		$a_materno=$data["a_materno"];
		$query="UPDATE usuarios SET nombres='".$nombres."', a_paterno='".$a_paterno."', a_materno='".$a_materno."' WHERE codigo=".$id;
		if(mysqli_query($connection, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Registro de usuario actualizado correctamente.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Fallo al actualizar registro de usuario.'
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
    }*/

?>