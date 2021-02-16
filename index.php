<?php

use Administracion\VistasHtml;
use Tiendita\Utilidades;

include_once "View/Componentes/Administracion/VistasHtml.php";
include_once "Business/Utilidades.php";

$html=new VistasHtml();
$ui=new Utilidades();
global $idioma;

$idioma=[ "ESPAÑOL"=>[ "MENU"=>[ "TIENDA","ARCHIVO","MARCA","ENGLISH","CARRITO(*)"] ],"ENGLISH"=>[ "MENU"=>[ "SHOP","ARCHIVE","IMPRINT","ESPAÑOL","CART(*)" ] ] ];
$idiomaActual="ENGLISH";
function Cart($number,$label):string
{
    return str_replace("*",$number,$label);
}



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
                    
                    #principal{
                        padding-left: 0px;
                        padding-right: 0px;
                    }
                    @keyframes blur-fx1 {   
                        
                        0%      { filter: blur(20px);-webkit-filter:blur(20px)}
                        100%    { filter: blur(0px);-webkit-filter:blur(0px)}
                    }
                    @keyframes blur-fx2 {
                        0%     { filter: blur(20px);-webkit-filter:blur(20px)}
                        100%    { filter: blur(0px);-webkit-filter:blur(0px)}
                    }
                    #left_home{
                        animation-name: blur-fx1;
                        animation-duration: 2s;
                    }
                    #right_home{
                        animation-name: blur-fx2;
                        animation-duration: 2s;
                        animation-delay: 1s;
                    }
                </style>
            ",
            '<script>
                      window.onload=function (){
                          load();
                      }
                      
                      function go(url){
                          window.location.href=url;
                      }
                      
                      function load(){
                        setTimeout(
                              function ()
                              {
                                    var r=document.getElementById("right_home");
                                    r.style.visibility="visible";
                                    
                              },1000
                        );
                      }
                      
                      
                    </script>'

        ),
    $html->Body([

        "<div class='fixed-top'>",
        $ui->Row([
            $ui->Columns(
                "<span onclick='go(\"shop.php\")'>".$idioma[ $idiomaActual ]["MENU"][0]."<span>",
                3,0,0,0,""
            ),
            $ui->Columns(
                "<span>".$idioma[ $idiomaActual ]["MENU"][1]."</span>",
                3,0,0,0,""
            ),
            $ui->Columns(
                "<span>".$idioma[ $idiomaActual ]["MENU"][2]."<span>",
                3,0,0,0,""
            ),
            $ui->Columns(
                "<span>".$idioma[ $idiomaActual ]["MENU"][3]."<span>",
                2,0,0,0,""
            ),
            $ui->Columns(
                "<span>".Cart(4,$idioma[ $idiomaActual ]["MENU"][4])."<span>",
                1,0,0,0,""
            )
        ]),
        "</div>",

        "<img style='display:inline-block;top:50vh;left: 90vw;width: 7%' class='fixed-top' src='img/ts_iso_oro.png' style='width: 7%'></img>",

        $ui->ContainerFluid([
            "<table cellpadding='0' cellspacing='0'>",
            "<tr>",
            "    <td><img id='left_home' class='img-fluid' src='img/ts-home_001.jpg'></img></td>",
            "    <td><img style='visibility: hidden' id='right_home' class='img-fluid' src='img/ts-home_002.jpg'></img></td>",
            "</tr>"
        ],"principal")

    ],"style='background-color:#FFFFF;color:#AC9950'")
);

print_r($h);

