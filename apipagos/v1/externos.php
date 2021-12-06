<?php
	// Connect to database
	include("../connection.php");
	$db = new dbObj();
    $connection =  $db->getConnstring();

    $request_method=$_SERVER["REQUEST_METHOD"];

    
    switch($request_method)
	{
		case 'GET':
			// Recuperar externos
			
			if(!empty($_GET["id"]))
			{
				$id=$_GET["id"];
				buscar_externos($id);
			}
			else{
								
				obtener_externos();
				}
            break;
            
        case 'POST':
            // Insertar reservas
            insertar_externos();
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
    
    function obtener_externos(){
        global $connection;
		$query="SELECT * FROM externos";
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
	
	
    function buscar_externos($id=0){
        global $connection;
        $query="SELECT * FROM externos";
        if($id != 0)
        {
            $query.=" WHERE DNI='".$id."'";
        }
        $response=array();
        $result=mysqli_query($connection, $query);
        while($row=mysqli_fetch_assoc($result))
        {
            $response[]=$row;
        }
		header('Content-Type: application/json');
        echo json_encode($response);
    }
	

    function insertar_externos(){ //modificado
		global $connection;

        $data = json_decode(file_get_contents('php://input'), true);
		
		$DNI=$_GET["id"];
		//$hora_ingreso=$data["hora_ingreso"];
		//$hora_salida=$data["hora_salida"];
		//$fecha=$data["fecha"];
		$query="INSERT INTO externos (DNI,ExtHrIngreso,ExtFec) VALUES ('".$DNI."',DATE_FORMAT(NOW(),'%H:%i:%S'),DATE_FORMAT(NOW(),'%Y-%m-%d'))";
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
    }*/

?>