<?php

use Administracion\VistasHtml;

use Tiendita\Utilidades;

include_once "View/Componentes/Administracion/VistasHtml.php";
include_once "Business/Utilidades.php";
include_once "Data/Connection/EntidadBase.php";
include_once "Data/Models/Producto.php";
include_once "Business/FrontComponents.php";

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

$idioma=[ "ESPAÑOL"=>[ "MENU"=>[ "TIENDA","ARCHIVO","MARCA","ENGLISH","CARRITO(*)"] ],"ENGLISH"=>[ "MENU"=>[ "SHOP","ARCHIVE","IMPRINT","ESPAÑOL","CART(*)" ] ] ];

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
                        left: 91vw;
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
                    [type='submit']{
                        -webkit-appearance: none!important;  
                    }
                    
                </style>
            ",
        "<script>
                      
                      
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
                          var id=str; //.replace(\"_\", \"\'\");
                          go(\"view.php?id=\"+id);
                      }
                      
                      
                      
                    </script>"

    ),
    $html->Body([
          $fc->Menu($idioma,$idiomaActual),
          $fc->LogoNegro(),
          $fc->TMenu($htmlIds),
          $fc->About($idiomaActual),
          $fc->Foot($idiomaActual)

    ],"style='background-color:#AC9950;color:black'")
);

print_r($h);