<?php
date_default_timezone_set('America/Monterrey');
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

$idioma=[ "ESPAÑOL"=>[ "MENU"=>[ "TIENDA","ARCHIVO","MARCA","INGRESO","ENGLISH","CARRITO(*)"] ],"ENGLISH"=>[ "MENU"=>[ "SHOP","ARCHIVE","IMPRINT","LOGIN","ESPAÑOL","CART(*)"] ] ];


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
                html, body {
                    width: 100%;
                    height: 100%;
                    padding: 0;
                    margin: 0;
                }
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
       // $fc->MenuArchive($idioma,$idiomaActual,$numeroProductosCarrito,["","'","","","",""],true,true),
        $fc->LogoNegroLg(),
        //$fc->TMenu($htmlIds),
        '<div style="position: fixed;left:0; top:0;width: 100%;height: 100%; padding: 15px; z-index: -10;"><div style="border: 1px solid #000; width: 100%; height: 100%;"></div></div>',
        //"<div class='fixed-top' style='z-index:100;display:block;width:96.1vw;height:95.7vh;background-color: transparent;border: 1px solid black;top:1vh;left: 2.1vw'></div>",
        $ui->ContainerFluidStyle([
            $ui->Row([
                $ui->Columns("<br/><br/>". $fc->TMenuSecond(""),0,0,12,0,"mb-1")
            ],"px-4"),
            $ui->Row([
                $ui->Columns(
                    $fc->getPictureVideo("https://www.youtube.com/embed/Oo_WiY2QEz8","width: 100%; height: 350px;", "video"),
                    0,0,0,0,"col px-0"),
            ]),
            $ui->Row([
                $ui->Columns("<span class='px-4 font-weight-bold'>VIDEO</span> <br/><br/>",12)],
                "mt-2"),
            $ui->Row([
                $ui->Columns(
                    $fc->getPictureVideo("https://picsum.photos/400/550", "width: 50%;").
                    $fc->getPictureVideo("https://picsum.photos/400/550", "width: 50%;"),
                    0,0,0,0,"col p-0")
            ]),
            $ui->Row([
                $ui->Columns(
                    $fc->getPictureVideo("https://picsum.photos/400/550", "width: 50%;").
                    $fc->getPictureVideo("https://picsum.photos/400/550", "width: 50%;"),
                    0,0,0,0,"col p-0")
            ]),
            $ui->Row([
                $ui->Columns("<span class='px-4 font-weight-bold'>IMAGEN</span> <br/><br/>",12)]
                ,"mt-2"),
//            $fc->Aviso()

        ],'padding: 0px;'),


    ],"'") //#AC9950
);

print_r($h);