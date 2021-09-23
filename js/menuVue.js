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
        totalEnCarrito:0,
        idioma:'-'
    },
    methods: {
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