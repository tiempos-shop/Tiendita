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

$productInformation = $products = $db->getBy("Productos","Clave", $id)[0];

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
$idioma=[ "ESPAÑOL"=>[ "MENU"=>[ "INICIO","ARCHIVO","MARCA","ENGLISH","CARRITO(*)"],"LOGIN"=>[] ],"ENGLISH"=>[ "MENU"=>[ "HOME","ARCHIVE","IMPRINT","ESPAÑOL","CART(*)" ] ] ];

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
    //$tallas=$productInformation->SelectSize;
    $tallas = array("XXS","XS", "S", "M", "L", "XL", "XXL");
    $opcionesTallas="";
    //$opcionesTallas="<a class='dropdown-item' href='#'>$tallas (Products in stock: $inventario)</a>";

    foreach ($tallas as $value) {
        $opcionesTallas .= "<a class='dropdown-item pl-4' href='#'>$value</a>";
    }
    $botonTalla="SELECT SIZE";
}
else{
    $productWord=$productInformation->Nombre;
    $price=$ui->Moneda($productInformation->Costo,"MXN $");
    if($productInformation->Sale){
        $price="<s>$price</s> ".$ui->Moneda($productInformation->CostoSale,"MXN $");
    }
    $descripcionLarga=$productInformation->DescripcionLarga;
    //$tallas=$productInformation->SeleccrionaTalla;
    $tallas = array( "XS", "SM", "GD" );
    foreach ($tallas as $value) {
        $opcionesTallas .= "<a class='dropdown-item pl-4' href='#'>$value</a>";
    }
    //$opcionesTallas="<a class='dropdown-item' href='#'>$tallas (Productos en inventario: $inventario)</a>";

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
$count=0;
foreach ($images as $image){
    $count++;
    $id="id".$count;
    $collage.="<img id='$id' class='img-fluid' src='$image' data-big='$image' data-overlay=''><br/>";// data-overlay="fondo.png"
    $innerScript.=$fc->ScriptAmpliarFoto($id);
}
$lupaScript=$fc->Lupa($innerScript);

$modal="<table class='table table-borderless prodSize' style='color: black;'>
    <thead>
        <tr style='color: black; opacity: 1;'>
            <td></td>
            <th>S</th>
            <th>M</th>
            <th>L</th>
            <th>XL</th>
        </tr>
    </thead>
    <tbody id='tableDetalle' style='color: black;'>
    </tbody>
</table>";

$db->close();
$htmlProducts="";
//$ui->Debug($productWord);


$h= $html->Html5(
    $html->Head(
        "Tiempos Shop",
        $html->Meta("utf-8","Tienda Online de Tiempos Shop","Egil Ordonez"),
        $html->LoadStyles(["View/css/bootstrap.css","css/view.css", "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"]),
        $html->LoadScripts(["vendor/jquery/jquery.js","js/jquery.mlens-1.7.min.js","js/bootstrap.bundle.min.js"]),
        "
        <style>
                main,#component{

    padding-right: 0!important;
                    padding-left: 0!important;
                }
                td{
    text-align: center;
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
                    
                    overflow: no-display;
                    font-size:.9em !important;
                }
                button {
                    letter-spacing: 0.081rem !important;
                }
                .btn:focus {
                    outline: none;
                    box-shadow: none;
                }
                [type='submit']{
                    -webkit-appearance: none!important;  
                } 
                
                .left-top{
                    position: fixed;
                    right: 0;
                    //top: 5vh;
                    margin-top: 50px;
                    //left: 50vw;
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
          
                div{
                    padding-right: 0;
                    padding-left: 0;
                }
                p{
                    text-align: justify;
                    text-align-last: justify;
                    padding-left: 40px;
                    padding-right: 40px; 
                    margin: 0 0 0 0;
                    font-size: inherit;
                }
                #componentBase{
                    position: fixed;
                    bottom: 0;
                    font-size: 0.9em;
                }
        
                .small-font{
                    font-size: 0.9em;
                }
                .prodSize{
                    text-align: center;
                    color:white;
                }
                .prodSize > tbody > tr > td:first-child {
                    text-align: left; 
                    
                }
                .prodSize > tbody > tr{
                 border-bottom: 1px solid black;
                }
                .prodSize > tbody > tr:last-child{
                    border: none;
                }
                .paddingNone{
                    padding: 0;
                }
                .modal-backdrop{
                    background-color: transparent;
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
                  '.$lupaScript.'
                  
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
                  
                  function ChangeSize(conversion, e)
                      {
                          $("span").removeClass("activerow");
                          $(e).addClass("activerow");
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
        $fc->Menu($idioma,$idiomaActual,$numeroProductosCarrito,["'","","","","",""]),
        $fc->LogoNegro(),
        $ui->ContainerFluid([
            $ui->Row([
                $ui->Columns(
                    $collage
                    ,6,0,0,0,"paddingNone"),
                $ui->Columns(
                    $ui->ContainerFluid([
                            "<br/>",
                            $ui->Row([
                                $ui->Columns("<p style='font-family: NHaasGroteskDSPro-65Md;'>$productWord</p>",12),
                            ]),
                            $ui->Row([
                                $ui->Columns("<p>$productInformation->Descripcion</p>",12),
                            ]),
                            "<hr style='margin-top: 1em!important;'/>",
                            $ui->Row([
                                $ui->Columns($descripcionLarga,12,0,0,0,"small-font")
                            ]),
                            "<hr style='margin-top: 1em!important;'/>",
                            "<div style='height: 25vh'>",
                            "<label style='padding-left: 40px'>$price</label>",
                            "</div><hr style='margin: 0 0 0 0'/>",
                            $fc->SizeButton($botonTalla,$opcionesTallas),
                            $flowButton,
                            $fc->MenuPrivacyReturnView(true,true)

                        ],"component")

//                        "<div class='container-fluid' style='position: fixed;bottom: 0;font-size: 0.9em;'>".
//                            "<label><span>PRIVACY POLICY</span></label><label><span>SHIPPING RETURNS</span></label><label><button type='button' class='btn btn-link' style='text-decoration: none;color: black;padding: 0;border: none;font-weight: normal;font-size: 14.4px'  data-toggle='modal' data-target='#size'><span>SIZE GUIDE</span></button></label>".
//                        "</div>"
                    ,6,0,0,0,"left-top paddingNone")
            ],"main")
        ]),
        '
        <div class="modal" id="size" tabindex="-1" role="dialog" aria-labelledby="sizeLabel" aria-hidden="true" 
        style="background-color: #ffffff8C;">
          <div class="modal-dialog modal-dialog-centered" style="max-width: 700px;" role="document">
            <div class="modal-content" style="border-radius: 0;border: 0 solid transparent; background-color:white;">
              <div class="modal-header" style="border-color: black; padding: 0px; padding-left: 20px; margin-bottom: 10px;">
                <h6 style="color:black;" class="modal-title" id="sizeLabel"><span onclick="ChangeSize(1, this);" class="activerow">CM</span><div class="space"></div><span onclick="ChangeSize(2.54, this)">IN</span></h6>
                <button style="Color:black; " type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
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

