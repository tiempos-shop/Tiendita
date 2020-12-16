<?php


namespace Tiendita;
include_once "iEntity.php";
include_once "BaseAuditoria.php";

class Envios extends BaseAuditoria implements iEntity
{
    public $IdEnvio=0;
    public $IdEmpresa=0;
    public $EstatusEnvio="";

    public static function getProperties(): array
    {
        return [
            "IdEnvio"=>["label"=>"Id","type"=>"I","typeDb"=>"#","required"=>false],
            "IdEmpresa"=>["label"=>"Empresa","type"=>"*","typeDb"=>"#","required"=>true,"table"=>"EmpresaEnvio"],
            "EstatusEnvio"=>["label"=>"Apellidos","type"=>"$","typeDb"=>"$","required"=>true],
            "FechaCambio"=>["label"=>"Fecha Auditoria","type"=>"F","typeDb"=>"$","required"=>false],
            "IdTipoMovimiento"=>["label"=>"Tipo Movimiento","type"=>"F","typeDb"=>"#","required"=>false],
            "IdUsuarioBase"=>["label"=>"Usuario de Registro]","type"=>"F","typeDb"=>"#","required"=>false]
        ];
    }
}