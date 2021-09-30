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

    //document.getElementById('botonMenuMovil').style.color = 'black';

    ///PARA INICIO DE CARGA
    document.getElementById('politicadesktop').classList.remove('d-flex');
    document.getElementById('politicadesktop').classList.add('d-none');



    if (ancho<=768)
    {
        //document.getElementById('menufamilia').style.display = 'none';
        //document.getElementById('menufiltro').style.display = 'none';
        document.getElementById('politicadesktop').classList.remove('d-flex');
        document.getElementById('politicadesktop').classList.add('d-none');

        document.getElementById('lista-menu').style.left = separacionBotonMenu +'px';
        document.getElementById('lista-filtro').style.left = separacionBotonMenu +'px';
        document.getElementById('lista-orden').style.left = separacionBotonMenu +'px';
        document.getElementById('logo').style.left = separacionCart +'px';

        modoMovil = true;
    }
    else
    {
        //document.getElementById('menufiltro').style.display = 'inline-block';
        //document.getElementById('menufamilia').style.display = 'block';
        document.getElementById('politicadesktop').classList.remove('d-none');
        document.getElementById('politicadesktop').classList.add('d-flex');
        document.getElementById('contenedorIndex').style.display = 'block';
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
        AbrirMenuMovil(esEjecucionAutomatica = false)
        {
            console.log("menu");
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
                setTimeout(function() {

                    document.getElementById('menu-movil-dorado-opcion').className = 'navbar-collapse collapse collapsing show';

                }, 50);

                setTimeout(function() {

                    document.getElementById('menu-movil-dorado-opcion').style.height = '90vh';

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

                setTimeout(function() {


                    document.getElementById('contenedorIndex').style.display = 'block';


                }, 90);



            }

            if (!esEjecucionAutomatica) { mostrarMenu =!mostrarMenu; console.log("mostrar", mostrarMenu); }

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
                console.log(resultado.data);
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