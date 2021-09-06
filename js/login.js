
var app = new Vue({
    el:'#app',
    data:{
        enCarrito:[],
        idCliente:0,
        monedas:[],
        idMoneda:0,
        siglasMoneda:"",
        subtotal:0,
        cliente:{
            name:'',
            lastname:'',
            email:'',
            password:'',
            newsletter: false
        },
        login:{
            email:'',
            password:'',
            session:'',
            accion:'',
        },
        status:{
            enviando:false,
            confirmadoEnvio:false,
            iniciando:false,
            inicioConfirmado:false,
        }

    },
    methods: {
        async Iniciar()
        {
            this.status.iniciando = true;
            this.login.accion ="ingresar";
            await axios.post(ServeApi + "api/login", this.login)
            .then((resultado) =>{
                if (resultado.data && resultado.data.idCliente != 0 && resultado.data.idCliente.length > 15)
                {
                    console.log("iniciado correcto");
                    resultado.data.accion ="ingresar";
                    
                    axios.post("session.php", resultado.data)
                    .then((data) =>{
                        console.log("data", data.data);
                        this.status.inicioConfirmado = true;
                        window.history.back();
                    })
                    
                }
                
            });
            this.status.iniciando = false;
        },
        async CrearCuenta()
        {
            this.status.enviando = true;

            await axios.post(ServeApi + "api/login/registrar", this.cliente)
            .then((resultado) =>{
                if (resultado.data == 1)
                {
                    this.status.confirmadoEnvio = true;
                }
            });

            this.status.enviando = false;
        },
        async CargaInicial()
        {
            await axios.get(ServeApi + "api/cargainicial/")
            .then((resultado) => {
                this.monedas = resultado.data;
            });
        },
        async ObtenerCarrito()
        {

        await axios.get(ServeApi + "api/encarrito/" + this.idCliente)
        .then((resultado) =>{
            if (resultado.data != null)
            {
                this.enCarrito = resultado.data;    
                this.$cantidadCarrito = this.enCarrito.length;
              
            }

        });
            
        }
    },
    async mounted() {
        this.$cantidadCarrito = 0;
        this.idCliente = 1;
        var respuestaMonedas = this.CargaInicial();
        await this.ObtenerCarrito();
        await respuestaMonedas;


    },
    

});