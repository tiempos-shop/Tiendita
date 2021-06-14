<?php


namespace Tiendita;
include_once "iEntity.php";
include_once "BaseAuditoria.php";
include_once "Data/Models/EstatusPedido.php";
include_once "Data/Models/Envios.php";
include_once "Data/Models/Clientes.php";


class Pedidos extends BaseAuditoria implements iEntity
{
    public $IdPedido = 0 ;
    public $IdEstatusPedido = "" ;
    public $IdEnvio = 0 ;
    public $FechaPedido = "" ;
    public $IdCliente = 0 ;
    public $EstatusPedido;
    public $Envios;
    public $Clientes;

    public function __construct()
    {
        $this->EstatusPedido=new EstatusPedido();
        //$this->Envios=new Envios();
        $this->Clientes=new Clientes();


    }

    public static function getProperties(): array
    {
        return [
            "IdPedido"=>["label"=>"Id","type"=>"I","typeDb"=>"#","required"=>false],
            "FechaPedido"=>["label"=>"Fecha de Pedido","type"=>"D","typeDb"=>"$","required"=>true],
            "IdEstatusPedido"=>["label"=>"Estatus","type"=>"*","typeDb"=>"$","required"=>true,"table"=>"EstatusPedido"],
            "IdEnvio"=>["label"=>"Envio","type"=>"F","typeDb"=>"#","required"=>false,"table"=>"Envios"],
            "IdCliente"=>["label"=>"Cliente","type"=>"*","typeDb"=>"#","required"=>true,"table"=>"Clientes"],
            "FechaCambio"=>["label"=>"Fecha Auditoria","type"=>"F","typeDb"=>"$","required"=>false],
            "IdTipoMovimiento"=>["label"=>"Tipo Movimiento","type"=>"F","typeDb"=>"#","required"=>false],
            "IdUsuarioBase"=>["label"=>"Usuario de Registro]","type"=>"F","typeDb"=>"#","required"=>false]
        ];
    }
}