<?php


namespace Administracion;
use Tiendita\ModeloEstatusPedido;
use Tiendita\Utilidades;
include_once "VistasMenu.php";
include_once "Data/Models/ModeloEstatusPedido.php";
include_once "Business/Utilidades.php";

class VistaEstatusPedido extends VistasMenu
{
    public function __construct()
    {
        $body = $this->BodyMenu();
        $html = $this->Html5(
            $this->HeadMenu(),
            $this->PageWrapper($body)
        );
        echo $html;
        parent::__construct();

    }
    public function Content()
    {
        $mainContent=$this->ContentHeader("Listar Estatus de Pedido","Vista");
        $ui=new Utilidades();
        $u=new ModeloEstatusPedido();

        $mainContent.=$ui->ContainerFluid(
            [
                $ui->Row(
                    [
                        $u->Object2Table()
                    ]
                )
            ]
        );




        return $mainContent;
    }
}