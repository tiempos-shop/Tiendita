<?php


namespace Administracion;


use Tiendita\ModeloEmpresasEnvio;
use Tiendita\Utilidades;
include_once "VistasMenu.php";
include_once "Business/Utilidades.php";
include_once "Data/Models/ModeloEmpresasEnvio.php";

class VistaEmpresasEnvio extends VistasMenu
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
        $mainContent=$this->ContentHeader("Listar Empresas Envio","Vista");
        $ui=new Utilidades();
        $u=new ModeloEmpresasEnvio();

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