<?php

use Administracion\VistasHtml;

session_start();

include_once "View/Componentes/Administracion/VistasHtml.php";

$html=new VistasHtml();


$htmlPrincipal = "<!DOCTYPE html>
        <html lang='es'>";
print_r($htmlPrincipal);
$h = $html->Head(
    "Tiempos Shop",
    $html->Meta("utf-8","Tienda Online de Tiempos Shop","Egil Ordonez"),
    $html->LoadStyles(["global.css","View/css/bootstrap.css","https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"]),
    $html->LoadScripts(["View/js/bootstrap.js",  "js/axios.min.js", "js/vue.js", "js/global.js", "vendor/jquery/jquery.js","js/jquery.mlens-1.7.min.js"]),
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
require_once('menu.php');
?>

<img onclick="go('index.php')" alt="SP" id="logo" class="fixed-top" src="img/ts_iso_negro.png"
        style="width: 7%">
    <div  class="container-fluid"  id="app">
    <input type="hidden"  class="form-control" value="<?php  echo isset($_SESSION["idCliente"]) ? $_SESSION["idCliente"] : '' ?>" id="idCliente">
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
                        {{siglasMoneda}} {{producto.precio}}
                    </div>
                </div>
            </div>
        </div>

        
        <hr style="margin: 0;" /><br />
        <div class="row ">
            <div class="  col-md-7  " >

            </div>
            <div class="  col-md-5  " >
                SUBTOTAL: $ {{subtotal}}
            </div>
        </div>
            <button  class="btn btn-dark btn-block"
                style="text-align: left;border-radius: 0" @click="IrACheckOut()">
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
    <div style="bottom: 0;margin-bottom: 0.8rem; min-height: 150px;"
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
            monedas:[],
            idMoneda:0,
            siglasMoneda:"",
            subtotal:0
        },
        methods: {
            IrACheckOut()
            {
                location.href = "checkoutshop.php";
            },
            SumarProductos()
            {
                var subtotal = 0;
                this.enCarrito.forEach(element => {
                    subtotal +=  Number(element.cantidad) * Number(element.precio);
                });
                this.subtotal = subtotal;
            },
            async CargaInicial()
            {
                await axios.get(ServeApi + "api/cargainicial/")
                .then((resultado) => {
                    this.monedas = resultado.data;
                });
            },
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
                    this.$cantidadCarrito = this.enCarrito.length;
                    
                    this.SumarProductos();
                }
   
            });
               
           }
        },
        async mounted() {
            this.$cantidadCarrito = 0;
            this.idCliente = document.getElementById('idCliente').value;
            var respuestaMonedas = this.CargaInicial();
            await this.ObtenerCarrito();
            await respuestaMonedas;
            this.idMoneda = idMoneda;
            this.siglasMoneda = siglasMoneda;
        },
        

    });
</script>