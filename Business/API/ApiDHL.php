<?php

include_once "../DHL/DHL.php";

$dhl_service = new DHL();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );


$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($requestMethod) {
    case 'POST':
        $respuesta = $dhl_service->GetRateRequest(100,"MXN", "97133", "44100", 1, 0.5, 11,11, 11);
        echo json_encode($respuesta);
        
        break;
    default :
        echo $requestMethod;
        break;
}


