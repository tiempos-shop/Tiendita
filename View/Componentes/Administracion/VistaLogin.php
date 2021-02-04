<?php


namespace Administracion;

use Tiendita\Utilidades;
include_once "View/Componentes/Administracion/VistasMenu.php";
include_once "Business/Utilidades.php";


class VistaLogin extends VistasMenu
{
    public function __construct()
    {
        $_SESSION = array();

        $html='<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">';
        $html.=$this->SideBarBrand("Inicio","");
        $html.=$this->Divider();

        $html.="</ul>";
        $body=$html.$this->ContentWrapper(
                $this->TopBar("",[],[]).
            $this->Content().
            $this->Footer("Tiempos Shop")
        );
        $body.= $this->Wrapper();

        $html=$this->Html5(
            $this->HeadMenu(),
            $this->PageWrapper(
                $body
            )
        );
        echo $html;

    }

    public function Content(){

        $ui=new Utilidades();

        return $ui->ContainerFluid([
            $this->ContentHeader("Login","Ingreso"),
            $ui->Row([
                $ui->Columns("",3),
                $ui->Columns(
                    $ui->Form([
                        $ui->Input("usuario","Usuario","","$",true),
                        $ui->Input("password","Password","","?",true)
                    ],"administracion.php","Ingresar"
                    )
                    ,6),
                $ui->Columns("",3)
            ])
        ]);
    }
}