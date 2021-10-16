<?php

use Administracion\VistasHtml;

include_once "View/Componentes/Administracion/VistasHtml.php";
include_once "Data/Connection/EntidadBase.php";

$html=new VistasHtml();
$db=new \Tiendita\EntidadBase();

$auxmenu = 0;
$menuPrincipal = "";
$menu = $db->getAll("menus");
$submenu = $db->getAll("submenus");


$db->close();

session_start();

$htmlPrincipal = "<!DOCTYPE html>
        <html lang='es'>";
print_r($htmlPrincipal);
$h = $html->Head(
    "Tiempos Shop",
    $html->Meta("utf-8","Tienda Online de Tiempos Shop","Egil Ordonez"),
    $html->LoadStyles(["global.css","View/css/bootstrap.css","https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css", "css/menumovil.css"]),
    $html->LoadScripts(["View/js/bootstrap.js", "js/axios.min.js", "js/vue.js", "js/global.js"]),
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
                  function filter(){
                    let s=document.getElementById("s");
                    let smenu=document.getElementById("sMenu");
                    s.style.display="none";
                    smenu.style.display="block";
                    
                    }
                    function showfilter(){
                        let s=document.getElementById("s");
                        let smenu=document.getElementById("sMenu");
                        s.style.display="block";
                        smenu.style.display="none";
                        
                        }         
                        
                        function openSubmenu(event){
                     let menu = event.dataset.menu;
                     let submenu = document.querySelectorAll("div.submenu"); 
                     for (let i = 0; i < submenu.length; ++i) {
                         if( parseInt(menu) === i )
                            {
                                if( submenu[i].classList.contains("d-none") ){
                                    submenu[i].classList.remove("d-none");
                                }else{
                                    submenu[i].classList.add("d-none");
                                }
                            }
                     }
                  }
                </script>'

);
print_r($h);

require_once('menu.php');
?>

<div id="app" >

    <div  style="min-height: 84vh">

    <img onclick='go("index.php")' alt='SP' id='logo' class='fixed-top' src='img/ts_iso_negro.png'
         >
    <div id="contenedorIndex" stryle = "min-height: 80vh" class="shop">
        <div class="row mt-2">

            <div class="container p-4 m-4" v-if="status.cargandoProductos">
                <br><br>
                <div class="text-center"><i class='fa fa-spinner fa-spin' ></i></div>

            </div>

            <div v-for="(producto, index) in listaProductos" :key="index" class="col-md-4" :style="estilo.productos">

                <div class='text-center' >

                    <br /><br /><img   :src="producto.imagenPrincipal"
                                    @click="VerProducto(producto.idProducto)"
                                    @mouseover="producto.dentro = true; CambiarImagen(producto,false)"
                                    @mouseleave="producto.dentro = false; CambiarImagen(producto,true)" style="width: 100%"><br /><br />
                    <p style="font-family: NHaasGroteskDSPro-65Md;line-height: 1">{{producto.color}}</p>
                    <p><s style="font-size: 0.7rem;" v-if="producto.precioComparativo>0 && producto.precioComparativo != producto.precioFinal">{{siglasMoneda}} {{Number(producto.precioComparativo) | moneda}}</s> {{siglasMoneda}} {{Number(producto.precioFinal) | moneda}}</p>
                </div>

            </div>
        </div>


        <div style='position: fixed;top:8.5vh;margin-left: -12vw' class="d-none d-md-block">
            <a @click='ObtenerProductos(0)'  class='d-block text-dark p-1' style="cursor: pointer;">SHOP ALL'</a>
            <?php
            foreach ($menu as $valor) {
                $menuSecundario = "";
                foreach ($submenu as $subvalor) {
                    if( $subvalor->idMenu == $valor->idMenu )
                        $menuSecundario .= "<a href='#' class='d-block text-dark pl-2'>$subvalor->SubMenu</a>";
                    $menuSecundario = "";
                }
                if ( $menuSecundario != "" ){
                    $menuPrincipal .= "<div class='p-1'><a href='#' class='d-block text-dark' style='text-transform: uppercase;' data-menu='$auxmenu' onclick='openSubmenu(this);' @click='ObtenerProductos(".$valor->idMenu.")'>$valor->menu</a>";
                    $menuPrincipal .= "<div class='submenu d-none'>";
                    $menuPrincipal .= $menuSecundario;
                    $menuPrincipal .= "</div>";
                    $menuPrincipal .= "</div>";
                    $auxmenu++;
                }else{
                    $menuPrincipal .= "<a @click='ObtenerProductos(".$valor->idMenu.")' class='d-block text-dark p-1'><span style='text-transform: uppercase;'>$valor->menu</span></a>";
                }
            }
            echo $menuPrincipal;
            ?>
        </div>

        <div class='small d-none d-md-block' style='position: fixed;display: inline-block;top: 8.5vh;right: 1.6vw;width:11vw'>
            <label onclick='filter()' id='s' style='font-size: 0.9rem;'>SORT +</label>
            <div id='sMenu' style='color:white;background-color: gray;border-radius: 5px;display: none'>
                <div class='container-fluid'
                     style='padding-left: 0;padding-right: 0;padding-top: 0.5vh;padding-bottom: 0.5vh;'>
                    <div class='row item' style='margin-left: 0'>
                        <div class='col-md-1 align-self-center' style='padding-right: 0'>
                            <label style='width: 100%;text-align: right;'></label>
                        </div>
                        <div class='col-md-10'>
                            <a href='#' style='display: block' @click="ordenar(1)">FEATURED</a>


                        </div>
                        <div class='col-md-1'>

                        </div>
                    </div>
                    <div class='row item' style='margin-left: 0'>
                        <div class='col-md-1 align-self-center' style='padding-right: 0'>
                            <label style='width: 100%;text-align: right'></label>
                        </div>
                        <div class='col-md-10'>
                            <a href='#' style='display: block' @click="ordenar(2)">A TO Z</a>

                        </div>
                        <div class='col-md-1'>

                        </div>
                    </div>
                    <div class='row item' style='margin-left: 0'>
                        <div class='col-md-1 align-self-center' style='padding-right: 0'>
                            <label style='width: 100%;text-align: right'></label>
                        </div>
                        <div class='col-md-10'>
                            <a href='#' style='display: block' @click="ordenar(3)">PRICE LOW TO HIGH</a>

                        </div>
                        <div class='col-md-1'>

                        </div>

                    </div>
                    <div class='row item' style='margin-left: 0'>
                        <div class='col-md-1 align-self-center' style='padding-right: 0'>
                            <label style='width: 100%;text-align: right'></label>
                        </div>
                        <div class='col-md-10'>
                            <a href='#' style='display: block' @click="ordenar(4)">PRICE HIGH TO LOW</a>

                        </div>
                        <div class='col-md-1'>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class=" ">

            <input type="hidden"  class="form-control" value="<?php  echo isset($_SESSION["idCliente"]) ? $_SESSION["idCliente"] : '' ?>" id="idCliente">

        </div>



    
</div>

    </div>

    <!--<div class='container-fluid mb-2'
         style='bottom: 1vh;font-size: 0.7rem;padding-left: 50%; padding-bottom: 1.5rem;' id="politicadesktop">
        <label style='width: 14vw;display: inline-block;position: absolute;left: 50vw;font-size: 0.7rem;' onclick='go("privacy.php")'>PRIVACY POLICY'</label>
        <label style='width: 15vw;display: inline-block;position: absolute;left: 62vw;font-size: 0.7rem;'><span onclick='go("shipping.php")'>SHIPPING RETURNS</span></label>
    </div>-->
<div id="politicadesktop">
<?php
    require_once('privacyShiping.php');
?>
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
            mensaje:'hola',
            listaProductos:[],
            idCliente:0,
            enCarrito:[],
            status:{
                cargandoProductos:true,
                esClienteLocal:false
            },
            siglasMoneda:'',
            monedas:[],
            estilo:{
                tablaProducto:'',
                productos:'',

            }
        },
        methods: {

            ordenar(opcion)
            {
                var ListaOrdenProductos = this.listaProductos.slice();

                switch (opcion) {
                    case 1:
                        //featured
                        
                        ListaOrdenProductos.sort(function(a,b) {
                            return  b.idProducto - a.idProducto;
                        });
                        break;
                    case 2:
                        //a - z
                        
                        ListaOrdenProductos.sort(function(a,b) {
                            var x = a.color.toLowerCase();
                            var y = b.color.toLowerCase();
                            return x < y ? -1 : x > y ? 1 : 0;
                        });
                        break;
                    case 3:
                        //price low
                        
                        ListaOrdenProductos.sort(function(a,b) {
                            return a.precio - b.precio;
                        });
                        break;
                    case 4:
                        //price higth
                        
                        ListaOrdenProductos.sort(function(a,b) {
                            return  b.precio - a.precio;
                        });
                        
                        break;
                    default:
                        break;
                }

                this.listaProductos = ListaOrdenProductos;
                showfilter();
            },
            VerProducto(idProducto)
            {
                window.location.href="viewtienda.php?id=" + idProducto;
            },
            async ObtenerProductos(idMenu)
            {
                var inicial = this.CargaInicial();
                if (idMenu == null || idMenu == "undefined")
                {
                    idMenu = 0;
                }

                console.log("idmenu", idMenu);

                var busqueda = { "idMenu": idMenu};

                this.status.cargandoProductos = true;
                this.listaProductos = [];
                var result = await axios.post(ServeApi + "api/productostiendabusqueda", busqueda)
                .then((resultado) =>{
                    console.log("resultado", resultado.data);
                    var productos = null;

                    productos = resultado.data;

                    return productos;
                });
                
                await inicial;
                if (this.siglasMoneda == "USD")
                {
                        
                    var monedaEncontrada = this.monedas.find((moneda) => moneda.siglas == "USD" );

                    
                }

                result.forEach(element => {
                        if (element.imagen.length>0)
                        {
                            element.imagenPrincipal = element.imagen[0].ruta;
                            
                        }
                        else
                        {
                            element.imagenPrincipal = '';
                        }
                        element.precioFinal =element.precio;
                        element.cargandoImagen = false;
                        element.dentro = false;
                        if (this.siglasMoneda == "USD")
                        {
                            element.precioFinal = element.precio / monedaEncontrada.convertirMoneda;
                            element.precioComparativo = element.precioComparativo / monedaEncontrada.convertirMoneda;
                        }

                        
                    });

                this.status.cargandoProductos = false;

                this.listaProductos = result;
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
                        
                        productosLocal.forEach(element => {
                            element.ruta = "";
                        });

                        this.enCarrito = productosLocal;
                        this.$cantidadCarrito = this.enCarrito.length;
                        
                    }
                    

                    return productosLocal;

                }
                else
                {
                    
                    await axios.get(ServeApi + "api/encarrito/" + this.idCliente)
                    .then((resultado) =>{
                        if (resultado.data != null)
                        {
                            this.enCarrito = resultado.data;    
                            this.$cantidadCarrito = this.enCarrito.length;
                            
                        }
        
                    });

                    
                }
              
            },
            async CargaInicial()
            {
                await axios.get(ServeApi + "api/cargainicial")
                .then((resultado) => {
                     this.monedas = resultado.data.monedas;
                });
            },
            CambiarImagen(producto, regresar)
            {
                var app = this;

                
                if (producto.imagen.length>1)
                {
                    if (!producto.cargandoImagen)
                    {
                        if (regresar)
                        {
                            producto.imagenPrincipal = producto.imagen[0].ruta;
                        }
                        else
                        {
                            producto.imagenPrincipal = producto.imagen[1].ruta;
                        }

                        producto.cargandoImagen = true;
                    }
                    else
                    {
                        if (regresar & producto.dentro)
                        {
                            setTimeout(() => {
                                producto.cargandoImagen = false;
                                producto.imagenPrincipal = producto.imagen[0].ruta;
                            }, 40);
                        }
                    }
                   
                    

                    setTimeout(() => {
                        producto.cargandoImagen = false;
                    }, 50);
                    
                }
            }
        },
        created() {
            this.siglasMoneda = localStorage.getItem("moneda");
            this.ObtenerProductos();
        },
        async mounted() {


            
            this.idCliente = document.getElementById('idCliente').value;

            if (this.idCliente.length == 0)
            {
                //local
                this.status.esClienteLocal = true;
            }


            await this.ObtenerEnCarrito();
        },
        

    });

</script>
