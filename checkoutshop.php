<?php

use Administracion\VistasHtml;


include_once "View/Componentes/Administracion/VistasHtml.php";

$html = new VistasHtml();



$htmlPrincipal = "<!DOCTYPE html>
        <html lang='es'>";
print_r($htmlPrincipal);
$h = $html->Head(
    "Tiempos Shop",
    $html->Meta("utf-8", "Tienda Online de Tiempos Shop", "Egil Ordonez"),
    $html->LoadStyles(["global.css", "View/css/bootstrap.css", "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"]),
    $html->LoadScripts(["View/js/bootstrap.js",  "js/axios.min.js", "js/vue.js", "js/global.js",]),
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

require_once('menu.php');
?>

<div class="container-fluid" id="app">
    <div class="row ">
        <div class="  col-md-12  " style="text-align:center;margin-top:100px">
            <label style="font-family: NHaasGroteskDSPro-65Md">CHECKOUT</label>
        </div>
    </div>
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:2vh">

        </div>
    </div>
    <hr style="opacity: 1" />
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1vh">

        </div>
    </div>
    <div class="row ">
        <div class="  col-md-2  ">
            <input type="hidden" id="moneda" value="MXN">
        </div>
        <div class="  col-md-4  ">
            SHIPPING ADDRESS
        </div>
        <div class="  col-md-4  ">

        </div>
        <div class="  col-md-2  ">

        </div>
    </div>
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:2vh">

        </div>
    </div>
    <div class="row ">
        <div class="  col-md-2  ">

        </div>
        <div class="  col-md-4  ">
            <input class="form-control"  id="nombre" maxlength="999999" 
            v-model="direccion.nombre"
            placeholder="FIRST NAME" style="border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em" />
        </div>
        <div class="  col-md-4  ">
            <input class="form-control" 
            v-model="direccion.apellido"
            name="apellido" id="apellido" maxlength="999999" placeholder="LAST NAME" style="border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em" />
        </div>
        <div class="  col-md-2  ">

        </div>
    </div>
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1em">

        </div>
    </div>
    <div class="row ">
        <div class="  col-md-2  ">

        </div>
        <div class="  col-md-4  ">
            <input class="form-control" name="calle" 
            v-model="direccion.calle"
            id="calle" maxlength="999999" placeholder="STREET ADDRESS" style="border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em" />
        </div>
        <div class="  col-md-4  ">
            <input class="form-control" 
            v-model="direccion.company"
            name="company" id="company" maxlength="999999" placeholder="COMPANY (OPTIONAL)" style="border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em" />
        </div>
        <div class="  col-md-2  ">

        </div>
    </div>
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1em">

        </div>
    </div>
    <div class="row ">
        <div class="  col-md-2  ">

        </div>
        <div class="  col-md-4  ">
            <input class="form-control" name="ciudad" 
            v-model="direccion.ciudad"
            id="ciudad" maxlength="999999" placeholder="CITY" style="border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em" />
        </div>
        <div class="  col-md-4  ">
            <input class="form-control" 
            v-model="direccion.codigo_postal"
            name="postalcode" id="postalcode" maxlength="5" placeholder="ZIP OR POSTAL CODE" style="border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em" />
        </div>
        <div class="  col-md-2  ">

        </div>
    </div>
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1em">

        </div>
    </div>
    <div class="row ">
        <div class="  col-md-2  ">

        </div>
        <div class="  col-md-4  ">
            <input class="form-control"
            v-model="direccion.pais"
            name="pais" id="pais" maxlength="999999" placeholder="COUNTRY/REGION" style="border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em" />
        </div>
        <div class="  col-md-4  ">
            <input class="form-control" 
            v-model="direccion.estado"
            name="estado" id="estado" maxlength="999999" placeholder="STATE/PROVINCE" style="border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em" />
        </div>
        <div class="  col-md-2  ">

        </div>
    </div>
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:2em">

        </div>
    </div>
    <div class="row ">
        <div class="  col-md-2  ">

        </div>
        <div class="  col-md-2  ">
            <input class="form-control"
            v-model="direccion.telefono"
            name="telefono" id="telefono" maxlength="999999" placeholder="PHONE" style="border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em" />
        </div>
        <div class="  col-md-6  ">

        </div>
        <div class="  col-md-2  ">

        </div>
    </div>
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1em">

        </div>
    </div>
    <div class="row ">
        <div class="  col-md-2  ">

        </div>
        <div class="  col-md-2  ">
            <button class="btn btn-block btn-dark" onclick="CalcRate()" style="border-radius: 0;background-color: black;margin-top: 1em;">SAVE</button>
        </div>
        <div class="  col-md-2  ">
            <button class="btn btn-block btn-dark" formaction="customerLogin.php?action=create" type="submit" style="border-radius: 0;background-color: black;margin-top: 1em;">CANCEL</button>
        </div>
        <div class="  col-md-4  ">

        </div>
        <div class="  col-md-2  ">

        </div>
    </div>
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1em">

        </div>
    </div>
    <div class="row ">
        <div class="  col-md-2  ">

        </div>
        <div class="  col-md-4  ">
            <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter" style="border-radius: 10px;border-color: black"> USE AS BILLING ADDRESS</input>
        </div>
        <div class="  col-md-4  ">

        </div>
        <div class="  col-md-2  ">

        </div>
    </div>
    <hr style="opacity: 1" />
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1vh">

        </div>
    </div>
    <div class="row ">
        <div class="  col-md-4  ">

        </div>
        <div class="  col-md-4  ">
            SHIPPING METHOD
        </div>
        <div class="  col-md-4  ">

        </div>
    </div>
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:2vh">

        </div>
    </div>
    <div class="row ">
        <div class="  col-md-2  ">

        </div>
        <div class="  col-md-4  ">
            <input class="form-check-input" type="checkbox" 
                :disabled="status.cotizando" 
                style="border-radius: 10px;border-color: black">
                <span id="postalcodetext" class="ml-1 text-muted">
                    {{status.resultadoCotizacion}}
                </span>
            </input>
        </div>
        <div class="  col-md-4  ">

        </div>
        <div class="  col-md-2  ">

        </div>
    </div>
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:2vh">

        </div>
    </div>
    <hr style="opacity: 1" />
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1vh">

        </div>
    </div>
    <div class="row ">

        <div class="container-fluid">
          
         
         
            <div class="row ">
                <div class="  col-md-2  ">

                </div>
                <div class="  col-md-4  ">
                    PAYMENT METHOD
                </div>
                <div class="  col-md-4  ">

                </div>
                <div class="  col-md-2  ">

                </div>
            </div>
            <div class="row ">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:2vh">

                </div>
            </div>
            <div class="row ">
                <div class="  col-md-2  ">

                </div>
                <div class="  col-md-4  ">
                    <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter" style="border-radius: 10px;border-color: black"> PAY WITH CREDIT OR DEBIT CARD</input>
                </div>
                <div class="  col-md-6  0">
                    <img id="pago-seguro" src="img/pago-seguro.png" class="img-fluid" />
                </div>
            </div>
            <div class="row ">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1vh">

                </div>
            </div>
            <div class="row ">
                <div class="  col-md-2  ">

                </div>
                <div class="  col-md-4  " >
                    <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter" style="border-radius: 10px;border-color: black"> PAY WITH PAYPAL</input>
                </div>
                <div class="  col-md-4  ">

                </div>
                <div class="  col-md-2  ">

                </div>
            </div>
            <div class="row ">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:2vh">

                </div>
            </div>
            <hr style="opacity: 1" />
            <div class="row ">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1vh">

                </div>
            </div>
            <div class="row ">
                <div class="  col-md-2  ">

                </div>
                <div class="  col-md-4  ">
                    CARD DETAILS
                </div>
                <div class="  col-md-4  ">

                </div>
                <div class="  col-md-2  ">

                </div>
            </div>
            <div class="row ">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:2vh">

                </div>
            </div>
            <div class="row ">
                <div class="  col-md-2  ">

                </div>
                <div class="  col-md-4  ">
                    <input class="form-control" name="name" id="name" maxlength="999999" placeholder="CARD NUMBER" style="border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em" />
                </div>
                <div class="  col-md-2  ">
                    <input class="form-control" name="name" id="name" maxlength="999999" placeholder="EXPIRATION DAY" style="border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em" />
                </div>
                <div class="  col-md-4  ">

                </div>
            </div>
            <div class="row ">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1em">

                </div>
            </div>
            <div class="row ">
                <div class="  col-md-2  ">

                </div>
                <div class="  col-md-4  ">
                    <input class="form-control" name="name" id="name" maxlength="999999" placeholder="CARDHOLDDER´S NAME" style="border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em" />
                </div>
                <div class="  col-md-1  ">
                    <input class="form-control" name="name" id="name" maxlength="999999" placeholder="CVV" style="border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em" />
                </div>
                <div class="  col-md-5  ">

                </div>
            </div>
            <div class="row ">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:2vh">

                </div>
            </div>
            <hr style="opacity: 1" />
            <div class="row ">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1vh">

                </div>
            </div>
            <div class="row ">
                <div class="  col-md-12  " style="text-align:center;margin-top:10px">
                    <label style="font-family: NHaasGroteskDSPro-65Md">SUMMARY</label>
                </div>
            </div>

            <hr style="opacity: 1;margin-bottom: 0px;" />
            <div class="row " v-for="(producto, index) in enCarrito" :key="index">
                <div class="  col-md-2  ">

                </div>
                <div class="  col-md-2  ">
                    <div style="cursor: pointer;">
                        <img :src="producto.ruta" height="172">

                    </div>
                </div>
                <div class="col-md-2">
                    <div style="display: inline-block;vertical-align: top;margin-top: 16px;">
                        {{producto.color}}
                    </div>
                    <div>

                        {{producto.sku}}
                    </div>
                </div>
                <div class="  col-md-1  ">
                    <div class="d-flex" style="margin-top: 16px;">
                        
                            <button type="submit" style="border:0 solid transparent;background-color:transparent;display: inline-block">X</button>
                            <input @change="CambiarCantidad(producto)" type="number" maxlength="1" 
                            :max="producto.inventario"
                            :disabled="producto.enviando"
                            v-model="producto.cantidad" style="width: 65px;padding-left: 5px;">
                    </div>
                </div>
                <div class="  col-md-1  ">
                    <div style="margin-top: 16px;">{{producto.valor}}</div>
                </div>
                <div class="  col-md-1  ">

                </div>
                <div class="  col-md-3  ">
                    <div style="margin-top: 16px; display: inline-block;">
                        <div class="  ">
                            {{siglasMoneda}} {{producto.precio}}
                        </div>
                    </div>
                </div>
                <hr style="margin: 0;opacity: 1;margin-bottom: 0px;" />
            </div>

            <div class="row ">
                <div class="  col-md-12  pt-6 pb-4 border-bottom border-dark">
                    <div class="row ">
                        <div class="  col-md-3  ">

                        </div>
                        <div class="  col-md-6  ">
                            <div class="d-flex flex-column" style="margin-top: 10px;">
                                <p class="mr-5">Subtotal</p>
                                <p>Shipping total</p>
                                <p>Duties and taxes</p>
                                <p class="font-weight-bold mt-2">Total</p>
                            </div>
                        </div>
                        <div class="  col-md-3  ">
                            <div style="margin-top: 10px;" class="d-flex flex-column">
                                <p class="mr-5">{{siglasMoneda}} {{subtotal | moneda}} <input type="hidden" value="1300" id="subtotal"> </p>
                                <p> <span id="monedaEnvio"></span> <span class="ml-1" id="precioEnvio">
                                    {{siglasMoneda}} {{envio | moneda}}
                                </span> </p>
                                <p>(Included)</p>
                                <p class="font-weight-bold mt-2"><span id="monedaTotal"></span> <span class="ml-1" id="precioTotal">
                                {{siglasMoneda}}  {{total | moneda}}
                                </span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-dark btn-block" style="text-align: left;border-radius: 0" 
                    @click="ProcesarPedido()" :disabled="status.procesado || status.enviandoPedido || status.cotizando">
                    <div class="text-center" id="procesarText">{{status.procesadoEstatus}}</div>
                </button>

                <div class="col-md-12 mt-2">
                    <div class="bg-danger text-white p-2" v-if="errores.sistema.length > 0">
                        {{errores.sistema}}
                    </div>
                </div>
            </div>
        </div>
 
    </div>

    

    
</div>
<div style="position: inherit;bottom: 0;margin-bottom: 0.8rem; min-height: 150px;" class="col-md-8 col-sm-12 text-right pr-4 pl-4 d-flex align-items-end"><span class="small mr-4 col-md-6" onclick="go('privacy.php')"> PRIVACY POLICY</span><span onclick="go('shipping.php')" class="small ml-4 col-md-5">SHIPPING & RETURNS</span></div>

<script>
    Vue.filter('moneda', function(value) {
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
        el: '#app',
        data: {
            enCarrito: [],
            idCliente: 0,
            monedas: [],
            idMoneda: 0,
            siglasMoneda: "",
            subtotal: 0,
            envio: 0,
            total:0,
            direccion:{
                codigo_postal:'',
                telefono:'',
                nombre: '',
                apellido: '',
                company:'',
                calle:'',
                ciudad:'',
                pais:'',
                estado:''
            },
            status:{
                cotizando:false,
                procesado:false,
                enviandoPedido:false,
                textoDias:'DAYS',
                resultadoCotizacion: 'INPUT POSTAL CODE FIRST',
                procesadoEstatus:'PLACE ORDER',
            },
            errores:{
                sistema:''
            }
        },
        methods: {
            async CambiarCantidad(producto)
            {   
                producto.enviando = true;
                
                try {
                    await new Promise(resolve => setTimeout(resolve, 1000));
                    console.log("envio terminado");
                    

                    await axios.post(ServeApi + "api/encarrito/", { "producto" : producto, "movimiento":"MODIFICAR"})
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
            async ProcesarPedido()
            {
                this.status.enviandoPedido = true;

                try {
                    var data = {
                        "idCliente": this.idCliente,
                        "nombre": this.direccion.nombre,
                        "apellido" : this.direccion.apellido,
                        "idDireccion" : 2,
                        "moneda": this.siglasMoneda,
                        "total" : this.total,
                        "precioEnvio" : this.envio,
                        "subtotal": this.subtotal,
                        "nombre_recibe": this.direccion.nombre +  " " +  this.direccion.apellido,
                        "productos": this.enCarrito
                    }
            
                    await axios.post(ServeApi + "api/pedidos", data)
                    .then((resultado) => {
                        
                        var info =resultado.data;
                        if (info.IdPedido>0)
                        {
                            this.status.procesado = true;
                            
                            this.status.procesadoEstatus = "READY!";
                        }
                    }).catch((problema) =>
                    {
                        if (problema.response.data)
                        {
                            this.errores.sistema = problema.response.data;
                            
                        }
                        else
                        {
                            console.log("problema", problema);
                        }
                        
                    });
                } catch (error) {
                    
                }

                this.status.enviandoPedido = false;
            },
            async CalcularEnvio()
            {
               
                var data = {
                    "precio": this.subtotal,
                    "moneda": this.siglasMoneda,
                    "codigo_postal": this.direccion.codigo_postal,
                    "cantidad_productos":this.enCarrito.length,
                    "idCliente": this.idCliente,
                    "productos": this.enCarrito,
                }
                var idiomaActual = "ESPAÑOL";

                switch (idiomaActual)
                {
                    case "ESPAÑOL" :
                        this.status.resultadoCotizacion = "Cargando ...";
                        this.textoDias = "DÍAS";
                        break;
                    default:
                        this.status.resultadoCotizacion = "Loading ...";
                        this.textoDias = "DAYS";
                        break;
                }

                this.status.cotizando = true;

                await axios.post(ServeApi + "api/envios_mov/cotizar", data)
                .then((resultado) => {
                    
                    var info =resultado.data;
                    if (info.dias != null)
                    {
                        
                        this.status.resultadoCotizacion = info.precio + " " + info.moneda + " " +  info.dias + " " +  this.textoDias;
                        this.envio = Number(info.precio);
                        this.SumarProductos();
                    }
                });
                this.status.cotizando = false;
            },
            IrACheckOut() {
                location.href = "checkoutshop.php";
            },
            SumarProductos() {
                var subtotal = 0;
                this.enCarrito.forEach(element => {
                    
                    subtotal += Number(element.cantidad) * Number(element.precio);
                    
                });
                this.subtotal = Number(subtotal);
                
                this.total = (Number(subtotal) + Number(this.envio)).toFixed(2);
                

            },
            async CargaInicial() {
                await axios.get(ServeApi + "api/cargainicial/")
                    .then((resultado) => {
                        this.monedas = resultado.data;
                    });
            },
            async ObtenerDireccionPrincipal()
            {
                await axios.get(ServeApi + 'api/direccion/porcliente/' + this.idCliente)
                .then((resultado)=>{
                    console.log(resultado.data);
                    var data = resultado.data;

                    this.direccion.telefono= data.telefono;
                    this.direccion.nombre=data.nombre;
                    this.direccion.apellido = data.apellido;
                    this.direccion.company = data.company;
                    this.direccion.calle = data.Calle;
                    this.direccion.ciudad = data.Ciudad;
                    this.direccion.codigo_postal= data.CodigoPostal;
                    this.direccion.pais = data.Pais;
                    this.direccion.estado = data.estado;
                    this.CalcularEnvio();
                });
            },
            ValidarSiExisteEnCarrito() {
                this.status.agregadoAlCarrito = false;

                var productoEncontrado = this.enCarrito.find((p) => {
                    return p.idProducto == this.producto.idProducto
                });

                if (productoEncontrado) {
                    if (!this.producto.manejaraTallas) {
                        this.status.agregadoAlCarrito = true;
                    } else {
                        var tallaEncontrada = this.variantes.find((v) => {
                            return v.idProductoVarianteDetalle == this.producto.idProductoVarianteDetalle
                        });
                        if (tallaEncontrada) {
                            this.status.agregadoAlCarrito = true;
                        }
                    }

                } else {
                    console.log("no encontrado");
                }
            },

            async ObtenerCarrito() {

                await axios.get(ServeApi + "api/encarrito/" + this.idCliente)
                    .then((resultado) => {
                        if (resultado.data != null) {
                            
                            resultado.data.forEach(element => {
                                element.enviando = false;
                            });

                            this.enCarrito = resultado.data;

                            this.$cantidadCarrito = this.enCarrito.length;
                            this.SumarProductos();
                        }

                    });

            }
        },
        async mounted() {
            this.$cantidadCarrito = 0;
            this.idCliente = 1;
            var respuestaMonedas = this.CargaInicial();
            this.ObtenerCarrito();
            this.ObtenerDireccionPrincipal();
            await respuestaMonedas;
            this.idMoneda = idMoneda;
            this.siglasMoneda = siglasMoneda;
        },


    })
</script>