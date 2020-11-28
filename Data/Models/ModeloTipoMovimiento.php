<?php


namespace Tiendita;
include_once ("ModeloBase.php");

class ModeloTipoMovimiento extends ModeloBase
{
    public function __construct()
    {
        parent::__construct("TipoMovimientos", "IdTipoMovimiento", TipoMovimiento::getCampos(), TipoMovimiento::getType(), false);
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
}