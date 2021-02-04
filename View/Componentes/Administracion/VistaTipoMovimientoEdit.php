<?php


namespace Administracion;
use Tiendita\ModeloTipoMovimiento;
use Tiendita\Utilidades;
include_once("VistasMenu.php");
include_once("PieChartData.php");
include_once "Business/Utilidades.php";
include_once "Data/Models/ModeloTipoMovimiento.php";

class VistaTipoMovimientoEdit extends VistasMenu
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
        $mainContent = $this->ContentHeader("Usuarios", "Vista");
        $ui = new Utilidades();
        $u = new ModeloTipoMovimiento();

        // Si se van a guardar datos
        if ($u->SafeSave() == 0) {
            $mainContent .= $ui->ContainerFluid([
                $ui->Row([
                    $u->Object2TableEdit("idUsuarios",
                        "<i class='fa fa-edit'></i> Editar",
                        "<i class='fa fa-eraser'></i> Borrar",
                        "<i class='fa fa-plus'></i> Insertar",
                        "",
                        ["Nombres", "IdTipoMovimiento"]
                    )
                ])
            ]);
        } else {
            $mainContent = "Ocurrio un error en la página";
        }


        return $mainContent;
    }
}