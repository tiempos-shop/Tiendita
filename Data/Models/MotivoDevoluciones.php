<?php


namespace Tiendita;
include_once "iEntity.php";

class MotivoDevoluciones implements iEntity
{
    public $IdMotivoDevolucion=0;
    public $Descripcion="";
    public $Otro="";

    public static function getProperties(): array
    {
        return [
            "IdMotivoDevolucion" => ["label" => "Id", "type" => "I", "typeDb" => "#", "required" => false],
            "Descripcion" => ["label" => "Motivo", "type" => "$", "typeDb" => "$", "required" => true],
            "Otro" => ["label" => "Clave", "type" => "$", "typeDb" => "$", "required" => false]
        ];
    }
}