<?php


namespace Tiendita;
include_once "Data/Models/ModeloBase.php";
include_once "Data/Models/Direcciones.php";

class ModeloDirecciones extends ModeloBase
{
    public function __construct()
    {
        parent::__construct("Direcciones","IdDireccion",Direcciones::getProperties(),false);
    }

    public function Object2SimpleTable(string $k, object $v)
    {
        if($k=="Cliente") {
            return $v->Nombre." ".$v->Apellidos;
        }
        else{
            return "No definido campo: ".$k;
        }
    }

    public function Object2SimpleFormulary(string $k, object $v)
    {
        if($k=="Cliente") {
            return "
            <div class='row'>
                <div class='col-sm-2'>Modificación</div>
                <div class='col-sm-10'>$v->Nombre.' '.$v->Apellidos</div>
            </div>";
        }
        else{
            return "No definido campo: ".$k;
        }
    }

    public function Adicional():array
    {
        return [ "ad1"=>"Cliente"];
    }

    public function SimpleAdd()
    {
        return $this->Adicional();
    }
}