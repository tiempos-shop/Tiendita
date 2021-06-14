<?php


namespace Administracion;


use Tiendita\ModeloMotivoDevoluciones;
use Tiendita\Utilidades;
include_once "Data/Models/ModeloMotivoDevoluciones.php";
include_once "Business/Utilidades.php";
include_once "View/Componentes/Administracion/VistasMenu.php";

class VistaMotivoDevoluciones extends VistasMenu
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
        $mainContent=$this->ContentHeader("Listar Motivos Devoluciones","Vista");
        $ui=new Utilidades();
        $u=new ModeloMotivoDevoluciones();

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