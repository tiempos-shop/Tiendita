var mostrarMenu = true;
var mostrarMenuMovilFiltro = true;
var modoMovil = false;
var mostrarMenuMovilOrdenar = true;

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
        document.getElementById('menufamilia').style.display = 'none';
        document.getElementById('menufiltro').style.display = 'none';
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

function  OcultarCaracter()
{
    var menus, i;
    menus = document.querySelector('#menu-movil-dorado').querySelectorAll(".menu");


    for (i = 0; i < menus.length; i++) {

        menus[i].querySelector('.caracter').classList.add('text-white');

    }
}

function  AbrirSubMenuFiltro(index) {
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
}

function AbrirMenuMovil(esEjecucionAutomatica = false)
{
    OcultarCaracter();

    //oculto los demas menos moviles
    document.getElementById('menu-movil-filtro').style.height = '0';
    document.getElementById('lista-filtro').style.display = 'none';
    document.getElementById('lista-orden').style.display = 'none';
    document.getElementById('menu-movil-ordenamiento').style.height = '0';
    mostrarMenuMovilOrdenar = true;
    mostrarMenuMovilFiltro = true;


    if (mostrarMenu & !esEjecucionAutomatica)
    {
        document.getElementById('botonMenuMovil').querySelector('.caracter').classList.remove('text-white');
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


        }, 150);



    }

    if (!esEjecucionAutomatica) { mostrarMenu =!mostrarMenu; console.log("mostrar", mostrarMenu); }


}

function AbrirMenuMovilFiltro(esEjecucionAutomatica = false)
{
    OcultarCaracter();
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

}

function AbrirMenuMovilOrdenar(esEjecucionAutomatica = false )
{
    OcultarCaracter();

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

}


setTimeout( function () {
    ///para todos los elementos de menu principal agregar caracter
    var menus, i;
    menus = document.querySelectorAll(".menu");


    for (i = 0; i < menus.length; i++) {
        var caracterSpan = document.createElement("span");
        var caracterValor = document.createTextNode("'");
        caracterSpan.appendChild(caracterValor);
        caracterSpan.classList.add('caracter', 'text-white', 'omitir');
        menus[i].appendChild(caracterSpan);
    }

    //para el submenus de filtro



    validarDimenciones();
}, 10);

window.onresize = validarDimenciones;

