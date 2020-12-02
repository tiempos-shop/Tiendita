<?php


namespace Administracion;

use Tiendita\ModeloUsuarios;
use Tiendita\Test;
use Tiendita\Utilidades;

include_once ("VistasMenu.php");
include_once ("PieChartData.php");

include_once ("Test.php");

class VistaUsuariosEdit extends VistasMenu
{
    public function __construct()
    {
        $body=$this->BodyMenu();
        $html=$this->Html5(
            $this->HeadMenu(),
            $this->PageWrapper($body)
        );
        echo $html;
        parent::__construct();

    }

    public function Content(){
        $mainContent=$this->ContentHeader("Usuarios","Vista");
        $ui=new Utilidades();
        $u=new ModeloUsuarios();

        $mainContent.=$ui->ContainerFluid(
            [
                $ui->Row(
                    [
                        $u->Object2TableEdit("idUsuarios",
                            "Editar",
                            "Borrar",
                            "Insertar",
                            "",
                            [ "Nombres" ]
                        )
                    ]
                )
            ]
        );




        return $mainContent;
    }
}