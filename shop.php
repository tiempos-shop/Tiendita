<?php

use Administracion\VistasHtml;
use Tiendita\Utilidades;

include_once "View/Componentes/Administracion/VistasHtml.php";
include_once "Business/Utilidades.php";
include_once "Data/Connection/EntidadBase.php";


$html=new VistasHtml();
$ui=new Utilidades();
$db=new \Tiendita\EntidadBase();

$idiomaActual="";

if(count($_POST)>0)
{
    $idiomaActual=$_POST["language"];
}
else{
    $idiomaActual="ENGLISH";
}
$tipoCambio=20;

$idioma=[ "ESPAÑOL"=>[ "MENU"=>[ "INICIO","ARCHIVO","MARCA","ENGLISH","CARRITO(*)"] ],"ENGLISH"=>[ "MENU"=>[ "HOME","ARCHIVE","IMPRINT","ESPAÑOL","CART(*)" ] ] ];


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
    if($idiomaActual=="ENGLISH"){
        $dollarPrice=$product->Costo/$tipoCambio;
        $price=$ui->Moneda($dollarPrice,"USD $");
    }
    else{
        $price=$ui->Moneda($product->Costo,"MXN $");
    }


    $arr = explode(",", $image, 4);
    $first = "'$arr[0]'";
    $four="'$arr[2]'";
    $code=str_replace("'","_",$code);
    $js="view('$code')";
    $htmlColumns[]=$ui->Columns('<br/><br/><img onclick="'.$js.'" src="'.$arr[0].'" onmouseover="changeImage(this,'.$four.')" onmouseleave="changeImage(this,'.$first.')" width="300px"><br/><br/><span style="font-family: NHaasGroteskDSPro-65Md">'.$description.'</span><br/>'.$price,
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
                    src: url(font/NHaasGroteskDSPro-55Rg.woff2);
                    src: url(font/NHaasGroteskDSPro-55Rg.ttf);
                }
                
                @font-face {
                    font-family: NHaasGroteskDSPro-65Md;
                    src: url(font/NHaasGroteskDSPro-65Md.woff);
                    src: url(font/NHaasGroteskDSPro-65Md.woff2);
                    src: url(font/NHaasGroteskDSPro-65Md.ttf);
                    
                }

                body,button {
                    font-family: NHaasGroteskDSPro-55Rg;
                    letter-spacing:0.09em; 
                }
                #logo{
                    display:inline-block;
                    top:50vh;
                    left: 90vw;
                    width: 7%
                }
                
            </style>
        ",
        '<script>
                  function go(url){
                      window.location.href=url;
                  }
                  function changeImage(imageElement,image){
                      imageElement.src=image;
                      imageElement.style.cursor="pointer";
                  }
                  function view(str){
                      let id=str; //str.replace("_", "\'");
                      go("view.php?id="+id);
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
        "<div class='fixed-top' style='padding-top:2vh;padding-bottom:2vh;padding-left: 2vw;padding-right: 2vw'>",
        $ui->Row([
            $ui->Columns(
                "<span onclick='go(\"index.php\")'>".$idioma[ $idiomaActual ]["MENU"][0]."<span>",
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
                FormLink(
                    [
                        $ui->Input("language","",$idioma[ $idiomaActual ]["MENU"][3],"F",true),
                    ],
                    "",
                    $idioma[ $idiomaActual ]["MENU"][3]

                ),
                2,0,0,0,""
            ),
            $ui->Columns(
                "<span>".Cart(4,$idioma[ $idiomaActual ]["MENU"][4])."<span>",
                1,0,0,0,""
            )
        ]),
        "</div>",
        "<img id='logo' class='fixed-top' src='img/ts_iso_negro.png' style='width: 7%'></img>",
        $htmlProducts

    ],"style='background-color:#FFFFF;' ") //#AC9950
);

print_r($h);

function FormLink(array $content,string $url,string $button){
    $html= "
            <form method='post' action='$url'>";
    $html.=implode("",$content);
    $html.='
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-link" style="text-decoration: none;color:black;padding: 0px;border: none"><span type="submit">'.$button.'</span></button>
                    </div>
                </div>
            </form>';
    return $html;
}

function Cart($number,$label):string
{
    return str_replace("*",$number,$label);
}