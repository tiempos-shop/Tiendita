<?php


namespace Administracion;
use Tiendita\EntidadBase;
use Tiendita\Usuarios;
use Tiendita\Utilidades;

include_once ("VistasMenu.php");
include_once ("PieChartData.php");
include_once "Business/Utilidades.php";
include_once "Data/Connection/EntidadBase.php";



class VistaPrincipal extends VistasMenu
{

    public function __construct()
    {

    }


    public function Principal(){

        $html=$this->Html5(
            $this->HeadMenu(),
            $this->PageWrapper(
                $this->BodyMenu()
            )
        );
        echo $html;
    }



    public function Content(){
        $ui=new Utilidades();

        return $ui->ContainerFluid([
            $this->ContentHeader("Informes","Resumen General"),
            $ui->Row([
                $this->Card("Ventas","$0.00","info","fas fa-money-check-alt"),
                $this->Card("Devoluciones","$0.00","warning","fas fa-money-check-alt"),
                $this->CardSlider("Ventas-Devoluciones",0,100,80,"% 80","info","fas fa-money-check-alt"),
                $this->Card("Eficiencia","95%","danger","fas fa-info-circle")
            ]),
            $ui->Row([
                $ui->Columns(
                    $this->ProyectCard(
                        $this->AreaChart("my","Últimas Ventas",
                            [ "Ene"=>0, "Feb"=>60*13, "Mar"=>60*20, "Abr"=>60*35, "May"=>60*45, "Jun"=>60*50, "Jul"=>60*55, "Ago"=>60*54, "Sep"=>60*50,"Oct"=>60*40,"Nov"=>60*55,"Dic"=>60*70 ],
                            [ "A"=>"A", "B"=>"Tabla de Datos","-"=>"", "C"=>"Por Años"]),
                        "info"),
                    6
                ),
                $ui->Columns(
                    $this->PieChart("my","Ventas Pie",
                        [
                            new PieChartData("Ago",20,"#FF0000","#FF0000"),
                            new PieChartData("Sep",40,"#800000","#800000"),
                            new PieChartData("Oct",25,"#FFFF00","#FFFF00"),
                            new PieChartData("Nov",15,"#00FF00","#008000")
                        ],
                        [ "A"=>"A", "B"=>"Tabla de Datos","-"=>"", "C"=>"Por Años"]
                    ),
                    6
                )
            ])
        ]);
    }

}