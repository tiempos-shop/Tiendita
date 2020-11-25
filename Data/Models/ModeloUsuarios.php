<?php
namespace Tiendita;
include_once ("Data/Models/ModeloBase.php");

class ModeloUsuarios extends ModeloBase
{
    public function __construct()
    {
        parent::__construct("Usuarios","IdUsuario",Usuarios::getCampos(),Usuarios::getType());


    }
}