<?php
namespace Tiendita;
include_once ("ModeloBase.php");
include_once "Data/Models/Usuarios.php";

class ModeloUsuarios extends ModeloBase
{
    public function __construct()
    {
        parent::__construct("Usuarios","IdUsuario",Usuarios::getCampos(),Usuarios::getType());


    }

    public function Object2Table(string $k,array $v){
        if($k=="TipoMovimiento") {
            return $v["Descripcion"];
        }
        elseif ($k=="Usuarios"){
            return $v["Nombres"]." ".$v["Apellidos"];
        }
        else{
            return $k;
        }
    }
}