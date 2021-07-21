async function CalcRate()
{
    var postalcode = document.getElementById("postalcode").value;
    var moneda = document.getElementById("moneda").value;
    var checkEntrega = document.getElementById('tiempoEntrega');
    var checkLabel = document.getElementById('postalcodetext');

    var data = {
        "precio": 150,
        "campo" : "valor",
        "moneda": moneda,
        "codigo_postal": postalcode,
        "cantidad_productos":1
    }


    checkLabel.textContent = "";
    checkLabel.classList.add("text-muted");

    checkEntrega.disabled = true;

    await axios.post("http://127.0.0.1:8000/api/envios_mov/cotizar", data)
        .then((resultado) => {
            console.log(resultado.data);
            var info =resultado.data;
            if (info.idcotizacion != null)
            {
                checkEntrega.disabled = false;
                checkLabel.classList.remove('text-muted');
                checkLabel.textContent = info.precio + " " + info.moneda + " " +  info.dias + " DAYS";
            }
        });
    //console.log(data);
}

async function ObtenerDireccionPrincipal()
{
    console.log("obte direcc");
    await axios.get('http://127.0.0.1:8000/api/direccion/porcliente/1')
        .then((resultado)=>{
            console.log(resultado.data);
        })
}

ObtenerDireccionPrincipal();