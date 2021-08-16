<?php
date_default_timezone_set('America/Monterrey');
use Administracion\VistasHtml;
use Tiendita\Utilidades;

include_once "View/Componentes/Administracion/VistasHtml.php";
include_once "Business/Utilidades.php";
include_once "Data/Connection/EntidadBase.php";
include_once "Business/FrontComponents.php";
include_once "Data/Models/Producto.php";

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
$entity=new \Tiendita\EntidadBase();
try {
    $products = $entity->getAll("Productos");
} catch (Exception $e) {

}
$entity->close();
$item=new \Tiendita\Producto(0,1);
global $idioma;
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

$htmlIds="";


// Obtener de base de datos de productos
$htmlIds="";


foreach ($products as $product){

    $item->Clave=$product->Clave;
    $item->Costo=$product->Costo;

    $ide=str_replace("_","'",$item->Clave);
    $js="view('$product->Clave')";
    $htmlIds.="<hr style='padding: 0px;border: none;margin: 0px'/><span onclick=\"$js\">$ide</span><br/>";
}


$fc=new \Tiendita\FrontComponents();

$h= $html->Html5(
    $html->Head(
        "Tiempos Shop",
        $html->Meta("utf-8","Tienda Online de Tiempos Shop","Egil Ordonez"),
        $html->LoadStyles(["global.css","View/css/bootstrap.css","https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"]),
        $html->LoadScripts(["View/js/bootstrap.js"]),
        "
            <style>
                body{
                    color:black;
                }
                td{
                    padding: 0!important;
                }
                #t{
                    left: 0px; 
                    text-align: center;
                    width: 9%;
                }
                #t > span{
                    padding: 8px 10px; 
                    display: block; 
                    user-select: none; 
                    -moz-user-select: none; 
                    -webkit-user-select: none;
                }
                #t > span.hidden{
                    opacity: 0;
                }
                #t:hover > span{
                    border-top: 1px solid #000;
                    opacity: 100;
                }
                #t:hover > span:last-child{
                    border-bottom: 1px solid #000;
                }
            </style>
        ",
        "<script>
                      function go(url){
                          window.location.href=url;
                      }
                      
                      function tOverMenu(){
                          var t=document.getElementById(\"t\");
                          var tover=document.getElementById(\"t-over\");
                          t.style.visibility=\"hidden\";
                          tover.style.visibility=\"visible\";
                      }
                      
                      function tOffMenu(){
                          const t=document.getElementById(\"t\");
                          const tover=document.getElementById(\"t-over\");
                          t.style.visibility=\"visible\";
                          tover.style.visibility=\"hidden\";
                      }
                      
                      function view(str){
                          var id=str; //.replace(\"_\", \"\'\");
                          go(\"view.php?id=\"+id);
                      } 
                      
                      var catalogos = [];
                      var catalogoslabel = [];
                      window.addEventListener(\"scroll\", reordenarcatalogo);
                      window.addEventListener(\"load\", function () {
                        catalogos = document.querySelectorAll(\"hr.catalogo\");
                        catalogoslabel = document.querySelectorAll(\"span.catalogolabel\");
                        reordenarcatalogo();
                      });
                      
                      function reordenarcatalogo(){
                          let scrollwindows = document.documentElement.scrollTop;
                          let scrolltop = document.getElementById(\"t\").offsetTop;
                          let variable = 0;
                          scrolltop += scrollwindows;
                          
                          for(let i = 0; i < catalogos.length ; i++) {
                                let animationAlto = catalogos[i].offsetTop;
                                if( animationAlto < scrolltop ){
                                    variable = i;   
                                }
                                catalogoslabel[i].classList.add(\"hidden\");
                          }
                          catalogoslabel[variable].classList.remove(\"hidden\");
                      }
                      
                      function  ircatalogo(e){
                          let altocatalogo = catalogos[e].offsetTop;
                          window.scroll({ top: altocatalogo, behavior: 'smooth' });
                      }
                    </script>"

    ),
    $html->Body([
        $fc->MenuArchive($idioma,$idiomaActual,$numeroProductosCarrito,["","'","","","",""],true,true),
        $fc->LogoNegro(),
        $fc->TMenu(2),
        "<div class='fixed-top' style='z-index:100;display:block;width:96.1vw;height:95.7vh;background-color: transparent;border: 1px solid black;top:1vh;left: 2.1vw'></div>",
        $ui->ContainerFluid([
            $ui->Row([$ui->Columns("<br/><br/>",12)]),
            $ui->Row([
                $ui->Columns("<hr class='catalogo d-none' />",1),
                $ui->Columns(
                    '
                        <script>
                            function play(){
                                var d=document.getElementById("d");
                                if (d.paused){
                                    d.play(); 
                                    alert("play");
                                } 
                                    
                                else {
                                    d.pause();
                                    alert("play");
                                }
                                    
                            }                       
                        </script>
                        
                        <video id="d" style="width: 100%;height: auto;" autoplay muted>
                            <source src="video/video.mp4" type="video/mp4" >
                            
                            Your browser does not support the video tag.
                        </video>
                            
                        
        ',11,0,0,0,"",""),
            ],""),
            $ui->Row(
                [
                    $ui->Columns("",1),
                    $ui->Columns("<br/><label style='padding-right: 10%' >VIDEO</label><br/><br/>",11)
                ]),
            $ui->Row(
                [
                    $ui->Columns("<hr class='catalogo' />",12),
                ]),
            $ui->Row([
                $ui->Columns("",1),
                $ui->Columns(
                    "
                        <table class='table table-borderless' style='width: 100%;padding-right: 5%' >
                            <tr>
                                <td><img src='img/0000-JALAPENO.jpg' style='width: 100%'></td>
                                <td><img src='img/0001-OBSIDIANA.jpg' style='width: 100%'></td>
                                <td><img src='img/0002-TACUBAYA.jpg' style='width: 100%'></td>
                                <td><img src='img/0003-ANIL.jpg' style='width: 100%'></td>
                            </tr>
                            <tr>
                                <td><img src='img/0000-JALAPENO.jpg' style='width: 100%'></td>
                                <td><img src='img/0001-OBSIDIANA.jpg' style='width: 100%'></td>
                                <td><img src='img/0002-TACUBAYA.jpg' style='width: 100%'></td>
                                <td><img src='img/0003-ANIL.jpg' style='width: 100%'></td>
                            </tr>
                        </table>
                        ",11)
            ]),
            $ui->Row(
                [
                    $ui->Columns("",1),
                    $ui->Columns("<br/><label style='padding-right: 10%' >COLLECTION</label><br/><br/>",11)
                ]),
            "<br/><br/>"
//            $fc->Aviso()

        ]),


    ],"style='background-color:transparent;z-index:100;overflow-x:hidden'") //#AC9950
);

print_r($h);