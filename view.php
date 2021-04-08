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
$id=$_GET["id"];

$idiomaActual="";

$fc=new \Tiendita\FrontComponents();
$productInformation=$products=$db->getBy("Productos","Clave",$id)[0];
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
foreach ($images as $image){
    $collage.="<img class='img-fluid' src='$image'><br/>";
}

$modal="
<table class='table table-borderless' style=''>
    <thead>
        <tr>
            <td></td>
            <th><span>S</span></th>
            <th><span>M</span></th>
            <th><span>L</span></th>
            <th><span>XL</span></th>
        </tr>
    </thead>
    <tr>
        <td>HEIGHT</td>
        <td>26</td>
        <td>27</td>
        <td>29</td>
        <td>30</td>
    </tr>
    <tr>
        <td>SHOULDER</td>
        <td>22</td>
        <td>23</td>
        <td>25</td>
        <td>27</td>
    </tr>
    <tr>
        <td>BACK</td>
        <td>26</td>
        <td>28</td>
        <td>30</td>
        <td>32</td>
    </tr>
    <tr>
        <td>CHEST</td>
        <td>18</td>
        <td>20</td>
        <td>22</td>
        <td>24</td>
    </tr>
    <tr>
        <td>SLEEVE</td>
        <td>26</td>
        <td>28</td>
        <td>30</td>
        <td>32</td>
    </tr>
    <tr>
        <td>EUROPEAN SIZE</td>
        <td>46</td>
        <td>48</td>
        <td>50</td>
        <td>52</td>
    </tr>
</table>";

$db->close();
$htmlProducts="";
//$ui->Debug($productWord);


$h= $html->Html5(
    $html->Head(
        "Tiempos Shop",
        $html->Meta("utf-8","Tienda Online de Tiempos Shop","Egil Ordonez"),
        $html->LoadStyles(["View/css/bootstrap.css","https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"]),
        $html->LoadScripts(["js/popper.min.js","View/js/bootstrap.js"]),
        "
            <style>
            
                main,#component{
                    
                    padding-right: 0!important;
                    padding-left: 0!important;
                }
                td{
                    text-align: center;                
                }
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
                    overflow: no-display;
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
                    top: 5vh;
                    left: 50vw;
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
                hr{
                    margin-right: 0;
                    margin-left: 0;
                    margin-top:0!important; 
                     
                    opacity: 1;
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

        $fc->Menu($idioma,$idiomaActual,$numeroProductosCarrito,["'","","","","",""]),
        $fc->LogoNegro(),

        $ui->ContainerFluid([
            $ui->Row([
                $ui->Columns(
                    $collage
                    ,6,0,0,0,""),
                $ui->Columns(
                    $ui->ContainerFluid([
                            "<br/>",
                            $ui->Row([
                                $ui->Columns("<p style='font-family: NHaasGroteskDSPro-65Md'>$productWord</p>",12),

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


                        ],"component").
                        $fc->MenuPrivacyReturnView(true,true)
//                        "<div class='container-fluid' style='position: fixed;bottom: 0;font-size: 0.9em;'>".
//                            "<label><span>PRIVACY POLICY</span></label><label><span>SHIPPING RETURNS</span></label><label><button type='button' class='btn btn-link' style='text-decoration: none;color: black;padding: 0;border: none;font-weight: normal;font-size: 14.4px'  data-toggle='modal' data-target='#size'><span>SIZE GUIDE</span></button></label>".
//                        "</div>"
                    ,6,0,0,0,"left-top")
            ],"main")
        ]),
        '
        <div class="modal" id="size" tabindex="-1" role="dialog" aria-labelledby="sizeLabel" aria-hidden="true" style="background-color: transparent;">
          <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 0;border: 0 solid transparent;top:30vh;background-color: white">
              <div class="modal-header">
                <h5 class="modal-title" id="sizeLabel"><span>CM</span><div class="space"></div><span>IN</span></h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                  X
                </button>
              </div>
              <div class="modal-body">
                '.$modal.'
              </div>
              
            </div>
          </div>
        </div>
        '


    ],"style='background-color:#FFFFF;' ") //#AC9950
);

print_r($h);

