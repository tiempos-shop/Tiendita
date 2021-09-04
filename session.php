<?php

$data = json_decode(file_get_contents("php://input"), true);

header('Content-Type: application/json');

if (!isset($data["accion"]))
{
    http_response_code(400);
    echo "no se establecio accion";
    return; 
}

$accion = $data["accion"];
$idCliente = $data["idCliente"];
$nombre = $data["nombre"];

$info = new \stdClass();


switch ($accion) {
    case 'ingresar':
        if (!isset($data["idCliente"]))
        {
            http_response_code(400);
            echo "no se establecio id cliente";
            return;
        }
        if (!isset($data["nombre"]))
        {
            http_response_code(400);
            echo "no se establecio Nombre";
            return;
        }

        session_start();
        $_SESSION["idCliente"] =  $idCliente;
        $_SESSION["nombre"] =  strtoupper($nombre);
        echo "iniciado";
        
        break;
    case 'cerrar':
            session_start();
            session_destroy();
            echo "cerrado";
            break;
    default:
        # code...
        break;
}


?>