<?php


namespace Tiendita;
include_once "ModeloBase.php";
include_once "Data/Models/MotivoDevoluciones.php";


class ModeloMotivoDevoluciones extends ModeloBase
{
    public function __construct()
    {
        parent::__construct("MotivoDevoluciones", "IdMotivoDevolucion", MotivoDevoluciones::getProperties(), false);
    }

    public function Object2SimpleTable(string $k, object $v)
    {
        return "";
    }

    public function Adicional()
    {
        return [];
    }

    public function SimpleAdd()
    {
        return $this->Adicional();
    }

    public function Object2SimpleFormulary(string $k, object $v)
    {
        return "";
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