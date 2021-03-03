<?php

use Administracion\VistasHtml;

use Tiendita\Utilidades;

include_once "View/Componentes/Administracion/VistasHtml.php";
include_once "Business/Utilidades.php";
include_once "Data/Connection/EntidadBase.php";
include_once "Data/Models/Producto.php";
include_once "Business/FrontComponents.php";

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
}
else{
    $idiomaActual="ENGLISH";
}

$idioma=[ "ESPAÑOL"=>[ "MENU"=>[ "TIENDA","ARCHIVO","MARCA","ENGLISH","CARRITO(*)"] ],"ENGLISH"=>[ "MENU"=>[ "SHOP","ARCHIVE","IMPRINT","ESPAÑOL","CART(*)" ] ] ];

// Obtener de base de datos de productos
$htmlIds="";


foreach ($products as $product){

    $item->Clave=$product->Clave;
    $item->Costo=$product->Costo;

    $ide=str_replace("'","_",$item->Clave);
    $js="view('$ide')";
    $htmlIds.="<hr style='padding: 0px;border: none;margin: 0px'/><span onclick=\"$js\">$item->Clave</span><br/>";
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
                    
                    #principal{
                        top:0px;
                        position: absolute;
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
                        background-color: rgba(255,255,255,.1)
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
                    right{
                        text-align: right;
                    }
                    hr{
                        margin-right: 0;
                        margin-left: 0;
                        opacity: 1;
                    }
                    
                </style>
            ",
        "<script>
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
                                    var r=document.getElementById(\"right_home\");
                                    r.style.visibility=\"visible\";
                                    
                              },1000
                        );
                       
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
                          var id=str; //.replace(\"_\", \"\'\");
                          go(\"view.php?id=\"+id);
                      }
                      
                      
                      
                    </script>,"

        ),
    $html->Body([
        $fc->MenuDorado($idioma,$idiomaActual),
        $fc->LogoDorado(),
        $fc->TMenu($htmlIds),
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