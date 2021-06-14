<?php


namespace Administracion;


use Tiendita\ModeloProducto;
use Tiendita\Utilidades;
include_once "VistasMenu.php";
include_once "Data/Models/ModeloProducto.php";
include_once "Business/Utilidades.php";

class VistaProductos extends VistasMenu
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
        $mainContent=$this->ContentHeader("Lista Productos","Vista");
        $ui=new Utilidades();
        $u=new ModeloProducto();
        $mainContent.=$ui->ContainerFluid([
            $ui->Row([
                $u->Object2Table()
            ])
        ]);
        return $mainContent;
    }
}