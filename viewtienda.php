<?php

use Administracion\VistasHtml;


include_once "View/Componentes/Administracion/VistasHtml.php";



$html=new VistasHtml();


session_start();


$h = $html->Html5Shop(
    $html->Head('Tiempos Shop',
        $html->Meta("utf-8","Tienda Online de Tiempos Shop","Egil Ordonez"),
        $html->LoadStyles(["global.css","View/css/bootstrap.css","https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css", "css/menumovil.css"]),
    $html->LoadScripts(["View/js/bootstrap.js",
        "vendor/jquery/jquery.js", "js/jquery.mlens-1.7.min.js", "js/axios.min.js", "js/vue.js", "js/global.js"]),
        "<style>
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
</style>",
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
                    </script>'), "style='background-color:#FFFFF;' ");
print_r($h);

require_once('menu.php');
?>

<div id="app">
    <img onclick='go("index.php")' alt='SP' id='logo' class='fixed-top' src='img/ts_iso_negro.png'
        >
    <div class="container-fluid" id="contenedorIndex">
        <div class="row main sinpadding">

            <!-- para movil mostrar el carousel -->
            <div id="carouselExampleIndicators" class="carousel slide " >

                <div class="carousel-inner">
                    <div class="carousel-item " v-for="(imagen, index) in imagenes" :key="index"
                         :class="index == 0 ? 'active' : ''" >
                        <img class="d-block w-100" style="max-height: 800px;" :src="imagen.ruta" alt="First slide">
                    </div>

                </div>


                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" v-for="(imagen, index) in imagenes" :key="index" :data-slide-to="index" :class="index == 0 ? 'active' : ''" ></li>
                </ol>
            </div>

            <div class='  col-md-6  paddingNone' style="display: none" id="imagenesDesk">



       
                <div class=' ' v-for="(imagen, index) in imagenes" :key="index">
                    <img :id="'ids' + (index + 1)" class='img-fluid' :src="imagen.ruta" :data-big="imagen.ruta"
                        data-overlay=''><br />

                </div>
            </div>
            <div class='  col-md-6  left-top paddingNone' id="infoProducto">
                <div class="container p-4 m-4" v-if="status.cargandoProductos">
                    <br><br>
                    <div class="text-center"><i class='fa fa-spinner fa-spin' ></i></div>

                </div>
                <div id='component' class="container-fluid" ><br />

                    <input type="hidden" value="<?php echo $_GET["id"] ?>" id="idProducto">
                    <input type="hidden"  class="form-control" value="<?php  echo isset($_SESSION["idCliente"]) ? $_SESSION["idCliente"] : '' ?>" id="idCliente">


                    <div class="row " v-if="!status.cargandoProductos">
                        <div class='  col-md-12  ' >
                            <p style='font-family: NHaasGroteskDSPro-65Md;'>{{info.nombre}}</p>
                        </div>
                    </div>
                    <div class="row " v-if="!status.cargandoProductos">
                        <div class='  col-md-12  '>
                            <p>{{info.color}}</p>
                        </div>
                    </div>
                    <hr style='margin-top: 1em!important;' />
                    <div class="row " v-if="!status.cargandoProductos">
                        <div class='  col-md-12  small-font' id="descripcion">
                            <div v-html="info.descripcion"></div>
                        </div>
                    </div>
                    <hr style='margin-top: 1em!important;' />
                    <div style='height: 25vh' v-show="!status.cargandoProductos" id="precio"><label style='padding-left: 40px'>{{siglasMoneda}} {{Number(producto.precioFinal) | moneda}}</label></div>
                    <hr style='margin: 0 0 0 0' />
                    <div class="btn-group" style="width:100%">
                        <button type="button" class="btn btn-block dropdown-toggle "
                            v-if="producto.manejaraTallas"
                            @click="status.verVariantes = !status.verVariantes">
                            {{productoVariante.valor}}
                        </button>
                        <div class="dropdown-menu align-content-center " 
                            :class="status.verVariantes ? 'show' : ''"  
                            style="width: 100%; position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(0px, -35px);">
                            <a class='dropdown-item pl-4' href='#' v-for="(talla, index) in variantes" :key="index"
                                @click="EstablecerVarianteTallas(talla)">
                                {{talla.valor}}
                            </a>
                        
                        </div>
                    </div>
                 

                    <hr style="margin: 0 0 0 0" />
                    
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button id="cart" type="submit" class="btn btn-dark btn-block" v-if="!status.agregadoAlCarrito"
                                style="border-radius: 0" @click="AgregarAlCarrito()">ADD TO CART</button>
                            <button id="cart" type="submit" class="btn btn-dark btn-block" v-else
                                style="border-radius: 0" @click="IrAlCheckout()">PROCEED TO CHECKOUT</button>
                        </div>
                    </div>

    <div class="container-fluid mb-2" id="politicadesktop"
                    style="position: fixed;bottom: 0;font-size: 0.7rem; margin-top: calc(5% - 1rem);">
                        <label class="mr-4"><span style="width: 10vw;" >PRIVACY
                                POLICY</span>
                        </label>
                        <label class="mr-4"><span style="width: 10vw;"
                            >SHIPPING RETURNS</span>
                        </label>
                        <button type="button"
                            class="btn btn-link"
                            style="text-decoration: none;color: #212529;padding: 0;border: none;font-weight: normal; vertical-align: baseline;font-size: inherit !important; "
                            data-bs-toggle="modal" data-bs-target="#size">
                            <span>SIZE GUIDE</span>
                        </button>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>



    <div class="modal" id="size" tabindex="-1" role="dialog" aria-labelledby="sizeLabel" aria-hidden="true"
        style="background-color: #ffffff8C;">
        <div class="modal-dialog modal-dialog-centered"  role="document">
            <div class="modal-content" style="border-radius: 0;border: 0 solid transparent; background-color:white;width: auto;">
               
                <div class="modal-body" style="padding: 0;">
                    <img :src="producto.rutaGuiaTallas" alt="Guia de tallas" style="min-width: 400px;max-width: 480px;">
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
            english:{
                idProductoIdioma:0,
                nombre:'',
                descripcion:'',
            },
            info:{
                nombre: '.',
                descripcion : '...',
                color: '....'
            },
            idCliente:0,
            variantes:[],
            productoVariante:{
                valor:'SELECT SIZE'
            },
            imagenes:[],
            enCarrito:[],
            status:{
                verVariantes:false,
                agregadoAlCarrito: false,
                esClienteLocal:false,
                cargandoProductos:true,
            },
            idioma : '',
            siglasMoneda: '..'
        },
        methods: {
            IrAlCheckout()
            {
                window.location.href="carttienda.php";
            },
            ValidarSiExisteEnCarrito()
            {
                

                if (this.enCarrito.length>0)
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
                }
                
            },
            EstablecerVarianteTallas(talla)
            {
                this.status.verVariantes = false; 
                this.producto.idProductoVarianteDetalle = talla.idProductoVarianteDetalle; 
                this.productoVariante.valor = talla.valor;
                this.ValidarSiExisteEnCarrito();

            },
            async AgregarAlCarrito()
            {
                if (this.status.esClienteLocal)
                {
                    var productosLocal = await this.ObtenerEnCarrito();

                    console.log("prod", productosLocal);

                    //si es nulo la lista de productos crear una lista;
                    if (productosLocal == null)
                    {
                        productosLocal = [];
                    }
                    
                    //agregar cantidad
                    this.producto.cantidad = 1;
                    console.log("producto a guardar", this.producto);
                    productosLocal.push(this.producto);
                    console.log("productos push", productosLocal);
                    localStorage.setItem("productos", JSON.stringify(productosLocal));

                }
                else
                {
                
                    await axios.post(ServeApi + "api/encarrito", { "producto" : this.producto, "movimiento":"AGREGAR"})
                    .then((resultado) =>{
                        console.log(resultado.data);
                        if (resultado.data.idDetalle > 0)
                        {
                            this.status.agregadoAlCarrito = true;
                        }
                    });
                }
                
                //global para ambos casos
                await this.ObtenerEnCarrito();
  
            },
           async ObtenerProducto()
           {
               var idProducto = document.getElementById('idProducto');
               this.status.cargandoProductos = true;


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
                                this.english = resultado.data.english;
                                this.producto.idProductoVarianteDetalle = 0;
                                this.producto.idCliente = this.idCliente;
                                
                                if (this.idioma != "ENGLISH")
                                {
                                    /*para la traduccion*/
                                    this.info.nombre = this.english.nombre;
                                    this.info.descripcion = this.english.descripcion;
                                    
                                    console.log("english");
                                }
                                else
                                {
                                    this.info.nombre = this.producto.nombre;
                                    this.info.descripcion = this.producto.descripcion;
                                    console.log("español", this.english);
                                }
                                /*general*/
                                this.info.color = this.producto.color;

                                if (resultado.data.variantes.length > 0)
                                {
                                    this.variantes = resultado.data.variantes;
                                }
                                if (resultado.data.imagenes)
                                {
                                    this.imagenes =resultado.data.imagenes;
                                }

                                if (this.siglasMoneda == "USD")
                                {

                                    var monedaEncontrada = this.monedas.find((moneda) => moneda.siglas == "USD" );
                                    this.producto.precioFinal = this.producto.precio / monedaEncontrada.convertirMoneda;
                                }
                                else
                                {
                                    this.producto.precioFinal = this.producto.precio;
                                }

                            }
                        });

                   }
                   this.status.cargandoProductos = false;
                   await this.ObtenerEnCarrito();
                    
               }
               else
               {
                   console.log("no se encontro id");
               }
               
           },
           ObtenerMoneda()
           {
                this.siglasMoneda = localStorage.getItem("moneda");
           },
            async CargaInicial()
            {
                await axios.get(ServeApi + "api/cargainicial")
                    .then((resultado) => {
                        this.monedas = resultado.data.monedas;
                    });
            },
           async ObtenerEnCarrito()
           {
               if (this.status.esClienteLocal)
               {
                    var productosLocal = localStorage.getItem("productos");
                    //convertir json
                    if (productosLocal != null)
                    {
                        
                        productosLocal = JSON.parse(productosLocal);

                        console.log("productos local", productosLocal);

                        this.enCarrito = productosLocal;
                        this.$cantidadCarrito = this.enCarrito.length;
                        
                        this.ValidarSiExisteEnCarrito();
                    }
                    

                    return productosLocal;

               }
               else
               {
                   try
                   {

                   }
                   catch (theError)
                   {
                       await axios.get(ServeApi + "api/encarrito/" + this.idCliente)
                           .then((resultado) =>{
                               if (resultado.data != null)
                               {
                                   this.enCarrito = resultado.data;
                                   this.$cantidadCarrito = this.enCarrito.length;

                                   this.ValidarSiExisteEnCarrito();
                               }
                               else
                               {
                                   console.log("no hay data");
                               }
                           });
                   }

               }
                
           }
        },
        async mounted() {
            await this.ObtenerMoneda();
            await this.CargaInicial();
            this.idioma = localStorage.getItem("idioma");
            
            if (this.idioma == null)
            {
                this.idioma = "ENGLISH"
            };

            

            this.idCliente = document.getElementById('idCliente').value;

            /*validar si es cliente con sesion o cliente local */
            if (this.idCliente.length == 0)
            {
                //local
                this.status.esClienteLocal = true;
            }

            this.ObtenerProducto();
            this.$cantidadCarrito = this.enCarrito.length;
            
        },
        

    })
</script>

<script>
    //var myCarousel = document.querySelector('#carouselExampleIndicators');
    //var carousel = new bootstrap.Carousel(myCarousel);

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

</body>
</html>

