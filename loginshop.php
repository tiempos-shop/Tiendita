<?php

use Administracion\VistasHtml;



include_once "View/Componentes/Administracion/VistasHtml.php";

$html = new VistasHtml();
session_start();


if(!$html->ValidarSession())
{
    header("Location: shoptienda.php", TRUE, 301);
    exit();
}

$h = $html->Html5(
    $html->Head(
        "Tiempos Shop",
        $html->Meta("utf-8", "Tienda Online de Tiempos Shop", "Egil Ordonez"),
        $html->LoadStyles(["global.css", "View/css/bootstrap.css", "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"]),
        $html->LoadScripts(["vendor/jquery/jquery.js", "js/axios.min.js", "View/js/bootstrap.js", "js/vue.js", "js/global.js"]),
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
                                    //document.getElementById("formFacebook").submit();
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
    "style='background-color:#FFFFF;' "
); //#AC9950

print_r($h);

require_once('menu.php');
?>

<img onclick='go("index.php")' alt='SP' id='logo' class='fixed-top' src='img/ts_iso_negro.png' style='width: 7%'>
<div class="container-fluid" id="app">
    <div class="row ">
        <div class='  col-md-12  ' style='text-align:center;margin-top:100px'>
            <label style='font-family: NHaasGroteskDSPro-65Md'>LOGIN</label>
        </div>
    </div>
    <div class="row ">
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:2vh'>

        </div>
    </div>
    <div class="row ">
        <div class='  col-md-4  '>

        </div>
        <div class='  col-md-4  ' style='text-align:center;'>
            
            <input type="hidden"  class="form-control" value="<?php  echo isset($_SESSION["idCliente"]) ? $_SESSION["idCliente"] : '' ?>" id="idCliente">

            <input class='form-control' name='login' id='login' maxlength='999999' 
                placeholder='EMAIL ADDRES' v-model="login.email"
                style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em' />
                <div class="row ">
                    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:1vh'>

                    </div>
                </div>
                <div class='input-group'>
                    <input type='password' class='form-control' name='password' 
                        id='password' placeholder='PASSWORD' v-model="login.password"
                        style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em'>
                        <a href='#' onclick='seteyePassword(this);' style='position: absolute; right: 10px;z-index: 99;top: 2px;'>
                        <i class='fa fa-eye-slash' style='color: black;' aria-hidden='true'></i></a>
                </div>
                <button   class='btn small-font'>FORGOT
                    YOUR PASSWORD?</button>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <button class='btn btn-block ' :class="!status.inicioConfirmado ? 'btn-dark' : ''"   
                            style='border-radius: 0;'
                            :disabled="status.iniciando || status.inicioConfirmado"
                            @click="Iniciar()">LOGIN</button>
                    </div>
                </div>
            
            <div class="row ">
                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:1vh'>

                </div>
            </div>

            <form  id="formFacebook">
                <input type="hidden" value="" name="email" id="email" v-model="cliente.email">
                <input type="hidden" value="" name="name" id="name" v-model="cliente.name">
                <input type="hidden" value="" name="lastname" id="lastname" v-model="cliente.lastname">
                <input type="hidden" value="" name="password1" id="password1" v-model="cliente.password1">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <button  onclick='return loginFacebook()' class='btn btn-block' style='border-radius: 0;border-color: black;background-color: white;margin-top: 1em;font-family: "NHaasGroteskDSPro-65Md"'>LOGIN
                            WITH FACEBOOK</button>
                    </div>
                </div>
            </form>

            <form method='post' action=''>
                <div class="form-group row">
                    <div class="col-sm-12">
                      <!--  <button class='btn btn-block' formaction='customerLogin.php?action=google'  style='border-radius: 0;border-color: black;background-color: white;margin-top: 1em;font-family: "NHaasGroteskDSPro-65Md"'>LOGIN
                            WITH GOOGLE</button> -->
                    </div>
                </div>
            </form>
        </div>

    </div>
    <div class="row ">
        <div class='  col-md-12  ' style='text-align:center;margin-top:100px'>
            <label style='font-family: NHaasGroteskDSPro-65Md'>CREATE AN ACCOUNT</label>
        </div>
    </div>
    <div class="row ">
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:2vh'>

        </div>
    </div>
    <div class="row ">
        <div class='  col-md-4  '>

        </div>
        <div class='  col-md-4  ' style='text-align:center;'>

            
                <input required type='text' class='form-control' name='name' placeholder='NAME' v-model="cliente.name" style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em' />
                <div class="row ">
                    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:1vh'>

                    </div>
                </div>
                <input type='text' class='form-control' name='lastname' placeholder='LAST NAME' v-model="cliente.lastname" style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em' />
                <div class="row ">
                    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:1vh'>

                    </div>
                </div>
                <input type='email' class='form-control' name='login' placeholder='EMAIL ADDRESS' 
                    v-model="cliente.email" style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em' />
                <div class="row ">
                    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:1vh'>

                    </div>
                </div>
                <input  required type='password' class='form-control' name='password1' id='password1' 
                    v-model="cliente.password" placeholder='PASSWORD' style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em' />
                <div class="row ">
                    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:1vh'>

                    </div>
                </div>
                <input  required type='password' class='form-control' name='password2' id='password2' 
                    v-model="cliente.password2" placeholder='REPEAT PASSWORD' style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em' />
                <div class="row ">
                    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' style='height:1vh'>

                    </div>
                </div>
                <input class='form-check-input' type='checkbox' id='newsletter' name='newsletter' 
                    v-model="cliente.newsletter" style='border-radius: 10px;border-color: black'> SIGN UP FOR NEWSLETTER</input>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <button class='btn btn-block btn-dark' @click="CrearCuenta()"
                            :disabled="status.enviando || status.confirmadoEnvio" v-if="!status.confirmadoEnvio"
                            style='border-radius: 0;background-color: black;margin-top: 1em;'>CREATE AN
                            ACCOUNT</button>
                        <div class='btn btn-block  ' style="background-color: #899583;" v-else>
                            Revisa tu correo para confirmar la cuenta
                        </div>
                    </div>
                </div>
            
        </div>

    </div>
</div>
<div style='position: inherit;bottom: 0;margin-bottom: 0.8rem; min-height: 150px;' 
    class='col-md-8 col-sm-12 text-right pr-4 pl-4 d-flex align-items-end'>
    <span class='small mr-4 col-md-6' onclick='go("privacy.php")'> PRIVACY POLICY</span>
    <span onclick='go("shipping.php")' class='small ml-4 col-md-5'>SHIPPING & RETURNS</span>
</div>

<script src="js/login.js"></script>