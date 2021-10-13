var mostrarMenu = false;
var mostrarMenuMovilFiltro = true;
var modoMovil = false;
var mostrarMenuMovilOrdenar = true;

setTimeout( function () {
    ///para todos los elementos de menu principal agregar caracter
    var menus, i;
    menus = document.querySelectorAll(".menu");


    for (i = 0; i < menus.length; i++) {
        var caracterSpan = document.createElement("span");
        var caracterValor = document.createTextNode("'");
        caracterSpan.appendChild(caracterValor);
        caracterSpan.classList.add('caracter', 'omitir', 'd-none');
        menus[i].appendChild(caracterSpan);
    }

    //para el submenus de filtro



    validarDimenciones();
}, 10);

function validarDimenciones() {
    var alto = window.innerHeight;
    var ancho = window.innerWidth;
    var separacionBotonMenu = document.getElementById("botonMenuMovil").offsetLeft;
    var separacionCart = document.getElementById("carrito").offsetLeft;

    var separacionCartDesk = null;
    if (document.getElementById('carritoDesk') != null)
    {
        separacionCartDesk = document.getElementById("carritoDesk").offsetLeft;
    }

    ///PARA INICIO DE CARGA
    document.getElementById('politicadesktop').classList.remove('d-flex');
    document.getElementById('politicadesktop').classList.add('d-none');



    if (ancho<=768)
    {
        /*Movil*/
        //document.getElementById('menufamilia').style.display = 'none';
        //document.getElementById('menufiltro').style.display = 'none';
        document.getElementById('politicadesktop').classList.remove('d-flex');
        document.getElementById('politicadesktop').classList.add('d-none');

        document.getElementById('lista-menu').style.left = separacionBotonMenu +'px';
        document.getElementById('lista-filtro').style.left = separacionBotonMenu +'px';
        document.getElementById('lista-orden').style.left = separacionBotonMenu +'px';
        document.getElementById('logo').style.left = (separacionCart + 10) +'px';

        if (location.pathname.indexOf('archive.php')>=0)
        {
            /*para archivo*/
            document.getElementById('margen-der').style.display = 'none';
        }

        if (location.pathname.indexOf('viewtienda')>=0)
        {
            /*para view del producto*/
            document.getElementById('infoProducto').classList.remove('left-top');
            document.getElementById('infoProducto').style.paddingBottom = '1.5rem';
            document.getElementById('component').style.fontSize ='1.9vh';
            document.getElementById('precio').style.cssText =null;
            document.getElementById('precio').style.minHeight= '5vh';
            document.getElementById('carouselExampleIndicators').style.display = 'block';
            document.getElementById('imagenesDesk').style.display = 'none';
        }

        /*para productos en shop*/
        if (location.pathname.indexOf('shoptienda.php') >= 0)
        {
            app.estilo.productos = 'width: 50%;padding-left: 0px;padding-right: 0px;';

        }

        /*para privacity*/
        if (location.pathname.indexOf('privacy.php') >= 0)
        {

            document.getElementById('privacity-text').style.marginLeft = null;
            document.getElementById('menu-movil-dorado').style.borderBottom = '1px solid black';
        }
        if (location.pathname.indexOf('shipping.php') >= 0)
        {

            document.getElementById('shipping-text').style.marginLeft = null;
            document.getElementById('menu-movil-dorado').style.borderBottom = '1px solid black';
        }


        if (location.pathname.indexOf('loginshop.php')>=0)
        {
            document.getElementById('contenedorIndex').style.cssText = "padding-bottom: 2rem !important;";
        }

        modoMovil = true;
    }
    else
    {
        if (location.pathname.indexOf('shoptienda.php') >= 0)
        {
            app.estilo.productos = '';
        }

        if (location.pathname.indexOf('archive.php')>=0)
        {
            /*para archivo*/
            document.getElementById('margen-der').style.display = 'block';
        }

        if (location.pathname.indexOf('viewtienda')>=0)
        {
            /*para view del producto*/
            document.getElementById('infoProducto').classList.add('left-top');
            document.getElementById('carouselExampleIndicators').style.display = 'none';
            document.getElementById('imagenesDesk').style.display = 'block';
        }

        //document.getElementById('menufiltro').style.display = 'inline-block';
        //document.getElementById('menufamilia').style.display = 'block';
        document.getElementById('politicadesktop').classList.remove('d-none');
        document.getElementById('politicadesktop').classList.add('d-flex');
        document.getElementById('contenedorIndex').style.display = 'block';
        if (separacionCartDesk != null)
        {

            document.getElementById('logo').style.left = separacionCartDesk +'px';
        }



        modoMovil = false;
    }

    //para los row de productos

    mostrarMenu = true;
    //AbrirMenuMovil(true);
    mostrarMenuMovilFiltro = true;
    //AbrirMenuMovilFiltro(true);


}

window.onresize = validarDimenciones;


var menuApp = new Vue({
    el:'#menu',
    data:{
        idiomas:[
            {
                es : {
                    shop: 'MENU',
                    archive: 'ARCHIVE',
                    imprimt : 'IMPRINT'
                }
            }
        ],
        login:{
            idCliente:0,
            nombre:'',
            accion:''
        },
        cliente:{
            nombre:'',
            idCliente :0,
        },
        elemento: {
            shop: 'SHOP',
            archive: 'ARCHIVE',
            imprint : 'IMPRINT',

        },
        status:{
            menuAbierto : false,
            enTienda:false,
            enIndex:false,
            enImprint:false,
            enArchivo:false,
            enPricavy:false,
        },
        estilo:{
            menuEscritorio:'padding: 2vh 2vw 0px;'
        },
        totalEnCarrito:0,
        idioma:'-'
    },
    methods: {

        OcultarCaracter()
        {
            var menus, i;
            menus = document.querySelector('#menu-movil-dorado').querySelectorAll(".menu");

            if (menus != "undefined")
            {
                for (i = 0; i < menus.length; i++) {

                    menus[i].querySelector('.caracter').classList.add('text-white');

                }
            }

        },
        FiltrarProductos(opcion)
        {

            this.AbrirMenuMovilFiltro(true);
            app.ObtenerProductos(opcion);
        },
        Ordenamiento(opcion)
        {
            this.AbrirMenuMovilOrdenar(true);
            mostrarMenuMovilOrdenar =! mostrarMenuMovilOrdenar;
            app.ordenar(opcion);
        },
        AbrirMenuMovilOrdenar(esEjecucionAutomatica = false )
        {
            this.OcultarCaracter();

            //oculto los demas menos moviles
            document.getElementById('menu-movil-dorado-opcion').style.height = '0';
            document.getElementById('menu-movil-filtro').style.height = '0';
            //para menu principal
            document.getElementById('lista-menu').style.display ='none';
            document.getElementById('lista-filtro').style.display = 'none';
            mostrarMenu = true;
            mostrarMenuMovilFiltro = true;

            if (mostrarMenuMovilOrdenar & !esEjecucionAutomatica)
            {
                document.getElementById('orden').querySelector('.caracter').classList.remove('text-white');
                setTimeout(function() {

                    document.getElementById('menu-movil-ordenamiento').className = 'navbar-collapse collapse collapsing show';

                }, 50);

                setTimeout(function() {

                    document.getElementById('menu-movil-ordenamiento').style.height = '90vh';

                    document.getElementById('contenedorIndex').style.display = 'none';
                    document.getElementById('lista-orden').style.display = 'block';

                    document.getElementById('politica').classList.remove('d-none');
                    document.getElementById('politicadesktop').classList.remove('d-flex');
                    document.getElementById('politicadesktop').classList.add('d-none');
                    //politicadesktop

                }, 150);


            }
            else
            {

                document.getElementById('menu-movil-ordenamiento').style.height = '0';


                document.getElementById('politica').classList.add('d-none');

                if (!modoMovil)
                {
                    document.getElementById('politicadesktop').classList.remove('d-none');
                    document.getElementById('politicadesktop').classList.add('d-flex');
                }

                setTimeout(function() {

                    document.getElementById('lista-orden').style.display = 'none';
                    document.getElementById('contenedorIndex').style.display = 'block';


                }, 150);



            }
            if (!esEjecucionAutomatica) { mostrarMenuMovilOrdenar =! mostrarMenuMovilOrdenar; }

        },
        AbrirSubMenuFiltro(index) {
            var collapseElementList = [].slice.call(document.getElementById('lista-filtro').querySelectorAll('.collapse'));
            var internoIndex = 0;
            var collapseList = collapseElementList.map(function (collapseEl) {
                //si tiene show
                if (internoIndex != index)
                {
                    if (collapseEl.classList.contains('show'))
                    {
                        new bootstrap.Collapse(collapseEl);
                    }
                }
                if (internoIndex == index)
                {
                    internoIndex++;
                    return new bootstrap.Collapse(collapseEl);

                }
                internoIndex++;
            });
        },

         nombreUsuarioSubstring(nombreCliente) {
    nameShort = nombreCliente;
    if (nombreCliente.length > 16) {
        nameShort = nombreCliente.substring(0,14);//"12345678910111213";
        nameShort = nameShort + "...";
    }
    return nameShort;
    },

        AbrirMenuMovil(esEjecucionAutomatica = false)
        {

            this.OcultarCaracter();


            //oculto los demas menos moviles
            document.getElementById('menu-movil-filtro').style.height = '0';
            document.getElementById('lista-filtro').style.display = 'none';
            document.getElementById('lista-orden').style.display = 'none';
            document.getElementById('menu-movil-ordenamiento').style.height = '0';
            mostrarMenuMovilOrdenar = true;
            mostrarMenuMovilFiltro = true;


            if (mostrarMenu & !esEjecucionAutomatica)
            {
                document.getElementById('menu-movil-dorado').style.backgroundColor = 'white';
                //document.getElementById('botonMenuMovil').querySelector('.caracter').classList.remove('text-white');
                var appThis = this;
                setTimeout(function() {
                    if (appThis.status.enIndex)
                    {
                        logo.src='img/ts_iso_negro.png';
                        document.getElementById('lista-menu').style.color ='black';
                        document.getElementById('botonMenuMovil').style.color = 'black';
                        document.getElementById('carrito').style.color = 'black';

                    }
                    document.getElementById('menu-movil-dorado-opcion').className = 'navbar-collapse collapse collapsing show';

                }, 50);

                setTimeout(function() {

                    document.getElementById('menu-movil-dorado-opcion').style.height = '95vh';

                    document.getElementById('contenedorIndex').style.display = 'none';


                    document.getElementById('politica').classList.remove('d-none');
                    document.getElementById('politicadesktop').classList.remove('d-flex');
                    document.getElementById('politicadesktop').classList.add('d-none');

                    document.getElementById('lista-menu').style.display ='block';
                    //politicadesktop

                }, 150);


            }
            else
            {
                document.getElementById('menu-movil-dorado').style.backgroundColor = 'transparent';

                document.getElementById('menu-movil-dorado-opcion').style.height = '0';
                document.getElementById('lista-menu').style.display ='none';

                document.getElementById('politica').classList.add('d-none');

                if (!modoMovil)
                {
                    document.getElementById('politicadesktop').classList.remove('d-none');
                    document.getElementById('politicadesktop').classList.add('d-flex');
                }
                var appThis = this;
                setTimeout(function() {
                    if (appThis.status.enIndex)
                    {
                        logo.src='img/ts_iso_oro.png';
                        document.getElementById('botonMenuMovil').style.color = '#AC9950';
                        document.getElementById('carrito').style.color = '#AC9950';
                        document.getElementById('lista-menu').style.color ='#AC9950';
                    }

                    document.getElementById('contenedorIndex').style.display = 'block';


                }, 90);



            }

            if (!esEjecucionAutomatica) { mostrarMenu =!mostrarMenu;  }

        },
        AbrirMenuMovilFiltro(esEjecucionAutomatica = false)
        {
            this.OcultarCaracter();
            //oculto los demas menos moviles
            document.getElementById('menu-movil-dorado-opcion').style.height = '0';
            document.getElementById('menu-movil-ordenamiento').style.height = '0';

            //para menu principal
            document.getElementById('lista-menu').style.display ='none';
            document.getElementById('lista-orden').style.display = 'none';

            mostrarMenu = true;
            mostrarMenuMovilOrdenar = true;

            if (mostrarMenuMovilFiltro & !esEjecucionAutomatica)
            {
                document.getElementById('filtro').querySelector('.caracter').classList.remove('text-white');

                setTimeout(function() {

                    document.getElementById('menu-movil-filtro').className = 'navbar-collapse collapse collapsing show';

                }, 50);

                setTimeout(function() {

                    document.getElementById('menu-movil-filtro').style.height = '90vh';

                    document.getElementById('contenedorIndex').style.display = 'none';
                    document.getElementById('lista-filtro').style.display = 'block';

                    document.getElementById('politica').classList.remove('d-none');
                    document.getElementById('politicadesktop').classList.remove('d-flex');
                    document.getElementById('politicadesktop').classList.add('d-none');
                    //politicadesktop

                }, 150);


            }
            else
            {

                document.getElementById('menu-movil-filtro').style.height = '0';


                document.getElementById('politica').classList.add('d-none');

                if (!modoMovil)
                {
                    document.getElementById('politicadesktop').classList.remove('d-none');
                    document.getElementById('politicadesktop').classList.add('d-flex');

                }

                setTimeout(function() {

                    document.getElementById('lista-filtro').style.display = 'none';
                    document.getElementById('contenedorIndex').style.display = 'block';


                }, 150);



            }
            if (!esEjecucionAutomatica) { mostrarMenuMovilFiltro =! mostrarMenuMovilFiltro; }

        },
        irAlUrl(url)
        {
            location.href = url;
        },
        async CerrarSession()
        {
            this.login.accion ="cerrar";
            await axios.post("session.php", this.login)
            .then((resultado) =>{

                if (resultado.data = "cerrado")
                {
                    location.href ="shoptienda.php";
                }
            })
        },
        EstablecerIdioma()
        {
            var idioma = this.ObtenerIdioma();
            var moneda = "USD";

            if (idioma == "ENGLISH")
            {
                idioma = "ESPAÑOL";
                moneda = "MXN";
            }
            else
            {
                idioma = "ENGLISH";
                moneda = "USD";
            }

            localStorage.setItem("idioma", idioma);
            localStorage.setItem("moneda", moneda);

            location.reload();
        },
        ObtenerIdioma()
        {
            var idioma = localStorage.getItem("idioma");
            var moneda = "USD";


            if (idioma == null)
            {
                idioma = "ENGLISH";
                moneda = "USD";
            }

            if (idioma != "ENGLISH")
            {
                moneda = "USD";
            }
            else
            {
                moneda = "MXN";
            }

            localStorage.setItem("moneda", moneda);

            return idioma;
        },
        ObtenerUltimaRuta()
        {
            var rutaActual = location.href;
            var ultimaRuta = localStorage.getItem('ruta');
            if (ultimaRuta == null)
            {
                localStorage.setItem('ruta', rutaActual);
            }
            if (ultimaRuta != "checkoutshop.php")
            {
                localStorage.setItem('ruta', rutaActual);
            }


            /*actualizando ultima ruta */

            ultimaRuta = localStorage.getItem('ruta');
            return ultimaRuta;
        }
    },
    async mounted() {

        /*para ocultar elementos del menu*/
        var nombrePaginaHtml =location.pathname;

        if (nombrePaginaHtml.indexOf("shoptienda.php")>=0)
        {
            this.status.enTienda = true;

        }
        if (nombrePaginaHtml.indexOf("index.php")>=0)
        {
            /*agregar transparencia*/
            document.getElementById('menudesk').classList.remove('bg-white');
            document.getElementById('menu-movil-dorado').classList.remove('bg-white');
            document.getElementById('botonMenuMovil').style.color = '#AC9950';
            this.status.enIndex = true;
        }
        if (nombrePaginaHtml.indexOf("imprint.php")>=0) {
            document.getElementById('menu-movil-dorado').classList.remove('bg-white');
        }
        if (nombrePaginaHtml.indexOf("imprint.php")>=0)
        {
            document.getElementById('menudesk').classList.remove('bg-white');
            this.status.enImprint = true;
        }

        if (nombrePaginaHtml.indexOf("privacy.php")>=0)
        {

            this.status.enPricavy = true;
        }

        if (nombrePaginaHtml.indexOf('archive.php')>=0)
        {
            this.status.enArchivo = true;
            this.estilo.menuEscritorio = 'margin: 2vh 2vw 0px;margin-top: 1.1vh; margin-left: 2.1vw;border: 1px solid black; border-bottom:0;margin-right: 0.6vw;min-height: 4vh; width: 96.1vw; '
            document.getElementById('menuEspacio').style.border='1px solid black';
            document.getElementById('menuEspacio').style.width ='96.1vw';
            document.getElementById('menuEspacio').classList.remove('ml-1');
            document.getElementById('menuEspacio').style.marginLeft ='2.1vw';

            document.getElementById('menu-movil-dorado').classList.remove('bg-white');
            //document.getElementById('menudesk').classList.remove('bg-white');

        }
        else
        {
            //OCULTAR BARRA ARCHIVO en otras paginas POR LA TRANSPARENCIA
            document.getElementById('barraArchive').style.display = 'none';
        }

        var nombreCliente = document.getElementById("nombre");
        this.idioma = this.ObtenerIdioma();

        /*Condición para traducción*/
        /*Archivo, marca */
        if (this.idioma == "ENGLISH")
        {
            this.elemento.archive = "ARCHIVO";
            this.elemento.imprint = "MARCA";
        }
        else
        {
            this.elemento.archive = "ARCHIVE";
            this.elemento.imprint = "IMPRINT";
        }


        if (nombreCliente != null)
        {
            var nombre =  nombreCliente.value;

            if (nombre.length >0)
            {
                this.cliente.nombre = nombre;
            }
        }

        this.ObtenerUltimaRuta();
        
    },
    

});