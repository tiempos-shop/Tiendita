<?php


namespace Tiendita;
include_once ("ModeloBase.php");
include_once "TipoMovimiento.php";

class ModeloTipoMovimiento extends ModeloBase
{
    public function __construct()
    {
        parent::__construct("TipoMovimientos", "IdTipoMovimiento", TipoMovimiento::getProperties(),false);
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
}