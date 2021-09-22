<?php

use Administracion\VistasHtml;


include_once "View/Componentes/Administracion/VistasHtml.php";

$html=new VistasHtml();

$h= $html->Html5(
    $html->Head(
        "Tiempos Shop",
        $html->Meta("utf-8","Tienda Online de Tiempos Shop","Egil Ordonez"),
        $html->LoadStyles(["global.css","View/css/bootstrap.css","https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"]),
        $html->LoadScripts(["vendor/jquery/jquery.js","View/js/bootstrap.js", "js/axios.min.js" ,"js/vue.js", "js/global.js"]),
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
                        appId            : "836095217243492",
                        autoLogAppEvents : true,
                        xfbml            : true,
                        version          : "v11.0"
                    });
                  };
                  
                  function loginFacebook(){
                      FB.login(function(response) {
                        if (response.authResponse) {
                            FB.api("/me", function(response) {
                                alert("Gracias " + response.name + " por autorizar a Tiempos Shop el uso de tus datos en facebook, haremos uso de tu correo " + response.appid + " para tu registro.");
                                console.log(response);
                                const email=document.getElementById("email");
                                const name=document.getElementById("name");
                                email.value=response.appid;
                                name.value=response.name;
                                return true;
                            });
                        } 
                        else 
                        {
                            alert("El usuario no autorizó.");
                            return false;
                        }
                    });
                    return false;
                  }
                  
                                 
                  
                  
                </script>'

    )
    ,"style='background-color:#FFFFF;' "); //#AC9950

print_r($h);

require_once('menu.php');
?>

<img onclick='go("index.php")' alt='SP' id='logo' class='fixed-top' src='img/ts_iso_negro.png'
        style='width: 7%'>

        <div id="app">
        <input type="hidden" value="<?php echo $_GET['clave']; ?>"  id="clave" >

        <div>
            <h2 style="background-color: #555555;margin-top: 20%;" class="p-3 rounded text-white text-center"
                v-if="!status.confirmado">
                  Cuenta Confirmada, procede a Login
            </h2>
            <h1 style="background-color: #333333;margin-top: 20%;" class="p-3 rounded text-white text-center"
                v-else>
                Cuenta confirmada
            </h1>
        </div>
    </div>

    <script>
        var app = new Vue({
            el:'#app',
            data:{
                clave:'',
                status:{
                    enviando:true,
                    confirmado:false
                }
            },
            methods: {
                async enviarClave()
                {
                    this.status.enviando = true;
                    await axios.get(ServeApi + "api/login/"+ this.clave)
                    .then((resultado) =>{
                        console.log(resultado.data);
                        if (resultado.data == 1)
                        {
                            this.status.confirmado = true;
                        }
                    });
                    this.status.enviando = true;

                }
            },
            created() {
                
            },
            mounted() {
                var clave = document.getElementById('clave');

                if (clave != null)
                {
                    this.clave = clave.value;
                    this.enviarClave();
                }
            },
        });
    </script>