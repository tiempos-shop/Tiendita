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

if(count($_POST)>0)
    $idiomaActual=$_POST["language"];
else
    $idiomaActual=$_SESSION["language"];

$tipoCambio=20;
$idioma=[ "ESPAÑOL"=>[ "MENU"=>[ "INICIO","ARCHIVO","MARCA","ENGLISH","CARRITO(*)"] ],"ENGLISH"=>[ "MENU"=>[ "HOME","ARCHIVE","IMPRINT","ESPAÑOL","CART(*)" ] ] ];

$price=0;
$tipoCambio=20;
$productInformation=$products=$db->getBy("Productos","Clave",$id)[0];
$_SESSION["CheckOut"]=[ $productInformation->Clave,1,"ONE SIZE"];



$productWord=explode(" ",$productInformation->Nombre);
$n=count($productWord);
$p=100/$n;

$nameTable="<table class='table table-borderless'><tr>";
foreach ($productWord as $word){
    $nameTable.="<td style='font-family: NHaasGroteskDSPro-65Md;width: $p%'>$word</td>";
}
$nameTable.="</tr></table>";

$inventario=$productInformation->Inventario;
if($idiomaActual=="ENGLISH"){
    $dollarPrice=$productInformation->Costo/$tipoCambio;
    $price=$ui->Moneda($dollarPrice,"USD $");
    $productWord=explode(" ",$productInformation->Descripcion);
    $descripcionLarga=$productInformation->LargeDescription;
    $tallas=$productInformation->SelectSize;
    $opcionesTallas="<a class='dropdown-item' href='#'>$tallas (Products in stock: $inventario)</a>";
    $botonTalla="SELECT SIZE";
}
else{
    $price=$ui->Moneda($productInformation->Costo,"MXN $");
    $productWord=explode(" ",$productInformation->Descripcion);
    $descripcionLarga=$productInformation->DescripcionLarga;
    $tallas=$productInformation->SeleccionarTalla;
    $opcionesTallas="<a class='dropdown-item' href='#'>$tallas (Productos en inventario: $inventario)</a>";
    $botonTalla="SELECCIONAR TALLA";
}
$n=count($productWord);
$p=100/$n;

$descriptionTable="<table class='table table-borderless'><tr>";
foreach ($productWord as $word){
    $descriptionTable.="<td style='width: $p%'>$word</td>";
}
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
$fc=new \Tiendita\FrontComponents();

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
        "<br/>",
        $ui->ContainerFluid([
            $ui->Row([
                $ui->Columns(
                    $collage
                    ,6,0,0,0,""),
                $ui->Columns(
                    $ui->ContainerFluid([
                            "<hr/>",
                            $ui->Row([
                                $ui->Columns("<p style='font-family: NHaasGroteskDSPro-65Md'>$productInformation->Name</p>",12),

                            ]),
                            $ui->Row([
                                $ui->Columns("<p>$productInformation->Descripcion</p>",12),

                            ]),
                            "<hr/>",
                            $ui->Row([
                                $ui->Columns($descripcionLarga,12,0,0,0,"small-font")

                            ]),
                            "<hr/><div style='height: 35vh'>",
                            "<label style='padding-left: 40px'>$price</label>",
                            "</div><hr style='margin: 0 0 0 0'/>",
                            '<div class="btn-group" style="width:100%">
                                <button type="button" class="btn btn-block dropdown-toggle" data-toggle="dropdown">
                                  '.$botonTalla.'
                                </button>
                                <div class="dropdown-menu align-content-center" role="menu" style="width:100%">
                                    '.$opcionesTallas.'
                                    
                                </div>
                              </div>',
                            '<hr style="margin: 0 0 0 0"/>',
                            $ui->FormButtom([
                                $ui->Input("CheckOut","",1,"F",false)
                            ],"cart.php",'<button type="submit" class="btn btn-dark btn-block" style="border-radius: 0">ADD TO CART</button>'),


                        ],"component").

                        $ui->ContainerFluid([
                                "<label><span>PRIVACY POLICY</span></label><label><span>SHIPPING RETURNS</span></label><label><button type='button' class='btn btn-link' style='text-decoration: none;color: black;padding: 0;border: none;font-weight: normal;font-size: 14.4px'  data-toggle='modal' data-target='#size'><span>SIZE GUIDE</span></button></label>"
                            ],"componentBase")
                    ,6,0,0,0,"left-top")
            ],"main")
        ]),
        '
        <div class="modal fade" id="size" tabindex="-1" role="dialog" aria-labelledby="sizeLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
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

function FormLink(array $content,string $url,string $button){
    $html= "
            <form method='post' action='$url'>";
    $html.=implode("",$content);
    $html.='
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-link" style="text-decoration: none;color:black;padding: 0px;border: none"><span type="submit">'.$button.'</span></button>
                    </div>
                </div>
            </form>';
    return $html;
}

function Cart($number,$label):string
{
    return str_replace("*",$number,$label);
}