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

    await axios.post("business/api/apidhl.php", data)
        .then((resultado) => {
            console.log(resultado.data);
            var info =resultado.data;
            if (info.dias != null)
            {
                checkEntrega.disabled = false;
                checkLabel.classList.remove('text-muted');
                checkLabel.textContent = info.Amount + " " + info.Currency + " " +  info.dias + " DAYS";
            }
        });
    //console.log(data);
}