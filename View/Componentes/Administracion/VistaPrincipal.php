<?php


namespace Administracion;
include_once ("VistasMenu.php");
include_once ("PieChartData.php");


class VistaPrincipal extends VistasMenu
{
    public function __construct()
    {

    }

    public function Principal(){
        $body=$this->Body();
        $html=$this->Html5(
            $this->HeadMenu(),
            $this->PageWrapper($body)
        );
        echo $html;
    }

    public function Content(){
        $mainContent=$this->ContentHeader("Informes","Resumen General");
        $row1Content=$this->Card("Ventas","$0.00","info","fas fa-money-check-alt");
        $row1Content.=$this->Card("Devoluciones","$0.00","warning","fas fa-money-check-alt");
        $row1Content.=$this->CardSlider("Ventas-Devoluciones",0,100,80,"% 80","info","fas fa-money-check-alt");
        $row1Content.=$this->Card("Eficiencia","95%","danger","fas fa-info-circle");
        $datos=[ "Ene"=>0, "Feb"=>60*13, "Mar"=>60*20, "Abr"=>60*35, "May"=>60*45, "Jun"=>60*50, "Jul"=>60*55, "Ago"=>60*54, "Sep"=>60*50,"Oct"=>60*40,"Nov"=>60*55,"Dic"=>60*70 ];
        $datosPie=[
            new PieChartData("Ago",20,"#FF0000","#FF0000"),
            new PieChartData("Sep",40,"#800000","#800000"),
            new PieChartData("Oct",25,"#FFFF00","#FFFF00"),
            new PieChartData("Nov",15,"#00FF00","#008000")
        ];
        $menu=[ "A"=>"A", "B"=>"Tabla de Datos","-"=>"", "C"=>"Por Años"];
        $row2Content1=$this->ProyectCard(
            $this->AreaChart("my","Últimas Ventas",$datos,$menu),
            "info");
        $row2Content2=$this->PieChart("my","Ventas Pie",$datosPie,$menu);

        return '<!-- Begin Page Content -->
        <div class="container-fluid">
            '.$mainContent.'
            <div class="row">
                '.$row1Content.'
            </div>  
            <!-- Content Row -->
            <div class="row">
                <!-- Content Column -->
                <div class="col-6">
                    '.$row2Content1.'
                </div>
                <div class="col-6">
                    '.$row2Content2.'
                </div>
            </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->';

    }
}