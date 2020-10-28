<?php


namespace Tiendita;


class BaseAuditoria
{
    public $FechaCambio;
    public $IdTipoMovimiento;
    public $IdUsuario;

    public function __construct()
    {
        include_once ("TipoMovimiento.php");
        $IdTipoMovimiento=new TipoMovimiento();


    }
}