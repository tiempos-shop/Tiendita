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

    public function Adicional(){
        return [ "ad1"=>"Tipo Movimiento", "ad2"=>"Usuario "];
    }

    public function Object2SimpleTable(string $k, object $v)
    {
        if($k=="TipoMovimiento") {
            return $v->Descripcion;
        }
        elseif ($k=="UsuarioBase"){
            return $v->Nombres." ".$v->Apellidos;
        }
        else{
            return "No definido campo: ".$k;
        }
    }

    public function SimpleAdd()
    {
        return $this->Adicional();
    }
}