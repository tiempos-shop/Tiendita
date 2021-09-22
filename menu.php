
<div class="fixed-top" id="menu"
    style="padding-top:2vh;padding-bottom:0;padding-left: 2vw;padding-right: 2vw;background-color: white;">
    <input type="hidden" id="nombre" value="<?php echo isset($_SESSION["nombre"]) ?  $_SESSION["nombre"] : '' ?>">
    <div class="row right">
        <div class="  col-md-2  " >
            <span @click="irAlUrl('shoptienda.php')">{{elemento.shop}} </span>
        </div>
        <div class="  col-md-2  " >
            <span style="padding-left: 5%" @click="irAlUrl('archive.php')" >{{elemento.archive}}</span>
        </div>
        <div class="  col-md-2  " >
            <span style="padding-left: 20%" @click="irAlUrl('imprint.php')" >{{elemento.imprint}}</span>
        </div>
        <div class=" col-sm-2  " v-if="cliente.nombre.length == 0">
            <span style="padding-left: 35%" @click="irAlUrl('loginshop.php')">LOGIN</span>
        </div>
        <div class=" col-sm-2  " style="margin-top: -8px" v-else>
            <span style="padding-left: 5%;" >{{cliente.nombre}}</span>
            <span class="text-muted"  @click="CerrarSession()">
                    <img src="img/push.png" alt="cerrarSesion" style="width: 30px; margin-bottom: 10px" />
                </span>
            
        </div>
        <div class="  col-md-2 " >
            <span style="padding-left: 35%" @click="EstablecerIdioma()">{{idioma}}</span>
        </div>
        <div class="  col-md-2  " >
            <span style="right: 2%;position: absolute" @click="irAlUrl('carttienda.php')">CART({{$cantidadCarrito}})</span>
        </div>
    </div>
    <hr style="margin: 1em -3vw 0px -2vw;opacity: 1; " :style="cliente.nombre.length > 0 ? 'margin-top:0;' : ''" />
</div>

<script src="js/menuVue.js"></script>