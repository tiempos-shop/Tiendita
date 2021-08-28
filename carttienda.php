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
    '<style>
                
    .left-top{
        position: fixed;
        left: 50vw;
    }
    .space{
        position: relative;
        display:inline-block; 
        width:30px; 
    }
    
    #app{
        margin-top: calc(2vh + 37.55px);
        padding: 0 0 0 0;
    }
    
</style>',
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

<img onclick="go('index.php')" alt="SP" id="logo" class="fixed-top" src="img/ts_iso_negro.png"
        style="width: 7%">
    <div  class="container-fluid"  id="app">
        <div class="row " v-for="(producto, index) in enCarrito" :key="index">
            <div class="  col-md-2  " >

            </div>
            <div class="  col-md-4  " >
                <div style="cursor: pointer;" onclick="view('T0001_02')"><img :src="producto.ruta" height="172">
                    <div
                        style="height: 100%;margin-left: 15px;display: inline-block;vertical-align: top;margin-top: 16px;">
                        {{producto.color}}</div>
                </div>
            </div>
            <div class="  col-md-1  " >
                <div class="d-flex" style="margin-top: 16px;">
                    <form method="post" action="" name="T0001_02"><button type="submit"
                            style="border:0 solid transparent;background-color:transparent;display: inline-block">X</button>
                    </form><input onchange="edit(this,'T0001_02');" type="text" maxlength="1" v-model="producto.cantidad"
                        style="width: 25px;padding-left: 5px;">
                </div>
            </div>
            <div class="  col-md-1  " >
                <div style="margin-top: 16px;">{{producto.valor}}</div>
            </div>
            <div class="  col-md-1  " >

            </div>
            <div class="  col-md-3  " >
                <div style="margin-top: 16px; display: inline-block;">
                    <div class="  col-md-1  " >
                        USD {{producto.precio}}
                    </div>
                </div>
            </div>
        </div>

        
        <hr style="margin: 0;" /><br />
        <div class="row ">
            <div class="  col-md-7  " >

            </div>
            <div class="  col-md-5  " >
                SUBTOTAL: $ 65.00
            </div>
        </div><button onclick="go('checkout.php')" class="btn btn-dark btn-block"
            style="text-align: left;border-radius: 0">
            <div class="row ">
                <div class="  col-md-7  " >

                </div>
                <div class="  col-md-5  " >
                    CHECKOUT
                </div>
            </div>
        </button>
        <div class="row ">
            <div class="  col-md-7  " >

            </div>
            <div class="  col-md-5  " >
                <p class="small">SHIPPING & TAXES CALCULATED AT CHECKOUT</p>
            </div>
        </div>
    </div>
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1em">

        </div>
    </div>
    <div style="position: absolute;bottom: 0;margin-bottom: 0.8rem; min-height: 150px;"
        class="col-md-8 col-sm-12 text-right pr-4 pl-4 d-flex align-items-end"><span class="small mr-4 col-md-6"
            onclick="go('privacy.php')"> PRIVACY POLICY</span><span onclick="go('shipping.php')"
            class="small ml-4 col-md-5">SHIPPING & RETURNS</span></div>

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
            enCarrito:[],
            idCliente:0,
        },
        methods: {
            
            ValidarSiExisteEnCarrito()
            {
                this.status.agregadoAlCarrito = false;

                var productoEncontrado = this.enCarrito.find( (p) => { return p.idProducto == this.producto.idProducto});

                if (productoEncontrado)
                {
                    if (!this.producto.manejaraTallas)
                    {
                        this.status.agregadoAlCarrito = true;
                    }
                    else{
                        var tallaEncontrada = this.variantes.find((v)=> { 
                            return v.idProductoVarianteDetalle == this.producto.idProductoVarianteDetalle});
                        if (tallaEncontrada)
                        {
                            this.status.agregadoAlCarrito = true;
                        }
                    }
                    
                }
                else
                {
                    console.log("no encontrado");
                }
            },

           async ObtenerCarrito()
           {
    
            await axios.get(ServeApi + "api/encarrito/" + this.idCliente)
            .then((resultado) =>{
                if (resultado.data != null)
                {
                    this.enCarrito = resultado.data;
                    
                }
   
            });
               
           }
        },
        mounted() {
            this.idCliente = 1;
            this.ObtenerCarrito();
            
        },
        

    })
</script>