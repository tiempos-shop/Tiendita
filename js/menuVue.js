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
            imprimt : 'IMPRINT'
        },
        totalEnCarrito:0
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
            })
        }
    },
    async mounted() {
        var nombreCliente = document.getElementById("idCliente");

        if (nombreCliente != null)
        {
            var nombre =  nombreCliente.value;

            if (nombre.length >0)
            {
                this.cliente.nombre = nombre;
            }
        }
    },
    

});