<!DOCTYPE html>
<?php
$header="";
$styles="";
$body="";
$foot="";

// Begin

// Configuración

$header.='
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda en Construcción!</title>';

// Scripts
$header.='<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>';
$header.='<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>';

// Hojas de Estilo
$header.='<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">';
$header.='<link href="https://fonts.googleapis.com/css2?family=Grandstander:wght@100&display=swap" rel="stylesheet">';



// Estilos Directos
$styles.="body{font-family: 'Grandstander', cursive;}";



$body.='<div class="jumbotro"><h1></h1><p>Nuestra Tienda Online</p></div>';



















// End
$HtmlInjection="<html lang='es'><head><style>".$styles."</style>".$header."</head><body>".$body."</body></html>";

echo $HtmlInjection;