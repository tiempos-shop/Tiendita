<?php


namespace Tiendita;
include_once "iEntity.php";

class EstatusPedido implements iEntity
{
    public $IdEstatusPedido=0;
    public $Nombre="";
    public $Descripcion="";

    public static function getProperties(): array
    {
        return [
            "IdEstatusPedido" => ["label" => "Id", "type" => "I", "typeDb" => "#", "required" => false],
            "Nombre" => ["label" => "Estatus", "type" => "$", "typeDb" => "$", "required" => true],
            "Descripcion" => ["label" => "Descripción", "type" => "$", "typeDb" => "$", "required" => true]
        ];
    }
}