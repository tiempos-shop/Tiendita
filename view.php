<?php


use Administracion\VistasHtml;
use Tiendita\EntidadBase;
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
$db=new EntidadBase();
$id = $_GET["id"];

$idiomaActual="";

$fc=new \Tiendita\FrontComponents();

$productInformation = $products = $db->getBy("Productos","Clave",$id)[0];

$_SESSION["CheckOut"]=[ $productInformation->Clave,1,"ONE SIZE"];

if(count($_POST)>0){
    if(isset($_POST["Cart"])){
        $flowButton=$fc->CheckoutButton();
        $idiomaActual=$_SESSION["language"];
        if(isset($_SESSION["ProductosCarrito"])){
            $productosCarrito=$_SESSION["ProductosCarrito"];
            $productosCarrito[]=[ $productInformation->Clave,1,"ONE SIZE"];
            $_SESSION["ProductosCarrito"]=$productosCarrito;
        }
        else{
            $productosCarrito[]=[ $productInformation->Clave,1,"ONE SIZE"];
            $_SESSION["ProductosCarrito"]=$productosCarrito;
        }
        $numeroProductosCarrito=count($productosCarrito);

    }
    if(isset($_POST["language"])){
        $idiomaActual=$_POST["language"];
        $flowButton=$fc->CartButton();
        if(isset($_SESSION["ProductosCarrito"])) {
            $productosCarrito = $_SESSION["ProductosCarrito"];
            if($fc->Existe($productInformation->Clave,$productosCarrito)){
                $flowButton=$fc->CheckoutButton();
            }
        }

    }
}
else
{
    $flowButton=$fc->CartButton();
    $idiomaActual=$_SESSION["language"];
    if(isset($_SESSION["ProductosCarrito"])) {
        $productosCarrito = $_SESSION["ProductosCarrito"];
        if($fc->Existe($productInformation->Clave,$productosCarrito)){
            $flowButton=$fc->CheckoutButton();
        }
    }
}


$tipoCambio=20;
//$idioma=[ "ESPAÑOL"=>[ "MENU"=>[ "INICIO","ARCHIVO","MARCA","ENGLISH","CARRITO(*)"],"LOGIN"=>[] ],"ENGLISH"=>[ "MENU"=>[ "HOME","ARCHIVE","IMPRINT","ESPAÑOL","CART(*)" ] ] ];
$idioma=[ "ESPAÑOL"=>[ "MENU"=>[ "TIENDA","ARCHIVO","MARCA","INGRESO","ENGLISH","CARRITO(*)"] ],"ENGLISH"=>[ "MENU"=>[ "SHOP","ARCHIVE","IMPRINT","LOGIN","ESPAÑOL","CART(*)"] ] ];


$price=0;
$tipoCambio=20;


//$n=count($productWord);
//$p=100/$n;

$nameTable="<table class='table table-borderless'><tr>";
//foreach ($productWord as $word){
//    $nameTable.="<td style='font-family: NHaasGroteskDSPro-65Md;width: $p%'>$word</td>";
//}
$nameTable.="</tr></table>";

$inventario=$productInformation->Inventario;
if($idiomaActual=="ENGLISH"){
    $productWord=$productInformation->Name;
    $dollarPrice=$productInformation->Costo/$tipoCambio;
    $price=$ui->Moneda($dollarPrice,"USD $");
    if($productInformation->Sale){
        $price="<s>$price</s> ".$ui->Moneda($productInformation->CostoSale/$tipoCambio,"USD $");
    }
    $descripcionLarga=$productInformation->LargeDescription;
    $tallas=$productInformation->SelectSize;
    $opcionesTallas="<a class='dropdown-item' href='#'>$tallas (Products in stock: $inventario)</a>";
    $botonTalla="SELECT SIZE";
}
else{
    $productWord=$productInformation->Nombre;
    $price=$ui->Moneda($productInformation->Costo,"MXN $");
    if($productInformation->Sale){
        $price="<s>$price</s> ".$ui->Moneda($productInformation->CostoSale,"MXN $");
    }
    $descripcionLarga=$productInformation->DescripcionLarga;
    $tallas=$productInformation->SeleccionarTalla;
    $opcionesTallas="<a class='dropdown-item' href='#'>$tallas (Productos en inventario: $inventario)</a>";
    $botonTalla="SELECCIONAR TALLA";
}
//$n=count($productWord);
//$p=100/$n;

$descriptionTable="<table class='table table-borderless'><tr>";
//foreach ($productWord as $word){
//    $descriptionTable.="<td style='width: $p%'>$word</td>";
//}
$descriptionTable.="</tr></table>";

$images=explode(",",$productInformation->RutaImagen);

$collage="";
$innerScript="";



$collage .= '
<div class="container-fluid my-2 mb-5">
    <div class="row">
        <div class="col sinpadding">  
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

  <div class="carousel-inner">';

$count=0;
foreach ($images as $image) {
$count++;
$id = "id" . $count;
//$collage.="<img id='$id' class='img-fluid' src='$image' data-big='$image' data-overlay=''><br/>";// data-overlay="fondo.png"
$collage.=ImagenCarrusel($id, $image);
}

$collage .= '
  </div>
  
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
  </ol>
</div>
</div>
</div>
</div>';

function ImagenCarrusel($id,$rutaImagen){
    $active = "";
    if($id == "id1")  $active = "active";

    return '<div class="carousel-item '.$active.'">
        <img src="'.$rutaImagen.'" class="d-block w-100" style="max-height: 800px;" alt="..." />
      </div>';
}


//print_r($collage);
;
//$lupaScript=$fc->Lupa($innerScript);

$modal="
<table class='table table-borderless prodSize' style='color: black;'>
    <thead>
        <tr>
            <td></td>
            <th><span>S</span></th>
            <th><span>M</span></th>
            <th><span>L</span></th>
            <th><span>XL</span></th>
        </tr>
    </thead>
    <tbody id='tableDetalle'>
    </tbody>
</table>";

$db->close();
$htmlProducts="";
//$ui->Debug($productWord);


$h= $html->Html5(
    $html->Head(
        "Tiempos Shop",
        $html->Meta("utf-8","Tienda Online de Tiempos Shop","Egil Ordonez"),
        $html->LoadStyles(["View/css/bootstrap.css","css/view.css", "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css","css/menumovil.css"]),
        $html->LoadScripts(["vendor/jquery/jquery.js","js/jquery.mlens-1.7.min.js","vendor/bootstrap/js/bootstrap.bundle.js", "js/index.js","carousel.js"]),
        "<style>
                .sinpadding{
                    margin: 0 !important;
                    padding: 0 !important;
                }
                .modal-backdrop{
                background-color: transparent;
                }
                .container-fluid{
                    padding: 0 !important;
                }
                .row{
                    margin: 0px !important;
                }
                .carousel-indicators li.active{
                    background-color: black;
                }
                .carousel-indicators li {
                    background-color: gray;
                    height: 10px;
                    width: 10px;
                    border-radius: 50%;
                  }
                  .carousel-indicators{
                    margin: 0px;
                    bottom: -30px; 
                    justify-content: normal; 
                    padding-left: 40px;
                  }
               </style>",

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
                  
                   const dataSize = [
                          ["HEIGHT", 26, 27, 29, 30],
                          ["SHOULDER", 22, 23, 25, 27],
                          ["BACK", 26, 28, 30, 32],
                          ["CHEST", 18, 20, 22, 24],
                          ["SLEEVE", 26, 28, 30, 32],
                          ["EUROPEAN SIZE", 46, 48, 50, 52]
                      ];
                  
                  $(document).ready(function(e){
                      for(let i = 0; i < dataSize.length; i++){
                          $("#tableDetalle").append(`<tr>
                            <td>${dataSize[i][0]}</td>
                            <td>${dataSize[i][1]}</td>
                            <td>${dataSize[i][2]}</td>
                            <td>${dataSize[i][3]}</td>
                            <td>${dataSize[i][4]}</td>
                          </tr>`);
                      }
                  });
                  
                  function ChangeSize(conversion)
                      {
                          $("#tableDetalle").html("");
                          for(let i = 0; i < dataSize.length; i++){
                              $("#tableDetalle").append(`<tr>
                                <td>${dataSize[i][0]}</td>
                                <td>${ Math.round(dataSize[i][1] / conversion) }</td>
                                <td>${ Math.round(dataSize[i][2] / conversion) }</td>
                                <td>${ Math.round(dataSize[i][3] / conversion) }</td>
                                <td>${ Math.round(dataSize[i][4] / conversion) }</td>
                              </tr>`);
                          }
                      }
                  
                </script>'

    ),
    $html->Body([

        $html->MenuMovil($idioma, $idiomaActual, $numeroProductosCarrito, "cambiarLogoFijo()" , "index"),
        '<br /><br />',
        $fc->Menu($idioma,$idiomaActual,$numeroProductosCarrito,["'","","","","",""]),
        $fc->LogoNegro(),
        $collage,
        $ui->ContainerFluid([
            $ui->Row([
                    $ui->ContainerFluid([
                            "<hr style='background-color: black; opacity: 1; margin: 0px 0px 10px 0px !important;' />" ,
                            $ui->Row([
                                $ui->Columns("<p style='font-family: NHaasGroteskDSPro-65Md;'>$productWord</p>",6),
                            ]),
                            $ui->Row([
                                $ui->Columns("<p>$productInformation->Descripcion</p>",12),

                            ]),
                            "<hr style='margin: 10px 0px 10px 0px !important;' />",
                            $ui->Row([
                                $ui->Columns($descripcionLarga,12,0,0,0,"small-font")
                            ]),
                            "<hr style='margin-top: 1em!important;'/>",
                            "<div style='height: 25vh display: contents;'>",
                            "<label style='padding-left: 40px'>$price</label>",
                            "</div><hr style='margin: 0 0 0 0'/>",
                            $fc->SizeButton($botonTalla,$opcionesTallas),
                            $flowButton,
                            $fc->MenuPrivacyReturnView(true,true)

                        ],"component")

//                        "<div class='container-fluid' style='position: fixed;bottom: 0;font-size: 0.9em;'>".
//                            "<label><span>PRIVACY POLICY</span></label><label><span>SHIPPING RETURNS</span></label><label><button type='button' class='btn btn-link' style='text-decoration: none;color: black;padding: 0;border: none;font-weight: normal;font-size: 14.4px'  data-toggle='modal' data-target='#size'><span>SIZE GUIDE</span></button></label>".
//                        "</div>"
            ],"main"),
        ]),
        $fc->TMenu(""),
        $ui->ContainerFluid([
        ], "contenedorIndex"),
        '
        <div class="modal" id="size" tabindex="-1" role="dialog" aria-labelledby="sizeLabel" aria-hidden="true" 
        style="background-color: rgba(255,255,255,0.6);">
          <div class="modal-dialog modal-dialog-centered" style="max-width: 700px;" role="document">
            <div class="modal-content" style="border-radius: 0;border: 0 solid transparent;background-color: white; color: black;">
              <div class="modal-header" style="border-color: black; padding: 0px; padding-left: 20px; margin-bottom: 10px;">
                <h7 class="modal-title" id="sizeLabel"><span onclick="ChangeSize(1);">CM</span><div class="space"></div><span onclick="ChangeSize(2.54)">IN</span></h7>
                <button style="color:black;" type="button" class="btn" data-dismiss="modal" aria-label="Close">
                  X
                </button>
              </div>
              <div class="modal-body" style="padding: 0;">
                '.$modal.'
              </div>
            </div>
          </div>
        </div>
        '


    ],"style='background-color:#FFFFF;' ") //#AC9950
);

print_r($h);

