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
    $html->LoadScripts(["View/js/bootstrap.js", "js/global.js", "js/axios.min.js", "js/vue.js"]),
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

<div id="app">

    <img onclick='go("index.php")' alt='SP' id='logo' class='fixed-top' src='img/ts_iso_negro.png'
         style='width: 7%'>
    <div style='margin-left: 15%;margin-right: 15%'>
        <div class="row ">
            <div v-for="(producto, index) in listaProductos" :key="index" class="col-md-4">
            
                <div class='text-center' style=''>
                   
                    <br /><br /><img   :src="producto.imagenPrincipal"
                                    @click="VerProducto(producto.idproducto)"
                                    @mouseover="producto.dentro = true; CambiarImagen(producto,false)"
                                    @mouseleave="producto.dentro = false; CambiarImagen(producto,true)" style="width: 100%"><br /><br />
                    <p style="font-family: NHaasGroteskDSPro-65Md;line-height: 1">{{producto.color}}</p>
                    <p><s style="font-size: 0.7rem;">USD {{producto.precioComparativo}}</s> USD {{producto.precio}}</p>
                </div>
                
            </div>
        </div>

      
        <div style='position: fixed;top:8.5vh;margin-left: -12vw'><a href='shop.php?submenu=0'
                                                                     class='d-block text-dark p-1'>SHOP ALL'</a>
            <div class='p-2'><a href='#' class='d-block text-dark' data-menu='0' onclick='openSubmenu(this);'>MENS</a>
                <div class='submenu d-none'><a href='#' class='d-block text-dark pl-2'>TOPS</a><a href='#'
                                                                                                  class='d-block text-dark pl-2'>PANTS</a><a href='#' class='d-block text-dark pl-2'>SHOES</a>
                </div>
            </div>
            <div class='p-2'><a href='#' class='d-block text-dark' data-menu='1' onclick='openSubmenu(this);'>WOMENS</a>
                <div class='submenu d-none'><a href='#' class='d-block text-dark pl-2'>TOPS</a><a href='#'
                                                                                                  class='d-block text-dark pl-2'>PANTS</a><a href='#' class='d-block text-dark pl-2'>SHOES</a>
                </div>
            </div><a href='shop.php?submenu=3' class='d-block text-dark p-1'><span>ACCESSORIES</span></a><a
                    href='shop.php?submenu=4' class='d-block text-dark p-1'><span><b>SALE</b></span></a>
        </div>
        <div class='small' style='position: fixed;display: inline-block;top: 8.5vh;right: 1.6vw;width:11vw'>
            <label onclick='filter()' id='s' style='font-size: 0.9rem;'>SORT +</label>
            <div id='sMenu' style='color:white;background-color: gray;border-radius: 5px;display: none'>
                <div class='container-fluid'
                     style='padding-left: 0;padding-right: 0;padding-top: 0.5vh;padding-bottom: 0.5vh;'>
                    <div class='row item' style='margin-left: 0'>
                        <div class='col-md-1 align-self-center' style='padding-right: 0'>
                            <label style='width: 100%;text-align: right;'></label>
                        </div>
                        <div class='col-md-10'>
                            <a href='shop.php?submenu=1&order=1' style='display: block'>FEATURED</a>


                        </div>
                        <div class='col-md-1'>

                        </div>
                    </div>
                    <div class='row item' style='margin-left: 0'>
                        <div class='col-md-1 align-self-center' style='padding-right: 0'>
                            <label style='width: 100%;text-align: right'></label>
                        </div>
                        <div class='col-md-10'>
                            <a href='shop.php?submenu=1&order=2' style='display: block'>A TO Z</a>

                        </div>
                        <div class='col-md-1'>

                        </div>
                    </div>
                    <div class='row item' style='margin-left: 0'>
                        <div class='col-md-1 align-self-center' style='padding-right: 0'>
                            <label style='width: 100%;text-align: right'></label>
                        </div>
                        <div class='col-md-10'>
                            <a href='shop.php?submenu=1&order=3' style='display: block'>PRICE LOW TO HIGH</a>

                        </div>
                        <div class='col-md-1'>

                        </div>

                    </div>
                    <div class='row item' style='margin-left: 0'>
                        <div class='col-md-1 align-self-center' style='padding-right: 0'>
                            <label style='width: 100%;text-align: right'></label>
                        </div>
                        <div class='col-md-10'>
                            <a href='shop.php?submenu=1&order=4' style='display: block'>PRICE HIGH TO LOW</a>

                        </div>
                        <div class='col-md-1'>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row ">
            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:1em'>

            </div>
        </div>
        <div style='position: inherit;bottom: 0;margin-bottom: 0.8rem; min-height: 150px;'
             class='col-md-8 col-sm-12 text-right pr-4 pl-4 d-flex align-items-end'>
        <span class='small mr-4 col-md-6'
              onclick='go("privacy.php")'> PRIVACY POLICY</span><span onclick='go("shipping.php")'
                                                                      class='small ml-4 col-md-5'>SHIPPING & RETURNS</span></div>
    </div>

    
</div>



<script>

    var app = new Vue({
        el:'#app',
        data:{
            mensaje:'hola',
            listaProductos:[]
        },
        methods: {
            VerProducto(idproducto)
            {
                window.location.href="viewtienda.php?id=" + idproducto;
            },
            async ObtenerProductos()
            {
                
                var result = await axios.get(ServeApi + "api/productostienda")
                .then((resultado) =>{
                    console.log("resultado", resultado.data);
                    var productos = null;

                    productos = resultado.data;
                    
                    return productos;
                });

                result.forEach(element => {
                        if (element.imagen.length>0)
                        {
                            element.imagenPrincipal = element.imagen[0].ruta;
                            
                        }
                        else
                        {
                            element.imagenPrincipal = '';
                        }
                        element.cargandoImagen = false;
                        element.dentro = false;
                        
                    });

                this.listaProductos = result;
            },
            CambiarImagen(producto, regresar)
            {
                var app = this;

                console.log(producto.idproducto);
                if (producto.imagen.length>1)
                {
                    if (!producto.cargandoImagen)
                    {
                        if (regresar)
                        {
                            producto.imagenPrincipal = producto.imagen[0].ruta;
                            console.log("regresar");
                        }
                        else
                        {
                            producto.imagenPrincipal = producto.imagen[1].ruta;
                            console.log("otro");
                        }

                        producto.cargandoImagen = true;
                    }
                    else
                    {
                        console.log("reg", regresar);
                        if (regresar & producto.dentro)
                        {
                            setTimeout(() => {
                                producto.cargandoImagen = false;
                                producto.imagenPrincipal = producto.imagen[0].ruta;
                                console.log("regresando original");
                            }, 40);
                        }
                    }
                   
                    

                    setTimeout(() => {
                        producto.cargandoImagen = false;
                    }, 50);
                    
                }
            }
        },
        mounted() {
            this.ObtenerProductos();
        },
        

    })
</script>
