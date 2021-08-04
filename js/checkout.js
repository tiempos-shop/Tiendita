async function ProcesarPedido()
{
    var postalcode = document.getElementById("postalcode").value;
    var moneda = document.getElementById("moneda").value;
    var checkEntrega = document.getElementById('tiempoEntrega');
    var checkLabel = document.getElementById('postalcodetext');
    var idiomaActual = document.getElementById('idiomaActual');
    var envioLabel = document.getElementById('precioEnvio');
    var monedaLavel = document.getElementById('monedaEnvio');
    var monedaTotalLabel = document.getElementById('monedaTotal');
    var precioTotalLabel = document.getElementById('precioTotal');
    var subtotalInput = document.getElementById('subtotal').value;
    var procesarLabel = document.getElementById('procesarText');
    var total = Number(precioTotalLabel.textContent);
    var envio = Number(envioLabel.textContent);
    var subtotal = Number(subtotalInput);
    var name  = nombre.value;
    var firstname = apellido.value;

    var data = {
        "idCliente": 1,
        "nombre": name,
        "apellido" : firstname,
        "idDireccion" : 2,
        "moneda": moneda,
        "total" : total,
        "precioEnvio" : envio,
        "subtotal": subtotal
    }
    procesarLabel.textContent = "Loading...";
    await axios.post(ServeApi + "api/pedidos", data)
    .then((resultado) => {
        console.log(resultado.data);
        var info =resultado.data;
        if (info.IdPedido>0)
        {
            console.log("Procesado!");
        }
    });
    procesarLabel.textContent = "READY";


}

async function CalcRate()
{
    var postalcode = document.getElementById("postalcode").value;
    var moneda = document.getElementById("moneda").value;
    var checkEntrega = document.getElementById('tiempoEntrega');
    var checkLabel = document.getElementById('postalcodetext');
    var idiomaActual = document.getElementById('idiomaActual');
    var envioLabel = document.getElementById('precioEnvio');
    var monedaLavel = document.getElementById('monedaEnvio');
    var monedaTotalLabel = document.getElementById('monedaTotal');
    var precioTotalLabel = document.getElementById('precioTotal');
    var subtotalInput = document.getElementById('subtotal').value;

    var data = {
        "precio": 150,
        "campo" : "valor",
        "moneda": moneda,
        "codigo_postal": postalcode,
        "cantidad_productos":1
    }

    checkLabel.textContent = "";
    var textoDias = "days";
    switch (idiomaActual)
    {
        case "ESPAÑOL" :
            checkLabel.textContent = "Cargando ...";
            textoDias = "DÍAS";
            break;
        default:
            checkLabel.textContent = "Loading ...";
            textoDias = "DAYS";
            break;
    }

    checkLabel.classList.add("text-muted");

    checkEntrega.disabled = true;

    await axios.post(ServeApi + "api/envios_mov/cotizar", data)
    .then((resultado) => {
        console.log(resultado.data);
        var info =resultado.data;
        if (info.dias != null)
        {
            checkEntrega.disabled = false;
            checkLabel.classList.remove('text-muted');
            checkLabel.textContent = info.precio + " " + info.moneda + " " +  info.dias + " " +  textoDias;
            envioLabel.textContent = info.precio;
            monedaLavel.textContent = info.moneda;
            monedaTotalLabel.textContent = moneda;
            precioTotalLabel.textContent = Number(info.precio) + Number(subtotalInput);
        }
    });

}

async function ObtenerDireccionPrincipal()
{
    console.log("obte direcc");
    await axios.get(ServeApi + 'api/direccion/porcliente/1')
        .then((resultado)=>{
            console.log(resultado.data);
            var data = resultado.data;
            telefono.value= data.telefono;
            nombre.value=data.nombre;
            apellido.value = data.apellido;
            company.value = data.company;
            calle.value = data.Calle;
            ciudad.value = data.Ciudad;
            postalcode.value= data.CodigoPostal;
            pais.value = data.Pais;
            estado.value = data.estado;
            CalcRate();
        });
}

ObtenerDireccionPrincipal();

console.log(ServeApi);