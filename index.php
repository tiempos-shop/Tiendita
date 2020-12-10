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
                    $ui->ModalButtonNormal("login","<i class='fa fa-user'></i> Ingresar","","Ingresar Usuario y Contraseña","<i class='fa fa-cross'></i>Cancelar",
                    $ui->Form([
                        $ui->Input("usuario","Usuario","","$",true),
                        $ui->Input("password","Password","","?",true),
                        "<br/>"
                    ],"administracion.php","<i class='fa fa-check'></i> Ingresar")
                    ,"","","primary btn-sm"),
                    12,0,0,0,"text-right"
                )
            ]),
            $ui->Row([
                $ui->Columns(
                    "Hola Mundo 1",
                    4,0,0,0,
                    "text-center"



                ),
                $ui->Columns(
                    "Hola Mundo 2",
                    8,0,0,0,"text-center"
                )
            ])
        ])
    ],"style='background-color:pink;' ")
);

print_r($h);
