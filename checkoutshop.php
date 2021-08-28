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

$idioma=[ "ESPAÑOL"=>[ "MENU"=>[ "INICIO","ARCHIVO","MARCA","ENGLISH","CARRITO(*)"], "CURRENCY" => "MXN" ],"ENGLISH"=>[ "MENU"=>[ "HOME","ARCHIVE","IMPRINT","ESPAÑOL","CART(*)" ], "CURRENCY" => "USD" ] ];


$htmlPrincipal = "<!DOCTYPE html>
        <html lang='es'>";
print_r($htmlPrincipal);
$h = $html->Head(
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

);
print_r($h);

$menu = $fc->Menu($idioma,$idiomaActual,$numeroProductosCarrito,["","","","'","",""]);
print_r($menu);

?>

<div class="container-fluid" style="style=""">
<div class="row ">
    <div class='  col-md-12  ' style='text-align:center;margin-top:100px'>
        <label style='font-family: NHaasGroteskDSPro-65Md'>CHECKOUT</label>
    </div>
</div>
<div class="row ">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:2vh'>

    </div>
</div>
<hr style='opacity: 1' />
<div class="row ">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:1vh'>

    </div>
</div>
<div class="row ">
    <div class='  col-md-2  ' style=''>
        <input type='hidden' id='moneda' value='MXN'>
    </div>
    <div class='  col-md-4  ' style=''>
        SHIPPING ADDRESS
    </div>
    <div class='  col-md-4  ' style=''>

    </div>
    <div class='  col-md-2  ' style=''>

    </div>
</div>
<div class="row ">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:2vh'>

    </div>
</div>
<div class="row ">
    <div class='  col-md-2  ' style=''>

    </div>
    <div class='  col-md-4  ' style=''>
        <input class='form-control' name='nombre' id='nombre' maxlength='999999' placeholder='FIRST NAME'
               style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em' />
    </div>
    <div class='  col-md-4  ' style=''>
        <input class='form-control' name='apellido' id='apellido' maxlength='999999' placeholder='LAST NAME'
               style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em' />
    </div>
    <div class='  col-md-2  ' style=''>

    </div>
</div>
<div class="row ">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:1em'>

    </div>
</div>
<div class="row ">
    <div class='  col-md-2  ' style=''>

    </div>
    <div class='  col-md-4  ' style=''>
        <input class='form-control' name='calle' id='calle' maxlength='999999' placeholder='STREET ADDRESS'
               style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em' />
    </div>
    <div class='  col-md-4  ' style=''>
        <input class='form-control' name='company' id='company' maxlength='999999'
               placeholder='COMPANY (OPTIONAL)'
               style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em' />
    </div>
    <div class='  col-md-2  ' style=''>

    </div>
</div>
<div class="row ">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:1em'>

    </div>
</div>
<div class="row ">
    <div class='  col-md-2  ' style=''>

    </div>
    <div class='  col-md-4  ' style=''>
        <input class='form-control' name='ciudad' id='ciudad' maxlength='999999' placeholder='CITY'
               style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em' />
    </div>
    <div class='  col-md-4  ' style=''>
        <input class='form-control' name='postalcode' id='postalcode' maxlength='5'
               placeholder='ZIP OR POSTAL CODE'
               style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em' />
    </div>
    <div class='  col-md-2  ' style=''>

    </div>
</div>
<div class="row ">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:1em'>

    </div>
</div>
<div class="row ">
    <div class='  col-md-2  ' style=''>

    </div>
    <div class='  col-md-4  ' style=''>
        <input class='form-control' name='pais' id='pais' maxlength='999999' placeholder='COUNTRY/REGION'
               style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em' />
    </div>
    <div class='  col-md-4  ' style=''>
        <input class='form-control' name='estado' id='estado' maxlength='999999' placeholder='STATE/PROVINCE'
               style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em' />
    </div>
    <div class='  col-md-2  ' style=''>

    </div>
</div>
<div class="row ">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:2em'>

    </div>
</div>
<div class="row ">
    <div class='  col-md-2  ' style=''>

    </div>
    <div class='  col-md-2  ' style=''>
        <input class='form-control' name='telefono' id='telefono' maxlength='999999' placeholder='PHONE'
               style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em' />
    </div>
    <div class='  col-md-6  ' style=''>

    </div>
    <div class='  col-md-2  ' style=''>

    </div>
</div>
<div class="row ">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:1em'>

    </div>
</div>
<div class="row ">
    <div class='  col-md-2  ' style=''>

    </div>
    <div class='  col-md-2  ' style=''>
        <button class='btn btn-block btn-dark' onclick='CalcRate()'
                style='border-radius: 0;background-color: black;margin-top: 1em;'>SAVE</button>
    </div>
    <div class='  col-md-2  ' style=''>
        <button class='btn btn-block btn-dark' formaction='customerLogin.php?action=create' type='submit'
                style='border-radius: 0;background-color: black;margin-top: 1em;'>CANCEL</button>
    </div>
    <div class='  col-md-4  ' style=''>

    </div>
    <div class='  col-md-2  ' style=''>

    </div>
</div>
<div class="row ">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:1em'>

    </div>
</div>
<div class="row ">
    <div class='  col-md-2  ' style=''>

    </div>
    <div class='  col-md-4  ' style=''>
        <input class='form-check-input' type='checkbox' id='newsletter' name='newsletter'
               style='border-radius: 10px;border-color: black'> USE AS BILLING ADDRESS</input>
    </div>
    <div class='  col-md-4  ' style=''>

    </div>
    <div class='  col-md-2  ' style=''>

    </div>
</div>
<hr style='opacity: 1' />
<div class="row ">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:1vh'>

    </div>
</div>
<div class="row ">
    <div class='  col-md-4  ' style='text-aling: center;'>

    </div>
    <div class='  col-md-4  ' style=''>
        SHIPPING METHOD
    </div>
    <div class='  col-md-4  ' style=''>

    </div>
</div>
<div class="row ">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:2vh'>

    </div>
</div>
<div class="row ">
    <div class='  col-md-2  ' style=''>

    </div>
    <div class='  col-md-4  ' style=''>
        <input class='form-check-input' type='checkbox' disabled id='tiempoEntrega' name='newsletter'
               style='border-radius: 10px;border-color: black'><span id='postalcodetext'
                                                                     class='ml-1 text-muted'>INPUT POSTAL CODE FIRST</span></input>
    </div>
    <div class='  col-md-4  ' style=''>

    </div>
    <div class='  col-md-2  ' style=''>

    </div>
</div>
<div class="row ">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:2vh'>

    </div>
</div>
<hr style='opacity: 1' />
<div class="row ">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:1vh'>

    </div>
</div>
<div class="row ">
    <div class='  col-md-2  ' style=''>

    </div>
    <div class='  col-md-4  ' style=''>
        PAYMENT METHOD
    </div>
    <div class='  col-md-4  ' style=''>

    </div>
    <div class='  col-md-2  ' style=''>

    </div>
</div>
<div class="row ">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:2vh'>

    </div>
</div>
<div class="row ">
    <div class='  col-md-2  ' style=''>

    </div>
    <div class='  col-md-4  ' style=''>
        <input class='form-check-input' type='checkbox' id='newsletter' name='newsletter'
               style='border-radius: 10px;border-color: black'> PAY WITH CREDIT OR DEBIT CARD</input>
    </div>
    <div class='  col-md-6  0' style=''>
        <img id='pago-seguro' src='img/pago-seguro.png' class='img-fluid' />
    </div>
</div>
<div class="row ">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:1vh'>

    </div>
</div>
<div class="row ">
    <div class='  col-md-2  ' style=''>

    </div>
    <div class='  col-md-4  0' style='margin-top:-50px'>
        <input class='form-check-input' type='checkbox' id='newsletter' name='newsletter'
               style='border-radius: 10px;border-color: black'> PAY WITH PAYPAL</input>
    </div>
    <div class='  col-md-4  ' style=''>

    </div>
    <div class='  col-md-2  ' style=''>

    </div>
</div>
<div class="row ">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:2vh'>

    </div>
</div>
<hr style='opacity: 1' />
<div class="row ">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:1vh'>

    </div>
</div>
<div class="row ">
    <div class='  col-md-2  ' style=''>

    </div>
    <div class='  col-md-4  ' style=''>
        CARD DETAILS
    </div>
    <div class='  col-md-4  ' style=''>

    </div>
    <div class='  col-md-2  ' style=''>

    </div>
</div>
<div class="row ">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:2vh'>

    </div>
</div>
<div class="row ">
    <div class='  col-md-2  ' style=''>

    </div>
    <div class='  col-md-4  ' style=''>
        <input class='form-control' name='name' id='name' maxlength='999999' placeholder='CARD NUMBER'
               style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em' />
    </div>
    <div class='  col-md-2  ' style=''>
        <input class='form-control' name='name' id='name' maxlength='999999' placeholder='EXPIRATION DAY'
               style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em' />
    </div>
    <div class='  col-md-4  ' style=''>

    </div>
</div>
<div class="row ">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:1em'>

    </div>
</div>
<div class="row ">
    <div class='  col-md-2  ' style=''>

    </div>
    <div class='  col-md-4  ' style=''>
        <input class='form-control' name='name' id='name' maxlength='999999' placeholder='CARDHOLDDER´S NAME'
               style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em' />
    </div>
    <div class='  col-md-1  ' style=''>
        <input class='form-control' name='name' id='name' maxlength='999999' placeholder='CVV'
               style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em' />
    </div>
    <div class='  col-md-5  ' style=''>

    </div>
</div>
<div class="row ">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:2vh'>

    </div>
</div>
<hr style='opacity: 1' />
<div class="row ">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:1vh'>

    </div>
</div>
<div class="row ">
    <div class='  col-md-12  ' style='text-align:center;margin-top:10px'>
        <label style='font-family: NHaasGroteskDSPro-65Md'>SUMMARY</label>
    </div>
</div>
<div class="row ">
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:2vh'>

    </div>
</div>
<hr style='opacity: 1' />
<div class="row ">
    <div class='  col-md-2  ' style=''>

    </div>
    <div class='  col-md-4  ' style=''>
        <div style='cursor: pointer;' onclick="view('T0001_05')"><img src='img/0005-BETABEL.jpg' height='172'>
            <div
                style='height: 100%;margin-left: 15px;display: inline-block;vertical-align: top;margin-top: 16px;'>
                BETABEL</div>
        </div>
    </div>
    <div class='  col-md-1  ' style=''>
        <div class='d-flex' style='margin-top: 16px;'>
            <form method='post' action='' name='T0001_05'><input type="hidden" value="T0001_05" name="borrar"
                                                                 id="borrar"><button type='submit'
                                                                                     style='border:0 solid transparent;background-color:transparent;display: inline-block'>X</button>
            </form><input onchange='edit(this,"T0001_05");' type='text' maxlength='1' value='1'
                          style='width: 25px;padding-left: 5px;'>
        </div>
    </div>
    <div class='  col-md-1  ' style=''>
        <div style='margin-top: 16px;'>ONE SIZE</div>
    </div>
    <div class='  col-md-1  ' style=''>

    </div>
    <div class='  col-md-3  ' style=''>
        <div style='margin-top: 16px; display: inline-block;'>
            <div class='  col-md-1  ' style=''>
                MXN $1,300.00
            </div>
        </div>
    </div>
</div>
<hr style='margin: 0;' /><br />
<div class="row ">
    <div class='  col-md-12  pt-6 pb-4 border-bottom border-dark' style=''>
        <div class="row ">
            <div class='  col-md-3  ' style=''>

            </div>
            <div class='  col-md-6  ' style=''>
                <div class='d-flex flex-column' style='margin-top: 10px;'>
                    <p class='mr-5'>Subtotal</p>
                    <p>Shipping total</p>
                    <p>Duties and taxes</p>
                    <p class='font-weight-bold mt-2'>Total</p>
                </div>
            </div>
            <div class='  col-md-3  ' style=''>
                <div style='margin-top: 10px;' class='d-flex flex-column'>
                    <p class='mr-5'>MXN 1300 <input type='hidden' value='1300' id='subtotal'> </p>
                    <p> <span id='monedaEnvio'></span> <span class='ml-1' id='precioEnvio'></span> </p>
                    <p>(Included)</p>
                    <p class='font-weight-bold mt-2'><span id='monedaTotal'></span> <span class='ml-1'
                                                                                          id='precioTotal'></span></p>
                </div>
            </div>
        </div>
    </div><button class='btn btn-dark btn-block' style='text-align: left;border-radius: 0'
                  onclick='ProcesarPedido()'>
        <div class='text-center' id='procesarText'>PLACE ORDER</div>
    </button>
</div>
</div>
<div style='position: inherit;bottom: 0;margin-bottom: 0.8rem; min-height: 150px;'
     class='col-md-8 col-sm-12 text-right pr-4 pl-4 d-flex align-items-end'><span class='small mr-4 col-md-6'
                                                                                  onclick='go("privacy.php")'> PRIVACY POLICY</span><span onclick='go("shipping.php")'
                                                                                                                                          class='small ml-4 col-md-5'>SHIPPING & RETURNS</span></div>