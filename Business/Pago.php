<?php


namespace Tiendita;

use Conekta\Conekta;
use Conekta\Customer;

require_once("Conekta.php");
require_once "Data/Models/Pagos.php";
require_once "Data/Models/ModeloPagos.php";
require_once "Business/Utilidades.php";

class Pago
{
    /**
     * @var mixed
     */
    private $customer;

    public function __construct($token, $card, $name, $description, $total, $email){

        $this->token=$token;
        $this->card=$card;
        $this->name=$name;
        $this->description=$description;
        $this->total=$total;
        $this->email=$email;



        Conekta::setApiKey("key_eYvWV7gSDkNYXsmr");
        Conekta::setApiVersion("2.0.0");
        Conekta::setLocale('es');

        $this->card=$card;



    }

    public function Pay(){


        if(!$this->Validate())
            return false;

        if(!$this->CreateCustomer())
            return false;

        if(!$this->CreateOrder())
            return false;

        $u=new Utilidades();
        $oPagos=new ModeloPagos();
        $entidadPagos=new Pagos(0,1);
        $entidadPagos->Compania="$this->name ($this->email)";
        $entidadPagos->Descripcion=$this->card;
        $entidadPagos->EstatusPago=true;
        $entidadPagos->MontoPago=$this->total;
        $entidadPagos->FechaCambio=$u->FechaHoy();
        $entidadPagos->IdTipoMovimiento=1;
        $entidadPagos->IdUsuarioBase=0;
        $entidadPagos->

        $oPagos->insert($entidadPagos);
        return true;
    }

    public function Validate(){
        if($this->card=="" || $this->name=="" || $this->description=="" || $this->total=="" || $this->email==""){
            $this->error="El número de tarjeta, el nombre, concepto, monto y correo electrónico son obligatorios";
            return false;
        }

        if(strlen($this->card)<=14){
            $this->error="El número de tarjeta debe tener al menos 15 caracteres";
            return false;
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $this->error="El correo electrónico no tiene un formato de correo valido";
            return false;
        }
        if($this->total<=20){
            $this->error="El monto debe ser mayor a 20 pesos";
            return false;
        }

        return true;
    }

    public function CreateCustomer(){
        try {
            $this->customer = Customer::create(
                array(
                    "name" => $this->name,
                    "email" => $this->email,
                    //"phone" => "+52181818181",
                    "payment_sources" => array(
                        array(
                            "type" => "card",
                            "token_id" => $this->token
                        )
                    )//payment_sources
                )//customer
            );
        } catch (\Conekta\ProcessingError $error){
            $this->error=$error->getConektaMessage();
            return false;
        } catch (\Conekta\ParameterValidationError $error){
            $this->error=$error->getConektaMessage();
            return false;
        } catch (\Conekta\Handler $error){
            $this->error=$error->getConektaMessage();
            return false;
        }

        return true;
    }

    public function CreateOrder(){
        try{

            $this->order = \Conekta\Order::create(
                array(
                    "amount"=>$this->total,
                    "line_items" => array(
                        array(
                            "name" => $this->description,
                            "unit_price" => $this->total*100, //se multiplica por 100 conekta
                            "quantity" => 1
                        )//first line_item
                    ), //line_items
                    "currency" => "MXN",
                    "customer_info" => array(
                        "customer_id" => $this->customer->id
                    ), //customer_info
                    "charges" => array(
                        array(
                            "payment_method" => array(
                                "type" => "default"
                            )
                        ) //first charge
                    ) //charges
                )//order
            );
        } catch (\Conekta\ProcessingError $error){
            $this->error=$error->getMessage();
            return false;
        } catch (\Conekta\ParameterValidationError $error){
            $this->error=$error->getMessage();
            return false;
        } catch (\Conekta\Handler $error){
            $this->error=$error->getMessage();
            return false;
        }

        return true;
    }


}