<?php

use Administracion\VistasHtml;
use Tiendita\Utilidades;

include_once "View/Componentes/Administracion/VistasHtml.php";
include_once "Business/Utilidades.php";
include_once "Data/Connection/EntidadBase.php";
include_once "Business/FrontComponents.php";

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
$db=new \Tiendita\EntidadBase();

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


$products=$db->getAll("Productos");
$db->close();

$filtroDescripcion=array_column($products,"Descripcion");
$filtroPrecio=array_column($products,"Costo");
if(isset($_GET["order"])){
    $order=$_GET["order"];
    switch ($order){
        case 2:
            $temp=array_multisort($filtroDescripcion,SORT_ASC,$products);
            break;
        case 3:
            $temp=array_multisort($filtroPrecio,SORT_ASC,$products);
            break;
        case 4:
            $temp=array_multisort($filtroPrecio,SORT_DESC,$products);
            break;
        case 5:
            $temp=[];
            foreach ($products as $product){
                if($product->Sale==1)
                $temp[]=$product;
            }
            $products=$temp;
        default:
    }

}




$htmlProducts="";

$htmlColumns=[];
$htmlRow="";
$n=count($products);
$i=0;
foreach ($products as $product){
    $i++;
    $image=$product->RutaImagen;
    $description=$product->Descripcion;

    $precioSale="";

    if($idiomaActual=="ENGLISH"){
        $dollarPrice=$product->Costo/$tipoCambio;
        $price=$ui->Moneda($dollarPrice,"USD $");
        if($product->Sale){
            $dollarPrice=$product->CostoSale/$tipoCambio;
            $price="<s>$price</s> ".$ui->Moneda($dollarPrice,"USD $");
        }
    }
    else{
        $price=$ui->Moneda($product->Costo,"MXN $");
        if($product->Sale){
            $price="<s>$price&#160;</s>&#160;".$ui->Moneda($product->CostoSale,"MXN $");
        }
    }


    $arr = explode(",", $image, 4);
    $first = "'$arr[0]'";
    $four="'$arr[2]'";
    $code=$product->Clave;
    $code=str_replace("'","_",$code);
    $js="view('$code')";
    $htmlColumns[]=$ui->Columns('<br/><br/><img onclick="'.$js.'" src="'.$arr[0].'" onmouseover="changeImage(this,'.$four.')" onmouseleave="changeImage(this,'.$first.')" style="width: 100%"><br/><br/><p style="font-family: NHaasGroteskDSPro-65Md;line-height: 1">'.$description.'</p><p>'.$price.'</p>',
        4,0,0,0,"text-center");
    if(count($htmlColumns)==3 or $n==$i)
    {
        $htmlRow.=$ui->Row($htmlColumns);
        $htmlProducts.=$htmlRow;
        $htmlRow="";
        $htmlColumns=[];
    }
}
$fc=new \Tiendita\FrontComponents();



$h= $html->Html5(
    $html->Head(
        "Tiempos Shop",
        $html->Meta("utf-8","Tienda Online de Tiempos Shop","Egil Ordonez"),
        $html->LoadStyles(["global.css","View/css/bootstrap.css","https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"]),
        $html->LoadScripts(["View/js/bootstrap.js"]),
        "",
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
                  function filter(){
                      let s=document.getElementById("s");
                      let smenu=document.getElementById("sMenu");
                      s.style.display="none";
                      smenu.style.display="block";
                  }
                </script>'

    ),
    $html->Body([
        $fc->Menu($idioma,$idiomaActual,$numeroProductosCarrito,["'","","","","",""]),
        $fc->LogoNegro(),
        "<div style='margin-left: 15%;margin-right: 15%'>",
        $htmlProducts,
        
        $fc->MenuFamilia(),
        $fc->MenuFiltro(),
        $fc->Aviso( ($n< 3) ? 'absolute' : 'inherit'),

    ],"style='background-color:#FFFFF;min-height: 100%' ") //#AC9950
);

print_r($h);
