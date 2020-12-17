<?php


namespace Tiendita;
include_once "BaseAuditoria.php";
include_once "iEntity.php";
include_once "Data/Models/MotivoDevoluciones.php";
include_once "Data/Models/Pedidos.php";

class Devoluciones extends BaseAuditoria implements iEntity
{

    public $IdDevolucion = 0 ;
    public $IdPedido = 0 ;
    public $IdMotivoDevolucion = "" ; // NUM o STR?
    public $GastoEnvio = 0.0 ;
    public $Notas = "" ;
    public $MotivoDevoluciones;
    public $Pedidos;

    public function __construct()
    {
        $this->MotivoDevoluciones=new MotivoDevoluciones();
        $this->Pedidos=new Pedidos();
    }

    public static function getProperties(): array
    {
        return [
            "IdDevolucion"=>["label"=>"Id","type"=>"I","typeDb"=>"#","required"=>false],
            "GastoEnvio"=>["label"=>"Gasto Envio","type"=>"#","typeDb"=>"#","required"=>false],
            "Notas"=>["label"=>"Nota","type"=>"&","typeDb"=>"$","required"=>false],
            "IdPedido"=>["label"=>"Pedido","type"=>"*","typeDb"=>"#","required"=>true,"table"=>"Pedidos"],
            "IdMotivoDevolucion"=>["label"=>"Motivo","type"=>"*","typeDb"=>"#","required"=>true,"table"=>"MotivoDevoluciones"],
            "FechaCambio"=>["label"=>"Fecha Auditoria","type"=>"F","typeDb"=>"$","required"=>false],
            "IdTipoMovimiento"=>["label"=>"Tipo Movimiento","type"=>"F","typeDb"=>"#","required"=>false],
            "IdUsuarioBase"=>["label"=>"Usuario de Registro]","type"=>"F","typeDb"=>"#","required"=>false]
        ];
    }
}