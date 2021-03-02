<?php




use Administracion\VistasHtml;
use Tiendita\EntidadBase;
use Tiendita\Utilidades;

include_once "View/Componentes/Administracion/VistasHtml.php";
include_once "Business/Utilidades.php";
include_once "Data/Connection/EntidadBase.php";


$html=new VistasHtml();
$ui=new Utilidades();
$db=new EntidadBase();
//$id=$_GET["id"];

$idiomaActual="";

if(count($_POST)>0)
    $idiomaActual=$_POST["language"];
else
    $idiomaActual="ENGLISH";

$tipoCambio=20;
$idioma=[ "ESPAÑOL"=>[ "MENU"=>[ "INICIO","ARCHIVO","MARCA","ENGLISH","CARRITO(*)"] ],"ENGLISH"=>[ "MENU"=>[ "HOME","ARCHIVE","IMPRINT","ESPAÑOL","CART(*)" ] ] ];

$price=0;
$tipoCambio=20;
//$productInformation=$products=$db->getBy("Productos","Clave",$id)[0];

if($idiomaActual=="ENGLISH"){


}
else{

}


//$images=explode(",",$productInformation->RutaImagen);
$collage="";

//echo "<pre>";
//var_dump($productInformation);
//echo "</pre>";

$modal="
<table class='table'>
    <thead>
        <tr>
            <td></td>
            <th>S</th>
            <th>M</th>
            <th>L</th>
            <th>XL</th>
        </tr>
    </thead>
    <tr>
        <td>HEIGHT</td>
        <td>26</td>
        <td>27</td>
        <td>29</td>
        <td>30</td>
    </tr>
    <tr>
        <td>SHOULDER</td>
        <td>22</td>
        <td>23</td>
        <td>25</td>
        <td>27</td>
    </tr>
    <tr>
        <td>BACK</td>
        <td>26</td>
        <td>28</td>
        <td>30</td>
        <td>32</td>
    </tr>
    <tr>
        <td>CHEST</td>
        <td>18</td>
        <td>20</td>
        <td>22</td>
        <td>24</td>
    </tr>
    <tr>
        <td>SLEEVE</td>
        <td>26</td>
        <td>28</td>
        <td>30</td>
        <td>32</td>
    </tr>
    <tr>
        <td>EUROPEAN SIZE</td>
        <td>46</td>
        <td>48</td>
        <td>50</td>
        <td>52</td>
    </tr>
</table>";

$db->close();
$htmlProducts="";

$h= $html->Html5(
    $html->Head(
        "Tiempos Shop",
        $html->Meta("utf-8","Tienda Online de Tiempos Shop","Egil Ordonez"),
        $html->LoadStyles(["View/css/bootstrap.css","https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"]),
        $html->LoadScripts(["View/js/bootstrap.js"]),
        "
            <style>
                span:hover{
                    cursor: pointer;
                }
                span:hover::after{
                    content: \"'\";
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

                body,button {
                    font-family: NHaasGroteskDSPro-55Rg;
                    letter-spacing:0.09em;
                }
                .left-top{
                    position: fixed;
                    left: 50vw;
                }
                .space{
                    position: relative;
                    display:inline-block; 
                    width:30px; 
                }
                #logo{
                    display:inline-block;
                    top:50vh;
                    left: 90vw;
                    width: 7%
                }
                
            </style>
        ",
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

    ),
    $html->Body([
        // Load Facebook button
        "
            <div id=\"fb-root\"></div>
            <script async defer 
                crossorigin=\"anonymous\" 
                src=\"https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v9.0&appId=1794600520762591&autoLogAppEvents=1\" 
                nonce=\"wlJTE7aj\">
            </script>",
        "<div class='fixed-top' style='padding-top:2vh;padding-bottom:2vh;padding-left: 2vw;padding-right: 2vw'>",
        $ui->Row([
            $ui->Columns(
                "<span onclick='go(\"shop.php\")'>".$idioma[ $idiomaActual ]["MENU"][0]."<span>",
                3,0,0,0,""
            ),
            $ui->Columns(
                "<span>".$idioma[ $idiomaActual ]["MENU"][1]."</span>",
                3,0,0,0,""
            ),
            $ui->Columns(
                "<span>".$idioma[ $idiomaActual ]["MENU"][2]."<span>",
                3,0,0,0,""
            ),
            $ui->Columns(
                FormLink(
                    [
                        $ui->Input("language","",$idioma[ $idiomaActual ]["MENU"][3],"F",true),
                    ],
                    "",
                    $idioma[ $idiomaActual ]["MENU"][3]

                ),
                2,0,0,0,""
            ),
            $ui->Columns(
                "<span>".Cart(4,$idioma[ $idiomaActual ]["MENU"][4])."<span>",
                1,0,0,0,""
            )
        ]),
        "</div>",
        "<img id='logo' class='fixed-top' src='img/ts_iso_negro.png' style='width: 7%'></img>",
        "<br/>",
        $ui->ContainerFluid([
            $ui->Row([
                $ui->Columns("<hr/>",12)
            ]),
            $ui->Row([
                $ui->Columns("<hr/>",12)
            ]),
            $ui->Row([
                $ui->Columns("<hr/>",12)
            ])

        ]),
        '
        <div class="modal fade" id="size" tabindex="-1" role="dialog" aria-labelledby="sizeLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="sizeLabel"><span>CM</span><div class="space"></div><span>IN</span></h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                  X
                </button>
              </div>
              <div class="modal-body">
                '.$modal.'
              </div>
              
            </div>
          </div>
        </div>
        '


    ],"style='background-color:#FFFFF;' ") //#AC9950
);

print_r($h);

function FormLink(array $content,string $url,string $button){
    $html= "
            <form method='post' action='$url'>";
    $html.=implode("",$content);
    $html.='
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-link" style="text-decoration: none;color:black;padding: 0px;border: none"><span type="submit">'.$button.'</span></button>
                    </div>
                </div>
            </form>';
    return $html;
}

function Cart($number,$label):string
{
    return str_replace("*",$number,$label);
}
