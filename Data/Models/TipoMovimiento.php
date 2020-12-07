<?php


namespace Tiendita;
include_once "iEntity.php";

class TipoMovimiento implements iEntity
{
    public $IdTipoMovimiento=0;
    public $Descripcion="";

    public static function getCampos(): array
    {
        return ["Descripcion"];
    }

    public static function getType(): array
    {
        return ["Descripcion"=>"$"];
    }

    public static function getProperties(): array
    {
        return [
            "IdTipoMovimiento"=>["Id","I"],
            "Descripcion"=>["Descripcion","$"]
        ];
    }
}