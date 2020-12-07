<?php


namespace Tiendita;
use DateTime;

abstract class BaseAuditoria
{
    public $FechaCambio;
    public $IdTipoMovimiento=0;
    public $TipoMovimiento;
    public $IdUsuarioBase=0;
    public $UsuarioBase;

    public function __construct(int $idUsuario,int $idTipoMovimiento)
    {
        include_once ("TipoMovimiento.php");
        $this->TipoMovimiento=new TipoMovimiento();
        //$this->UsuarioBase=new Usuarios();
        $utilidades=new Utilidades();

        $this->FechaCambio = $utilidades->FechaHoy();
        $this->IdUsuarioBase=$idUsuario;
        $this->IdTipoMovimiento=$idTipoMovimiento;

    }
}