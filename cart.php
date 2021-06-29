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
    if (is_numeric( $_GET["n"] ))
    {
        $n=$_GET["n"];
    }
    else
    {
        $n=1;
    }

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
        if ($fc->BorrarCarrito($clave))
        {
            $numeroProductosCarrito -= 1;
            $_POST["borrar"] = "";
        }
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
$idioma=[ "ESPAÑOL"=>[ "MENU"=>[ "TIENDA","ARCHIVO","MARCA","INGRESO","ENGLISH","CARRITO(*)"] ],"ENGLISH"=>[ "MENU"=>[ "SHOP","ARCHIVE","IMPRINT","LOGIN","ESPAÑOL","CART(*)"] ] ];

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
            $carrito["CostoSale"] = ($pi->CostoSale == 0) ? $pi->Costo : $pi->CostoSale;
            $carrito["Sale"]=$pi->Sale;

            $elements[]=$carrito;
        }
    }
}

$db->close();
$htmlProducts="";
$suma=0;
foreach ($elements as $element){
    $n=$element["Cantidad"];
    if($idiomaActual=="ENGLISH")
    {
        $costo=$ui->Moneda($n*$element["Costo"]/$tipoCambio,"USD $");
        $costoSale=$ui->Moneda($n*$element["CostoSale"]/$tipoCambio,"USD $");
    }
    else
    {
        $costo=$ui->Moneda($n*$element["Costo"],"MXN $");
        $costoSale=$ui->Moneda($n*$element["CostoSale"],"MXN $");
    }

    $price="";
    if($element["Sale"]==1){
        $price=$ui->Columns("<s>$costo</s> ".$costoSale,1);
    }
    else
    {
        $price=$ui->Columns($costo,1);
    }
    $code=$element["Clave"];
    $code=str_replace("'","_",$code);
    $js="view('$code')";
    $htmlProducts.="<hr style='margin: 0; color:black; opacity: 1;' />".$ui->Row([
            $ui->Columns("<div style='cursor: pointer;' onclick=\"$js\"><img src='".$element["RutaImagen"]."' style='width: 100%;' /></div>",0,0,0,0,"col-4"),
            $ui->Columns(
                $ui->Row([
                    $ui->Columns("<div>".$element["Descripcion"]."</div>", 0, 0 ,0,0,"col"),
                    $ui->Columns("<div>".$element["CostoSale"]."</div>", 0, 0 ,0,0,"col text-right mr-3")
                ]).$ui->Row([
                    $ui->Columns("<div style='margin-top: 16px;'>".$fc->Borrar($element)."<span class='mx-2'>".$fc->BotonEditar($element)."</span>".$carrito["Talla"]."</form></div>",
                        0, 0 ,0,0,"col"),
                ])
                ,0,0,0,0,"col-8 mt-2"),
    ]);

    if($idiomaActual=="ENGLISH") $suma+=floatval($n*$element["CostoSale"]/$tipoCambio);else $suma+=floatval($n*$element["CostoSale"]);
}
$htmlProducts.="<hr style='margin: 0; opacity: 1;' />";

$idiomaInformativo = array("ENGLISH" => "SHIPPING & TAXES CALCULATED AT CHECKOUT", "ESPAÑOL" => "ENVIO E IMPUESTO CALCULADOS AL PAGAR");


$h= $html->Html5(
    $html->Head(
        "Tiempos Shop",
        $html->Meta("utf-8","Tienda Online de Tiempos Shop","Egil Ordonez"),
        $html->LoadStyles(["global.css","View/css/bootstrap.css","https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css","css/menumovil.css"]),
        $html->LoadScripts(["View/js/bootstrap.js", "js/index.js"]),
        "
            <style>
                
                .left-top{
                    position: fixed;
                    left: 50vw;
                }
                .space{
                    position: relative;
                    display:inline-block; 
                    width:30px; 
                }
                
                #container{
                    margin-top: 10px;
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
                      go("view.php?id="+str);
                  }
                  function edit(input,clave){
                      let n=input.value;
                      let parameters="?clave="+clave+"&n="+n;
                      go("cart.php"+parameters);
                  }
                </script>'

    ),
    $html->Body([
        $html->MenuMovil($idioma, $idiomaActual, $numeroProductosCarrito, "cambiarLogoFijo()" , "index"),
        '<br /><br />',
        $fc->Menu($idioma,$idiomaActual,$numeroProductosCarrito,["","","","","","'"]),
        //$fc->LogoNegro(),
        "<div id='logo'> </div>",
        $ui->ContainerFluid([ "",
            //$ui->RowSpace("1em"),
            $htmlProducts,
            $ui->Row([
                $ui->Columns("",0,0,0,0,"col"),
                $ui->Columns("SUBTOTAL:",0,0,0,0,"col text-center"),
                $ui->Columns("".$ui->Moneda($suma),0,0,0,0,"col"),
            ], "my-2"),
            "<button onclick='go(\"checkout.php\")' class='btn btn-dark btn-block' style='text-align: left;border-radius: 0'>
                ".$ui->Row([
                    $ui->Columns('CHECKOUT',0,0,0,0,"col text-center")
                ])."
            </button>",
            $ui->Row([
                $ui->Columns("",7),
                $ui->Columns("<p class='small'>$idiomaInformativo[$idiomaActual]</p>",5,0,0,0,"text-center")
            ]),
        ],"container"),
        //$fc->TMenu(""),
        "<label id='t'></label>",
        $ui->ContainerFluid([
        ], "contenedorIndex"),
        $fc->Aviso((count($elements)>2 ? "inherit": "absolute")),
    ],"style='background-color:#FFFFF;' ") //#AC9950
);

print_r($h);