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
                    $ui->ContainerFluid([
                        $ui->ModalButtonNormal("login","<i class='fa fa-user'></i> Ingresar","","Ingresar Usuario y Contraseña","<i class='fa fa-cross'></i>Cancelar",
                            $ui->Form([
                                $ui->Input("usuario","Usuario","","$",true),
                                $ui->Input("password","Password","","?",true),
                                "<br/>"
                            ],"administracion.php","<i class='fa fa-check'></i> Ingresar")
                            ,"","","outline-dark btn-sm"),
                        "<hr/>"
                    ]),
                    12,0,0,0,"text-right"
                )
            ]),
            $ui->Row([
                $ui->Columns(
                    $ui->Button("btn","SHOP"),
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
                    "LIMITED",
                    1,0,0,0,""
                )

            ]),
            $ui->Row([
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>FOTO<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>Descripción",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>FOTO<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>Descripción",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>FOTO<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>Descripción",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>FOTO<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>Descripción",
                    3,0,0,0,"text-center"
                )
            ]),
            $ui->Row([
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>FOTO<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>FOTO<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>FOTO<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>FOTO<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>",
                    3,0,0,0,"text-center"
                )
            ]),

        ])
    //],"style='background-color:white;' ")
    ],"style='background-color:#AC9950;' ")
);

print_r($h);
