<?php

use Administracion\VistasHtml;
use Tiendita\EntidadBase;
use Tiendita\FrontComponents;
use Tiendita\Utilidades;


include_once "View/Componentes/Administracion/VistasHtml.php";
include_once "Business/Utilidades.php";
include_once "Data/Connection/EntidadBase.php";
include_once "Business/FrontComponents.php";
include_once "Data/Models/Clientes.php";
include_once "Data/Models/ModeloClientes.php";

$fc=new FrontComponents();
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
if(count($_POST)>0) {
    if (isset($_POST["language"])) {
        $idiomaActual = $_POST["language"];
        $_SESSION["language"] = $idiomaActual;
    } else {
        $idiomaActual = $_SESSION["language"];
    }

    if (isset($_GET["action"])) {
        $action = $_GET["action"];
        switch ($action) {
            case "login":
                $realPassword = "";
                $email = $_POST["login"];
                $password = $_POST["password"];
                $clienteTable = $db->getBy("Clientes", "CorreoElectronico", $email);

                if (count($clienteTable) > 0) {
                    $realPassword = $clienteTable[0]->Password;

                }
                if ($realPassword === $password) {
                    $_SESSION["LOGGED"] = "NORMAL";
                    $ui->Redirect("checkout.php");
                }
                break;

            case "forgot":
                break;
            case "facebook":

                $name = $_POST["name"];
                $lastname = $_POST["lastname"];
                $login = $_POST["email"];
                $password1 = $_POST["password1"];
                //$datos = $_POST;

                $mensaje = "<h2>Registro de Nuevo Cliente</h2>
                    <h3>$name $lastname</h3>
                    <p>Se registro el cliente con el password: $password1</p>
                    <br/>
                    <b>Saludos Cordiales</b>
                    <b>El equipo de tiempos Shop</b>";
                    //$mail = $ui->SendMail("Tiempos Shop", "informes@softquimia.com", $login, "Registro de Cliente Tiempos Shop", $mensaje)
                    //if ($mail) {
                        $cliente = new \Tiendita\Clientes();
                        $cliente->Nombre = $name;
                        $cliente->Apellidos = $lastname;
                        $cliente->FechaCambio = $ui->FechaHoy();
                        $cliente->CorreoElectronico = $login;
                        $cliente->IdTipoMovimiento = 1;
                        $cliente->IdUsuarioBase = 1;
                        $cliente->Password = $password1;

                        try {
                            $sql = \Tiendita\ModeloBase::GetInsert($cliente, "Clientes", \Tiendita\Clientes::getProperties());
                            $db->AddQuerys($sql);
                            $db->SaveAll();
                        } catch (mysqli_sql_exception $exception) {
                            $ui->Debug($exception);
                        }
                        echo "<script>alert('Solicitud correcta. Se envio un correo a $login.')</script>";
                        $_SESSION["LOGGED"] = "NORMAL";
                        exit(0);
                        $ui->Redirect("checkout.php");
                    //} else {
                       // echo "<script>alert('Error en el servidor de correos')</script>";
                    //}

                break;

            case "google":
                break;
            case "create":

                $name = $_POST["name"];
                $lastname = $_POST["lastname"];
                $login = $_POST["login"];
                $password1 = $_POST["password1"];
                $password2 = $_POST["password2"];
                if (isset($_POST["newsletter"])) {
                    $newsletter = true;
                    $news = "Adicionalmente se solicito el servicio de Newsletter.";
                } else {
                    $newsletter = false;
                    $news = "No se solicitó el servicio de Newsletter.";
                };
                $mensaje = "<h2>Registro de Nuevo Cliente</h2>
                    <h3>$name $lastname</h3>
                    <p>Se registro el cliente con el password: $password1</p>
                    <br/>
                    <p>$news</p>
                    <b>Saludos Cordiales</b>
                    <b>El equipo de tiempos Shop</b>";

                if ($password1 === $password2) {
                    //$ui->Debug($mensaje);
                    //$ui->Debug($login);
                    $mail = $ui->SendMail("Tiempos Shop", "informes@softquimia.com", $login, "Registro de Cliente Tiempos Shop", $mensaje);
                    if ($mail) {
                        $cliente = new \Tiendita\Clientes();
                        $cliente->Nombre = $name;
                        $cliente->Apellidos = $lastname;
                        $cliente->FechaCambio = $ui->FechaHoy();
                        $cliente->CorreoElectronico = $login;
                        $cliente->IdTipoMovimiento = 1;
                        $cliente->IdUsuarioBase = 1;
                        $cliente->Password = $password1;

                        try {
                            $sql = \Tiendita\ModeloBase::GetInsert($cliente, "Clientes", \Tiendita\Clientes::getProperties());
                            $db->AddQuerys($sql);
                            $db->SaveAll();
                        } catch (mysqli_sql_exception $exception) {
                            $ui->Debug($exception);
                        }
                        echo "<script>alert('Solicitud correcta. Se envio un correo a $login.')</script>";
                        $_SESSION["LOGGED"] = "NORMAL";
                        $ui->Redirect("checkout.php");
                    } else {
                        echo "<script>alert('Error en el servidor de correos')</script>";
                    }
                } else {
                    echo "<script>alert('Los password no coinciden')</script>";
                }

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
        $html->LoadScripts(["vendor/jquery/jquery.js","View/js/bootstrap.js"]),
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
                  function seteyePassword (e) {
                      const input = document.getElementById("password");
                      const eye = e.querySelector(".fa");
                      if(eye.classList.contains("fa-eye-slash")){
                          eye.classList.add("fa-eye");
                          eye.classList.remove("fa-eye-slash");
                          input.type = "text";
                      }else{
                          input.type = "password";
                          eye.classList.add("fa-eye-slash");
                          eye.classList.remove("fa-eye");
                      }
                  }
                  function passwordValidate(){
                      let password1=document.getElementById("password1");
                      let password2=document.getElementById("password2");
                      if(password1.value===password2.value){
                          password1.style.borderColor="black";
                          password2.style.borderColor="black";
                          return true;
                      }
                      else {
                          password1.style.borderColor="red";
                          password2.style.borderColor="red";
                          return false;
                      }
                  }

                  window.fbAsyncInit = function() {
                    FB.init({
                      appId      : "836095217243492",
                      cookie     : true,
                      xfbml      : true,
                      version    : "v11.0"
                    });
                    
                      
                    FB.AppEvents.logPageView();   
                      
                  };
                
                  (function(d, s, id){
                     var js, fjs = d.getElementsByTagName(s)[0];
                     if (d.getElementById(id)) {return;}
                     js = d.createElement(s); js.id = id;
                     js.src = "https://connect.facebook.net/en_US/sdk.js";
                     fjs.parentNode.insertBefore(js, fjs);
                   }(document, "script", "facebook-jssdk"));

                  
                  function loginFacebook () {
                        FB.login( function (response) {
                            if (response.authResponse) {
                                FB.api("/me?fields=id,email,name,last_name", function (response){                        
                                    alert("Gracias " + response.id + " por autorizar a Tiempos Shop el uso de tus datos en facebook, haremos uso de tu correo " + response.email + " para tu registro.");
                                    console.log(response);
                                    const email = document.getElementById("email");
                                    const name = document.getElementById("name");
                                    const lastname = document.getElementById("lastname");
                                   const password1 = document.getElementById("password1");
                                    email.value = response.email;
                                    name.value = response.name;
                                    lastname.value = response.last_name;
                                    password1.value = response.id;
                                    document.getElementById("formFacebook").submit();
                                });
                            } 
                            else 
                            {
                                alert("El usuario no autorizó.");
                            }
                        },{scope: "public_profile,email"});   
                  }
                  
                </script>'

    ),
    $html->Body([
        // Load Facebook button
        "
            <div id=\"fb-root\"></div>
            <script src='https://connect.facebook.net/en_US/sdk.js' nonce='orILiGEB'></script>
            
        ",
        $fc->Menu($idioma,$idiomaActual,$numeroProductosCarrito,["","","","'","",""]),
        $fc->LogoNegro(),
        //$fc->TMenu(2),

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
                            $fc->BlackInputEye($idioma[$idiomaActual]["LOGIN"][2],"password",true),
                            "<button type='submit' formaction='customerLogin.php?action=forgot' class='btn small-font'>".$idioma[$idiomaActual]["LOGIN"][3]."</button>",
                        ],"","<button class='btn btn-block btn-dark' formaction='customerLogin.php?action=login' type='submit' style='border-radius: 0;background-color: black;'>".$idioma[$idiomaActual]["LOGIN"][0]."</button>"),
                        $ui->RowSpace("1vh"),
                        //"<button onclick='return loginFacebook()' class='btn btn-block' style='border-radius: 0;border-color: black;background-color: white;margin-top: 1em;font-family: \"NHaasGroteskDSPro-65Md\"'>".$idioma[$idiomaActual]["LOGIN"][4]."</button>",
                        $ui->FormButtom(
                            [
                                $ui->Input("email","","","F",false),
                                $ui->Input("name","","","F",false),
                                $ui->Input("lastname","","","F",false),
                                $ui->Input("password1","","","F",false),
                            ],
                            "customerLogin.php?action=facebook",
                            "<button type='button' onclick='loginFacebook(this)' class='btn btn-block' style='border-radius: 0;border-color: black;background-color: white;margin-top: 1em;font-family: \"NHaasGroteskDSPro-65Md\"'>".$idioma[$idiomaActual]["LOGIN"][4]."</button>",
                            "formFacebook"),
                        //$ui->FormButtom([ ],"","<button class='btn btn-block' formaction='customerLogin.php?action=google' type='submit' style='border-radius: 0;border-color: black;background-color: white;margin-top: 1em;font-family: \"NHaasGroteskDSPro-65Md\"'>".$idioma[$idiomaActual]["LOGIN"][5]."</button>")

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

                            $fc->BlackInputType($idioma[$idiomaActual]["CREAR"][1],"name","text",true),
                            $ui->RowSpace("1vh"),
                            $fc->BlackInputType($idioma[$idiomaActual]["CREAR"][2],"lastname","text"),
                            $ui->RowSpace("1vh"),
                            $fc->BlackInputType($idioma[$idiomaActual]["CREAR"][3],"login","email"),
                            $ui->RowSpace("1vh"),
                            $fc->BlackInputTypeAttrib($idioma[$idiomaActual]["CREAR"][4],"password1","password",true,"onkeyup='passwordValidate()'"),
                            $ui->RowSpace("1vh"),
                            $fc->BlackInputTypeAttrib($idioma[$idiomaActual]["CREAR"][5],"password2","password",true,"onkeyup='passwordValidate()'"),
                            $ui->RowSpace("1vh"),
                            "<input class='form-check-input' type='checkbox' id='newsletter' name='newsletter' style='border-radius: 10px;border-color: black'>".$idioma[$idiomaActual]["CREAR"][6]."</input>",

                        ],"","<button class='btn btn-block btn-dark' onclick='return passwordValidate()' formaction='customerLogin.php?action=create' type='submit' style='border-radius: 0;background-color: black;margin-top: 1em;'>".$idioma[$idiomaActual]["CREAR"][0]."</button>"),
                    ]),
                    4,0,0,0,"","text-align:center;"),
                $ui->Columns("",4),
            ])


        ]),
        $fc->MenuPrivacyReturn(true,true)



    ],"style='background-color:#FFFFF;' ") //#AC9950
);

print_r($h);

