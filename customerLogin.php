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

    if(isset($_GET["action"])){
        $action=$_GET["action"];
        switch ($action){
            case "login":
                $realPassword="";
                $email=$_POST["login"];
                $password=$_POST["password"];
                $clienteTable=$db->getBy("Clientes","CorreoElectronico",$email);

                if(count($clienteTable)>0){
                    $realPassword=$clienteTable[0]->Password;

                }
                if($realPassword===$password){
                    $_SESSION["LOGGED"]="NORMAL";
                    $ui->Redirect("checkout.php");
                }
                break;

            case "forgot":
                break;
            case "facebook":
                break;
            case "google":
                break;
            case "create":
                break;
        }
    }

}
else{
    $idiomaActual=$_SESSION["language"];
}
$tipoCambio=20;
$idioma=
    [
        "ESPAÑOL"=>[
            "MENU"=>[ "INICIO","ARCHIVO","MARCA","ENGLISH","CARRITO(*)"],
            "LOGIN" => [ "ACCESO","CORREO ELECTRÓNICO","CONTRASEÑA","OLVIDASTE TU CONTRASEÑA?","ACCESO CON FACEBOOK","ACCESO CON GOOGLE" ],
            "CREAR" => [ "CREAR CUENTA","NOMBRE","APELLIDO(S)","CORREO ELECTRÓNICO","CONTRASEÑA","REPETIR CONTRASEÑA"," SUSCRIBIRSE AL NEWSLETTER" ]
        ],
        "ENGLISH"=>[
            "MENU"=>[ "HOME","ARCHIVE","IMPRINT","ESPAÑOL","CART(*)" ],
            "LOGIN" => [ "LOGIN","EMAIL ADDRES","PASSWORD","FORGOT YOUR PASSWORD?","LOGIN WITH FACEBOOK","LOGIN WITH GOOGLE" ],
            "CREAR" => [ "CREATE AN ACCOUNT","NAME","LAST NAME","EMAIL ADDRESS","PASSWORD","REPEAT PASSWORD"," SIGN UP FOR NEWSLETTER" ]
        ]
    ];




$h= $html->Html5(
    $html->Head(
        "Tiempos Shop",
        $html->Meta("utf-8","Tienda Online de Tiempos Shop","Egil Ordonez"),
        $html->LoadStyles(["global.css","View/css/bootstrap.css","https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"]),
        $html->LoadScripts(["View/js/bootstrap.js"]),
        "
            <style>
                
                .btn:focus {
                    outline: none;
                    box-shadow: none;
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

                $ui->Columns("<label style='font-family: NHaasGroteskDSPro-65Md'>".$idioma[$idiomaActual]["LOGIN"][0]."</label>",12,0,0,0,"",
                    "text-align:center;margin-top:100px")
            ]),
            $ui->RowSpace("2vh"),
            $ui->Row([
                $ui->Columns("",4),
                $ui->Columns(
                    $ui->Lines([
                        $ui->FormButtom([

                            $fc->BlackInput($idioma[$idiomaActual]["LOGIN"][1],"login"),
                            $ui->RowSpace("1vh"),
                            $fc->BlackInput($idioma[$idiomaActual]["LOGIN"][2],"password",true),
                            "<button type='submit' formaction='customerLogin.php?action=forgot' class='btn small-font'>".$idioma[$idiomaActual]["LOGIN"][3]."</button>",
                        ],"","<button class='btn btn-block btn-dark' formaction='customerLogin.php?action=login' type='submit' style='border-radius: 0;background-color: black;'>".$idioma[$idiomaActual]["LOGIN"][0]."</button>"),
                        $ui->RowSpace("1vh"),
                        $ui->FormButtom([],"","<button class='btn btn-block' formaction='customerLogin.php?action=facebook' type='submit' style='border-radius: 0;border-color: black;background-color: white;margin-top: 1em;font-family: \"NHaasGroteskDSPro-65Md\"'>".$idioma[$idiomaActual]["LOGIN"][4]."</button>"),
                        $ui->FormButtom([],"","<button class='btn btn-block' formaction='customerLogin.php?action=google' type='submit' style='border-radius: 0;border-color: black;background-color: white;margin-top: 1em;font-family: \"NHaasGroteskDSPro-65Md\"'>".$idioma[$idiomaActual]["LOGIN"][5]."</button>")

                    ]),
                4,0,0,0,"","text-align:center;"),
                $ui->Columns("",4),
            ]),
            "",
            $ui->Row([

                $ui->Columns("<label style='font-family: NHaasGroteskDSPro-65Md'>".$idioma[$idiomaActual]["CREAR"][0]."</label>",12,0,0,0,"",
                    "text-align:center;margin-top:100px")
            ]),
            $ui->RowSpace("2vh"),
            $ui->Row([
                $ui->Columns("",4),
                $ui->Columns(
                    $ui->Lines([
                        $ui->FormButtom([

                            $fc->BlackInput($idioma[$idiomaActual]["CREAR"][1],"name"),
                            $ui->RowSpace("1vh"),
                            $fc->BlackInput($idioma[$idiomaActual]["CREAR"][2],"lastname"),
                            $ui->RowSpace("1vh"),
                            $fc->BlackInput($idioma[$idiomaActual]["CREAR"][3],"login"),
                            $ui->RowSpace("1vh"),
                            $fc->BlackInput($idioma[$idiomaActual]["CREAR"][4],"password1",true),
                            $ui->RowSpace("1vh"),
                            $fc->BlackInput($idioma[$idiomaActual]["CREAR"][5],"password2",true),
                            $ui->RowSpace("1vh"),
                            "<input class='form-check-input' type='checkbox' id='newsletter' name='newsletter' style='border-radius: 10px;border-color: black'>".$idioma[$idiomaActual]["CREAR"][6]."</input>",

                        ],"","<button class='btn btn-block btn-dark' formaction='customerLogin.php?action=create' type='submit' style='border-radius: 0;background-color: black;margin-top: 1em;'>".$idioma[$idiomaActual]["CREAR"][0]."</button>"),
                    ]),
                    4,0,0,0,"","text-align:center;"),
                $ui->Columns("",4),
            ])


        ]),
        $fc->MenuPrivacyReturn(true,true)



    ],"style='background-color:#FFFFF;' ") //#AC9950
);

print_r($h);

