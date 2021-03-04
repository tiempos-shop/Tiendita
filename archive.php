<?php

use Administracion\VistasHtml;
use Tiendita\Utilidades;

include_once "View/Componentes/Administracion/VistasHtml.php";
include_once "Business/Utilidades.php";
include_once "Data/Connection/EntidadBase.php";
include_once "Business/FrontComponents.php";
include_once "Data/Models/Producto.php";

session_start();
$html=new VistasHtml();
$ui=new Utilidades();
$entity=new \Tiendita\EntidadBase();
try {
    $products = $entity->getAll("Productos");
} catch (Exception $e) {

}
$entity->close();
$item=new \Tiendita\Producto(0,1);
global $idioma;
$idiomaActual="";

if(count($_POST)>0)
{
    $idiomaActual=$_POST["language"];
    $_SESSION["language"]=$idiomaActual;
}
else{
    $idiomaActual=$_SESSION["language"];
}
$tipoCambio=20;

$idioma=[ "ESPAÑOL"=>[ "MENU"=>[ "INICIO","ARCHIVO","MARCA","ENGLISH","CARRITO(*)"] ],"ENGLISH"=>[ "MENU"=>[ "HOME","ARCHIVE","IMPRINT","ESPAÑOL","CART(*)" ] ] ];

$htmlIds="";


// Obtener de base de datos de productos
$htmlIds="";


foreach ($products as $product){

    $item->Clave=$product->Clave;
    $item->Costo=$product->Costo;

    $ide=str_replace("_","'",$item->Clave);
    $js="view('$product->Clave')";
    $htmlIds.="<hr style='padding: 0px;border: none;margin: 0px'/><span onclick=\"$js\">$ide</span><br/>";
}

$fc=new \Tiendita\FrontComponents();



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
                #t{
                    position:fixed;
                    display:inline-block;
                    top:50vh;
                    left: 2vw;
                    
                }
                #t-over{
                    visibility:hidden;
                    position:fixed;
                    display:inline-block;
                    top:50vh;
                    left: 2vw;
                    /*background-color: rgba(255,255,255,.3);*/
                    cursor: pointer;
                    
                }
                button{
                    background-color: transparent;
                    border: none;
                    background-repeat:no-repeat;
                    cursor:pointer;
                    overflow: hidden;  
                }
                
                
                hr{
                    margin-right: 0;
                    margin-left: 0;
                    opacity: 1;
                }
                p{
                    text-align: justify;
                    text-align-last: justify;
                    margin: 0 0 0 0;
                    font-size: inherit;
                }
                
            </style>
        ",
        '<script>
                  function go(url){
                      window.location.href=url;
                  }
                  function tOverMenu(){
                      var t=document.getElementById(\"t\");
                      var tover=document.getElementById(\"t-over\");
                      t.style.visibility=\"hidden\";
                      tover.style.visibility=\"visible\";
                  }
                  
                  function tOffMenu(){
                      const t=document.getElementById(\"t\");
                      const tover=document.getElementById(\"t-over\");
                      t.style.visibility=\"visible\";
                      tover.style.visibility=\"hidden\";
                  }
                  function view(str){
                      let id=str; //str.replace("_", "\'");
                      go("view.php?id="+id);
                  }
                </script>'

    ),
    $html->Body([
        $fc->Menu($idioma,$idiomaActual),
        $fc->LogoNegro(),
        $fc->TMenu($htmlIds),
        "<div class='fixed-top' style='z-index:-100;width:96.1vw;height:95.7vh;background-color: transparent;border: 1px solid black;top:2vh;left: 2vw;bottom: 2vh;right: 2vw'></div>"


    ],"style='background-color:transparent;'") //#AC9950
);

print_r($h);