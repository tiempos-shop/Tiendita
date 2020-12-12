<?php


namespace Administracion;


use Tiendita\ModeloClientes;
use Tiendita\Utilidades;

include_once "View/Componentes/Administracion/VistasMenu.php";
include_once "Data/Models/ModeloClientes.php";

class VistaClientes extends VistasMenu
{
    public function __construct()
    {
        $body=$this->BodyMenu();
        $html=$this->Html5(
            $this->HeadMenu(),
            $this->PageWrapper($body)
        );
        echo $html;

    }
    public function Content()
    {
        $mainContent=$this->ContentHeader("Listar Clientes","Vista");
        $ui=new Utilidades();
        $u=new ModeloClientes();
        $mainContent.=$ui->ContainerFluid([
            $ui->Row([
                $u->Object2Table()
            ])
        ]);
        return $mainContent;
    }
}