<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Pago en línea</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link href="css/bootstrap.css"  type="text/css">
</head>

<body>

<form id="card-form">

    <input type="hidden" name="conektaTokenId" id="conektaTokenId" value="">

    <div class="card">
        <div class="card-header">
            <div class="row display-tr">
                <h3>Pago en línea</h3>

            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label>
                        Nombre del tarjetahabiente
                    </label>
                    <input value="Juan Ramirez Ledesma" data-conekta="card[name]" class="form-control" name="name" id="name"  type="text" >
                </div>
                <div class="col-md-6">
                    <label>
                        Número de tarjeta
                    </label>
                    <input value="4242424242424242" name="card" id="card" data-conekta="card[number]" class="form-control"   type="text" maxlength="16" >
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label>
                        CVC
                    </label>
                    <input value="399" data-conekta="card[cvc]" class="form-control"  type="text" maxlength="4" >
                </div>
                <div class="col-md-6">
                    <label>
                        Fecha de expiración (MM/AA)
                    </label>
                    <div>
                        <input style="width:50px; display:inline-block" value="11" data-conekta="card[exp_month]" class="form-control"  type="text" maxlength="2" >
                        <input style="width:50px; display:inline-block" value="22" data-conekta="card[exp_year]" class="form-control"  type="text" maxlength="2" >

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label><span>Email</span></label>
                    <input class="form-control" type="text" name="email" id="email" maxlength="200" value="pepepecaspicapapasconunpico666@gmail.com">
                </div>
                <div class="col-md-4">
                    <label>Concepto</label>
                    <input class="form-control" type="text" name="description" id="description" maxlength="100" value="papitas">
                </div>
                <div class="col-md-4">
                    <label>Monto</label>
                    <input class="form-control" type="number" name="total" id="total" value="30">
                </div>

            </div>
            <br>
            <div class="row">
                <div class="col-md-12" style="text-align:center;">
                    <button class="btn btn-success btn-lg">
                        <i class="fa fa-check-square"></i> PAGAR
                    </button>
                </div>

            </div>

        </div>
    </div>


</form>

<script>
    Conekta.setPublicKey("key_eYvWV7gSDkNYXsmr");

    var conektaSuccessResponseHandler= function(token){

        $("#conektaTokenId").val(token.id);

        jsPay();
    };

    var conektaErrorResponseHandler =function(response){
        var $form=$("#card-form");

        alert(response.message_to_purchaser);
    }

    $(document).ready(function(){

        $("#card-form").submit(function(e){
            e.preventDefault();

            var $form=$("#card-form");

            Conekta.Token.create($form,conektaSuccessResponseHandler,conektaErrorResponseHandler);
        })

    })

    function jsPay(){
        let params=$("#card-form").serialize();
        let url="respuestaPago.php";

        $.post(url,params,function(data){
            if(data=="1"){
                alert("Se realizo el pago :D");
                jsClean();
            }else{
                alert(data)
            }

        })

    }

    function jsClean(){
        $(".form-control").prop("value","");
        $("#conektaTokenId").prop("value","");
    }
</script>

</body>
</html>
