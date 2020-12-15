<?php


namespace Tiendita;
include_once "Data/Models/ModeloBase.php";
include_once "Data/Models/EmpresasEnvio.php";


class ModeloEmpresasEnvio extends ModeloBase
{
    public function __construct()
    {
        parent::__construct("EmpresaEnvio","IdEmpresa",EmpresasEnvio::getProperties(),false);
    }
    public function Foreign(string $k, string $v)
    {
        return "";
    }

    public function ForeignInput(string $k, string $v)
    {
        return "";
    }

    public function Object2SimpleTable(string $k, object $v)
    {
        return "";
    }

    public function Object2SimpleFormulary(string $k, object $v)
    {
        return "";
    }

    public function Adicional()
    {
        return [];
    }

    public function SimpleAdd()
    {
        return $this->Adicional();
    }
}