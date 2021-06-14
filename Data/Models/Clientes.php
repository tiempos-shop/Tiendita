<?php


namespace Tiendita;

include_once "Data/Models/BaseAuditoria.php";
include_once "Data/Models/iEntity.php";

class Clientes extends BaseAuditoria implements iEntity
{

    public $IdCliente = 0 ;
    public $CorreoElectronico = "" ;
    public $Password = "" ;
    public $Nombre = "" ;
    public $Apellidos = "" ;
    public $Vip = 0;

    public function __construct()
    {

    }


    public static function getProperties(): array
    {
        return [
            "IdCliente"=>["label"=>"Id","type"=>"I","typeDb"=>"#","required"=>false],
            "Nombre"=>["label"=>"Nombre","type"=>"$","typeDb"=>"$","required"=>true],
            "Apellidos"=>["label"=>"Apellidos","type"=>"$","typeDb"=>"$","required"=>true],
            "Password"=>["label"=>"Password","type"=>"?","typeDb"=>"$","required"=>true],
            "CorreoElectronico"=>["label"=>"Email","type"=>"@","typeDb"=>"$","required"=>true],
            "Vip"=>["label"=>"VIP","type"=>"#","typeDb"=>"#","required"=>true],
            "FechaCambio"=>["label"=>"Fecha Auditoria","type"=>"F","typeDb"=>"$","required"=>false],
            "IdTipoMovimiento"=>["label"=>"Tipo Movimiento","type"=>"F","typeDb"=>"#","required"=>false],
            "IdUsuarioBase"=>["label"=>"Usuario de Registro]","type"=>"F","typeDb"=>"#","required"=>false]
        ];
    }
}