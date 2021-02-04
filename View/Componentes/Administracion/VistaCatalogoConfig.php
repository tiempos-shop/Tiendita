<?php


namespace Administracion;


use Tiendita\ModeloCatalogoConfig;
use Tiendita\Utilidades;
include_once "VistasMenu.php";
include_once "Data/Models/ModeloCatalogoConfig.php";
include_once "Business/Utilidades.php";

class VistaCatalogoConfig extends VistasMenu
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
        $mainContent=$this->ContentHeader("Lista Config.","Vista");
        $ui=new Utilidades();
        $u=new ModeloCatalogoConfig();

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