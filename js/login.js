
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
        },
        problemas:{
            sistema:'',
            inicio:"",
            registrar:""
        }

    },
    methods: {
        ObtenerRutaRedirigir()
        {

            var rutaRedirigir = localStorage.getItem('ruta');
            if (rutaRedirigir == null)
            {
                rutaRedirigir = "shoptienda.php";
            }

            return rutaRedirigir;
        },
        async Iniciar()
        {
            this.problemas.inicio = "";
            this.problemas.sistema = "";
            try {
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
                            if (data.data == "iniciado")
                            {
                                this.status.inicioConfirmado = true;
                                location.href = this.ObtenerRutaRedirigir();
                            }
                            else
                            {
                                this.status.iniciando = false;
                            }
                        });
                        
                    }
                    else
                    {
                        if (resultado.data.idCliente == 0)
                        {
                            this.problemas.sistema = "no hay información de la sessión, idcliente";
                        }
                    };
                    
                }).catch((problemas) =>{

                    this.problemas.sistema = "ocurrio un problema con el inicio de sesión";

                    if (problemas.response.data)
                    {
                        this.problemas.inicio = problemas.response.data;
                    }
                    this.status.iniciando = false;
                });
            } catch (error) {
                this.status.iniciando = false;
            }
            
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
            }).
            catch((problemas)=>
            {
                this.status.enviando = false;
                this.problemas.registrar = "ocurrio un problema con el registro";
                var respuesta = problemas.response.data;
                if (respuesta)
                {
                    this.problemas.registrar = "problem!";
                    if (respuesta.name)
                    {
                        this.problemas.registrar = respuesta.name;
                    }
                    if (respuesta.lastname)
                    {
                        this.problemas.registrar = respuesta.lastname;
                    }
                    if (respuesta.email)
                    {
                        this.problemas.registrar = respuesta.email;
                    }
                    if (respuesta.password)
                    {
                        this.problemas.registrar = respuesta.password;
                    }
                    if (respuesta.password2)
                    {
                        this.problemas.registrar = respuesta.password2;
                    }
                    if (respuesta.sistema)
                    {
                        this.problemas.registrar = respuesta.sistema;
                    }
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
            if (this.idCliente.length >0)
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
            
        
            
        }
    },
    async mounted() {
        this.$cantidadCarrito = 0;
        
        this.idCliente = document.getElementById('idCliente').value;
        var respuestaMonedas = this.CargaInicial();
        await this.ObtenerCarrito();
        await respuestaMonedas;


    },
    

});