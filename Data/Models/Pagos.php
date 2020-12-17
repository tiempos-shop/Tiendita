<?php


namespace Tiendita;
include_once "iEntity.php";

class Pagos extends BaseAuditoria implements iEntity
{

    public $IdPago = 0 ;
    public $Descripcion = "" ;
    public $Compania = "" ;
    public $EstatusPago = false ;

    public static function getProperties(): array
    {
        return [];
    }
}