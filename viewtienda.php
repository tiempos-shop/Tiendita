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
    $html->LoadScripts(["View/js/bootstrap.js", "js/global.js", "js/axios.min.js", "js/vue.js", "vendor/jquery/jquery.js","js/jquery.mlens-1.7.min.js"]),
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

<style>
    main,
    #component {

        padding-right: 0 !important;
        padding-left: 0 !important;
    }

    td {
        text-align: center;
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

    body,
    button {
        font-family: NHaasGroteskDSPro-55Rg;

        overflow: no-display;
        font-size: .9em !important;
    }

    button {
        letter-spacing: 0.081rem !important;
    }

    .btn:focus {
        outline: none;
        box-shadow: none;
    }

    [type='submit'] {
        -webkit-appearance: none !important;
    }

    .left-top {
        position: fixed;
        right: 0;
        top: 5vh;
        margin-top: 50px;
        left: 50vw;
    }

    .space {
        position: relative;
        display: inline-block;
        width: 30px;
    }

    #logo {
        display: inline-block;
        top: 50vh;
        left: 90vw;
        width: 7%
    }

    div {
        padding-right: 0;
        padding-left: 0;
    }

    p {
        text-align: justify;
        text-align-last: justify;
        padding-left: 40px;
        padding-right: 40px;
        margin: 0 0 0 0;
        font-size: inherit;
    }

    #componentBase {
        position: fixed;
        bottom: 0;
        font-size: 0.9em;
    }

    .small-font {
        font-size: 0.9em;
    }

    .prodSize {
        text-align: center;
        color: white;
    }

    .prodSize>tbody>tr>td:first-child {
        text-align: left;

    }

    .prodSize>tbody>tr {
        border-bottom: 1px solid black;
    }

    .prodSize>tbody>tr:last-child {
        border: none;
    }

    .paddingNone {
        padding: 0;
    }

    .modal-backdrop {
        background-color: transparent;
    }
</style>

<script>
    function go(url) {
        window.location.href = url;
    }
    function changeImage(imageElement, image) {
        imageElement.src = image;
        imageElement.style.cursor = "pointer";
    }
    function view(str) {
        let id = str.replace("_", "'");
        go("view.php?id=" + id);
    }

    $(document).ready(function () {

        $("#id1").mlens(
            {
                imgSrc: $("#id1").attr("data-big"),
                lensShape: "circle",
                lensSize: 180,
                borderSize: 4,
                borderColor: "#fff",
                borderRadius: 0,
                imgOverlay: $("#id1").attr("data-overlay"),
                overlayAdapt: true
            });

        $("#id2").mlens(
            {
                imgSrc: $("#id2").attr("data-big"),
                lensShape: "circle",
                lensSize: 180,
                borderSize: 4,
                borderColor: "#fff",
                borderRadius: 0,
                imgOverlay: $("#id2").attr("data-overlay"),
                overlayAdapt: true
            });

        $("#id3").mlens(
            {
                imgSrc: $("#id3").attr("data-big"),
                lensShape: "circle",
                lensSize: 180,
                borderSize: 4,
                borderColor: "#fff",
                borderRadius: 0,
                imgOverlay: $("#id3").attr("data-overlay"),
                overlayAdapt: true
            });

    });


    const dataSize = [
        ["HEIGHT", 26, 27, 29, 30],
        ["SHOULDER", 22, 23, 25, 27],
        ["BACK", 26, 28, 30, 32],
        ["CHEST", 18, 20, 22, 24],
        ["SLEEVE", 26, 28, 30, 32],
        ["EUROPEAN SIZE", 46, 48, 50, 52]
    ];

    $(document).ready(function (e) {
        for (let i = 0; i < dataSize.length; i++) {
            $("#tableDetalle").append(`<tr>
                        <td>${dataSize[i][0]}</td>
                        <td>${dataSize[i][1]}</td>
                        <td>${dataSize[i][2]}</td>
                        <td>${dataSize[i][3]}</td>
                        <td>${dataSize[i][4]}</td>
                        </tr>`);
        }
    });

    function ChangeSize(conversion, e) {
        $("span").removeClass("activerow");
        $(e).addClass("activerow");
        $("#tableDetalle").html("");
        for (let i = 0; i < dataSize.length; i++) {
            $("#tableDetalle").append(`<tr>
                            <td>${dataSize[i][0]}</td>
                            <td>${Math.round(dataSize[i][1] / conversion)}</td>
                            <td>${Math.round(dataSize[i][2] / conversion)}</td>
                            <td>${Math.round(dataSize[i][3] / conversion)}</td>
                            <td>${Math.round(dataSize[i][4] / conversion)}</td>
                            </tr>`);
        }
    }
    </script>

<div id="app">
    <img onclick='go("index.php")' alt='SP' id='logo' class='fixed-top' src='img/ts_iso_negro.png'
        style='width: 7%'>
    <div class="container-fluid">
        <div class="row main">
            <div class='  col-md-6  paddingNone' style=''>
                <img id='id1' class='img-fluid' src='img/0001-OBSIDIANA.jpg' data-big='img/0001-OBSIDIANA.jpg'
                    data-overlay=''><br /><img id='id2' class='img-fluid' src='img/0001-OBSIDIANA-back.jpg'
                    data-big='img/0001-OBSIDIANA-back.jpg' data-overlay=''><br /><img id='id3' class='img-fluid'
                    src='img/0001-OBSIDIANA-unfold.jpg' data-big='img/0001-OBSIDIANA-unfold.jpg' data-overlay=''><br />
            </div>
            <div class='  col-md-6  left-top paddingNone' style=''>
                <div id='component' class="container-fluid" ><br />

                    <input type="hidden" value="<?php echo $_GET["id"] ?>" id="idproducto">
                    
                    <div class="row ">
                        <div class='  col-md-12  ' style=''>
                            <p style='font-family: NHaasGroteskDSPro-65Md;'>THE WALLET PROJECT</p>
                        </div>
                    </div>
                    <div class="row ">
                        <div class='  col-md-12  ' style=''>
                            <p>{{producto.nombre}}</p>
                        </div>
                    </div>
                    <hr style='margin-top: 1em!important;' />
                    <div class="row ">
                        <div class='  col-md-12  small-font' id="descripcion">
                            <div v-html="producto.descripcion"></div>
                        </div>
                    </div>
                    <hr style='margin-top: 1em!important;' />
                    <div style='height: 25vh'><label style='padding-left: 40px'>USD {{Number(producto.precio) | moneda}}</label></div>
                    <hr style='margin: 0 0 0 0' />
                    <div class="btn-group" style="width:100%">
                        <button type="button" class="btn btn-block dropdown-toggle "
                            @click="status.verVariantes = !status.verVariantes">
                            SELECT SIZE
                        </button>
                        <div class="dropdown-menu align-content-center ":class="status.verVariantes ? 'show' : ''"  style="width: 100%; position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(0px, -35px);">
                            <a class='dropdown-item pl-4' href='#' v-for="(talla, index) in variantes" :key="index"
                                @click="status.verVariantes = false;">
                                {{talla.valor}}
                            </a>
                        
                        </div>
                    </div>
                 

                    <hr style="margin: 0 0 0 0" />
                    
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button id="cart" type="submit" class="btn btn-dark btn-block"
                                style="border-radius: 0" @click="AgregarAlCarrito()">ADD TO CART</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="size" tabindex="-1" role="dialog" aria-labelledby="sizeLabel" aria-hidden="true"
        style="background-color: #ffffff8C;">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 700px;" role="document">
            <div class="modal-content" style="border-radius: 0;border: 0 solid transparent; background-color:white;">
                <div class="modal-header"
                    style="border-color: black; padding: 0px; padding-left: 20px; margin-bottom: 10px;">
                    <h6 style="color:black;" class="modal-title" id="sizeLabel"><span onclick="ChangeSize(1, this);"
                            class="activerow">CM</span>
                        <div class="space"></div><span onclick="ChangeSize(2.54, this)">IN</span>
                    </h6>
                    <button style="Color:black; " type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                        X
                    </button>
                </div>
                <div class="modal-body" style="padding: 0;">
                    <table class='table table-borderless prodSize' style='color: black;'>
                        <thead>
                            <tr style='color: black; opacity: 1;'>
                                <td></td>
                                <th>S</th>
                                <th>M</th>
                                <th>L</th>
                                <th>XL</th>
                            </tr>
                        </thead>
                        <tbody id='tableDetalle' style='color: black;'>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    
    Vue.filter('moneda', function (value) {
        if (typeof value !== "number") {
            return value;
        }
        var formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 2
        });
        return formatter.format(value);
    });

      var app = new Vue({
        el:'#app',
        data:{
            producto:{},

            variantes:[],
            status:{
                verVariantes:false,
            }
        },
        methods: {
            async AgregarAlCarrito()
            {
                await axios.post(ServeApi + "api/encarrito/", { "producto" : this.producto, "movimiento":"A"})
                .then((resultado) =>{
                    console.log(resultado.data);
                })

                return;
                await axios.post("enCarrito.php", { "producto" : this.producto, "movimiento":"A"})
                .then(resultado => {
                    console.log(resultado.data);
                })
            },
           async ObtenerProducto()
           {
               var idProducto = document.getElementById('idproducto');
               if (idProducto != null)
               {
                   idProducto = idProducto.value;

                   if (!isNaN(idProducto))
                   {
                        await axios.get(ServeApi + "api/productos/" + idProducto)
                        .then((resultado) => {
                            console.log(resultado.data);
                            if (resultado.data != null)
                            {
                                this.producto = resultado.data.producto;

                                if (resultado.data.variantes.length > 0)
                                {
                                    this.variantes = resultado.data.variantes;
                                }
                            }
                        });
                   }
                    
               }
               else
               {
                   console.log("no se encontro id");
               }
               
           }
        },
        mounted() {
            this.ObtenerProducto();
        },
        

    })
</script>