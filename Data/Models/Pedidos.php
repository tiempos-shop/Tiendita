<?php


namespace Tiendita;
include_once "iEntity.php";
include_once "BaseAuditoria.php";

class Pedidos extends BaseAuditoria implements iEntity
{
    public $IdPedido = 0 ;
    public $IdEstatusPedido = "" ;
    public $IdEnvio = 0 ;
    public $FechaPedido = "" ;
    public $IdCliente = 0 ;

    public static function getProperties(): array
    {
        return [
            "IdPedido"=>["label"=>"Id","type"=>"I","typeDb"=>"#","required"=>false],
            "IdEstatusPedido"=>["label"=>"Estatus","type"=>"*","typeDb"=>"$","required"=>true],
            "IdEnvio"=>["label"=>"Apellidos","type"=>"F","typeDb"=>"#","required"=>false,"table"=>"Envios"],
            "FechaPedido"=>["label"=>"Fecha de Pedido","type"=>"D","typeDb"=>"$","required"=>true],
            "IdCliente"=>["label"=>"Cliente","type"=>"F","typeDb"=>"#","required"=>true,"table"=>"Clientes"],
            "FechaCambio"=>["label"=>"Fecha Auditoria","type"=>"F","typeDb"=>"$","required"=>false],
            "IdTipoMovimiento"=>["label"=>"Tipo Movimiento","type"=>"F","typeDb"=>"#","required"=>false],
            "IdUsuarioBase"=>["label"=>"Usuario de Registro]","type"=>"F","typeDb"=>"#","required"=>false]
        ];
    }
}