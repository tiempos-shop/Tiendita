<?php


namespace Administracion;


class VistaPrincipal extends VistasMenu
{
    public function Content(){
        $mainContent=$this->ContentHeader("Informes","Resumen General");
        $row1Content=$this->Card("Ventas","$0.00","info","fas fa-money-check-alt");
        $row1Content=$this->Card("Devoluciones","$0.00","warning","fas fa-money-check-alt");
        $row2Content1='';
        $row2Content2='';
        $html='<!-- Begin Page Content -->
        <div class="container-fluid">
            '.$mainContent.'
            <div class="row">
                '.$row1Content.'
            </div>  
            <!-- Content Row -->
            <div class="row">
                <!-- Content Row -->
                <div class="row">
                    <!-- Content Column -->
                    <div class="col-lg-6 mb-4">
                        '.$row2Content1.'
                    </div>
                    <div class="col-lg-6 mb-4">
                        '.$row2Content2.'
                    </div>
                </div>
            </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->';
        return $html;

    }
}