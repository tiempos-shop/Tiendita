<?php


namespace Tiendita;
include_once "iEntity.php";
include_once "BaseAuditoria.php";

class Pagos extends BaseAuditoria implements iEntity
{

    public $IdPago = 0 ;
    public $Descripcion = "" ;
    public $Compania = "" ;
    public $EstatusPago = false ;
    public $MontoPago=0.0;

    public static function getProperties(): array
    {
        return [
            "IdPago"=>["label"=>"Id","type"=>"I","typeDb"=>"#","required"=>false],
            "Descripcion"=>["label"=>"Descripcion","type"=>"$","typeDb"=>"$","required"=>true],
            "Compania"=>["label"=>"Referencia","type"=>"#","typeDb"=>"#","required"=>false],
            "EstatusPago"=>["label"=>"Estatus Pago","type"=>"%","typeDb"=>"#","required"=>true],
            "MontoPago"=>["label"=>"Monto del Pago","type"=>"M","typeDb"=>"#","required"=>true],
            "FechaCambio"=>["label"=>"Fecha Auditoria","type"=>"F","typeDb"=>"$","required"=>false],
            "IdTipoMovimiento"=>["label"=>"Tipo Movimiento","type"=>"F","typeDb"=>"#","required"=>false],
            "IdUsuarioBase"=>["label"=>"Usuario de Registro]","type"=>"F","typeDb"=>"#","required"=>false]
        ];
    }
}