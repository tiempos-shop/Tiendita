<?php

include_once ("Data/Connection/EntidadBase.php");
$db=new \Tiendita\EntidadBase();
$menu = $db->getAll("menus");

$db->close();
?>

<div id="menu">
    <div id="margen-der" v-if="status.enArchivo" style="background-color: white; min-height: 37px;margin-right: -1vw;z-index: 103;position: fixed;width: 100%;"></div>
    <div class="fixed-top d-none d-md-block bg-white" id="menudesk"
         :style="estilo.menuEscritorio">
        <div style="background-color: white;position: fixed;top: 0;right: 0;left: 0;z-index: 99; height: 8px;" id="barraArchive"></div>
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
                <span class="text-muted"  @click="CerrarSession()">
                    <img src="img/push.png" alt="cerrarSesion" style="width: 30px; margin-bottom: 10px" />
                </span>
                <span  >{{nombreUsuarioSubstring(cliente.nombre)}}</span>

            </div>
            <div class="  col-md-2 " >
                <span style="padding-left: 50%" @click="EstablecerIdioma()">{{idioma}}</span>
            </div>
            <div class="  col-md-2  " >
                <span style="right: 2%;position: absolute" @click="irAlUrl('carttienda.php')" id="carritoDesk">CART({{$cantidadCarrito}})</span>
            </div>
        </div>
        <div id="margen-der"  v-if="status.enArchivo" style="background-color: white; min-height: 10px"></div>
        <hr v-if="!status.enIndex && !status.enImprint && !status.enArchivo" style="margin: 1em -3vw 0px -2vw;opacity: 1; " :style="cliente.nombre.length > 0 ? 'margin-top:0;' : ''" />

    </div>

    <!--menu movil -->

    <nav id="menu-movil-dorado"
         class="navbar navbar-inverse navbar-static-top position-fixed d-sm-block d-md-none d-block d-block  shop bg-white"
         style="width: 100%; top:0; z-index: 2;left: 0;" role="navigation">
        <div class="ml-1 mr-1">
            <div class="navbar-header d-flex justify-content-between align-items-center ml-2 mr-2"
                 style="margin-top: 0;">
                <button type="button" class="navbar-toggle collapsed menu" data-toggle="collapse" id="botonMenuMovil"
                        @click="AbrirMenuMovil()" style="border: none; background-color: transparent;">

                    <span class="sincaracter omitir" >MENU</span>
                </button><a id="filtro" CLASS="elemento-menu-movil filtro menu" href="#"
                            v-if="status.enTienda"
                            @click="AbrirMenuMovilFiltro()">
                        <span class="sincaracter omitir"
                            >FILTER</span></a>
                <a id="orden" CLASS="elemento-menu-movil ordenamiento menu" href="#"
                    v-if="status.enTienda"
                    @click="AbrirMenuMovilOrdenar()"><span
                            class="sincaracter omitir">SORT</span></a>

                <span  class="elemento-menu-movil carrito menu"
                      id="carrito"
                      @click="irAlUrl('carttienda.php')">CART({{$cantidadCarrito}})</span>
            </div>

            <div id="menu-movil-dorado-opcion" class="collapse navbar-collapse">
                <ul id="lista-menu" class="nav navbar-nav row" style="margin-right: 0;">
                    <li><span @click="irAlUrl('shoptienda.php')">{{elemento.shop}} </span></li>
                    <li><span @click="irAlUrl('archive.php')" >{{elemento.archive}}</span></li>
                    <li><span @click="irAlUrl('imprint.php')" >{{elemento.imprint}}</span></li>
                    <li v-if="cliente.nombre.length == 0"><span  @click="irAlUrl('loginshop.php')">LOGIN</span></li>
                    <li v-else>
                        <span  >{{cliente.nombre}}</span>
                        <span class="text-muted"  @click="CerrarSession()">
                            <img src="img/push.png" alt="cerrarSesion" style="width: 30px;" />
                        </span>
                    </li>
                    <li>
                        <span  @click="EstablecerIdioma()">{{idioma}}</span>
                    </li>
                </ul>
            </div>
            <div class="d-sm-block d-md-none d-block d-block ">
                <div id="menu-movil-filtro" class="collapse navbar-collapse">
                    <ul id="lista-filtro" class="nav navbar-nav row" style="margin-right: 0;">
                        <li class="opcion">
                            <a  style="margin-top: -10px;" @click="FiltrarProductos(0)">SHOP
                                ALL"</a></li>

                        </li>

                        <?php
                        $menuPrincipal = "";
                        foreach ($menu as $valor) {
                            $menuPrincipal .= "
                        <li class='opcion d-md-none'><a
                            @click='FiltrarProductos(".$valor->idMenu.")'
                          style=' margin-top: -10px;text-transform: uppercase;'>$valor->menu</a></li>
                        </li>";

                        }
                        echo $menuPrincipal;
                        ?>

                        <li class="opcion"><a  style="display: block; margin-top: -10px;">SALE</a>
                        </li>

                    </ul>
                </div>
            </div>

            <div id="menu-movil-ordenamiento" class="collapse navbar-collapse">
                <ul id="lista-orden" class="nav navbar-nav row" style="margin-right: 0;">
                    <li class="col-md-2"><a  style="display: block" @click="Ordenamiento(1)">FEATURED</a></li>
                    <li><a  style="display: block" @click="Ordenamiento(2)">A TO Z</a></li>
                    <li><a style="display: block" @click="Ordenamiento(3)">PRICE LOW TO HIGH</a></li>
                    <li><a style="display: block" @click="Ordenamiento(4)">PRICE HIGH TO LOW</a></li>
                </ul>
            </div>
            <div id="politica" class="d-flex justify-content-around  d-none" style="position: fixed; "><span > PRIVACY POLICY</span><span class="">SHIPPING & RETURNS</span></div>
    </nav>

</div>

<script src="js/menuVue.js"></script>