<?php


namespace Tiendita;
include_once "iEntity.php";

class EmpresasEnvio implements iEntity
{
    public $IdEmpresa=0;
    public $Nombre="";
    public $Descripcion="";

    public static function getProperties(): array
    {
        return [
            "IdEmpresa" => ["label" => "Id", "type" => "I", "typeDb" => "#", "required" => false],
            "Nombre" => ["label" => "Empresa", "type" => "$", "typeDb" => "$", "required" => true],
            "Descripcion" => ["label" => "Descripción", "type" => "$", "typeDb" => "$", "required" => true]
        ];
    }
}