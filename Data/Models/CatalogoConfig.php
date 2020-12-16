<?php


namespace Tiendita;
include_once "Data/Models/iEntity.php";


class CatalogoConfig implements iEntity
{

    public $IdConfig = 0 ;
    public $Concepto = "" ;
    public $Valor = 0.0 ;


    public static function getProperties(): array
    {
        return [
            "IdConfig" => ["label" => "Id", "type" => "I", "typeDb" => "#", "required" => false],
            "Concepto" => ["label" => "Empresa", "type" => "$", "typeDb" => "$", "required" => true],
            "Valor" => ["label" => "Descripción", "type" => "#", "typeDb" => "#", "required" => true]
        ];
    }
}