var mostrarMenu = true;
var mostrarMenuMovilFiltro = true;
var modoMovil = false;
var mostrarMenuMovilOrdenar = true;

function validarDimenciones() {
    var alto = window.innerHeight;
    var ancho = window.innerWidth;

    //document.getElementById('botonMenuMovil').style.color = 'black';

    ///PARA INICIO DE CARGA
    document.getElementById('politicadesktop').classList.remove('d-flex');
    document.getElementById('politicadesktop').classList.add('d-none');


    if (ancho<=768)
    {
        document.getElementById('menufamilia').style.display = 'none';
        document.getElementById('menufiltro').style.display = 'none';
        document.getElementById('politicadesktop').classList.remove('d-flex');
        document.getElementById('politicadesktop').classList.add('d-none');
        modoMovil = true;
    }
    else
    {
        document.getElementById('menufiltro').style.display = 'inline-block';
        document.getElementById('menufamilia').style.display = 'block';
        document.getElementById('politicadesktop').classList.remove('d-none');
        document.getElementById('politicadesktop').classList.add('d-flex');
        modoMovil = false;
    }

    //para los row de productos

    mostrarMenu = true;
    AbrirMenuMovil(true);
    mostrarMenuMovilFiltro = true;
    AbrirMenuMovilFiltro(true);


}

function AbrirMenuMovil(esEjecucionAutomatica = false)
{

    //oculto los demas menos moviles
    document.getElementById('menu-movil-filtro').style.height = '0';
    document.getElementById('menu-movil-ordenamiento').style.height = '0';
    mostrarMenuMovilOrdenar = true;
    mostrarMenuMovilFiltro = true;


    if (mostrarMenu & !esEjecucionAutomatica)
    {

        setTimeout(function() {

            document.getElementById('menu-movil-dorado-opcion').className = 'navbar-collapse collapse collapsing show';

        }, 50);

        setTimeout(function() {

            document.getElementById('menu-movil-dorado-opcion').style.height = '90vh';

            document.getElementById('contenedorIndex').style.display = 'none';


            document.getElementById('politica').classList.remove('d-none');
            document.getElementById('politicadesktop').classList.remove('d-flex');
            document.getElementById('politicadesktop').classList.add('d-none');
            //politicadesktop

        }, 150);


    }
    else
    {

        document.getElementById('menu-movil-dorado-opcion').style.height = '0';


        document.getElementById('politica').classList.add('d-none');

        if (!modoMovil)
        {
            document.getElementById('politicadesktop').classList.remove('d-none');
            document.getElementById('politicadesktop').classList.add('d-flex');
        }

        setTimeout(function() {


            document.getElementById('contenedorIndex').style.display = 'block';


        }, 150);



    }

    if (!esEjecucionAutomatica) { mostrarMenu =!mostrarMenu; console.log("mostrar", mostrarMenu); }


}

function AbrirMenuMovilFiltro(esEjecucionAutomatica = false)
{

    //oculto los demas menos moviles
    document.getElementById('menu-movil-dorado-opcion').style.height = '0';
    document.getElementById('menu-movil-ordenamiento').style.height = '0';

    mostrarMenu = true;
    mostrarMenuMovilOrdenar = true;

    if (mostrarMenuMovilFiltro & !esEjecucionAutomatica)
    {
        setTimeout(function() {

            document.getElementById('menu-movil-filtro').className = 'navbar-collapse collapse collapsing show';

        }, 50);

        setTimeout(function() {

            document.getElementById('menu-movil-filtro').style.height = '90vh';

            document.getElementById('contenedorIndex').style.display = 'none';


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


            document.getElementById('contenedorIndex').style.display = 'block';


        }, 150);



    }
    if (!esEjecucionAutomatica) { mostrarMenuMovilFiltro =! mostrarMenuMovilFiltro; }

}

function AbrirMenuMovilOrdenar(esEjecucionAutomatica = false )
{

    //oculto los demas menos moviles
    document.getElementById('menu-movil-dorado-opcion').style.height = '0';
    document.getElementById('menu-movil-filtro').style.height = '0';
    mostrarMenu = true;
    mostrarMenuMovilOrdenar = true;

    if (mostrarMenuMovilOrdenar & !esEjecucionAutomatica)
    {

        setTimeout(function() {

            document.getElementById('menu-movil-ordenamiento').className = 'navbar-collapse collapse collapsing show';

        }, 50);

        setTimeout(function() {

            document.getElementById('menu-movil-ordenamiento').style.height = '90vh';

            document.getElementById('contenedorIndex').style.display = 'none';


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


            document.getElementById('contenedorIndex').style.display = 'block';


        }, 150);



    }
    if (!esEjecucionAutomatica) { mostrarMenuMovilOrdenar =! mostrarMenuMovilOrdenar; }

}


setTimeout( function () {
    validarDimenciones();
}, 10);

window.onresize = validarDimenciones;