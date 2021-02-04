<?php


namespace Administracion;
use Tiendita\ModeloPagos;
use Tiendita\Utilidades;
include_once "VistasMenu.php";
include_once "Business/Utilidades.php";
include_once "Data/Models/ModeloPagos.php";

class VistaPagos extends VistasMenu
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
        $mainContent=$this->ContentHeader("Lista Usuarios","Vista");
        $ui=new Utilidades();
        $u=new ModeloPagos();
        $mainContent.=$ui->ContainerFluid([
            $ui->Row([
                $u->Object2Table()
            ])
        ]);
        return $mainContent;
    }
}