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

$data_info = json_decode(file_get_contents('php://input'));

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($requestMethod) {
    case 'POST':
        $hasError = false;

        //echo  file_get_contents('php://input');
        $problemas = ["precio" => "", "moneda" =>"", "codigo_postal" =>""];

        if (!isset($data_info->precio))
        {
            $problemas["precio"] ="No se establecio el precio";
            $hasError = true;
        }
        if (!isset($data_info->moneda))
        {
            $problemas["moneda"] ="No se establecio el moneda";
            $hasError = true;
        }

        if (!isset($data_info->codigo_postal))
        {
            $problemas["codigo_postal"] ="No se establecio el codigo postal";
            $hasError = true;
        }
        if ($hasError)
        {
            http_response_code(400);
            echo  json_encode($problemas);
        }

        //$data = $dhl_service->GetRateRequest($data_info->precio,$data_info->moneda, "97133", $data_info->codigo_postal, 1, 0.5, 11,11, 11);
        //echo json_encode($data);

        $respuesta = json_decode(json_encode( $dhl_service->RateApiCall(
            $data_info->precio,
            $data_info->moneda,
            "97133",
            $data_info->codigo_postal,1,0.5,5, 5,5)
        ));

        if (isset($respuesta->RateResponse->Provider[0]->Service->TotalNet))
        {
            $precioEnvio =$respuesta->RateResponse->Provider[0]->Service->TotalNet;
            echo json_encode($precioEnvio);

        }
        //echo  json_encode($respuesta);

        break;
    default :
        echo $requestMethod;
        break;
}


