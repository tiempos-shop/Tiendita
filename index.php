<?php
date_default_timezone_set('America/Monterrey');
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

if(isset($_SESSION["ProductosCarrito"])){
    $productosCarrito=$_SESSION["ProductosCarrito"];
    $numeroProductosCarrito=count($productosCarrito);
}
else{
    $numeroProductosCarrito=0;
}


try {
    $products = $entity->getAll("Productos");
} catch (Exception $e) {

}
$entity->close();
$item=new \Tiendita\Producto(0,1);

$idiomaActual="";


if(count($_POST)>0)
{
    $idiomaActual=$_POST["language"];
    $_SESSION["language"]=$idiomaActual;

}
else{
    if(isset($_SESSION["language"])){

        $idiomaActual=$_SESSION["language"];
    }
    else{
        $idiomaActual="ENGLISH";
        $_SESSION["language"]=$idiomaActual;
    }

}


$idioma=[ "ESPAÑOL"=>[ "MENU"=>[ "TIENDA","ARCHIVO","MARCA","INGRESO","ENGLISH","CARRITO(*)"] ],"ENGLISH"=>[ "MENU"=>[ "SHOP","ARCHIVE","IMPRINT","LOGIN","ESPAÑOL","CART(*)" ] ] ];

if (!in_array($idiomaActual, $idioma))
{
    $idiomaActual = "ENGLISH";
}

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
        $html->LoadStyles(["global.css","View/css/bootstrap.css","https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css", "css/menumovil.css"]),
        $html->LoadScripts(["View/js/bootstrap.js", "js/index.js"]),
        "",
        ""
    ),
    $html->Body([
        $html->MenuMovil($idioma, $idiomaActual, $numeroProductosCarrito),
        $fc->MenuDorado($idioma,$idiomaActual,$numeroProductosCarrito),
        $fc->LogoDorado(),
        $fc->TMenu($htmlIds),
        $ui->ContainerFluid([

            "  <div id='fotosprincipal'>  <img id='left_home' class='img-fluid'  src='img/ts-home_001.jpg'></img>",
            "    <img id='right_home' class='img-fluid' src='img/ts-home_002.jpg'></img> </div>",
        ], "contenedorIndex")

    ],"style='background-color:#FFFFF;color:#AC9950'")
);

print_r($h);