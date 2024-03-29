<?php


namespace Administracion;

use Tiendita\ModeloClientes;
use Tiendita\ModeloUsuarios;
use Tiendita\Test;
use Tiendita\Utilidades;

include_once ("VistasMenu.php");
include_once ("PieChartData.php");
include_once "Data/Models/ModeloUsuarios.php";

class VistaUsuarios extends VistasMenu
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
        $u=new ModeloUsuarios();
        $mainContent.=$ui->ContainerFluid([
                $ui->Row([
                        $u->Object2Table()
                ])
        ]);
        return $mainContent;
    }
}