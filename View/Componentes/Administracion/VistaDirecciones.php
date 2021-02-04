<?php


namespace Administracion;


use Tiendita\ModeloDirecciones;
use Tiendita\Utilidades;

include_once "VistasMenu.php";
include_once "Data/Models/ModeloDirecciones.php";
include_once "Business/Utilidades.php";

class VistaDirecciones extends VistasMenu
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
        $mainContent=$this->ContentHeader("Listar Direcciones","Vista");
        $ui=new Utilidades();
        $u=new ModeloDirecciones();
        $mainContent.=$ui->ContainerFluid([
            $ui->Row([
                $u->Object2Table()
            ])
        ]);
        return $mainContent;
    }
}