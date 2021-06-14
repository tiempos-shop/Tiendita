<?php


namespace Administracion;
use Tiendita\ModeloDevoluciones;
use Tiendita\Utilidades;
include_once "View/Componentes/Administracion/VistasMenu.php";
include_once "Business/Utilidades.php";
include_once "Data/Models/ModeloDevoluciones.php";

class VistaDevoluciones extends VistasMenu
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
        $mainContent=$this->ContentHeader("Lista Devoluciones","Vista");
        $ui=new Utilidades();
        $u=new ModeloDevoluciones();
        $mainContent.=$ui->ContainerFluid([
            $ui->Row([
                $u->Object2Table()
            ])
        ]);
        return $mainContent;
    }
}