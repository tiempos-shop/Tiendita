<?php

use Administracion\VistasHtml;
use Tiendita\EntidadBase;
use Tiendita\Utilidades;

include_once "View/Componentes/Administracion/VistasHtml.php";
include_once "Business/Utilidades.php";
include_once "Data/Connection/EntidadBase.php";
include_once "Business/FrontComponents.php";

session_start();
$html=new VistasHtml();
$ui=new Utilidades();
$db=new EntidadBase();

$productosCarrito=array();
$tallas=[ "S","M","L","XL"];

$numeroProductosCarrito=0;
$productosCarrito=array();

$fc=new \Tiendita\FrontComponents();

$idiomaActual="";

if(count($_GET)>0){
    $clave=$_GET["clave"];
    $n=$_GET["n"];
    $productosCarrito=$_SESSION["ProductosCarrito"];
    foreach ($productosCarrito as $key=>$producto){
        if($producto[0]==$clave){
            $productosCarrito[$key][1]=$n;
        }
    }
    $_SESSION["ProductosCarrito"]=$productosCarrito;
}

// Producto previo del checkout
if(key_exists("CheckOut",$_POST)){

    $checkout=$_SESSION["CheckOut"];

    if(isset($_SESSION["ProductosCarrito"])){
        $productosCarrito=$_SESSION["ProductosCarrito"];
        if(!$fc->Existe($checkout[0],$productosCarrito)){
            $productosCarrito[]=$checkout;
            $_SESSION["ProductosCarrito"]=$productosCarrito;
        }
    }
    else{
        $productosCarrito[]=$checkout;
        $_SESSION["ProductosCarrito"]=$productosCarrito;
    }
    $numeroProductosCarrito=count($productosCarrito);
}
else
{
    if(isset($_SESSION["ProductosCarrito"])){
        $productosCarrito=$_SESSION["ProductosCarrito"];
        $numeroProductosCarrito=count($productosCarrito);
    }
    else{
        $numeroProductosCarrito=0;
    }
}

if(count($_POST)>0){
    if(key_exists("borrar",$_POST)) {
        $clave=$_POST["borrar"];
        $fc->BorrarCarrito($clave);
        $productosCarrito=$_SESSION["ProductosCarrito"];
    }
    if(key_exists("language",$_POST)) {
        $idiomaActual = $_POST["language"];
    }
    else{
        $idiomaActual=$_SESSION["language"];
    }


}
else{
    $idiomaActual=$_SESSION["language"];
}



$tipoCambio=20;
$idioma=[ "ESPAÑOL"=>[ "MENU"=>[ "INICIO","ARCHIVO","MARCA","ENGLISH","CARRITO(*)"] ],"ENGLISH"=>[ "MENU"=>[ "HOME","ARCHIVE","IMPRINT","ESPAÑOL","CART(*)" ] ] ];

$price=0;
$tipoCambio=20;
$productInformation=$db->getAll("Productos");

$carrito=array();
$elements=array();
foreach ($productosCarrito as $producto){
    $clave=$producto[0];
    foreach ($productInformation as $pi){
        if($clave==$pi->Clave){
            $imagen=explode(",",$pi->RutaImagen)[0];
            $carrito["Clave"]=$pi->Clave;
            $carrito["RutaImagen"]=$imagen;
            $carrito["Descripcion"]=$pi->Descripcion;
            $carrito["Cantidad"]=$producto[1];
            $carrito["Talla"]=$producto[2];
            $carrito["Costo"]=$pi->Costo;

            $elements[]=$carrito;
        }
    }
}

$db->close();
$htmlProducts="";
$suma=0;
foreach ($elements as $element){
    $n=$element["Cantidad"];
    if($idiomaActual=="ENGLISH") $costo=$ui->Moneda($n*$element["Costo"]/$tipoCambio,"USD $");
    else $costo=$ui->Moneda($n*$element["Costo"],"MXN $");
    $htmlProducts.="<hr/>".$ui->Row([
        $ui->Columns("",2),
        $ui->Columns("<img src='".$element["RutaImagen"]."' height='172'>",2),
        $ui->Columns($element["Descripcion"],2),
        $ui->Columns($fc->Borrar($element).$fc->BotonEditar($element),1),
        $ui->Columns($carrito["Talla"],1),
        $ui->Columns("",1),

        $ui->Columns($costo,1),
        $ui->Columns("",2)
    ]);

    if($idiomaActual=="ENGLISH") $suma+=floatval($n*$element["Costo"]/$tipoCambio);else $suma+=floatval($n*$element["Costo"]);
}
$htmlProducts.="<hr>";



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
                [type='submit']{
                    -webkit-appearance: none!important;  
                }
                .left-top{
                    position: fixed;
                    left: 50vw;
                }
                .space{
                    position: relative;
                    display:inline-block; 
                    width:30px; 
                }
                #logo{
                    display:inline-block;
                    top:50vh;
                    left: 90vw;
                    width: 7%
                }
                hr{
                    margin-right: 0;
                    margin-left: 0;
                    opacity: 1;
                }
                #container{
                    padding: 0 0 0 0;
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
                      let id=str.replace("_", "\'");
                      go("view.php?id="+id);
                  }
                  function edit(input,clave){
                      let n=input.value;
                      let parameters="?clave="+clave+"&n="+n;
                      go("cart.php"+parameters);
                  }
                </script>'

    ),
    $html->Body([
        $fc->Menu($idioma,$idiomaActual,$numeroProductosCarrito,["","","","","","'"]),
        $fc->LogoNegro(),
        "<br/>",
        $ui->ContainerFluid([
            $htmlProducts,
            $ui->Row([
                $ui->Columns("",7),
                $ui->Columns("SUBTOTAL: ".$ui->Moneda($suma,),5)
            ]),
            "<button type='submit' class='btn btn-dark btn-block' style='text-align: left;border-radius: 0px'>
                ".$ui->Row([
                    $ui->Columns('',7),
                    $ui->Columns('CHECKOUT',5,0,0,0,"")
                ])."
            </button>",
            $ui->Row([
                $ui->Columns("",7),
                $ui->Columns("<p class='small'>SHIPPING & TAXES CALCULATED AT CHECKOUT</p>",5)
            ]),
            $ui->Row([
                $ui->Columns("",7),
                $ui->Columns("<span class='small'>PRIVACY POLICY</span><label style='width: 40px'></label><span class='small'>SHIPPING & RETURNS</span>",5)
            ],"fixed-bottom"),
        ],"container")
    ],"style='background-color:#FFFFF;' ") //#AC9950
);

print_r($h);
