<?php
	// Connect to database
	include("../connection.php");
	$db = new dbObj();
    $connection =  $db->getConnstring();

    $request_method=$_SERVER["REQUEST_METHOD"];

    
    switch($request_method)
	{
		case 'GET':

            	$id=$_GET["Cerosss"];
				buscar_usuario($id);

			// if(!empty($_GET["Cero"]))
			// {
			// 	$id=$_GET["Cero"];
			// 	buscar_usuario($id);
			// }
			// else
			// {
			// 	obtener_codigos();
			// }
			break;
			// Recuperar usuarios
			// $Codigo_Traer=intval($_GET["TCodigo"]);

            // obtener_codigos($Codigo_Traer);
			 

            break;
            
        case 'POST':
            
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
    
    function obtener_codigos(){
        global $connection;
		$query="SELECT Alumno,DNI FROM historial ";
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
	
	
    function buscar_usuario($id){
        global $connection;
        $query="    SELECT Semestre FROM tabla 
        GROUP BY Semestre 
        HAVING COUNT(*)>0 ";
        
        
        $response=array();
        $result=mysqli_query($connection, $query);
        while($row=mysqli_fetch_assoc($result))
        {
            $response[]=$row;
        }
		header('Content-Type: application/json');
        echo json_encode($response);
    }
	

    
    
?>