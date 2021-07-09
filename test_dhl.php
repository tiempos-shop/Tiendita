<?php

include_once "Business/DHL/DHL.php";
include_once "Business/Utilidades.php";

$ui=new \Tiendita\Utilidades();
$dhl=new DHL();

$response=$dhl->GetRateRequest(100,"MXN",97133,44100,1,0.5,11,11,11);
$ui->Out(json_encode($response,true));
echo "<br/><br/>";
echo "<h1>Response</h1>";
$ui->Out($dhl->RateApiCall(100,"MXN",97133,44100,1,0.5,11,11,11));
