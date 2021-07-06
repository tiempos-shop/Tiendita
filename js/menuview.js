
var mostrarMenu = true;
var modoMovil = false;



function validarDimenciones() {
    var alto = window.innerHeight;
    var ancho = window.innerWidth;

    //ajuste de elementos con relacion de boton y logo
    var separacionBotonMenu = document.getElementById("botonMenuMovil").offsetLeft;
    var separacionCart = document.getElementById("carrito").offsetLeft;

    //document.getElementById('contenedorCart').classList.add('ocultarmargen');
    //document.getElementById('menu-movil-dorado').classList.remove('bg-white');

    if (ancho<=768)
    {

        //document.getElementById('menu-movil-dorado').style.transition = 'transition: background 0.2s ease 0s;';
        document.getElementById('lista-menu').style.left = separacionBotonMenu +'px';
        document.getElementById('logo').style.left = separacionCart +'px';

        modoMovil = true;

    }
    mostrarMenu = true;
    cambiarLogoFijo(true);
}

function cambiarLogoFijo(esEjecucionAutomatica = false)
{
    if (mostrarMenu & !esEjecucionAutomatica)
    {
        document.getElementById('botonMenuMovil').className = 'navbar-toggle ';

        setTimeout(function() {
            document.getElementById('menu-movil-dorado-opcion').className = 'navbar-collapse collapse collapsing show';
        }, 50);

        setTimeout(function() {

            document.getElementById('menu-movil-dorado-opcion').style.height = '110vh';
            document.getElementById('menu-movil-dorado-opcion').style.marginTop = '-10vh';
            document.getElementById('menu-movil-dorado-opcion').style.background = 'white';
            //document.getElementById('menu-movil-dorado').style.background = 'white';
            document.getElementById('menu-movil-dorado-opcion').style.left = '0';
            document.getElementById('botonMenuMovil').style.color = 'black';
            document.getElementById('carrito').style.color = 'black';

            document.getElementById('politica').classList.remove('d-none');
            document.getElementById('lista-menu').style.display ='block';
        }, 150);
    }
    else
    {
        document.getElementById('menu-movil-dorado-opcion').style.height = '0';
        document.getElementById('menu-movil-dorado').style.height = '40px';
        document.getElementById('politica').classList.add('d-none');
        document.getElementById('lista-menu').style.display ='none';
    }
    if (!esEjecucionAutomatica) { mostrarMenu =! mostrarMenu; }
}

window.onload=function (){
    //load();
}

function go(url){
    window.location.href=url;
}

function load(){
    setTimeout(
        function ()
        {
            var r=document.getElementById("right_home");
            r.style.visibility="visible";

        },1000
    );

}

function tOverMenu(){
    var t=document.getElementById("t");
    var tover=document.getElementById("t-over");
    t.style.visibility="hidden";
    tover.style.visibility="visible";
}

function tOffMenu(){
    const t=document.getElementById("t");
    const tover=document.getElementById("t-over");
    t.style.visibility="visible";
    tover.style.visibility="hidden";
}

function view(str){
    var id=str; //.replace("_", "'");
    go("view.php?id="+id);
}



setTimeout( function () {
    var border = document.createElement('div');
    border.classList.add('border-archive');

    document.getElementById('menu-movil-dorado').appendChild(border);
    validarDimenciones(true);

}, 10);

window.onresize = validarDimenciones;


