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
$idioma=[ "ESPAÑOL"=>["MENU"=>[ "INICIO","ARCHIVO","MARCA","ENGLISH","CARRITO(*)"], "FILTER" => ["INFORMACION", "HISTORIAL DE COMPRAS", "CERRAR SESION"] ],
    "ENGLISH"=>[ "MENU"=>[ "HOME","ARCHIVE","IMPRINT","ESPAÑOL","CART(*)" ], "FILTER" => ["INFORMATION", "ORDER HISTORY", "LOGOUT"] ]];
$idiomaL=
    [
        "ESPAÑOL"=>[
            "MENU"=>[ "INICIO","ARCHIVO","MARCA","ENGLISH","CARRITO(*)"],
            "LOGIN" => [ "ACCESO","CORREO ELECTRÓNICO","CONTRASEÑA","OLVIDASTE TU CONTRASEÑA?","ACCESO CON FACEBOOK","ACCESO CON GOOGLE" ],
            "CREAR" => [ "CREAR CUENTA","NOMBRE","APELLIDO(S)","CORREO ELECTRÓNICO","CONTRASEÑA","REPETIR CONTRASEÑA"," SUSCRIBIRSE AL NEWSLETTER" ]
        ],
        "ENGLISH"=>[
            "MENU"=>[ "HOME","ARCHIVE","IMPRINT","ESPAÑOL","CART(*)" ],
            "LOGIN" => [ "LOGIN","EMAIL ADDRES","PASSWORD","FORGOT YOUR PASSWORD?","LOGIN WITH FACEBOOK","LOGIN WITH GOOGLE" ],
            "CREAR" => [ "CREATE AN ACCOUNT","NAME","LAST NAME","EMAIL ADDRESS","PASSWORD","REPEAT PASSWORD"," SIGN UP FOR NEWSLETTER" ]
        ]
    ];


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
    $htmlProducts .= $ui->Row([
            $ui->Columns("",2),
            $ui->Columns("<div style='cursor: pointer;' onclick=\"$js\"><img src='".$element["RutaImagen"]."' height='172'><div style='height: 100%;margin-left: 15px;display: inline-block;vertical-align: top;margin-top: 16px;'>".$element["Descripcion"]."</div></div>",4),
            //$ui->Columns($element["Descripcion"],2),
            $ui->Columns("<div class ='d-flex' style='margin-top: 16px;'>".$fc->Borrar($element)."</form>".$fc->BotonEditar($element)."</div>",1),
            $ui->Columns("<div style='margin-top: 16px;'>".$carrito["Talla"]."</div>",1),
            $ui->Columns('',1),
            $ui->Columns("<div style='margin-top: 16px; display: inline-block;'>".$price."</div>",3)
        ])."<hr style='margin: 0;' />";

    if($idiomaActual=="ENGLISH") $suma+=floatval($n*$element["CostoSale"]/$tipoCambio);else $suma+=floatval($n*$element["CostoSale"]);
}
$htmlProducts .= "<br />";

$idiomaInformativo = array("ENGLISH" => "SHIPPING & TAXES CALCULATED AT CHECKOUT", "ESPAÑOL" => "ENVIO E IMPUESTO CALCULADOS AL PAGAR");

$h= $html->Html5(
    $html->Head(
        "Tiempos Shop",
        $html->Meta("utf-8","Tienda Online de Tiempos Shop","Egil Ordonez"),
        $html->LoadStyles(["global.css","View/css/bootstrap.css","https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"]),
        $html->LoadScripts(["View/js/bootstrap.js"]),
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
                    margin-top: calc(2vh + 37.55px);
                    height: 100%;
                    padding: 0px;
                }
                
                .row{
                margin-right: 0px;
                margin-left: 0px;
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
        $fc->Menu($idioma,$idiomaActual,$numeroProductosCarrito,["","","","","","'"]),
        $fc->LogoNegro(),
        //$fc->MenuAccount($idioma[$idiomaActual]['FILTER']),
        $ui->ContainerFluid([
            $ui->Row([
                $ui->Columns( $fc->MenuAccount($idioma[$idiomaActual]['FILTER']) ,2,0,0,0,'pl-5 pt-2'),
                $ui->Columns(
                    $ui->RowSpace("2vh")
                    .$ui->Row([
                        $ui->Columns("",4),
                        $ui->Columns(
                            $ui->Lines([
                                $ui->FormButtom([

                                    $fc->BlackInputType($idiomaL[$idiomaActual]["CREAR"][1],"name","text",true),
                                    $ui->RowSpace("1vh"),
                                    $fc->BlackInputType($idiomaL[$idiomaActual]["CREAR"][2],"lastname","text"),
                                    $ui->RowSpace("1vh"),
                                    $fc->BlackInputType($idiomaL[$idiomaActual]["CREAR"][3],"login","email"),
                                    $ui->RowSpace("1vh"),
                                    $fc->BlackInputTypeAttrib($idiomaL[$idiomaActual]["CREAR"][4],"password1","password",true,"onkeyup='passwordValidate()'"),
                                    $ui->RowSpace("1vh"),
                                    $fc->BlackInputTypeAttrib($idiomaL[$idiomaActual]["CREAR"][5],"password2","password",true,"onkeyup='passwordValidate()'"),
                                    $ui->RowSpace("1vh"),
                                    "<input class='form-check-input' type='checkbox' id='newsletter' name='newsletter' style='border-radius: 10px;border-color: black'>".$idiomaL[$idiomaActual]["CREAR"][6]."</input>",

                                ],"","<button class='btn btn-block btn-dark' onclick='return passwordValidate()' formaction='information.php?action=create' type='submit' style='border-radius: 0;background-color: black;margin-top: 1em;'>".$idiomaL[$idiomaActual]["CREAR"][0]."</button>"),
                            ]),
                           6,0,0,0),
                    ]), 10,0,0,0,"","text-align:center;")
            ],'')

        ],"container"),
        $fc->Aviso((count($elements)>2 ? "inherit": "absolute")),
    ],"style='background-color:#FFFFF;' ") //#AC9950
);

print_r($h);