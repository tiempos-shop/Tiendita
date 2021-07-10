<?php

include_once "Business/DHL/DHL.php";
include_once "Business/Utilidades.php";

$precio=100;
$currency="MXN";
$shipper_cp=97133;
$receiver_cp=44100;
$products_number=1;
$weight=0.5;
$length=11;
$width=11;
$height=11;

$ui=new \Tiendita\Utilidades();
$dhl=new DHL();
$request=$dhl->GetRateRequest($precio,$currency,$shipper_cp,$receiver_cp,$products_number,$weight,$length,$width,$height);
ob_start();
echo "<textarea rows='50' style='width: 100%'>";
var_dump($request);
echo "</textarea>";
$requestArray=ob_get_contents();
ob_clean();

$requestJson="<textarea rows='50' style='width: 100%'>".json_encode($request,JSON_PRETTY_PRINT)."'</textarea>";

$response=$dhl->RateApiCall($precio,$currency,$shipper_cp,$receiver_cp,$products_number,$weight,$length,$width,$height);
ob_start();
echo "<textarea rows='50' style='width: 100%'>";
var_dump($response);
echo "</textarea>";
$responseArray=ob_get_contents();
ob_clean();
$responseJson="<textarea rows='50' style='width: 100%'>".json_encode($response,JSON_PRETTY_PRINT)."'</textarea>";
echo "
    <table width='100%'>
    <tr><td style='width: 50%'>JSON REQUEST</td><td style='width: 50%'>PHP ARRAY REQUEST</td>
    <tr><td>$requestJson</td><td>$requestArray</td></tr>
    <tr><td style='width: 50%'>JSON RESPONSE</td><td style='width: 50%'>PHP ARRAY RESPONSE</td>
    <tr><td>$responseJson</td><td>$responseArray</td></tr>
    </table>";