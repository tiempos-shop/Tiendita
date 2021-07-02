var mostrarMenu = true;
var mostrarMenuMovilFiltro = true;
var modoMovil = false;
var mostrarMenuMovilOrdenar = true;

function validarDimenciones() {
    var alto = window.innerHeight;
    var ancho = window.innerWidth;

    //document.getElementById('botonMenuMovil').style.color = 'black';

    ///PARA INICIO DE CARGA
    if (document.getElementById('politicadesktop') != null)
    {
        document.getElementById('politicadesktop').classList.remove('d-flex');
        document.getElementById('politicadesktop').classList.add('d-none');
    }

    var separacionBotonMenu = document.getElementById("botonMenuMovil").offsetLeft;
    var separacionCart = document.getElementById("carrito").offsetLeft;


    //ocultar logo en privacity
    document.getElementById('logo').style.display = 'none';

    if (ancho<=768)
    {
        if (document.getElementById('t') != null)
        {
            document.getElementById('t').classList.remove('d-block');
            document.getElementById('t').classList.add('d-none');
        }


        if (document.getElementById('politicadesktop') != null)
        {
            document.getElementById('politicadesktop').classList.remove('d-flex');
            document.getElementById('politicadesktop').classList.add('d-none');
        }

        document.getElementById('menu-movil-dorado').style.borderBottom = 'none';

        document.getElementById('lista-menu').style.left = separacionBotonMenu +'px';
        document.getElementById('logo').style.left = separacionCart +'px';

        modoMovil = true;
    }
    else
    {
        if (document.getElementById('t') != null)
        {
            document.getElementById('t').classList.remove('d-none');
            document.getElementById('t').classList.add('d-block');
        }

        if (document.getElementById('politicadesktop') != null)
        {
            document.getElementById('politicadesktop').classList.remove('d-none');
            document.getElementById('politicadesktop').classList.add('d-flex');
        }

        modoMovil = false;
    }

    //para los row de productos

    mostrarMenu = true;
    AbrirMenuMovil(true);



}

function AbrirMenuMovil(esEjecucionAutomatica = false)
{

    //oculto los demas menos moviles

    mostrarMenuMovilOrdenar = true;
    mostrarMenuMovilFiltro = true;


    if (mostrarMenu & !esEjecucionAutomatica)
    {
        document.getElementById('menu-movil-dorado').style.borderBottom = 'none';
        setTimeout(function() {

            document.getElementById('menu-movil-dorado-opcion').className = 'navbar-collapse collapse collapsing show';

        }, 50);

        setTimeout(function() {

            document.getElementById('menu-movil-dorado-opcion').style.height = '90vh';
            document.getElementById('logo').style.display = 'block';

            if (document.getElementById('privacity-content'))
            {
                document.getElementById('privacity-content').style.display = 'none';
            }

            document.getElementById('politica').classList.remove('d-none');
            document.getElementById('politicadesktop').classList.remove('d-flex');
            document.getElementById('politicadesktop').classList.add('d-none');
            document.getElementById('lista-menu').style.display ='block';
            //politicadesktop

        }, 150);


    }
    else
    {
        document.getElementById('menu-movil-dorado').style.borderBottom = '1px solid black';
        document.getElementById('menu-movil-dorado-opcion').style.height = '0';

        //ocultar logo
        document.getElementById('logo').style.display = 'none';

        document.getElementById('politica').classList.add('d-none');
        document.getElementById('lista-menu').style.display ='none';

        if (!modoMovil)
        {
            if (document.getElementById('politicadesktop') != null)
            {
                document.getElementById('politicadesktop').classList.remove('d-none');
                document.getElementById('politicadesktop').classList.add('d-flex');
            }

        }

        setTimeout(function() {

            if (document.getElementById('privacity-content'))
            {
                document.getElementById('privacity-content').style.display = 'block';
            }



        }, 150);



    }

    if (!esEjecucionAutomatica) { mostrarMenu =!mostrarMenu; console.log("mostrar", mostrarMenu); }


}





///primer ejecucion por tiempo
setTimeout( function () {
    validarDimenciones();
}, 10);

//para escuchar el evento de cambio de tamaño
window.onresize = validarDimenciones;