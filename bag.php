<?php

use Administracion\VistasHtml;
use Tiendita\Utilidades;

include_once "View/Componentes/Administracion/VistasHtml.php";
include_once "Business/Utilidades.php";

$html=new VistasHtml();
$ui=new Utilidades();

$h= $html->Html5(
    $html->Head(
        "Tiempos Shop",
        $html->Meta("utf-8","Tienda Online de Tiempos Shop","Egil Ordonez"),
        $html->LoadStyles(["View/css/bootstrap.css","https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"]),
        $html->LoadScripts(["View/js/bootstrap.js"])
    ),
    $html->Body([
        $ui->ContainerFluid([

            $ui->Row([
                $ui->Columns(
                    $ui->ActionButton("btn","SHOP","window.location.href = \"shop.php\";"),
                    3,0,0,0,""
                ),
                $ui->Columns(
                    "PROJECTS",
                    3,0,0,0,""
                ),
                $ui->Columns(
                    "IMPRINT",
                    3,0,0,0,""
                ),
                $ui->Columns(
                    "TERMS",
                    2,0,0,0,""
                ),
                $ui->Columns(
                    "ES",
                    1,0,0,0,""
                )

            ]),
            $ui->Row([
                $ui->Columns(
                    "ALL'",
                    3,0,0,0,""
                ),
                $ui->Columns(
                    "TOPS",
                    3,0,0,0,""
                ),
                $ui->Columns(
                    "ACCESORIES",
                    3,0,0,0,""
                ),
                $ui->Columns(
                    "TWP",
                    2,0,0,0,""
                ),
                $ui->Columns(
                    $ui->ActionButton("btn","BAG","window.location.href = \"bag.php\";"),
                    1,0,0,0,""
                )

            ]),
            $ui->Row([
                $ui->Columns(
                    "<img class='img img-fluid' src='img/0001-OBSIDIANA.jpg'><br/>BLACK",
                    6,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "BLACK<br/> Agregar al carrito",
                    6,0,0,0,"d-flex align-items-center justify-content-center"
                )
            ]),
            $ui->Row([
                $ui->Columns(
                    "<img class='img img-fluid' src='img/0014-PERLA.jpg'><br/>CREMA",
                    6,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "Agregar al carrito",
                    6,0,0,0,"d-flex align-items-center justify-content-center"
                )
            ]),


        ])
        //],"style='background-color:white;' ")
    ],"style='background-color:#FFFFFF;' ")
);

print_r($h);

