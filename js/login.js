
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
        status:{
            enviando:false,
            confirmadoEnvio:false,
        }

    },
    methods: {
        async CrearCuenta()
        {
            this.status.enviando = true;

            await axios.post(ServeApi + "api/login", this.cliente)
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