<?php

use Administracion\VistasHtml;
use Tiendita\Utilidades;

include_once "View/Componentes/Administracion/VistasHtml.php";
include_once "Business/Utilidades.php";
include_once "Data/Connection/EntidadBase.php";
include_once "Business/FrontComponents.php";
include_once "Data/Models/Producto.php";

session_start();
if(isset($_SESSION["ProductosCarrito"])){
    $productosCarrito=$_SESSION["ProductosCarrito"];
    $numeroProductosCarrito=count($productosCarrito);
}
else{
    $numeroProductosCarrito=0;
}
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
        $html->LoadStyles(["global.css","View/css/bootstrap.css","https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"]),
        $html->LoadScripts(["View/js/bootstrap.js"]),
        "
            <style>
                
                body{
                    color:black;
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
        $fc->MenuArchive($idioma,$idiomaActual,$numeroProductosCarrito,["","'","","","",""],true,true),
        $fc->LogoNegro(),
        $fc->TMenu($htmlIds),
        "<div class='fixed-top' style='z-index:100;display:block;width:96.1vw;height:95.7vh;background-color: transparent;border: 1px solid black;top:1vh;left: 2.1vw'></div>",
        $ui->ContainerFluid([
            $ui->Row([$ui->Columns("<br/><br/>",12)]),
            $ui->Row([
                $ui->Columns("",1),
                $ui->Columns(
                    '
                        <iframe style="left: 80vw;width: 110%;height: 80vh"
                            src="https://www.youtube.com/embed/tgbNymZ7vqY?autoplay=1">
                        </iframe>
        ',11),
            ]),
            $ui->Row([$ui->Columns("<br/><br/>",12)]),
            $ui->Row([
                $ui->Columns("",1),
                $ui->Columns(
                    "
                        <table class='table table-borderless' style='width: 110%' >
                            <tr>
                                <td><img width='300' src='img/0000-JALAPEÑO-back.jpg'></td>
                                <td><img width='300' src='img/0001-OBSIDIANA-back.jpg'></td>
                                <td><img width='300' src='img/0002-TACUBAYA-back.jpg'></td>
                                <td><img width='300' src='img/0003-AÑIL-back.jpg'></td>
                            </tr>
                        </table>
                        ",11)
            ]),
//            $fc->Aviso()

        ]),


    ],"style='background-color:transparent;z-index:100'") //#AC9950
);

print_r($h);