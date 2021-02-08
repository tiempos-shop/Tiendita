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
        "",
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
                    $ui->Button("btn","SHOP"),
                    3,0,0,0,""
                ),
                $ui->Columns(
                    "PROJECTS",
                    3,0,0,0,""
                ),
                $ui->Columns(
                    "IMPRINT",
                    3,0,0,0,""
                ),
                $ui->Columns(
                    "TERMS",
                    2,0,0,0,""
                ),
                $ui->Columns(
                    $ui->ModalButtonNormal("idLogin","LOGIN","","Login de Cliente","Cerrar",
                    $ui->Form([
                        $ui->FacebookButton("doLogin()"),"<br/><br/>",
                        $ui->Input("CorreoElectronico","Correo Electronico","","@",true),
                        $ui->Input("Password","Password","","?",true),
                        $ui->ActionButton("btn btn-sm","<u>Registrarse como cliente</u>>","window.location.href = \"registroClientes.php\";")
                    ],"","ACCESS")
                    ),
                    1,0,0,0,""
                )

            ]),
            $ui->Row([
                $ui->Columns(
                    "ALL'",
                    3,0,0,0,""
                ),
                $ui->Columns(
                    "TOPS",
                    3,0,0,0,""
                ),
                $ui->Columns(
                    "ACCESORIES",
                    3,0,0,0,""
                ),
                $ui->Columns(
                    "TWP",
                    2,0,0,0,""
                ),
                $ui->Columns(
                    $ui->ActionButton("btn","BAG","window.location.href = \"bag.php\";"),
                    1,0,0,0,""
                )

            ]),
            $ui->Row([
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><img width='350px' src='img/0001-BLACK.jpg'><br/><br/><br/><br/>BLACK<br/>".$ui->ActionButton("btn","<i class=\"fa fa-shopping-bag\"></i> ADD TO BAG","alert(\"ADDED TO BAG\");")."<br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><img width='350px' src='img/0002-CREMA.jpg'><br/><br/><br/><br/>CREMA<br/>".$ui->ActionButton("btn","<i class=\"fa fa-shopping-bag\"></i> ADD TO BAG","alert(\"ADDED TO BAG\");")."<br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><img width='350px' src='img/0003-DARK_BLUE.jpg'><br/><br/><br/><br/>DARK BLUE<br/>".$ui->ActionButton("btn","<i class=\"fa fa-shopping-bag\"></i> ADD TO BAG","alert(\"ADDED TO BAG\");")."<br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><img width='350px' src='img/0004-DARK_ORANGE.jpg'><br/><br/><br/><br/>DARK ORANGE<br/>".$ui->ActionButton("btn","<i class=\"fa fa-shopping-bag\"></i> ADD TO BAG","alert(\"ADDED TO BAG\");")."<br/>",
                    3,0,0,0,"text-center"
                )
            ]),
            $ui->Row([
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><img width='350px' src='img/0005-EGG_YELLOW.jpg'><br/><br/><br/><br/>EGG YELLOW<br/>".$ui->ActionButton("btn","<i class=\"fa fa-shopping-bag\"></i> ADD TO BAG","alert(\"ADDED TO BAG\");")."<br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><img width='350px' src='img/0006-FLAG_GREEN.jpg'><br/><br/><br/><br/>FLAG GREEN<br/>".$ui->ActionButton("btn","<i class=\"fa fa-shopping-bag\"></i> ADD TO BAG","alert(\"ADDED TO BAG\");")."<br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><img width='350px' src='img/0007-FLUORESCENT_PINK.jpg'><br/><br/><br/><br/>FLUORESCENT PINK<br/>".$ui->ActionButton("btn","<i class=\"fa fa-shopping-bag\"></i> ADD TO BAG","alert(\"ADDED TO BAG\");")."<br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><img width='350px' src='img/0008-FLUORESCENT_YELLOW.jpg'><br/><br/><br/><br/>FLUORESCENT YELLOW<br/>".$ui->ActionButton("btn","<i class=\"fa fa-shopping-bag\"></i> ADD TO BAG","alert(\"ADDED TO BAG\");")."<br/>",
                    3,0,0,0,"text-center"
                )
            ]),
            $ui->Row([
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><img width='350px' src='img/0009-GRAY_FRONT.jpg'><br/><br/><br/><br/>GRAY FRONT<br/>".$ui->ActionButton("btn","<i class=\"fa fa-shopping-bag\"></i> ADD TO BAG","alert(\"ADDED TO BAG\");")."<br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><img width='350px' src='img/0010-GRAY_BLUE.jpg'><br/><br/><br/><br/>GRAY BLUE<br/>".$ui->ActionButton("btn","<i class=\"fa fa-shopping-bag\"></i> ADD TO BAG","alert(\"ADDED TO BAG\");")."<br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><img width='350px' src='img/0011-GUINDA.jpg'><br/><br/><br/><br/>GUINDA<br/>".$ui->ActionButton("btn","<i class=\"fa fa-shopping-bag\"></i> ADD TO BAG","alert(\"ADDED TO BAG\");")."<br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><img width='350px' src='img/0012-KING_BLUE.jpg'><br/><br/><br/><br/>KING BLUE<br/>".$ui->ActionButton("btn","<i class=\"fa fa-shopping-bag\"></i> ADD TO BAG","alert(\"ADDED TO BAG\");")."<br/>",
                    3,0,0,0,"text-center"
                )
            ]),
            $ui->Row([
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><img width='350px' src='img/0013-LIGHT_ORANGE.jpg'><br/><br/><br/><br/>LIGHT ORANGE<br/>".$ui->ActionButton("btn","<i class=\"fa fa-shopping-bag\"></i> ADD TO BAG","alert(\"ADDED TO BAG\");")."<br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><img width='350px' src='img/0014-LIGHT_YELLOW.jpg'><br/><br/><br/><br/>LIGHT YELLOW<br/>".$ui->ActionButton("btn","<i class=\"fa fa-shopping-bag\"></i> ADD TO BAG","alert(\"ADDED TO BAG\");")."<br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><img width='350px' src='img/0015-PINK_CARAMEL.jpg'><br/><br/><br/><br/>PINK CARAMEL<br/>".$ui->ActionButton("btn","<i class=\"fa fa-shopping-bag\"></i> ADD TO BAG","alert(\"ADDED TO BAG\");")."<br/>",
                    3,0,0,0,"text-center"
                ),
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><img width='350px' src='img/0016-SKY_BLUE.jpg'><br/><br/><br/><br/>SKY BLUE<br/>".$ui->ActionButton("btn","<i class=\"fa fa-shopping-bag\"></i> ADD TO BAG","alert(\"ADDED TO BAG\");")."<br/>",
                    3,0,0,0,"text-center"
                )
            ]),
            $ui->Row([
                $ui->Columns(
                    "<br/><br/><br/><br/><br/><br/><img width='350px' src='img/0017-TURQUOSE.jpg'><br/><br/><br/><br/>TURQUOSE<br/>".$ui->ActionButton("btn","<i class=\"fa fa-shopping-bag\"></i> ADD TO BAG","alert(\"ADDED TO BAG\");")."<br/>",
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
