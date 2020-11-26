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

    public function Object2Table(string $k,object $v){
        if($k=="TipoMovimiento") {
            return $v->Descripcion;
        }
        elseif ($k=="UsuarioBase"){
            return $v->Nombres." ".$v->Apellidos;
        }
        else{
            return $k;
        }
    }

    public function Adicional(){
        return [ "ad1"=>"Tipo Movimiento", "ad2"=>"Usuario "];
    }
}