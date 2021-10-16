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
    $html->LoadStyles(["global.css","View/css/bootstrap.css","https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css", "css/menumovil.css"]),
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
print_r('<body>');
require_once('menu.php');
?>

<img onclick="go('index.php')" alt="SP" id="logo" class="fixed-top" src="img/ts_iso_negro.png"
        style="width: 7%">
    <div id="contenedorIndex">


    <div  class="container-fluid"  id="app" style="min-height: 84vh;">
    <input type="hidden"  class="form-control" value="<?php  echo isset($_SESSION["idCliente"]) ? $_SESSION["idCliente"] : '' ?>" id="idCliente">
        <div class="container p-4 m-4" v-if="status.cargandoProductos">
            <br><br>
            <div class="text-center"><i class='fa fa-spinner fa-spin' ></i></div>

        </div>
    <div id="carritoProductos">
        <div class="row " v-for="(producto, index) in enCarrito" :key="index">
            <div class="  col-md-2  " >
                
            </div>
            <div class="  col-md-4  " >
                <div style="cursor: pointer;" ><img :src="producto.ruta" height="172">
                    
                    <div
                        style="height: 100%;margin-left: 15px;display: inline-block;vertical-align: top;margin-top: 16px;">
                        {{producto.color}}</div>
                </div>
            </div>
            <div class="  col-md-1  " >
                <div class="d-flex" style="margin-top: 16px;">

                    <button type="submit" style="border:0 solid transparent;background-color:transparent;display: inline-block"
                            @click="EliminarProducto(producto)">X</button>
                    <input @change="CambiarCantidad(producto)" type="number"
                           :max="producto.inventario"
                           :disabled="producto.enviando"
                           v-model="producto.cantidad" style="width: 65px;padding-left: 5px;">
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
                        {{siglasMoneda}} {{Number(producto.precioFinal) | moneda}}
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div id="carritoProductosMovil" >
            <div class="row " v-for="(producto, index) in enCarrito" :key="index">
                <hr style="opacity: 1;margin-top: -1px;margin-bottom: -1px; " />
            <table>
                <tr>
                    <td rowspan="4">

                                <img :src="producto.ruta" height="172">

                    </td>
                </tr>
                <tr>
                    <td  style ="display: inline-block;">
                        <p class="small">
                        {{producto.nombre}}
                    </p>
                    </td>
                    <td></td>
                    <td style ="display: inline-block;" >

                            {{siglasMoneda}} {{Number(producto.precioFinal) | moneda}}

                </tr>
                <tr>
                    <td style ="display: inline-block;"> <button type="submit" style="border:0 solid transparent;background-color:transparent;display: inline-block"
                                 @click="EliminarProducto(producto)">X</button>
                        <input @change="CambiarCantidad(producto)" type="number"
                               :max="producto.inventario"
                               :disabled="producto.enviando"
                               v-model="producto.cantidad" style="width: 65px;padding-left: 5px;">

                            {{producto.color}}
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td> </td>
                </tr>
            </table>
            </div>
        </div>
        
        <hr style="margin: 0;" /><br />
        <div class="row ">
            <div class="  col-md-7  " >

            </div>
            <div id="SubtotalWeb" class="  col-md-5  ">
                SUBTOTAL: {{subtotal | moneda}}
            </div>
            <div id="SubtotalMovil" class="  col-md-5  " style="padding-right: 90px;text-align: right" >
                SUBTOTAL: {{subtotal | moneda}}
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
            <div id="shippingWeb" class="  col-md-5 " >
                <p class="small">SHIPPING & TAXES CALCULATED AT CHECKOUT</p>
            </div>
        </div>
        <div id="shippingMovil" style="padding-left: 12%;" class="  col-md-3 " >
            <p class="small text-align-center">SHIPPING & TAXES CALCULATED AT CHECKOUT</p>
        </div>
    </div>

    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1em">

        </div>
    </div>
    <!--div style='bottom: 1vh;font-size: 0.7rem;padding-left: 50%; padding-bottom: 0.5em;'
         id="politicadesktop"
         class='container-fluid mb-2'
        <span
              onclick="go('privacy.php')"> PRIVACY POLICY</span>
        <span style = "padding-left: 10%" onclick="go('shipping.php')"
            >SHIPPING & RETURNS</span></div>

    </div-->
        <div  id="politicadesktop">
            <?php
            require_once('privacyShiping.php');
            ?>
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
            enCarrito:[],
            idCliente:0,
            monedas:[],
            idMoneda:0,
            siglasMoneda:"",
            subtotal:0,
            status:{
                esClienteLocal:false,
                cargandoProductos:true,
            }
        },
        methods: {
            IrACheckOut()
            {
                location.href = "checkoutshop.php";

            },
                async EliminarProducto(producto)
                {
                    producto.enviando = true;

                    try {
                        await new Promise(resolve => setTimeout(resolve, 1000));
                        console.log("envio terminado");

                        producto.idCliente = this.idCliente;
                        await axios.post(ServeApi + "api/encarrito", { "producto" : producto, "movimiento":"ELIMINAR"})
                            .then((resultado) =>{

                                if (resultado.data == "eliminado")
                                {
                                    console.log("eliminado");
                                }
                            }).catch((problema) =>{

                            });

                        await this.ObtenerCarrito();
                    } catch (error) {

                    }

                    producto.enviando = false;
                },
            async CambiarCantidad(producto)
            {
                producto.enviando = true;

                try {
                    await new Promise(resolve => setTimeout(resolve, 1000));
                    console.log("envio terminado");

                    producto.idCliente = this.idCliente;
                    await axios.post(ServeApi + "api/encarrito", { "producto" : producto, "movimiento":"MODIFICAR"})
                        .then((resultado) =>{

                            if (resultado.data.idDetalle > 0)
                            {
                                console.log("actualizado");
                            }
                        }).catch((problema) =>{

                        });

                    await this.ObtenerCarrito();
                } catch (error) {

                }

                producto.enviando = false;

            },
            SumarProductos()
            {
                var subtotal = 0;
                this.enCarrito.forEach(element => {
                    subtotal +=  Number(element.cantidad) * Number(element.precioFinal);
                });
                this.subtotal = subtotal;
            },
            async CargaInicial()
            {
                await axios.get(ServeApi + "api/cargainicial")
                .then((resultado) => {
                     this.monedas = resultado.data.monedas;
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
            async ObtenerInfoLocalCarrito(Producto)
            {
                //api/encarritolocal/5
                var img = await axios.get(ServeApi + "api/encarritolocal/" + Producto.idProducto)
                .then((resultado) => {
                    console.log("info", resultado.data);
                    var info = resultado.data;

                    if (info.imagen)
                    {
                        if (info.imagen.ruta.length > 0)
                        {
                            
                            return info.imagen.ruta;   
                        }
                    }
                });

                return img;

            },
            EstablecerRutaRedirigir()
            {
                var rutaActual = "checkoutshop.php";
                var ultimaRuta = localStorage.getItem('ruta');
                if (ultimaRuta == null)
                {
                    localStorage.setItem('ruta', rutaActual);
                }

                if (rutaActual != ultimaRuta)
                {
                    localStorage.setItem('ruta', rutaActual);
                }

                /*actualizando ultima ruta */

                ultimaRuta = localStorage.getItem('ruta');
                return ultimaRuta;
            },
            async ObtenerCarrito()
            {
                if (this.status.esClienteLocal)
                {
                    var productosLocal = localStorage.getItem("productos");
                    //convertir json
                    if (productosLocal != null)
                    {
                        
                        productosLocal = JSON.parse(productosLocal);

                        console.log("productos local", productosLocal);
                        
                        productosLocal.forEach(element => {
                            element.ruta = "";
                        });

                        this.enCarrito = productosLocal;
                        this.$cantidadCarrito = this.enCarrito.length;
                        
                    }

                    this.status.cargandoProductos = false;


                }
                else
                {
                    this.status.cargandoProductos = true;
                    await axios.get(ServeApi + "api/encarrito/" + this.idCliente)
                    .then((resultado) =>{
                        if (resultado.data != null)
                        {
                            this.enCarrito = resultado.data;    
                            this.$cantidadCarrito = this.enCarrito.length;
                            
                        }
        
                    });

                    this.status.cargandoProductos = false;
                }

                var monedaEncontrada = this.monedas.find((moneda) => moneda.siglas == "USD" );
                 /*ajustar precio final conversion Moneda*/

                        


                    
                    this.enCarrito.forEach(element => {

                        if (this.siglasMoneda == "USD")
                        {

                            element.precioFinal = element.precio / monedaEncontrada.convertirMoneda;
                        }
                        else
                        {

                            element.precioFinal = element.precio;
                        }
                    });

                
                this.SumarProductos();
                
                return null;
            
                
            }
        },
        async mounted() {
            this.$cantidadCarrito = 0;
            this.idCliente = document.getElementById('idCliente').value;

            await this.CargaInicial();

            /*validar si es cliente con sesion o cliente local */
            if (this.idCliente.length == 0)
            {
                //local
                this.status.esClienteLocal = true;
            }

            this.EstablecerRutaRedirigir();

            this.idMoneda = idMoneda;
            this.siglasMoneda = localStorage.getItem("moneda");
            
            await this.ObtenerCarrito();
               
            if (this.status.esClienteLocal)
            {
                this.enCarrito.forEach(async element => {
                    var ruta = await this.ObtenerInfoLocalCarrito(element);
                    element.ruta = ruta;

                });
                
            }

        },
        

    });
</script>

</body>