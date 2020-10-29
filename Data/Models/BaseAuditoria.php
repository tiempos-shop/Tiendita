<?php


namespace Tiendita;


use Cassandra\Date;

class BaseAuditoria
{
    public $FechaCambio;
    public $IdTipoMovimiento;
    public $IdUsuarioBase;

    public function __construct()
    {
        include_once ("TipoMovimiento.php");
        $this->IdTipoMovimiento=new TipoMovimiento();
        $this->FechaCambio=""; //\DateTime::createFromFormat('j-M-Y', '0-Ene-2000');
        //$this->IdUsuarioBase=new Usuarios();
    }
}