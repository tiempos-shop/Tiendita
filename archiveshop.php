<?php
date_default_timezone_set('America/Monterrey');
use Administracion\VistasHtml;
use Tiendita\Utilidades;

include_once "View/Componentes/Administracion/VistasHtml.php";
include_once "Business/Utilidades.php";
include_once "Data/Connection/EntidadBase.php";
include_once "Business/FrontComponents.php";
include_once "Data/Models/Producto.php";

session_start();

$html=new VistasHtml();
$ui=new Utilidades();

$db=new \Tiendita\EntidadBase();

$archivos = $db->getAll("archivo");
$dbURLAdmin = $db->getBy('configuracion','idConfiguracion','1');
$nombreURLAdmin = $dbURLAdmin[0]->valor."/";

$db->close();

global $idioma;
$idiomaActual="";


$fc=new \Tiendita\FrontComponents();

$h= $html->Html5Shop(
    $html->Head(
        "Tiempos Shop",
        $html->Meta("utf-8","Tienda Online de Tiempos Shop","Egil Ordonez"),
        $html->LoadStyles(["global.css","View/css/bootstrap.css","https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css", "css/menumovil.css"]),
        $html->LoadScripts(["View/js/bootstrap.js", "js/axios.min.js",  "js/vue.js", "js/global.js"]),
        "
            <style>
                body{
                    color:black;
                }
                td{
                    padding: 0!important;
                }
                #t{
                    left: 0px; 
                    text-align: center;
                    width: 9%;
                }
                #t > span{
                    padding: 8px 10px; 
                    display: block; 
                    user-select: none; 
                    -moz-user-select: none; 
                    -webkit-user-select: none;
                }
                #t > span.hidden{
                    opacity: 0;
                }
                #t:hover > span{
                    border-top: 1px solid #000;
                    opacity: 100;
                }
                #t:hover > span:last-child{
                    border-bottom: 1px solid #000;
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
                      
                      
                    </script>"

    ),"style='background-color:transparent;z-index:100;overflow-x:hidden'");

print_r($h);

require_once('menu.php');
?>

<img onclick="go('index.php')" alt="SP" id="logo" class="fixed-top" src="img/ts_iso_negro.png"
>
<div id="t" style="font-size:1.1em;font-family: NHaasGroteskDSPro-55Rg;z-index: 900" class="d-none d-md-block">
<?php
    $pocision = 0;
    foreach ($archivos as $row) {
        if ($row->tipo == "sec")
        {
            if ($pocision == 0)
            {
                echo '<span onclick="ircatalogo('.$pocision.')" class=" catalogolabel" >'.$row->html.'</span>';
            }
            else
            {
                echo '<span onclick="ircatalogo('.$pocision.')" class="hidden catalogolabel">'.$row->html.'</span>';
            }
            $pocision++;    
        } 
        
    }
?>
</div>
<div class="fixed-top" id="bordepagina"
     style="z-index:100;display:block;width:96.1vw;height:95.7vh;background-color: transparent;border: 1px solid black;top:1vh;left: 2.1vw; z-index: -10;">

</div>
<div class="container-fluid" id="contenedorIndex">
    <div class="row ">
        <div class="  col-md-12  " >
            <br /><br />
        </div>
    </div>
    <div class="row ">
        <div class="  col-md-1  " >
            <hr class="catalogo d-none" />
        </div>
        
    </div>
    <div class="row ">
            <?php
            $pocisionSeccion = 0;
            foreach ($archivos as $row) {
                echo '<div id="seccion'.$pocisionSeccion.'"></div>';
                if ($row->tipo != "sec")
                {
                    echo '<div class="  col-md-1  " ></div>';
                    echo '<div class="  col-md-11  " >';
                }
                else
                {
                    //para el borde
                    echo '<div class="  col-md-12  " >';
                }
                
                if ($row->tipo =="p")
                {
                    
                    echo $row->html;
                    
                }
                if ($row->tipo =="img" || $row->tipo =="imgprod")
                {
                    echo '<img src='.$nombreURLAdmin.$row->rutaserver.' style="width:100vw" />';
                }
                if ($row->tipo == "sec")
                {
                    echo '<hr class="catalogo" id="cat'.$row->id.'" />';
                    $pocisionSeccion++;
                }
                echo '</div>';
            }
            ?>
      
    </div>

    <div class="row ">
        <div class="  col-md-1  " >

        </div>
        <div class="  col-md-11  " >

        </div>
    </div>
    <br /><br />
</div>
<div id="politicadesktop"></div>
<script>
    document.getElementById('bordepagina').style.borderTop = 'none';

    document.getElementById('contenedorIndex').style.marginTop = '10px';
    document.getElementById('menu-movil-dorado').style.backgroundColor = 'white';
    document.getElementById('menu-movil-dorado').style.paddingBottom = '0px';

    function  ircatalogo(id){
        let scrollwindows = document.documentElement.scrollTop;
        let bordeCatalogo = document.getElementById('seccion' + id);
        let altocatalogo = bordeCatalogo.offsetTop;
        altocatalogo = altocatalogo - 50;
        console.log("alto", altocatalogo);
        window.scroll({ top: altocatalogo, behavior: 'smooth' });
    }
</script>
</body>
</html>
