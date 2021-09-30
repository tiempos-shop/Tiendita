<?php
date_default_timezone_set('America/Monterrey');
use Administracion\VistasHtml;

use Tiendita\Utilidades;

include_once "View/Componentes/Administracion/VistasHtml.php";
include_once "Business/Utilidades.php";
include_once "Data/Connection/EntidadBase.php";
include_once "Business/FrontComponents.php";

session_start();
$html=new VistasHtml();
$ui=new Utilidades();


$fc=new \Tiendita\FrontComponents();

$h= $html->Html5Shop(
    $html->Head(
        "Tiempos Shop",
            $html->Meta("utf-8","Tienda Online de Tiempos Shop","Egil Ordonez"),
            $html->LoadStyles(["global.css","View/css/bootstrap.css","https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css", "css/menumovil.css"]),
            $html->LoadScripts(["View/js/bootstrap.js", "js/vue.js", "js/global.js"]),
            "
                <style>
                    #contenedorIndex{
                        position: fixed;
                        left: 0;
                        top: 0;
                        width: 100%;
                        height: 100%;
                        padding: 0px;
                        margin: 0px;
                    }
                    body, html {
                        height: 100%;
                        width: 100%;
                    }
                </style>
            ",
            "<script>
                      window.onload=function (){
                          //load();
                      }
                      
                      function go(url){
                          window.location.href=url;
                      }
                      
                      function load(){
                        setTimeout(
                              function ()
                              {
                                    var r=document.getElementById(\"right_home\");
                                    r.style.visibility=\"visible\";
                                    
                              },1000
                        );
                       
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
                    
                    </script>,"

        ),"style='background-color:#FFFFF;color:#AC9950'");

print_r($h);

require_once('menu.php');
?>

<img alt="SP" id="logo" class="fixed-top" src="img/ts_iso_oro.png">
<input type="hidden"  class="form-control" value="<?php  echo isset($_SESSION["idCliente"]) ? $_SESSION["idCliente"] : '' ?>" id="idCliente">
<div id="contenedorIndex" class="container-fluid" >
    <div >
        <div id="app">
            <div class="col" style="padding: 0px; margin: 0px;">
                <img src="img/ts-home_001.jpg"
                    style="padding: 0px;margin: 0px; width: 100%; height: 100%;" />
                <img src="img/ts-home_002.jpg"
                     v-if="status.enIndex"
                     style="padding: 0px;margin: 0px; width: 100%; height: 100%;" />
        </div>


        </div>
    </div>
</div>
<div id="politicadesktop"></div>


<script>


    var app = new Vue({
        el:'#app',
        data:{
            listaProductos:[],
            idCliente:0,
            enCarrito:[],
            status:{
                cargandoProductos:true,
                esClienteLocal:false,
                enIndex:false,
            },
            siglasMoneda:'',
            monedas:[]
        },
        methods: {

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

        },
        created() {

        },
        async mounted() {
            var nombrePaginaHtml =location.pathname;

            if (nombrePaginaHtml.indexOf("index.php")>=0)
            {
                this.status.enIndex = true;
            }

            this.idCliente = document.getElementById('idCliente').value;

            if (this.idCliente.length == 0)
            {
                //local
                this.status.esClienteLocal = true;
            }


            await this.ObtenerEnCarrito();
        },


    })
</script>

</body>
</html>
