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
        document.getElementById('t').classList.remove('d-block');
        document.getElementById('t').classList.add('d-none');
        document.getElementById('politicadesktop').classList.remove('d-flex');
        document.getElementById('politicadesktop').classList.add('d-none');
        document.getElementById('menu-movil-dorado').style.borderBottom = 'none';
        modoMovil = true;
    }
    else
    {

        document.getElementById('t').classList.remove('d-none');
        document.getElementById('t').classList.add('d-block');
        document.getElementById('politicadesktop').classList.remove('d-none');
        document.getElementById('politicadesktop').classList.add('d-flex');
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

            document.getElementById('privacity-content').style.display = 'none';


            document.getElementById('politica').classList.remove('d-none');
            document.getElementById('politicadesktop').classList.remove('d-flex');
            document.getElementById('politicadesktop').classList.add('d-none');
            //politicadesktop

        }, 150);


    }
    else
    {
        document.getElementById('menu-movil-dorado').style.borderBottom = '1px solid black';
        document.getElementById('menu-movil-dorado-opcion').style.height = '0';


        document.getElementById('politica').classList.add('d-none');

        if (!modoMovil)
        {
            document.getElementById('politicadesktop').classList.remove('d-none');
            document.getElementById('politicadesktop').classList.add('d-flex');
        }

        setTimeout(function() {


            document.getElementById('privacity-content').style.display = 'block';


        }, 150);



    }

    if (!esEjecucionAutomatica) { mostrarMenu =!mostrarMenu; console.log("mostrar", mostrarMenu); }


}






setTimeout( function () {
    validarDimenciones();
}, 10);

window.onresize = validarDimenciones;