<?php


namespace Tiendita;
include_once ("ModeloBase.php");
include_once "Data/Models/Clientes.php";
include_once "Data/Models/ModeloTipoMovimiento.php";
include_once "Data/Models/Direcciones.php";

class ModeloClientes extends ModeloBase
{
    public function __construct()
    {
        parent::__construct("Clientes","IdCliente",Clientes::getProperties());
    }

    public function Object2SimpleTable(string $k, object $v)
    {
        if($k=="TipoMovimiento") {
            return $v->Descripcion;
        }
        elseif ($k=="UsuarioBase"){
            return $v->Nombres." ".$v->Apellidos;
        }
        else{
            return "No definido campo: ".$k;
        }
    }

    public function Object2SimpleFormulary(string $k, object $v)
    {
        if($k=="TipoMovimiento") {
            return "
            <div class='row'>
                <div class='col-sm-2'>Modificación</div>
                <div class='col-sm-10'>$v->Descripcion</div>
            </div>";
        }
        elseif ($k=="UsuarioBase"){
            return "
            <div class='row'>
                <div class='col-sm-2'>Usuario</div>
                <div class='col-sm-10'>$v->Nombres $v->Apellidos</div>
            </div>";

        }
        else{
            return "No definido campo: ".$k;
        }
    }

    public function Adicional()
    {
        return [ "ad1"=>"Tipo Movimiento", "ad2"=>"Usuario "];
    }

    public function SimpleAdd()
    {
        return $this->Adicional();
    }

    public function Foreign(string $k, string $v)
    {
        return "";
    }

    public function ForeignInput(string $k, string $v)
    {
        return "";
    }
}