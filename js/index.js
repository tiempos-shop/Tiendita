
var mostrarMenu = true;

function validarDimenciones() {
    var alto = window.innerHeight;
    var ancho = window.innerWidth;
    if (ancho>= 576)
    {
        mostrarMenu = false;
        cambiarLogoFijo();
        console.log("ajustado");
    }
    console.log("validando tamaño");
}

function cambiarLogoFijo()
{

    if (mostrarMenu)
    {
        logo.src='img/ts_iso_negro.png';

        document.getElementById('t').style.display = 'none';


        document.getElementById('botonMenuMovil').className = 'navbar-toggle ml-3';

        document.getElementById('t').style.position = 'relative';


        setTimeout(function() {

            document.getElementById('menu-movil-dorado-opcion').className = 'navbar-collapse collapse collapsing show';

        }, 50);

        setTimeout(function() {

            document.getElementById('menu-movil-dorado-opcion').style.height = '90vh';
            document.getElementById('botonMenuMovil').style.color = 'black';
            document.getElementById('contenedorIndex').style.display = 'none';
            document.getElementById('t').style.display = 'none';


            document.getElementById('politica').classList.remove('d-none');

        }, 150);


    }
    else
    {
        logo.src='img/ts_iso_oro.png';
        document.getElementById('menu-movil-dorado-opcion').style.height = '0';

        document.getElementById('politica').classList.add('d-none');

        setTimeout(function() {

            document.getElementById('t').style.position = 'fixed';
            document.getElementById('botonMenuMovil').style.color = '#AC9950';
            document.getElementById('contenedorIndex').style.display = 'block';
            document.getElementById('t').style.display = 'block';

        }, 150);



    }

    mostrarMenu =! mostrarMenu;
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

window.onresize = validarDimenciones;