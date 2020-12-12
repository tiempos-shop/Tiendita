<?php


namespace Tiendita;
use DateTime;
include_once ("TipoMovimiento.php");

abstract class BaseAuditoria
{
    public $FechaCambio;
    public $IdTipoMovimiento=0;
    public $TipoMovimiento;
    public $IdUsuarioBase=0;
    public $UsuarioBase;

    public function __construct(int $idUsuario,int $idTipoMovimiento)
    {

        $this->TipoMovimiento=new TipoMovimiento();
        //$this->UsuarioBase=new Usuarios();
        $utilidades=new Utilidades();

        $this->FechaCambio = $utilidades->FechaHoy();
        $this->IdUsuarioBase=$idUsuario;
        $this->IdTipoMovimiento=$idTipoMovimiento;

    }
}