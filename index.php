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
            $html->LoadScripts(["View/js/bootstrap.js"]),
            "
                <style>
                    span:hover{
                        cursor: pointer;
                    }
                    span:hover::after{
                        content: \"'\";
                    }
                </style>
            ",
            "<script>
                      function go(direccion){
                          window.location.href=direccion;
                      }
                    </script>"

        ),
    $html->Body([

        "<div class='fixed-top'>",
        $ui->ContainerFluid([
            $ui->Row([
                $ui->Columns(
                    "<span onclick='go(\"shop.php\")'>SHOP<span>",
                    3,0,0,0,""
                ),
                $ui->Columns(
                    "<span>PROJECTS</span>",
                    3,0,0,0,""
                ),
                $ui->Columns(
                    "<span>IMPRINT<span>",
                    3,0,0,0,""
                ),
                $ui->Columns(
                    "<span>TERMS<span>",
                    2,0,0,0,""
                ),
                $ui->Columns(
                    "<span>CART(0)<span>",
                    1,0,0,0,""
                )
            ]),
            "</div>"
        ]),

        $ui->ContainerFluid([
            "<table cellpadding='0' cellspacing='0'>",
            "<tr>",
            "    <td><img class='img-fluid' src='img/ts-home_001.jpg'></img></td>",
            "    <td><img class='img-fluid' src='img/ts-home_002.jpg'></img></td>",
            "</tr>"
        ])
    ],"style='background-color:#FFFFF;color:#AC9950'")
);

print_r($h);

