<?php


namespace Administracion;
use Tiendita\ModeloTipoMovimiento;
use Tiendita\Utilidades;
include_once("VistasMenu.php");
include_once("PieChartData.php");
include_once "Business/Utilidades.php";
include_once "Data/Models/ModeloTipoMovimiento.php";

class VistaTipoMovimiento extends VistasMenu
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
        $mainContent=$this->ContentHeader("Usuarios","Vista");
        $ui=new Utilidades();
        $u=new ModeloTipoMovimiento();

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