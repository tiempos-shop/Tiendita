<?php


namespace Administracion;

use Tiendita\Test;
use Tiendita\Utilidades;

include_once ("VistasMenu.php");
include_once ("PieChartData.php");

include_once ("Test.php");


class VistaUsuarios extends VistasMenu
{
    public function __construct()
    {
        $body=$this->Body();
        $html=$this->Html5(
            $this->HeadMenu(),
            $this->PageWrapper($body)
        );
        echo $html;

    }

    public function Content(){
        $mainContent=$this->ContentHeader("Usuarios","Vista");
        $u=new Utilidades();
        $t=new Test();
        $t->TestDelete();
        $mainContent.=$u->Container(
          [
              $u->Row(
                  [
                      $t->TestObjectToTable()
                  ]
              )
          ]
        );
        $mainContent.=$this->ProyectCard(
            $t->TestGrid(),
            "primary",
            "Ejemplo Grid"
        );



        return $mainContent;
    }
}