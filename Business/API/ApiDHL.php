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

$ruta = "/";
if (isset($_GET["ruta"]))
{
    $ruta = $_GET["ruta"];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($ruta) {
    case 'cotizar' :
        switch ($requestMethod) {
            case 'POST':
                $hasError = false;
                $problemas = ["precio" => "", "moneda" =>"", "codigo_postal" =>"", "sistema" =>""];

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
                $request=$dhl_service->GetRateRequest($data_info->precio,
                    $data_info->moneda,
                    "97133",
                    $data_info->codigo_postal,1,0.5,5, 3,3);

                $respuesta = json_decode(json_encode( $dhl_service->RateApiCall(
                    $data_info->precio,
                    $data_info->moneda,
                    "97133",
                    $data_info->codigo_postal,1,0.5,5, 3,3)
                ));

                if (isset($respuesta->RateResponse->Provider[0]->Service->TotalNet))
                {
                    $precioEnvio =$respuesta->RateResponse->Provider[0]->Service->TotalNet;
                    $fechaEntrega =  date_create( $respuesta->RateResponse->Provider[0]->Service->DeliveryTime );
                    $fechaInicio = date_create( $respuesta->RateResponse->Provider[0]->Service->CutoffTime );
                    $diferencia = date_diff($fechaInicio, $fechaEntrega);
                    $precioEnvio->dias = $diferencia->format("%d");

                    echo json_encode($precioEnvio);
                }
                else
                {

                    if (isset($respuesta->problema))
                    {

                        $problemas["sistema"] = $respuesta->problema;
                    }
                    else
                    {
                        $problemas["sistema"] = "No se pudo obtener cotización";
                    }

                    $hasError = true;
                }

                if ($hasError)
                {
                    http_response_code(400);
                    echo  json_encode($problemas);
                }


                break;
            default :
                echo $requestMethod;
                echo 'no existe ruta';
                break;
        }
        break;
    case 'envio':
        $hasError = false;
        $problemas = ["precio" => "", "moneda" =>"", "codigo_postal" =>"",
            "sistema" =>"", "nombre" =>"", "telefono" =>"", "correo" => "",
            "calle" =>"", "cuidad" =>"", "codigo_pais" =>""];

        if (!isset($data_info->precio))
        {
            $problemas["precio"] ="No se establecio el precio";
            $hasError = true;
        }

        if (!isset($data_info->nombre))
        {
            $problemas["nombre"] ="No se establecio el nombre";
            $hasError = true;
        }

        if (!isset($data_info->telefono))
        {
            $problemas["telefono"] ="No se establecio el telefono";
            $hasError = true;
        }
        if (!isset($data_info->ciudad))
        {
            $problemas["ciudad"] ="No se establecio la cuidad";
            $hasError = true;
        }
        if (!isset($data_info->calle))
        {
            $problemas["calle"] ="No se establecio la calle";
            $hasError = true;
        }
        if (!isset($data_info->codigo_pais))
        {
            $problemas["codigo_pais"] ="No se establecio el codigo de pais";
            $hasError = true;
        }
        if (!isset($data_info->correo))
        {
            $problemas["correo"] ="No se establecio el correo";
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
        $empacado = new PackageModel();
        $empacado->number = 1;
        $empacado->height = 1;
        $empacado->length = 1;
        $empacado->weight=2;
        $empacado->width=5;

        $info = $dhl_service->ShipmentInfo($data_info->precio, $data_info->moneda);
        $ship = $dhl_service->ShipmentRequested(
        $info,$data_info->codigo_postal,
        $data_info->nombre, $data_info->nombre, $data_info->telefono,
        $data_info->correo, $data_info->calle,
        $data_info->ciudad, $data_info->codigo_pais, $empacado );

        //echo json_encode($ship);
        //return;
        $response = $dhl_service->ShipingApiCall($ship);

        if (isset($response->ShipmentResponse))
        {
            $datos = ["TrackingNumber" =>"0", "LabelImageFormat"=> ""];
            $packageResult = $response->ShipmentResponse->PackagesResult->PackageResult[0];
            $labelImage =$response->ShipmentResponse->LabelImage[0].LabelImageFormat;
            if (isset($packageResult))
            {
                $datos["TrackingNumber"] = $packageResult->TrackingNumber;
            }
            if (isset($labelImage))
            {
                $datos["LabelImageFormat"] = $labelImage;
            }

            echo $datos;
        }
        else
        {
            if (isset($respuesta->problema))
            {


                $problemas["sistema"] = $respuesta->problema;
            }
            else
            {
                $problemas["sistema"] = "No se pudo obtener cotización";
            }

            $hasError = true;
        }

        break;
    default:
        http_response_code(400);
        echo  $ruta;
        echo 'no existe ruta';
        break;
}

