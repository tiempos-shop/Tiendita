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
$tipoCambio=20;
$idioma=[ "ESPAÑOL"=>[ "MENU"=>[ "INICIO","ARCHIVO","MARCA","ENGLISH","CARRITO(*)"] ],"ENGLISH"=>[ "MENU"=>[ "HOME","ARCHIVE","IMPRINT","ESPAÑOL","CART(*)" ] ] ];





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
                    overflow-y: overlay;
                }
                .btn:focus {
                    outline: none;
                    box-shadow: none;
                }
                [type='submit']{
                    -webkit-appearance: none!important;  
                }
                #logo{
                    display:inline-block;
                    top:50vh;
                    left: 90vw;
                    width: 7%;
                }
                #t{
                    position:fixed;
                    display:inline-block;
                    top:50vh;
                    left: 2vw;
                    
                }
                
                .small-font{
                    font-size: 0.9em;
                }
                .form-control:focus {
                    box-shadow:  0 1px 1px black, 0 0 3px black;
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
                $ui->Columns("",2),
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
                    $fc->BlackInput("FIRST NAME","name"),
                    4),
                $ui->Columns(
                    $fc->BlackInput("LAST NAME","name"),
                    4),
                $ui->Columns("",2),
            ]),
            $ui->RowSpace("1em"),
            $ui->Row([
                $ui->Columns("",2),
                $ui->Columns(
                    $fc->BlackInput("STREET ADDRESS","name"),
                    4),
                $ui->Columns(
                    $fc->BlackInput("COMPANY (OPTIONAL)","name"),
                    4),
                $ui->Columns("",2),
            ]),
            $ui->RowSpace("1em"),
            $ui->Row([
                $ui->Columns("",2),
                $ui->Columns(
                    $fc->BlackInput("CITY","name"),
                    4),
                $ui->Columns(
                    $fc->BlackInput("ZIP OR POSTAL CODE","name"),
                    4),
                $ui->Columns("",2),
            ]),
            $ui->RowSpace("1em"),
            $ui->Row([
                $ui->Columns("",2),
                $ui->Columns(
                    $fc->BlackInput("COUNTRY/REGION","name"),
                    4),
                $ui->Columns(
                    $fc->BlackInput("STATE/PROVINCE","name"),
                    4),
                $ui->Columns("",2),
            ]),
            $ui->RowSpace("2em"),
            $ui->Row([
                $ui->Columns("",2),
                $ui->Columns(
                    $fc->BlackInput("PHONE","name"),
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
                    "<button class='btn btn-block btn-dark' formaction='customerLogin.php?action=create' type='submit' style='border-radius: 0;background-color: black;margin-top: 1em;'>SAVE</button>",
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
                $ui->Columns("",2),
                $ui->Columns(
                    "SHIPPING METHOD",
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
                    "<input class='form-check-input' type='checkbox' id='newsletter' name='newsletter' style='border-radius: 10px;border-color: black'> $40.00 USD | 5 DAYS | EXPRESS</input>",
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
                    "",
                    4),
                $ui->Columns("",2),
            ]),
            $ui->RowSpace("1vh"),
            $ui->Row([
                $ui->Columns("",2),
                $ui->Columns(
                    "<input class='form-check-input' type='checkbox' id='newsletter' name='newsletter' style='border-radius: 10px;border-color: black'> PAY WITH PAYPAL</input>",
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

        ]),
        $fc->MenuPrivacyReturn(true,true)



    ],"style='background-color:#FFFFF;' ") //#AC9950
);

print_r($h);
