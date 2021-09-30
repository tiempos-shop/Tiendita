<?php
use Administracion\VistasHtml;

include_once "View/Componentes/Administracion/VistasHtml.php";
include_once "Data/Connection/EntidadBase.php";

$html = new VistasHtml();
session_start();

header('Access-Control-Allow-Origin: *');

$h = $html->Html5Shop(
    $html->Head(
        "Tiempos Shop",
        $html->Meta("utf-8", "Tienda Online de Tiempos Shop", "Egil Ordonez"),
        $html->LoadStyles(["global.css", "View/css/bootstrap.css", "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css", "css/menumovil.css"]),
        $html->LoadScripts(["vendor/jquery/jquery.js", "js/axios.min.js", "View/js/bootstrap.js", "js/vue.js", "js/global.js"]),
        "
            <style>
                    
                    button{
                        background-color: transparent;
                        border: none;
                        background-repeat:no-repeat;
                        cursor:pointer;
                        overflow: hidden;  
                    }
                    
                    p{
                        text-align: justify;
                        text-align-last: justify;
                        margin: 0 0 0 0;
                        font-size: inherit;
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
    "style='background-color:#AC9950;color:black'");

print_r($h);


require_once('menu.php');

?>
<div id="contenedorIndex">
    <img onclick="go('index.php')" alt="SP" id="logo" class="fixed-top" src="img/ts_iso_negro.png"
    >
    <div class="fixed-top" style="top:57vh;padding-bottom:2vh;padding-left: 2vw;padding-right: 2vw">
        <div class="row ">
            <div class="  col-md-12  " >
                <p>PIECES OF EVIDENCE</p>
            </div>
        </div>
        <div class="row ">
            <div class="  col-md-12  " >
                <p>WITHIN FLEETING TIMES . AN AIM TO CREATE</p>
            </div>
        </div>
        <div class="row ">
            <div class="  col-md-12  " >
                <p>PUNCTUAL YET LASTING MOMENTS</p>
            </div>
        </div>
        <div class="row ">
            <div class="  col-md-12  " >
                <p>WWW . TIEMPOS . SHOP</p>
            </div>
        </div>
    </div>
    <div class="fixed-bottom" style="padding-top:2vh;padding-bottom:2vh;padding-left: 2vw;padding-right: 2vw">
        <div class="row ">
            <div class="  col-md-12  " >
                <p>ABOUT BRANDS S.A. DE C.V. ABR181008L27</p>
            </div>
        </div>
        <div class="row ">
            <div class="  col-md-12  " >
                <p>CALLE INDUSTRIAL 4 51D</p>
            </div>
        </div>
        <div class="row ">
            <div class="  col-md-12  " >
                <p>COL. LA PRIMAVERA 8030 CULIACÁN SIN. MX</p>
            </div>
        </div>
        <div id="politicadesktop"></div>
    </div>

</div>

</body>
</html>
