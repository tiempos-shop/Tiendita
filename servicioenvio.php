<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tienda Shop - Envios Pendientes</title>
    <script src="js/vue.js"></script>
    <script src="js/axios.min.js"></script>
    <link rel="stylesheet" href="View/css/bootstrap.css">
</head>
<body>
    <div id="app">
        <div class="container">
            <h2>ENVIOS PENDIENTES</h2>
            <div class="row">
                <div class="col-md-12">
                    <h4>POR ATENDER</h4>

                    <ul class="list-group">
                        <li class="list-group-item" v-if="pendientes.length ==0">
                            <div class="text-muted">No hay servicios pendientes de confirmar</div>
                        </li>
                        <li v-for="(servicio, index) in pendientes" class="list-group-item">
                            <div class="row">
                                <div class="col-md-2">
                                    <span>{{servicio.precio | moneda}}</span>
                                    <span class="pl-1 text-muted">{{servicio.moneda | moneda}}</span>
                                </div>
                                <div class="col-md-1">

                                </div>
                                <div class="col-md-4">
                                    {{servicio.nombre}}
                                </div>
                                <div class="col-md-1">
                                    {{servicio.codigo_postal}}
                                </div>

                                <div class="col-md-4">
                                    <button class="btn btn-primary btn-sm" @click="ConfirmarEmpaquetado(index, servicio)">
                                        EMPAQUETADO
                                        <span v-if="status.enviandoInfo">
                                            ...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-md-12 mt-4">
                    ATENDIDOS

                    <ul class="list-group">
                        <li class="list-group-item" v-if="empaquetados.length ==0">
                            <div class="text-muted">No hay servicios Empaquetados</div>
                        </li>
                        <li v-for="servicio in empaquetados" class="list-group-item">
                            <div class="row">

                                <div class="col-md-2">
                                    <span>{{servicio.precio | moneda}}</span>
                                    <span class="pl-1 text-muted">{{servicio.moneda | moneda}}</span>
                                </div>
                                <div class="col-md-1">

                                </div>
                                <div class="col-md-4">
                                    {{servicio.nombre}}
                                </div>
                                <div class="col-md-1">
                                    {{servicio.codigo_postal}}
                                </div>

                                <div class="col-md-4">
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        ARCHIVO PDF
                                    </button>
                                </div>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>

        Vue.filter('moneda', function (value) {
            if (typeof value !== "number") {
                return value;
            }
            var formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
                minimumFractionDigits: 2
            });
            return formatter.format(value);
        });

        new Vue({
            el: "#app",
            data: {
                pendientes:[],
                empaquetados:[],
                status:{
                    enviandoInfo: false,
                }
            },
            methods: {
                async ConfirmarEmpaquetado(index, servicio){
                    console.log("index", index);
                    console.log("servicio", servicio);
                    this.status.enviandoInfo = true;

                    await axios.post("/Tiendita/business/api/apidhl.php?ruta=envio", servicio)
                    .then((resultado) => {
                        console.log("resultado", resultado.data);
                        var datos = resultado.data.ShipmentResponse.PackagesResult.PackageResult;
                        console.log("result packe",datos);
                        if (datos[0].TrackingNumber)
                        {
                            this.empaquetados.push(servicio);
                            this.pendientes.splice(index,1 );
                        }
                    });
                    this.status.enviandoInfo = false;

                }
            },
            mounted()
            {
                var envioPendiente = {
                    "precio": 150,
                    "moneda":"USD",
                    "codigo_postal":"44100",
                    "cantidad_productos":1,
                    "nombre" : "Luis Ricardo Genovez Cruz",
                    "telefono" : "899999999",
                    "correo" : "correoclientetest@gmail.com",
                    "calle" : "6a note s/n",
                    "ciudad" : "coita",
                    "codigo_pais" : "mx"
                }
                this.pendientes.push(envioPendiente);
            }
        });
    </script>

</body>
</html>
