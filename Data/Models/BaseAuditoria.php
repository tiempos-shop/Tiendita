<?php


namespace Tiendita;

use DateTime;

class BaseAuditoria
{
    public $FechaCambio;
    public $IdTipoMovimiento;
    public $TipoMovimiento;
    public $IdUsuarioBase;
    public $UsuarioBase;

    public function __construct()
    {
        include_once ("TipoMovimiento.php");
        $this->IdTipoMovimiento=new TipoMovimiento();
        $this->FechaCambio = ""; // new DateTime('d/m/Y H:i:s');
        // $this->IdUsuarioBase=new Usuarios();
    }
}