<?php


use Administracion\VistasHtml;
use Tiendita\EntidadBase;

include_once "View/Componentes/Administracion/VistasHtml.php";

include_once "Data/Connection/EntidadBase.php";


$html=new VistasHtml();
$db=new EntidadBase();

session_start();


$h= $html->Html5Shop(
    $html->Head(
        "Tiempos Shop",
        $html->Meta("utf-8","Tienda Online de Tiempos Shop","Egil Ordonez"),
        $html->LoadStyles(["global.css","View/css/bootstrap.css","https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css", "css/menumovil.css"]),
        $html->LoadScripts(["View/js/bootstrap.js","js/axios.min.js", "js/vue.js", "js/global.js"]),
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

    ),"style='background-color:#FFFFF;' "); //#AC9950

print_r($h);
require_once('menu.php');
?>

<div style='width:100%;height: 93%;border-bottom: 1px solid black' id="contenedorIndex">
    <div id="privacity-text">
        <br /><br /><br />
        <p style='text-align: center'>EJEMPLO DE TEXTO PRIVACY POLICY</p>
        <p style='text-align: center'>POLYCY</p>
        <p>PRIVACY</p>
        <p style='text-align: justify'>
            Depending on the shipping service selected, orders placed on TIEMPOS.SHOP are delivered to the
            courier service 2 days after the payment reception. Shipping costs will vary depending on the service
            selected, as well as the origin and destination of your chosen pieces. All relevant delivery options
            available
            for your order and to your destination will be displayed at checkout.
        </p>
        <p>Shipping Times:</p>
        <p style='text-align: justify'>
            Express Shipping for most of Europe and the USA: delivery within 2-4 days. Rest of the world: delivery
            within 3-7 days.
        <p>
        <p style='text-align: justify'>
            Please keep in mind that our shipping times should be used as a guide only and are based on time from
            dispatch. TIEMPOS.SHOP cannot take responsibility for customs clearance delays or failed payment
            approval, though we will try to minimise any potential delays.
            Our orders can be delivered by DHL, UPS, or FedEx.
        </p>
        <p style='text-align: justify'>
            All shipments are accompanied with an ocial invoice with the exact declared value of each item in
            dollars. Sale and discounted items reflect discounted prices. Worth of goods will be publicly available
            on
            the package’s insert for tax reasons on all orders. Once orders are sent they can no longer be cancelled
            and change of delivery address is no longer possible, please make sure to fill out a correct address
            when
            checking out. Once you receive your parcel, you can ask for the return or exchange within 14 days you
            (or someone you nominate, other than a carrier) received the goods.
        </p>
        <p style='text-align: center'>ORDERS</p>
        <p style='text-align: justify'>
            About Brands S.A. de C.V. has created and published the website TIEMPOS.SHOP with the mission to
            oer a service exclusively for its own Clients. The products on sale on the website TIEMPOS.SHOP are
            destined to the Final Customer. By “Final Customer” TIEMPOS.SHOP intends person or persons who do
            not operate their own entrepreneurial nor professional activities that may include but not limited to
            the
            re-sale of merchandise purchased at TIEMPOS.SHOP. Therefore, TIEMPOS.SHOP requests Users who
            are not considered a “Final Customer” to refrain from attempting to establish business relations with
            TIEMPOS.SHOP nor use accounts of third parties to forward purchase orders relative to the merchandise
            on sale. In regard to the commercial policy described above, TIEMPOS.SHOP reserves the right to
            not process orders from persons that are not the Final Customer and any other orders that are not in</p>
    </div>
</div>
<img onclick='go("index.php")' alt='SP' id='logo' class='fixed-top' src='img/ts_iso_negro.png'>

<!--div class='container-fluid mb-2 privacity-pie'
     style='bottom: 1vh;font-size: 0.7rem;padding-left: 50%; padding-bottom: 1.5rem;' id="politicadesktop">
        <label style='width: 14vw;display: inline-block;position: absolute;left: 50vw;font-size: 0.7rem;' onclick='go("privacy.php")'>PRIVACY POLICY'</label>
        <label style='width: 15vw;display: inline-block;position: absolute;left: 62vw;font-size: 0.7rem;'><span onclick='go("shipping.php")'>SHIPPING RETURNS</span></label>
</div-->
<div class='container-fluid mb-2 privacity-pie'
     style='bottom: 1vh;font-size: 0.7rem;' id="politicadesktop">
    <?php
    require_once('privacyShiping.php');
    ?>
</div>


</body>
</html>