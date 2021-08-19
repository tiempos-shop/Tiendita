<?php


use Administracion\VistasHtml;
use Tiendita\EntidadBase;
use Tiendita\Utilidades;

include_once "View/Componentes/Administracion/VistasHtml.php";
include_once "Business/Utilidades.php";
include_once "Data/Connection/EntidadBase.php";
include_once "Business/FrontComponents.php";

$fc=new \Tiendita\FrontComponents();
$html=new VistasHtml();
$ui=new Utilidades();
$db=new EntidadBase();

session_start();
if(isset($_SESSION["ProductosCarrito"])){
    $productosCarrito=$_SESSION["ProductosCarrito"];
    $numeroProductosCarrito=count($productosCarrito);
}
else{
    $numeroProductosCarrito=0;
}

// Idioma
$idiomaActual="";
if(count($_POST)>0)
{
    if(isset($_POST["language"])){
        $idiomaActual=$_POST["language"];
        $_SESSION["language"]=$idiomaActual;
    }
    else{
        $idiomaActual=$_SESSION["language"];
    }

    if(isset($_GET["action"])){
        $action=$_GET["action"];
        $ui->Debug($_POST);
        switch ($action){
            case "login":
                break;
            case "forgot":
                break;
            case "facebook":
                break;
            case "google":
                break;
            case "create":
                break;
        }
    }

}
else{
    $idiomaActual=$_SESSION["language"];
}

/*Obtener datos de carrito*/
$productosCarrito=array();
$tallas=[ "S","M","L","XL"];

$numeroProductosCarrito=0;
$productosCarrito=array();

$fc=new \Tiendita\FrontComponents();


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
$numeroProductosCarrito = 0;
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
}

/* HTML PARA PRODUCTOS */
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
$tipoCambio = 20;

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
            $ui->Columns("<div class ='d-flex' style='margin-top: 16px;'></form>".$element["Cantidad"]."</div>",1),
            $ui->Columns("<div style='margin-top: 16px;'>".$carrito["Talla"]."</div>",1),
            $ui->Columns('',1),
            $ui->Columns("<div style='margin-top: 16px; display: inline-block;'>".$price."</div>",3)
        ])."<hr style='margin: 0;' />";

    if($idiomaActual=="ENGLISH") $suma+=floatval($n*$element["CostoSale"]/$tipoCambio);else $suma+=floatval($n*$element["CostoSale"]);
}
$htmlProducts .= "<br />";


$idioma=[ "ESPAÑOL"=>[ "MENU"=>[ "INICIO","ARCHIVO","MARCA","ENGLISH","CARRITO(*)"], "CURRENCY" => "MXN" ],"ENGLISH"=>[ "MENU"=>[ "HOME","ARCHIVE","IMPRINT","ESPAÑOL","CART(*)" ], "CURRENCY" => "USD" ] ];

$moneda = $idioma[$idiomaActual]["CURRENCY"];
$h= $html->Html5(
    $html->Head(
        "Tiempos Shop",
        $html->Meta("utf-8","Tienda Online de Tiempos Shop","Egil Ordonez"),
        $html->LoadStyles(["global.css","View/css/bootstrap.css","https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"]),
        $html->LoadScripts(["View/js/bootstrap.js", "js/global.js", "js/axios.min.js", "js/checkout.js"]),
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
                      let id=str.replace("_", "\'");
                      go("view.php?id="+id);
                  }
                </script>'

    ),
    $html->Body([

        $fc->Menu($idioma,$idiomaActual,$numeroProductosCarrito,["","","","'","",""]),

        $ui->ContainerFluid([
            $ui->Row([

                $ui->Columns("<label style='font-family: NHaasGroteskDSPro-65Md'>CHECKOUT</label>",12,0,0,0,"",
                    "text-align:center;margin-top:100px")
            ]),
            $ui->RowSpace("2vh"),
            "<hr style='opacity: 1'/>",
            $ui->RowSpace("1vh"),
            $ui->Row([
                $ui->Columns("<input type='hidden' id='moneda' value='$moneda'>",2),
                $ui->Columns(
                    "SHIPPING ADDRESS",
                    4),
                $ui->Columns(
                    "",
                    4),
                $ui->Columns("",2),
            ]),
            $ui->RowSpace("2vh"),
            $ui->Row([
                $ui->Columns("",2),
                $ui->Columns(
                    $fc->BlackInput("FIRST NAME","nombre"),
                    4),
                $ui->Columns(
                    $fc->BlackInput("LAST NAME","apellido"),
                    4),
                $ui->Columns("",2),
            ]),
            $ui->RowSpace("1em"),
            $ui->Row([
                $ui->Columns("",2),
                $ui->Columns(
                    $fc->BlackInput("STREET ADDRESS","calle"),
                    4),
                $ui->Columns(
                    $fc->BlackInput("COMPANY (OPTIONAL)","company"),
                    4),
                $ui->Columns("",2),
            ]),
            $ui->RowSpace("1em"),
            $ui->Row([
                $ui->Columns("",2),
                $ui->Columns(
                    $fc->BlackInput("CITY","ciudad"),
                    4),
                $ui->Columns(
                    $fc->BlackInput("ZIP OR POSTAL CODE","postalcode", false, "5"),
                    4),
                $ui->Columns("",2),
            ]),
            $ui->RowSpace("1em"),
            $ui->Row([
                $ui->Columns("",2),
                $ui->Columns(
                    $fc->BlackInput("COUNTRY/REGION","pais"),
                    4),
                $ui->Columns(
                    $fc->BlackInput("STATE/PROVINCE","estado"),
                    4),
                $ui->Columns("",2),
            ]),
            $ui->RowSpace("2em"),
            $ui->Row([
                $ui->Columns("",2),
                $ui->Columns(
                    $fc->BlackInput("PHONE","telefono"),
                    2),
                $ui->Columns(
                    "",
                    6),
                $ui->Columns("",2),
            ]),
            $ui->RowSpace("1em"),
            $ui->Row([
                $ui->Columns("",2),
                $ui->Columns(
                    "<button class='btn btn-block btn-dark' onclick='CalcRate()' style='border-radius: 0;background-color: black;margin-top: 1em;'>SAVE</button>",
                    2),
                $ui->Columns(
                    "<button class='btn btn-block btn-dark' formaction='customerLogin.php?action=create' type='submit' style='border-radius: 0;background-color: black;margin-top: 1em;'>CANCEL</button>",
                    2),
                $ui->Columns(
                    "",
                    4),
                $ui->Columns("",2),
            ]),
            $ui->RowSpace("1em"),
            $ui->Row([
                $ui->Columns("",2),
                $ui->Columns(
                    "<input class='form-check-input' type='checkbox' id='newsletter' name='newsletter' style='border-radius: 10px;border-color: black'> USE AS BILLING ADDRESS</input>",
                    4),
                $ui->Columns(
                    "",
                    4),
                $ui->Columns("",2),
            ]),
            "<hr style='opacity: 1'/>",
            $ui->RowSpace("1vh"),
            $ui->Row([
                $ui->Columns("",4,0,0,0,"","text-aling: center;"),
                $ui->Columns(
                    "SHIPPING METHOD",
                    4),
                $ui->Columns(
                    "",
                    4),

            ]),
            $ui->RowSpace("2vh"),
            $ui->Row([
                $ui->Columns("",2),
                $ui->Columns(
                    "<input class='form-check-input' type='checkbox' disabled id='tiempoEntrega' name='newsletter' style='border-radius: 10px;border-color: black'>"
                    ."<span id='postalcodetext' class='ml-1 text-muted'>INPUT POSTAL CODE FIRST</span></input>",
                    4),
                $ui->Columns(
                    "",
                    4),
                $ui->Columns("",2),
            ]),
            $ui->RowSpace("2vh"),
            "<hr style='opacity: 1'/>",
            $ui->RowSpace("1vh"),
            $ui->Row([
                $ui->Columns("",2),
                $ui->Columns(
                    "PAYMENT METHOD",
                    4),
                $ui->Columns(
                    "",
                    4),
                $ui->Columns("",2),
            ]),
            $ui->RowSpace("2vh"),
            $ui->Row([
                $ui->Columns("",2),
                $ui->Columns(
                    "<input class='form-check-input' type='checkbox' id='newsletter' name='newsletter' style='border-radius: 10px;border-color: black'> PAY WITH CREDIT OR DEBIT CARD</input>",
                    4),
                $ui->Columns(
                    "<img id='pago-seguro' src='img/pago-seguro.png' class='img-fluid'/>",
                    6,0,0,0,0,"")

            ]),
            $ui->RowSpace("1vh"),
            $ui->Row([
                $ui->Columns("",2),
                $ui->Columns(
                    "<input class='form-check-input' type='checkbox' id='newsletter' name='newsletter' style='border-radius: 10px;border-color: black'> PAY WITH PAYPAL</input>",
                    4,0,0,0,0,"margin-top:-50px"),
                $ui->Columns(
                    "",
                    4),
                $ui->Columns("",2),
            ]),
            $ui->RowSpace("2vh"),
            "<hr style='opacity: 1'/>",
            $ui->RowSpace("1vh"),
            $ui->Row([
                $ui->Columns("",2),
                $ui->Columns(
                    "CARD DETAILS",
                    4),
                $ui->Columns(
                    "",
                    4),
                $ui->Columns("",2),
            ]),
            $ui->RowSpace("2vh"),
            $ui->Row([
                $ui->Columns("",2),
                $ui->Columns(
                    $fc->BlackInput("CARD NUMBER","name"),
                    4),
                $ui->Columns(
                    $fc->BlackInput("EXPIRATION DAY","name"),
                    2),
                $ui->Columns("",4),
            ]),
            $ui->RowSpace("1em"),
            $ui->Row([
                $ui->Columns("",2),
                $ui->Columns(
                    $fc->BlackInput("CARDHOLDDER´S NAME","name"),
                    4),
                $ui->Columns(
                    $fc->BlackInput("CVV","name"),
                    1),
                $ui->Columns("",5),
            ]),
            $ui->RowSpace("2vh"),
            "<hr style='opacity: 1'/>",
            $ui->RowSpace("1vh"),
            $ui->Row([
                $ui->Columns("<label style='font-family: NHaasGroteskDSPro-65Md'>SUMMARY</label>",12,0,0,0,"",
                    "text-align:center;margin-top:10px")
            ]),
            $ui->RowSpace("2vh"),
            "<hr style='opacity: 1; margin: 0px;' />",
            $htmlProducts,
            $ui->Row([
                $ui->Columns(

                    $ui->Row([
                        $ui->Columns("",3,0,0,0,''),
                        $ui->Columns("<div class ='d-flex flex-column' style='margin-top: 10px;'>
                                                <p class='mr-5'>Subtotal</p>
                                                <p>Shipping total</p>
                                                <p>Duties and taxes</p>
                                                <p class='font-weight-bold mt-2'>Total</p>
                                            </div>",6),
                        $ui->Columns("<div style='margin-top: 10px;' class='d-flex flex-column'>
                                                <p class='mr-5'>$moneda $suma</p>
                                                <p>USD $10</p>
                                                <p>(Included)</p>
                                                <p class='font-weight-bold mt-2'>USD $100</p>
                                            </div>",3)
                    ],''),12,0,0,0,'pt-6 pb-4 border-bottom border-dark'),
                "<button class='btn btn-dark btn-block' style='text-align: left;border-radius: 0'>
                ".$ui->Row([
                    //$ui->Columns('',6),
                    $ui->Columns('PLACE ORDER',12,0,0,0,"text-center")
                ])."
            </button>",

            ],''),
        ]),
        $fc->MenuPrivacyReturn(true,true)



    ],"style='background-color:#FFFFF;' ") //#AC9950
);

print_r($h);
