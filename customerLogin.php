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

}
else{
    $idiomaActual=$_SESSION["language"];
}
$tipoCambio=20;
$idioma=[ "ESPAÑOL"=>[ "MENU"=>[ "INICIO","ARCHIVO","MARCA","ENGLISH","CARRITO(*)"] ],"ENGLISH"=>[ "MENU"=>[ "HOME","ARCHIVE","IMPRINT","ESPAÑOL","CART(*)" ] ] ];





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
                    overflow-y: overlay;
                }
                .btn:focus {
                    outline: none;
                    box-shadow: none;
                }
                [type='submit']{
                    -webkit-appearance: none!important;  
                }
                #logo{
                    display:inline-block;
                    top:50vh;
                    left: 90vw;
                    width: 7%;
                }
                #t{
                    position:fixed;
                    display:inline-block;
                    top:50vh;
                    left: 2vw;
                    
                }
                
                .small-font{
                    font-size: 0.9em;
                }
                .form-control:focus {
                    box-shadow:  0 1px 1px black, 0 0 3px black;
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
        $fc->Menu($idioma,$idiomaActual,$numeroProductosCarrito,["","","","'","",""]),
        $fc->LogoNegro(),
        $fc->TMenu(""),

        $ui->ContainerFluid([
            $ui->Row([

                $ui->Columns("<label style='font-family: NHaasGroteskDSPro-65Md'>LOGIN</label>",12,0,0,0,"",
                    "text-align:center;margin-top:100px")
            ]),
            $ui->RowSpace("2vh"),
            $ui->Row([
                $ui->Columns("",4),
                $ui->Columns(
                    $ui->Lines([
                        $ui->FormButtom([

                            $fc->BlackInput("EMAIL ADDRESS","login"),
                            $ui->RowSpace("1vh"),
                            $fc->BlackInput("PASSWORD","password"),
                            "<button type='submit' formaction='customerLogin.php?action=forgot' class='btn small-font'>FORGOT YOUR PASSWORD?</button>",
                        ],"","<button class='btn btn-block btn-dark' formaction='customerLogin.php?action=login' type='submit' style='border-radius: 0;background-color: black;'>LOGIN</button>"),
                        $ui->RowSpace("1vh"),
                        $ui->FormButtom([],"","<button class='btn btn-block' formaction='customerLogin.php?action=facebook' type='submit' style='border-radius: 0;border-color: black;background-color: white;margin-top: 1em;font-family: \"NHaasGroteskDSPro-65Md\"'>LOGIN WITH FACEBOOK</button>"),
                        $ui->FormButtom([],"","<button class='btn btn-block' formaction='customerLogin.php?action=facebook' type='submit' style='border-radius: 0;border-color: black;background-color: white;margin-top: 1em;font-family: \"NHaasGroteskDSPro-65Md\"'>LOGIN WITH GOOGLE</button>")

                    ]),
                4,0,0,0,"","text-align:center;"),
                $ui->Columns("",4),
            ]),
            "",
            $ui->Row([

                $ui->Columns("<label style='font-family: NHaasGroteskDSPro-65Md'>CREATE AN ACCOUNT</label>",12,0,0,0,"",
                    "text-align:center;margin-top:100px")
            ]),
            $ui->RowSpace("2vh"),
            $ui->Row([
                $ui->Columns("",4),
                $ui->Columns(
                    $ui->Lines([
                        $ui->FormButtom([

                            $fc->BlackInput("NAME","name"),
                            $ui->RowSpace("1vh"),
                            $fc->BlackInput("LAST NAME","lastname"),
                            $fc->BlackInput("EMAIL ADDRESS","login"),
                            $ui->RowSpace("1vh"),
                            $fc->BlackInput("PASSWORD","password1"),
                            $ui->RowSpace("1vh"),
                            $fc->BlackInput("REPEAT PASSWORD","password2"),
                            $ui->RowSpace("1vh"),
                            "<input class='form-check-input' type='checkbox' name='newsletter' style='border-radius: 10px;border-color: black'> SIGN UP FOR NEWSLETTER</input>",

                        ],"","<button class='btn btn-block btn-dark' formaction='customerLogin.php?action=create' type='submit' style='border-radius: 0;background-color: black;margin-top: 1em;'>CREATE ACCOUNT</button>"),
                    ]),
                    4,0,0,0,"","text-align:center;"),
                $ui->Columns("",4),
            ])


        ]),
        $fc->MenuPrivacyReturn(true,true)



    ],"style='background-color:#FFFFF;' ") //#AC9950
);

print_r($h);

