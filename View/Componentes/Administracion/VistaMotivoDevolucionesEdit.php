<?php


namespace Administracion;
use Tiendita\ModeloMotivoDevoluciones;
use Tiendita\Utilidades;
include_once "Data/Models/ModeloMotivoDevoluciones.php";
include_once "Business/Utilidades.php";
include_once "View/Componentes/Administracion/VistasMenu.php";

class VistaMotivoDevolucionesEdit extends VistasMenu
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
        $mainContent = $this->ContentHeader("Edicion Motivo Devoluciones", "Vista");
        $ui = new Utilidades();
        $u = new ModeloMotivoDevoluciones();

        // Si se van a guardar datos
        if ($u->SafeSave() == 0) {
            $mainContent .= $ui->ContainerFluid([
                $ui->Row([
                    $u->Object2TableEdit("idConfig",
                        "<i class='fa fa-edit'></i> Editar",
                        "<i class='fa fa-eraser'></i> Borrar",
                        "<i class='fa fa-plus'></i> Insertar",
                        "",
                        []
                    )
                ])
            ]);
        } else {
            $mainContent = "Ocurrio un error en la página";
        }


        return $mainContent;
    }
}