<?php


namespace Administracion;

use Tiendita\Test;

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
        $t=new Test();
        $mainContent.=$t->TestObjectToTable();

        return '<!-- Begin Page Content -->
        <div class="container-fluid">
            '.$mainContent.'
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->';

    }
}