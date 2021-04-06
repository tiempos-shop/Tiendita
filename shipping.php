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
    $idiomaActual=$_POST["language"];
    $_SESSION["language"]=$idiomaActual;
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
                    width: 7%
                }
                #t{
                    position:fixed;
                    display:inline-block;
                    top:50vh;
                    left: 2vw;
                    
                }
                label{
                    padding-right: 50px;
                    padding-bottom: 2vh;
                }
                .small-font{
                    font-size: 0.9em;
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

        $fc->Menu($idioma,$idiomaActual,$numeroProductosCarrito,["","","","","",""]),
        "<div style='position: absolute;width:100%;height: 93%;border-bottom: 1px solid black'>",
        "<div style='overflow-y:hidden;padding-left:3%;padding-right:3%;position: absolute;width:56%;height: 100%;border-left: 1px solid black;border-right: 1px solid black;margin-left: 21vw'>",
        "<br/><br/><br/>",
        "<p style='text-align: center'>SHIPPING & RETURNS</p>",
        "<p style='text-align: center'>SHIPPING</p>",
        "<p>Shipping Information</p>",
        "<p style='text-align: justify'>
            Depending on the shipping service selected, orders placed on TIEMPOS.SHOP are delivered to the
            courier service 2 days after the payment reception. Shipping costs will vary depending on the service
            selected, as well as the origin and destination of your chosen pieces. All relevant delivery options available
            for your order and to your destination will be displayed at checkout.
        </p>",
        "<p>Shipping Times:</p>",
        "<p style='text-align: justify'>
Express Shipping for most of Europe and the USA: delivery within 2-4 days. Rest of the world: delivery
within 3-7 days.
        <p>",
        "<p style='text-align: justify'>
Please keep in mind that our shipping times should be used as a guide only and are based on time from
dispatch. TIEMPOS.SHOP cannot take responsibility for customs clearance delays or failed payment
approval, though we will try to minimise any potential delays.
Our orders can be delivered by DHL, UPS, or FedEx.
        </p>",
        "<p style='text-align: justify'>
All shipments are accompanied with an ocial invoice with the exact declared value of each item in
dollars. Sale and discounted items reflect discounted prices. Worth of goods will be publicly available on
the package’s insert for tax reasons on all orders. Once orders are sent they can no longer be cancelled
and change of delivery address is no longer possible, please make sure to fill out a correct address when
checking out. Once you receive your parcel, you can ask for the return or exchange within 14 days you
(or someone you nominate, other than a carrier) received the goods.
        </p>",
        "<p style='text-align: center'>ORDERS</p>",
        "<p style='text-align: justify'>
About Brands S.A. de C.V. has created and published the website TIEMPOS.SHOP with the mission to
oer a service exclusively for its own Clients. The products on sale on the website TIEMPOS.SHOP are
destined to the Final Customer. By “Final Customer” TIEMPOS.SHOP intends person or persons who do
not operate their own entrepreneurial nor professional activities that may include but not limited to the
re-sale of merchandise purchased at TIEMPOS.SHOP. Therefore, TIEMPOS.SHOP requests Users who
are not considered a “Final Customer” to refrain from attempting to establish business relations with
TIEMPOS.SHOP nor use accounts of third parties to forward purchase orders relative to the merchandise
on sale. In regard to the commercial policy described above, TIEMPOS.SHOP reserves the right to
not process orders from persons that are not the Final Customer and any other orders that are not in</p>",
        "</div>",
        "</div>",
        $fc->LogoNegro(),
        $fc->TMenu(""),
        $fc->Aviso(),
        $fc->MenuPrivacyReturn(true,true)
//        "<div class='container-fluid' style='position: fixed;bottom: 0;font-size: 0.9em;padding-left: 55%'>".
//        "<label><span onclick='go(\"privacy.php\")'>PRIVACY POLICY</span></label><label><span>SHIPPING RETURNS</span></label>".
//        "</div>"


    ],"style='background-color:#FFFFF;' ") //#AC9950
);

print_r($h);

