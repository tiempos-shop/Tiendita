<?php

use Administracion\VistasHtml;
use Tiendita\Utilidades;

include_once "View/Componentes/Administracion/VistasHtml.php";
include_once "Business/Utilidades.php";
include_once "Data/Connection/EntidadBase.php";


$html=new VistasHtml();
$ui=new Utilidades();
$db=new \Tiendita\EntidadBase();

$products=$db->getAll("Productos");

$db->close();
$htmlProducts="";

$htmlColumns=[];
$htmlRow="";
$n=count($products);
$i=0;
foreach ($products as $product){
    $i++;
    $image=$product->RutaImagen;
    $description=$product->Descripcion;
    $code=$product->Clave;
    $price=$ui->Moneda($product->Costo);

    $arr = explode(",", $image, 4);
    $first = "'$arr[0]'";
    $four="'$arr[2]'";
    $htmlColumns[]=$ui->Columns('<br/><br/><img src="'.$arr[0].'" onmouseover="changeImage(this,'.$four.')" onmouseleave="changeImage(this,'.$first.')" width="300px"><br/><br/>'.$description.'<br/>'.$price,
        3,0,0,0,"text-center");
    if(count($htmlColumns)==4 or $n==$i)
    {
        $htmlRow.=$ui->Row($htmlColumns);
        $htmlProducts.=$htmlRow;
        $htmlRow="";
        $htmlColumns=[];
    }
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
                @font-face {
                font-family: NHaasGroteskDSPro-55Rg;
                src: url(font/NHaasGroteskDSPro-55Rg.woff);
                }

                div {
                font-family: NHaasGroteskDSPro-55Rg;
                }
                
            </style>
        ",
        '<script>
                  
                  
                  function changeImage(imageElement,image){
                      imageElement.src=image;
                  }
                  
                  
                  
                </script>'

    ),
    $html->Body([
        // Load Facebook button
        "
            <div id=\"fb-root\"></div>
            <script async defer 
                crossorigin=\"anonymous\" 
                src=\"https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v9.0&appId=1794600520762591&autoLogAppEvents=1\" 
                nonce=\"wlJTE7aj\">
            </script>",
        $ui->ContainerFluid([

            $ui->Row([
                $ui->Columns(
                    "<span>SHOP<span>",
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

            ]),$htmlProducts
        ])
    ],"style='background-color:#FFFFF;' ") //#AC9950
);

print_r($h);
