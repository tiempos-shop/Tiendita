<?php
require_once("Business/Pago.php");
extract($_REQUEST);

if (isset($conektaTokenId)) {
    if (isset($card)) {
        if (isset($name)) {
            if (isset($description)) {
                if (isset($total)) {
                    if (isset($email)) {
                        $oPayment= new \Tiendita\Pago($conektaTokenId, $card,$name,$description,$total,$email);
                    }
                }
            }
        }
    }
}

if($oPayment->pay()){
    echo "Pago realizado con exito";
}else{
    echo $oPayment->error;
}

?>