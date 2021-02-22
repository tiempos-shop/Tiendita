<?php

use Administracion\VistasHtml;
use Tiendita\Utilidades;

include_once "View/Componentes/Administracion/VistasHtml.php";
include_once "Business/Utilidades.php";

$html=new VistasHtml();
$ui=new Utilidades();

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
                }

                div {
                font-family: NHaasGroteskDSPro-55Rg;
                }
            </style>
        ",
        "<script>
                  window.fbAsyncInit = function() {
                    FB.init({
                      appId            : '1794600520762591',
                      autoLogAppEvents : true,
                      xfbml            : true,
                      version          : 'v9.0'
                    });
                    
                    FB.getLoginStatus(function(response) {
                      if (response.status === 'connected') {
                        var uid = response.authResponse.userID;
                        var accessToken = response.authResponse.accessToken;
                      } else if (response.status === 'not_authorized') {
                        alert('Debes aceptar el ingreso a Facebook para iniciar sesión');
                      } else {
                        alert('Tus credenciales de ingreso a facebook no son correctas');
                      }
                    });
                  }
                  
                  function doLogin() 
                  { 
                     FB.login(function(response) 
                     { 
                        if (response.authResponse) { 
                            $(\"idLogin\").hide();
                        } 
                        else 
                        { 
                            alert('Has rechazado la autentificación); 
                        } 
                     }, {scope: 'email,user_friends'}); 
                  } 
                  
                </script>"

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
        $ui->ContainerFluid([
            $ui->Row([
                $ui->Columns(
                    "<span>SHOP<span>",
                    3,0,0,0,""
                ),
                $ui->Columns(
                    "<span>PROJECTS</span>",
                    3,0,0,0,""
                ),
                $ui->Columns(
                    "<span>IMPRINT<span>",
                    3,0,0,0,""
                ),
                $ui->Columns(
                    "<span>TERMS<span>",
                    2,0,0,0,""
                ),
                $ui->Columns(
                    "<span>CART(0)<span>",
                    1,0,0,0,""
                )

            ]),

            $ui->Row([
                $ui->Columns(
                    "<br/><br/><img width='350px' src='img/0001-OBSIDIANA.jpg'><br/><br/><br/><br/>BLACK<br/><br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><img width='350px' src='img/0014-PERLA.jpg'><br/><br/><br/><br/>CREMA<br/><br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><img width='350px' src='img/0009-QUETZAL.jpg'><br/><br/><br/><br/>DARK BLUE<br/><br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><img width='350px' src='img/0007-SOL.jpg'><br/><br/><br/><br/>DARK ORANGE<br/><br/>",
                    3,0,0,0,"text-center"
                )
            ]),
            $ui->Row([
                $ui->Columns(
                    "<br/><br/><img width='350px' src='img/0012-GILARDI.jpg'><br/><br/><br/><br/>EGG YELLOW<br/><br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><img width='350px' src='img/0000-JALAPEÑO.jpg'><br/><br/><br/><br/>FLAG GREEN<br/><br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><img width='350px' src='img/0002-TACUBAYA.jpg'><br/><br/><br/><br/>FLUORESCENT PINK<br/><br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><img width='350px' src='img/0011-ESTRELLA.jpg'><br/><br/><br/><br/>FLUORESCENT YELLOW<br/><br/>",
                    3,0,0,0,"text-center"
                )
            ]),
            $ui->Row([
                $ui->Columns(
                    "<br/><br/><img width='350px' src='img/0013-LUNA.jpg'><br/><br/><br/><br/>GRAY FRONT<br/><br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><img width='350px' src='img/0016-MEDIA-NOCHE.jpg'><br/><br/><br/><br/>GRAY BLUE<br/><br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><img width='350px' src='img/0005-BETABEL.jpg'><br/><br/><br/><br/>GUINDA<br/><br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><img width='350px' src='img/0003-AÑIL.jpg'><br/><br/><br/><br/>KING BLUE<br/><br/>",
                    3,0,0,0,"text-center"
                )
            ]),
            $ui->Row([
                $ui->Columns(
                    "<br/><br/><img width='350px' src='img/0010-FLAMA.jpg'><br/><br/><br/><br/>LIGHT ORANGE<br/><br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><img width='350px' src='img/0006-AURORA.jpg'><br/><br/><br/><br/>LIGHT YELLOW<br/><br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><img width='350px' src='img/0015-VALDIOSERA.jpg'><br/><br/><br/><br/>PINK CARAMEL<br/><br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><img width='350px' src='img/0008-NEBLINA.jpg'><br/><br/><br/><br/>SKY BLUE<br/><br/>",
                    3,0,0,0,"text-center"
                )
            ]),
            $ui->Row([
                $ui->Columns(
                    "<br/><br/><img width='350px' src='img/0004-AGAVE.jpg'><br/><br/><br/><br/>TURQUOSE<br/><br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>",
                    3,0,0,0,"text-center"
                )
            ]),
        ])
    //],"style='background-color:white;' ")
    ],"style='background-color:#FFFFF;' ") //#AC9950
);

print_r($h);
