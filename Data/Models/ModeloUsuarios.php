<?php


namespace Tiendita;


class ModeloUsuarios
{
    public $NombreTable="Usuarios";
    public $Id="IdUsuarios";
    public $Datos;

    public function __construct()
    {
        $this->Datos=new Collection();

    }

    public function AgregarUsuario($Usuario){
        if (!is_a($Usuario, 'Usuario')) {
            throw new Exception("La clase no es de tipo Usuario");
        }
        $this->Datos->addItem($Usuario,$Usuario->IdUsuario);
    }
}