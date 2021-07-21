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
$idioma=[ "ESPAÑOL"=>[ "MENU"=>[ "INICIO","ARCHIVO","MARCA","ENGLISH","CARRITO(*)"], "CURRENCY" => "MXN" ],"ENGLISH"=>[ "MENU"=>[ "HOME","ARCHIVE","IMPRINT","ESPAÑOL","CART(*)" ], "CURRENCY" => "USD" ] ];

$moneda = $idioma[$idiomaActual]["CURRENCY"];
$h= $html->Html5(
    $html->Head(
        "Tiempos Shop",
        $html->Meta("utf-8","Tienda Online de Tiempos Shop","Egil Ordonez"),
        $html->LoadStyles(["global.css","View/css/bootstrap.css","https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"]),
        $html->LoadScripts(["View/js/bootstrap.js", "js/axios.min.js", "js/checkout.js"]),
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
                    $fc->BlackInput("CITY","city"),
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
            "<hr style='opacity: 1'/>",

            $ui->Row([
                $ui->Columns(
                    $ui->Row([
                        $ui->Columns('',3),
                        $ui->Columns('<p><strong>Billing Address</strong><br><br> Santiago Martinez Alberú<br>Chicago 34 int. 10 Col. Nápoles<br>Ciudad de México, Distrito Federal, 03810<br>México<br>+525547317546 </p>',6,),
                        $ui->Columns('',3,)                  ])
                    .$ui->Row([
                        $ui->Columns("",2),
                        $ui->Columns("<div style='cursor: pointer;'><img src='img/0000-JALAPENO.jpg' height='150'  /></div>",1,0,0,0,'pl-0'),
                        $ui->Columns("<div class ='d-flex flex-column' style='margin-top: 10px;'>
                                                        <span class='text-uppercase'>JALAPEÑO</span>
                                                        <small>Lorem ipsum dolor sit amet</small>
                                           </div>",3),
                        $ui->Columns("<div class ='d-flex flex-row' style='margin-top: 10px;'>
                                                <span class='mr-5'>1</span>  
                                            </div>",1),
                        $ui->Columns("<div class ='d-flex flex-row' style='margin-top: 10px;'>
                                                <span>SMALL</span>
                                            </div>",2),
                        $ui->Columns("<div style='margin-top: 10px; display: inline-block;'> USD $154.00 </div>",2)
                    ],'border-top border-dark')
                    .$ui->Row([
                        $ui->Columns("",3,0,0,0,''),
                        $ui->Columns("<div class ='d-flex flex-column' style='margin-top: 10px;'>
                                                <span class='mr-5'>Subtotal</span>
                                                <span>Shipping total</span>
                                                <span>Duties and taxes</span>
                                                <span class='font-weight-bold mt-2'>Total</span>
                                            </div>",6),
                        $ui->Columns("<div style='margin-top: 10px;' class='d-flex flex-column'>
                                                <span class='mr-5'>USD $90</span>
                                                <span>USD $10</span>
                                                <span>(Included)</span>
                                                <span class='font-weight-bold mt-2'>USD $100</span>
                                            </div>",3)
                    ],'border-top border-dark'),12,0,0,0,'pt-6 pb-4 border-bottom border-dark'),
                "<button class='btn btn-dark btn-block' style='text-align: left;border-radius: 0'>
                ".$ui->Row([
                    $ui->Columns('',6),
                    $ui->Columns('PLACE ORDER',6,0,0,0,"")
                ])."
            </button>",

            ],''),
        ]),
        $fc->MenuPrivacyReturn(true,true)



    ],"style='background-color:#FFFFF;' ") //#AC9950
);

print_r($h);
