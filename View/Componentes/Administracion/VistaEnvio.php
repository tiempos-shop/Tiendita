<?php


namespace Administracion;


use Tiendita\ModeloEnvio;
use Tiendita\Utilidades;
include_once "VistasMenu.php";
include_once "Business/Utilidades.php";
include_once "Data/Models/ModeloEnvio.php";

class VistaEnvio extends VistasMenu
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
        $mainContent=$this->ContentHeader("Lista Envios","Vista");
        $ui=new Utilidades();
        $u=new ModeloEnvio();
        $mainContent.=$ui->ContainerFluid([
            $ui->Row([
                $u->Object2Table()
            ])
        ]);
        return $mainContent;
    }
}