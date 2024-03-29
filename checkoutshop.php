<?php

use Administracion\VistasHtml;


include_once "View/Componentes/Administracion/VistasHtml.php";
include_once "Data/Connection/EntidadBase.php";

$db=new \Tiendita\EntidadBase();

try {
    $paises=$db->getAll("paises");
    $db->close();
} catch (Exception $e) {
    echo $e->getMessage();
}

$dataOpcionPais = "";
$dataOpcionPais = "<input class='form-control'
    v-model='direccion.pais'
    @change='ObtenerIdPais(direccion.pais)'
    v-on:input='ObtenerIdPais(direccion.pais)'
    list='listaPais'
name='pais' id='pais' maxlength='999999' placeholder='COUNTRY/REGION' style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em' /><datalist id='listaPais'>";

foreach($paises as $pais) 
{
    $dataOpcionPais = $dataOpcionPais."<option value='$pais->nombre' ></option>";

}


$dataOpcionPais = $dataOpcionPais."</datalist>";

$html = new VistasHtml();

session_start();


if($html->ValidarSession())
{
    header("Location: loginshop.php", TRUE, 301);
    exit();
}


$htmlPrincipal = "<!DOCTYPE html>
        <html lang='es'>";
print_r($htmlPrincipal);
$h = $html->Head(
    "Tiempos Shop",
    $html->Meta("utf-8", "Tienda Online de Tiempos Shop", "Egil Ordonez"),
    $html->LoadStyles(["global.css", "View/css/bootstrap.css", "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css", "css/menumovil.css"]),
    $html->LoadScripts(["View/js/bootstrap.js", "js/axios.min.js", "js/vue.js", "js/global.js", "https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js","https://cdn.conekta.io/js/latest/conekta.js"]),
    "",
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
                  
                  Conekta.setPublicKey("key_eYvWV7gSDkNYXsmr");

    var conektaSuccessResponseHandler= function(token){

        $("#conektaTokenId").val(token.id);

        jsPay();
    };

    var conektaErrorResponseHandler =function(response){
        var $form=$("#card-form");

        alert(response.message_to_purchaser);
    }

    $(document).ready(function(){

        $("#card-form").submit(function(e){
            e.preventDefault();

            var $form=$("#card-form");

            Conekta.Token.create($form,conektaSuccessResponseHandler,conektaErrorResponseHandler);
        })

    })

    function jsPay(){
        let params=$("#card-form").serialize();
        let url="respuestaPago.php";

        $.post(url,params,function(data){
            alert(data);
            jsClean();
        })

    }

    function jsClean(){
        $(".form-control").prop("value","");
        $("#conektaTokenId").prop("value","");
    }
                </script>'

);
print_r($h);

require_once('menu.php');
?>
<img onclick='go("index.php")' alt='SP' id='logo' class='fixed-top' src='img/ts_iso_negro.png'>
<div class="container-fluid" id="contenedorIndex">
    
    <div class="row ">
        <div class="  col-md-12  " style="text-align:center;margin-top:100px">
            <label style="font-family: NHaasGroteskDSPro-65Md">CHECKOUT</label>
        </div>
    </div>
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:2vh">
        <input type="hidden"  class="form-control" value="<?php  echo isset($_SESSION["idCliente"]) ? $_SESSION["idCliente"] : '' ?>" id="idCliente">
        </div>
    </div>
    <hr style="opacity: 1" class="border-check" />
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1vh">

        </div>
    </div>
    <div class="row ">
        <div class="  col-md-2  ">

        </div>
        <div class="  col-md-4  ">
            SHIPPING ADDRESS
        </div>
        <div class="  col-md-4  ">

        </div>
        <div class="  col-md-2  ">

        </div>
    </div>
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:2vh">

        </div>
    </div>
    <div class="row ">
        <div class="  col-md-2  ">

        </div>
        <div class="  col-md-4  " style="padding-bottom: 0.3rem;">
            <input class="form-control"  id="nombre" maxlength="999999" 
            v-model="direccion.nombre"
            placeholder="FIRST NAME" style="border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em" />
        </div>
        <div class="  col-md-4  ">
            <input class="form-control" 
            v-model="direccion.apellido"
            name="apellido" id="apellido" maxlength="999999" placeholder="LAST NAME" style="border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em" />
        </div>
        <div class="  col-md-2  ">

        </div>
    </div>
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1em">

        </div>
    </div>
    <div class="row ">
        <div class="  col-md-2  ">

        </div>
        <div class="  col-md-4  " style="padding-bottom: 0.3rem;">
            <input class="form-control" name="calle" 
            v-model="direccion.calle"
            id="calle" maxlength="999999" placeholder="STREET ADDRESS" style="border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em" />
        </div>
        <div class="  col-md-4  ">
            <input class="form-control" 
            v-model="direccion.company"
            name="company" id="company" maxlength="999999" placeholder="COMPANY (OPTIONAL)" style="border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em" />
        </div>
        <div class="  col-md-2  ">

        </div>
    </div>
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1em">

        </div>
    </div>
    <div class="row ">
        <div class="  col-md-2  ">

        </div>
        <div class="  col-md-4  " style="padding-bottom: 0.3rem;">
            <input class="form-control" name="ciudad" 
            v-model="direccion.ciudad"
            id="ciudad" maxlength="999999" placeholder="CITY" style="border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em" />
        </div>
        <div class="  col-md-4  ">
            <input class="form-control" 
            v-model="direccion.codigo_postal"
            name="postalcode" id="postalcode" maxlength="5" placeholder="ZIP OR POSTAL CODE" style="border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em" />
        </div>
        <div class="  col-md-2  ">

        </div>
    </div>
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1em">

        </div>
    </div>
    <div class="row ">
        <div class="  col-md-2  ">

        </div>
        <div class="  col-md-4  " style="padding-bottom: 0.3rem;">
           
            <?php echo $dataOpcionPais; ?>
        </div>
        <div class="  col-md-4  ">
            <input class="form-control" 
            v-model="direccion.estado"
            name="estado" id="estado" maxlength="999999" placeholder="STATE/PROVINCE" style="border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em" />
        </div>
        <div class="  col-md-2  ">

        </div>
    </div>
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:2em">

        </div>
    </div>
    <div class="row ">
        <div class="  col-md-2  ">

        </div>
        <div class="col-md-4" style="padding-bottom: 0.3rem;">
        
            <input class="form-control"
            v-model="direccion.colonia"
            name="telefono" id="colonia"  placeholder="colony" style="border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em" />
        
        </div>
        <div class="  col-md-2  ">
            <input class="form-control"
            v-model="direccion.telefono"
            name="telefono" id="telefono" maxlength="999999" placeholder="PHONE" style="border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em" />
        </div>
        <div class="  col-md-6  ">

        </div>
        <div class="  col-md-2  ">

        </div>
    </div>
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1em">

        </div>
    </div>
    <div class="row ">
        <div class="  col-md-2  ">

        </div>
        <div class="  col-md-2  ">
            <button class="btn btn-block btn-dark" @click="CalcularEnvio()" style="border-radius: 0;background-color: black;margin-top: 1em;">SAVE</button>
        </div>
        <div class="  col-md-2  ">
            <button class="btn btn-block btn-dark" formaction="customerLogin.php?action=create" type="submit" style="border-radius: 0;background-color: black;margin-top: 1em;">CANCEL</button>
        </div>
        <div class="  col-md-4  ">

        </div>
        <div class="  col-md-2  ">

        </div>
    </div>
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1em">

        </div>
    </div>
    <div class="row ">
        <div class="  col-md-2  ">

        </div>
        <div class="  col-md-4  ">
            <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter" style="border-radius: 10px;border-color: black"> USE AS BILLING ADDRESS</input>
        </div>
        <div class="  col-md-4  ">

        </div>
        <div class="  col-md-2  ">

        </div>
    </div>
    <hr style="opacity: 1" class="border-check" />
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1vh">

        </div>
    </div>
    <div class="row ">
        <div class="  col-md-2  ">

        </div>
        <div class="  col-md-4  ">
            SHIPPING METHOD
        </div>
        <div class="  col-md-6  ">

        </div>
    </div>
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:2vh">

        </div>
    </div>
    <div class="row ">
        <div class="  col-md-2  ">

        </div>
        <div class="  col-md-4  ">

            <input class="form-check-input" type="radio" name="opcionEnvio" 
                id="opcionEnvio1" value="option1" :disabled="status.cotizando" 
                style="border-radius: 10px;border-color: black"
                checked>
            <label class="form-check-label ml-1 text-muted" for="opcionEnvio1" id="postalcodetext">
                {{status.resultadoCotizacion}}
            </label>
            <div class="p-1 text-danger" v-if="errores.envio.length>0">
                {{errores.envio}}
            </div>
          
        </div>
        <div class="  col-md-4  ">

        </div>
        <div class="  col-md-2  ">

        </div>
    </div>
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:2vh">

        </div>
    </div>
    <hr style="opacity: 1"  class="border-check"/>
    <div class="row ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1vh">

        </div>
    </div>
    <div class="row ">

        <div class="container-fluid">
          
         
         
            <div class="row ">
                <div class="  col-md-2  ">

                </div>
                <div class="  col-md-4  ">
                    PAYMENT METHOD
                </div>
                <div class="  col-md-4  ">

                </div>
                <div class="  col-md-2  ">

                </div>
            </div>
            <div class="row ">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:2vh">

                </div>
            </div>
            <div class="row ">
                <div class="  col-md-2  ">

                </div>
                <div class="  col-md-4  ">
                    <Label style="border-radius: 10px;border-color: black"> PAY WITH PAYPAL</Label>
                    <div id="smart-button-container">
                        <div style="text-align: center;">
                            <div id="paypal-button-container"></div>
                        </div>
                    </div>
                 
                </div>
                <div class="  col-md-6  0">
                    <img id="pago-seguro" src="img/pago-seguro.png" class="img-fluid" />
                </div>
            </div>
            <div class="row ">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1vh">

                </div>
            </div>
            <hr style="opacity: 1" class="border-check" />
            <div class="row ">
                <div class="  col-md-2  ">

                </div>
                <div class="  col-md-4  " >
                <label style="border-radius: 10px;border-color: black">PAY WITH CREDIT OR DEBIT CARD </label>

                </div>
                <div class="  col-md-4  ">

                </div>
                <div class="  col-md-2  ">

                </div>
            </div>
            <div class="row ">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:2vh">

                </div>
            </div>
            <div class="row ">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1vh">

                </div>
            </div>
            <div class="row ">
                <div class="  col-md-2  ">

                </div>
                <div class="  col-md-4  ">

                </div>
                <div class="  col-md-4  ">

                </div>
                <div class="  col-md-2  ">

                </div>
            </div>
            <div class="row ">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:2vh">

                </div>
            </div>
            <div class="row ">
                <div class="  col-md-2  ">

                </div>
                <div class="  col-md-8  ">
                    <form id='card-form'>

                        <input type='hidden' name='conektaTokenId' id='conektaTokenId' value=''>

                        <div class='card'>
                            <div class='card-header'>
                                <div>
                                    <h3>Pago en línea </h3>

                                </div>
                            </div>
                            <div class='card-body'>
                                <div class='row'>
                                    <div class='col-md-6'>
                                        <label>
                                            Nombre del tarjetahabiente
                                        </label>
                                        <input value='Juan Ramirez Ledesma' data-conekta='card[name]' class='form-control' name='name' id='name'  type='text' >
                                    </div>
                                    <div class='col-md-6'>
                                        <label>
                                            Número de tarjeta
                                        </label>
                                        <input value='4242424242424242' name='card' id='card' data-conekta='card[number]' class='form-control'   type='text' maxlength='16' >
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-6'>
                                        <label>
                                            CVC
                                        </label>
                                        <input value='399' data-conekta='card[cvc]' class='form-control'  type='text' maxlength='4' >
                                    </div>
                                    <div class='col-md-6'>
                                        <label>
                                            Fecha de expiración (MM/AA)
                                        </label>
                                        <div>
                                            <input style='width:50px; display:inline-block' value='11' data-conekta='card[exp_month]' class='form-control'  type='text' maxlength='2' >
                                            <input style='width:50px; display:inline-block' value='22' data-conekta='card[exp_year]' class='form-control' type='text' maxlength='2' >

                                        </div>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-4'>
                                        <label><span>Email</span></label>
                                        <input class='form-control' type='text' name='email' id='email' maxlength='200' value='pepepecaspicapapasconunpico666@gmail.com'>
                                    </div>
                                    <div class='col-md-4'>
                                        <label>Concepto</label>
                                        <input class='form-control' type='text' name='description' id='description' maxlength='100' value='papitas'>
                                    </div>
                                    <div class='col-md-4'>
                                        <label>Monto</label>
                                        <input class='form-control' type='number' name='total' id='total' value=''>
                                    </div>

                                </div>
                                <br>
                                <div class='row'>
                                    <div class='col-md-12' style='text-align:center;'>
                                        <button class='btn btn-success btn-lg'>
                                            <i class='fa fa-check-square'></i> PAGAR
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="  col-md-4  ">

                </div>
            </div>
            <div class="row ">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:2vh">

                </div>
            </div>
            <hr style="opacity: 1"  class="border-check"/>
            <div class="row ">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="height:1vh">

                </div>
            </div>
            <div class="row ">
                <div class="  col-md-12  " style="text-align:center;margin-top:10px">
                    <label style="font-family: NHaasGroteskDSPro-65Md">SUMMARY</label>
                </div>
            </div>

            <div id= "productosWeb">
            <hr style="opacity: 1;margin-bottom: 0px;" class="border-check" />
            <div  class="row " v-for="(producto, index) in enCarrito" :key="index">
                <div class="  col-md-2  ">

                </div>
                <div class="  col-md-2  ">
                    <div style="cursor: pointer;">
                        <img :src="producto.ruta" height="172">

                    </div>
                </div>
                <div class="col-md-2">
                    <div style="display: inline-block;vertical-align: top;margin-top: 16px;">
                        {{producto.color}}
                    </div>
                    <div>

                        {{producto.sku}}
                    </div>
                </div>
                <div class="  col-md-1  ">
                    <div class="d-flex" style="margin-top: 16px;">

                        <button type="submit" style="border:0 solid transparent;background-color:transparent;display: inline-block"
                                @click="EliminarProducto(producto)">X</button>
                        <input @change="CambiarCantidad(producto)" type="number"
                               :max="producto.inventario"
                               :disabled="producto.enviando"
                               v-model="producto.cantidad" style="width: 65px;padding-left: 5px;">
                    </div>
                </div>
                <div class="  col-md-1  ">
                    <div style="margin-top: 16px;">{{producto.valor}}</div>
                </div>
                <div class="  col-md-1  ">

                </div>
                <div class="  col-md-3  ">
                    <div style="margin-top: 16px; display: inline-block;">
                        <div class="  ">
                            {{siglasMoneda}} {{Number(producto.precioFinal) | moneda}}
                        </div>
                    </div>
                </div>
                <hr style="margin: 0;opacity: 1;margin-bottom: 0px;" class="border-check"/>
            </div>
        </div>

            <div id="productosCheckoutMovil">
                <hr style="opacity: 1;margin-bottom: 0px; margin-left: -32px;margin-right: -25px;" class="border-check"/>
                <div  v-for="(producto, index) in enCarrito" :key="index">

                    <table>
                        <tr>
                            <td rowspan="4">

                                <img :src="producto.ruta" height="172">

                            </td>
                        </tr>
                        <tr>
                            <td  style ="display: inline-block;">
                                <p class="small">
                                    {{producto.nombre}}
                                </p>
                            </td>
                            <td></td>
                            <td style ="display: inline-block;" >

                                {{siglasMoneda}} {{Number(producto.precioFinal) | moneda}}

                        </tr>
                        <tr>
                            <td style ="display: inline-block;"> <button type="submit" style="border:0 solid transparent;background-color:transparent;display: inline-block"
                                                                         @click="EliminarProducto(producto)">X</button>
                                <input @change="CambiarCantidad(producto)" type="number"
                                       :max="producto.inventario"
                                       :disabled="producto.enviando"
                                       v-model="producto.cantidad" style="width: 65px;padding-left: 5px;">

                                {{producto.color}}
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td> </td>
                        </tr>
                    </table>
                    <hr style="opacity: 1;margin-top: -1px;margin-bottom: -1px; margin-left: -32px;margin-right: -35px;" />
                </div>



            </div>

        <div id="movilTotal">
            <div >
                <div class="row ">

                    <div class="  col  ">
                        <div class="d-flex flex-column" style="margin-top: 10px;">
                            <p class="mr-5">Subtotal</p>
                            <p>Shipping total</p>
                            <p>Duties and taxes</p>
                            <p class="font-weight-bold mt-2">Total</p>
                        </div>
                    </div>
                    <div class="  col  ">
                        <div style="margin-top: 10px;" class="d-flex flex-column">
                            <p class="mr-5">{{siglasMoneda}} {{subtotal | moneda}} <input type="hidden" value="1300" id="subtotal"> </p>
                            <p> <span id="monedaEnvio"></span> <span class="ml-1" id="precioEnvio">
                                    {{siglasMoneda}} {{envio | moneda}}
                                </span> </p>
                            <p>(Included)</p>
                            <p class="font-weight-bold mt-2"><span id="monedaTotal"></span> <span class="ml-1" id="precioTotal">
                                {{siglasMoneda}}  {{Number(total) | moneda}}
                                </span></p>
                            <input type="hidden" v-model="total" id="totalCompra">
                            <input type="hidden" v-model="siglasMoneda" id="moneda">
                        </div>
                    </div>
                </div>
            </div>
            <hr style="opacity: 1;margin-top: -1px;margin-bottom: -1px; margin-left: -32px;margin-right: -35px;" />
        </div>

            <div id="sumFinalWeb" class="row ">
                <div class="  col-md-12  pt-6 pb-4 border-bottom border-dark">
                    <div class="row ">
                        <div class="  col-md-3  ">

                        </div>
                        <div class="  col-md-6  ">
                            <div class="d-flex flex-column" style="margin-top: 10px;">
                                <p class="mr-5">Subtotal</p>
                                <p>Shipping total</p>
                                <p>Duties and taxes</p>
                                <p class="font-weight-bold mt-2">Total</p>
                            </div>
                        </div>
                        <div class="  col-md-3  ">
                            <div style="margin-top: 10px;" class="d-flex flex-column">
                                <p class="mr-5">{{siglasMoneda}} {{subtotal | moneda}} <input type="hidden" value="1300" id="subtotal"> </p>
                                <p> <span id="monedaEnvio"></span> <span class="ml-1" id="precioEnvio">
                                    {{siglasMoneda}} {{envio | moneda}}
                                </span> </p>
                                <p>(Included)</p>
                                <p class="font-weight-bold mt-2"><span id="monedaTotal"></span> <span class="ml-1" id="precioTotal">
                                {{siglasMoneda}}  {{Number(total) | moneda}}
                                </span></p>
                                <input type="hidden" v-model="total" id="totalCompra">
                                <input type="hidden" v-model="siglasMoneda" id="moneda">
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-dark btn-block" style="text-align: left;border-radius: 0"
                    @click="ProcesarPedido()" :disabled="status.procesado || status.enviandoPedido || status.cotizando">
                    <div class="text-center" id="procesarText">{{status.procesadoEstatus}}</div>
                </button>

                <div class="col-md-12 mt-2">
                    <div class="bg-danger text-white p-2" v-if="errores.sistema.length > 0">
                        {{errores.sistema}}
                    </div>
                </div>
            </div>
        </div>
 
    </div>

    

    
</div>
<div class='container-fluid mb-2'
     style='bottom: 1vh;font-size: 0.7rem;padding-left: 50%; padding-bottom: 1.5rem;' id="politicadesktop">
    <label style='width: 14vw;display: inline-block;position: absolute;left: 50vw;font-size: 0.7rem;' onclick='go("privacy.php")'>PRIVACY POLICY</label>
    <label style='width: 15vw;display: inline-block;position: absolute;left: 62vw;font-size: 0.7rem;'><span onclick='go("shipping.php")'>SHIPPING RETURNS</span></label>
</div>

<script>
    Vue.filter('moneda', function(value) {
        if (typeof value !== "number") {
            return value;
        }
        var formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 2
        });
        return formatter.format(value);
    });

    var app = new Vue({
        el: '#contenedorIndex',
        data: {
            enCarrito: [],
            idCliente: 0,
            monedas: [],
            idMoneda: 0,
            siglasMoneda: "",
            subtotal: 0,
            envio: 0,
            total:0,
            paises:[],
            direccion:{
                codigo_postal:'',
                telefono:'',
                nombre: '',
                apellido: '',
                company:'',
                calle:'',
                ciudad:'',
                pais:'',
                estado:'',
                colonia:'',
                idDireccion:0,
                idPais:0,
            },
            status:{
                cotizando:false,
                procesado:false,
                enviandoPedido:false,
                textoDias:'DAYS',
                resultadoCotizacion: 'INPUT POSTAL CODE FIRST',
                procesadoEstatus:'PLACE ORDER',
            },
            errores:{
                sistema:'',
                envio:''
            }
        },
        methods: {
            async EliminarProducto(producto)
            {
                producto.enviando = true;
                
                try {
                    await new Promise(resolve => setTimeout(resolve, 1000));
                    console.log("envio terminado");
                    
                    producto.idCliente = this.idCliente;
                    await axios.post(ServeApi + "api/encarrito", { "producto" : producto, "movimiento":"ELIMINAR"})
                    .then((resultado) =>{
                        
                        if (resultado.data == "eliminado")
                        {
                            console.log("eliminado");
                        }
                    }).catch((problema) =>{

                    });

                    await this.ObtenerCarrito();
                } catch (error) {
                    
                }
                
                producto.enviando = false;
            },
            async CambiarCantidad(producto)
            {   
                producto.enviando = true;
                
                try {
                    await new Promise(resolve => setTimeout(resolve, 1000));
                    console.log("envio terminado");

                    producto.idCliente = this.idCliente;
                    await axios.post(ServeApi + "api/encarrito", { "producto" : producto, "movimiento":"MODIFICAR"})
                    .then((resultado) =>{
                        
                        if (resultado.data.idDetalle > 0)
                        {
                            console.log("actualizado");
                        }
                    }).catch((problema) =>{

                    });

                    await this.ObtenerCarrito();
                } catch (error) {
                    
                }
                
                producto.enviando = false;
                
            },
            async ProcesarPedido()
            {
                this.errores.sistema = "";
                
                this.status.enviandoPedido = true;
                var idPaypal = localStorage.getItem("pagoPaypal");

                if (idPaypal == null || idPaypal.length < 2)
                {
                    this.errores.sistema = "no se ha realizado el pago de paypal primero";
                }
                try {
                    var data = {
                        "idCliente": this.idCliente,
                        "nombre": this.direccion.nombre,
                        "apellido" : this.direccion.apellido,
                        "moneda": this.siglasMoneda,
                        "total" : this.total,
                        "precioEnvio" : this.envio,
                        "subtotal": this.subtotal,
                        "nombre_recibe": this.direccion.nombre +  " " +  this.direccion.apellido,
                        "productos": this.enCarrito,
                        "direccion" : this.direccion,
                        "idPaypal": idPaypal
                    }
            
                    await axios.post(ServeApi + "api/pedidos", data)
                    .then((resultado) => {
                        
                        var info =resultado.data;
                        if (info.IdPedido>0)
                        {
                            this.status.procesado = true;
                            
                            this.status.procesadoEstatus = "READY!";
                        }
                    }).catch((problema) =>
                    {
                        if (problema.response.data)
                        {
                            this.errores.sistema = problema.response.data;
                            
                        }
                        else
                        {
                            console.log("problema", problema);
                        }
                        
                    });
                } catch (error) {
                    
                }

                this.status.enviandoPedido = false;
            },
            async CalcularEnvio()
            {
                this.errores.envio = "";
                var data = {
                    "precio": this.subtotal,
                    "moneda": this.siglasMoneda,
                    "codigo_postal": this.direccion.codigo_postal,
                    "cantidad_productos":this.enCarrito.length,
                    "idCliente": this.idCliente,
                    "productos": this.enCarrito,
                    "idPais":this.direccion.idPais
                }
                var idiomaActual = "ESPAÑOL";

                switch (idiomaActual)
                {
                    case "ESPAÑOL" :
                        this.status.resultadoCotizacion = "Cargando ...";
                        this.textoDias = "DÍAS";
                        break;
                    default:
                        this.status.resultadoCotizacion = "Loading ...";
                        this.textoDias = "DAYS";
                        break;
                }

                this.status.cotizando = true;

                if (this.enCarrito.length == 0)
                {
                    /*no hay productos en el carrito */
                    this.subtotal = 0;
                    this.envio = 0;
                    this.status.cotizando = false;

                    switch (idiomaActual)
                    {
                        case "ESPAÑOL" :
                            this.status.resultadoCotizacion = "Agregar productos";
                            this.textoDias = "DÍAS";
                            break;
                        default:
                            this.status.resultadoCotizacion = "ADD PRODUCTS ";
                            this.textoDias = "DAYS";
                            break;
                    }
                    return;
                }
                try {
                    await axios.post(ServeApi + "api/envios_mov/cotizar", data)
                        .then((resultado) => {

                            var info =resultado.data;
                            if (info.dias != null)
                            {
                                /*convertir moneda de cotizacion */
                                if (info.moneda != this.siglasMoneda && info.moneda == "MXN")
                                {
                                    var monedaEncontrada = this.monedas.find((moneda) => moneda.siglas == "USD" );
                                    console.log("moneda encon", monedaEncontrada);

                                    info.precio = info.precio / monedaEncontrada.convertirMoneda;
                                    info.moneda = "USD";
                                }
                                if (info.moneda != this.siglasMoneda && info.moneda == "USD")
                                {
                                    var monedaEncontrada = this.monedas.find((moneda) => moneda.siglas == "USD" );
                                    console.log("moneda encon", monedaEncontrada);

                                    info.precio = info.precio * monedaEncontrada.convertirMoneda;
                                    info.moneda = "MXN";
                                }
                                info.precio = info.precio.toFixed(2);
                                this.status.resultadoCotizacion = info.precio + " " + info.moneda + " " +  info.dias + " " +  this.textoDias;
                                this.envio = Number(info.precio);
                                this.SumarProductos();
                            }
                        })
                        .catch((problema)=>
                        {
                            if (problema.response)
                            {
                                console.log("problema resp",problema.response);
                            }
                            if (problema.response.data)
                            {
                                console.log("problema data",problema.response.data);
                                this.errores.envio = problema.response.data;
                            }
                            this.status.resultadoCotizacion = "INPUT POSTAL CODE FIRST";
                            this.status.cotizando = false;
                        });
                }
                catch (problema){
                    this.status.cotizando = false;
                    if (problema.response)
                    {
                        console.log("problema resp",problema.response);
                    }

                    if (problema.response.data)
                    {
                        console.log("problema data",problema.response.data);
                    }

                };
                this.status.cotizando = false;
            },
            IrACheckOut() {
                location.href = "checkoutshop.php";
            },
            SumarProductos() {
                var subtotal = 0;
                this.enCarrito.forEach(element => {
                    
                    subtotal += Number(element.cantidad) * Number(element.precioFinal);
                    
                });
                this.subtotal = Number(subtotal);
                
                this.total = (Number(subtotal) + Number(this.envio)).toFixed(2);
                

            },
            async CargaInicial() {
                await axios.get(ServeApi + "api/cargainicial")
                    .then((resultado) => {
                        this.monedas = resultado.data.monedas;
                    });
            },
            async ObtenerDireccionPrincipal()
            {
                await axios.post(ServeApi + 'api/direccion/porcliente', {"idCliente" : this.idCliente})
                .then((resultado)=>{
                    console.log(resultado.data);
                    var data = resultado.data;
                    if (data == "undefined" | data == undefined | data.length == 0) 
                    {
                        return;
                    }

                    console.log("data", data);
                    this.direccion.idDireccion = data.IdDireccion;
                    this.direccion.telefono= data.telefono;
                    this.direccion.nombre=data.nombre;
                    this.direccion.apellido = data.apellido;
                    this.direccion.company = data.company;
                    this.direccion.calle = data.Calle;
                    this.direccion.ciudad = data.Ciudad;
                    this.direccion.codigo_postal= data.CodigoPostal;
                    this.direccion.pais = data.Pais;
                    this.direccion.estado = data.estado;
                    this.direccion.idPais = data.idPais;
                    this.direccion.colonia = data.Colonia;
                    this.CalcularEnvio();
                });
            },
            ValidarSiExisteEnCarrito() {
                this.status.agregadoAlCarrito = false;

                var productoEncontrado = this.enCarrito.find((p) => {
                    return p.idProducto == this.producto.idProducto
                });

                if (productoEncontrado) {
                    if (!this.producto.manejaraTallas) {
                        this.status.agregadoAlCarrito = true;
                    } else {
                        var tallaEncontrada = this.variantes.find((v) => {
                            return v.idProductoVarianteDetalle == this.producto.idProductoVarianteDetalle
                        });
                        if (tallaEncontrada) {
                            this.status.agregadoAlCarrito = true;
                        }
                    }

                } else {
                    console.log("no encontrado");
                }
            },

            async ObtenerCarrito() {
                console.log("obtieniendo productos al carrito");
                await axios.get(ServeApi + "api/encarrito/" + this.idCliente)
                    .then((resultado) => {
                        if (resultado.data != null) {


                            resultado.data.forEach(element => {
                                element.enviando = false;
                            });

                            this.enCarrito = resultado.data;

                            if (this.siglasMoneda == "USD")
                            {

                                var monedaEncontrada = this.monedas.find((moneda) => moneda.siglas == "USD" );
                                console.log("moneda encon", monedaEncontrada);

                                this.enCarrito.forEach(element => {
                                    element.precioFinal = element.precio / monedaEncontrada.convertirMoneda;
                                });
                            }
                            else
                            {
                                this.enCarrito.forEach(element => {
                                    element.precioFinal = element.precio;
                                });
                            }

                            this.$cantidadCarrito = this.enCarrito.length;
                            this.SumarProductos();
                        }

                    });

            },
            ObtenerIdPais(nombrePais)
            {
                console.log("buscando");
                var resultado = this.paises.find((pais) => pais.nombre == nombrePais);
                if (resultado != null)
                {
                    this.direccion.idPais = resultado.idPais;
                }
                else
                {
                    this.direccion.idPais = 0;
                }

                console.log("idpais", this.direccion.idPais);
                
            },
            async EnviarCarritoLocal()
            {
                if (this.idCliente.length >0)
                {
                    console.log("enviando productos al carrito");
                    /*Obtener el carrito local */
                    var productosLocal = localStorage.getItem("productos");

                    if (productosLocal != null)
                    {
                        
                        productosLocal = JSON.parse(productosLocal);

                        console.log("productos local", productosLocal);
                        

                        await Promise.all(productosLocal.map(async producto => {
                            /*Enviar post de cada producto */

                            /*Optimizar datos a enviar */
                            producto.idCliente = this.idCliente;
                            await axios.post(ServeApi + "api/encarrito", { "producto" : producto, "movimiento":"AGREGAR"})
                            .then((resultado) =>{
                                if (resultado.data.idDetalle > 0)
                                {
                                    console.log("producto agregado");
                                }
                                return resultado;
                            });
                        }));

                        localStorage.removeItem("productos");

                        
                    }
                }
            }
        },
        async mounted() {

            this.$cantidadCarrito = 0;
            this.idCliente = document.getElementById('idCliente').value;
            await this.CargaInicial();
            this.ObtenerDireccionPrincipal();

            await this.EnviarCarritoLocal();
            this.idMoneda = idMoneda;
            this.siglasMoneda = localStorage.getItem("moneda");
            console.log("siglas",this.siglasMoneda);
            await this.ObtenerCarrito();
            
            <?php echo "this.paises = ["; ?>
                <?php 
                foreach ($paises as $pais) {
                   echo "{idPais : ".$pais->idPais.",";
                   echo "nombre : '".$pais->nombre."'},";
                } 
                ?>
            <?php echo "];"; ?>; 

        },


    })
</script>

<script src="https://www.paypal.com/sdk/js?client-id=sb&enable-funding=venmo&currency=MXN"& data-sdk-integration-source="button-factory"></script>
                    <script>
                        function initPayPalButton() {
                            paypal.Buttons({
                                style: {
                                    shape: 'rect',
                                    color: 'gold',
                                    layout: 'vertical',
                                    label: 'paypal',

                                },

                                createOrder: function(data, actions) {
                                    var moneda = document.getElementById('moneda').value;
                                    
                                    var suma = document.getElementById('totalCompra').value;

                                    console.log("SUMA", suma);

                                    if (suma == null)
                                    {
                                        console.log("no hay suma")
                                        return;
                                    }
                                    return actions.order.create({
                                        purchase_units: [{'amount':{'currency_code': 'MXN','value':suma}}]
                                    });
                                },

                                onApprove: function(data, actions) {
                                    return actions.order.capture().then(function(orderData) {

                                        // Full available details
                                        console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

                                        // Show a success message within this page, e.g.
                                        const element = document.getElementById('paypal-button-container');
                                        element.innerHTML = '';
                                        element.innerHTML = '<h3>Thank you for your payment!</h3>';

                                        localStorage.setItem("pagoPaypal", orderData.id);

                                    });
                                },

                                onError: function(err) {
                                    console.log(err);
                                }
                            }).render('#paypal-button-container');
                        }
                        initPayPalButton();
                    </script>