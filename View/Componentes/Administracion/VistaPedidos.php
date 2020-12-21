<?php


namespace Administracion;


use Tiendita\ModeloPedidos;
use Tiendita\Utilidades;
include_once "VistasMenu.php";
include_once "Data/Models/ModeloPedidos.php";
include_once "Business/Utilidades.php";

class VistaPedidos extends VistasMenu
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

    public function Content(){
        $ui=new Utilidades();
        $u=new ModeloPedidos();

        $mainContent=$this->ContentHeader("Lista Pedidos","Vista");
        $this->scripts.=$ui->DataTable("idTablaEntidad");
        $mainContent.=$ui->ContainerFluid([
            $ui->Row([
                $u->Object2Table()
            ])
        ]);
        return $mainContent;
    }
}