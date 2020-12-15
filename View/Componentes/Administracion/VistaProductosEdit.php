<?php


namespace Administracion;


use Tiendita\ModeloProducto;
use Tiendita\Utilidades;
include_once "VistasMenu.php";
include_once "Data/Models/ModeloProducto.php";
include_once "Business/Utilidades.php";

class VistaProductosEdit extends VistasMenu
{
    public function __construct()
    {
        $ui = new Utilidades();
        $body = $this->BodyMenu();
        $html = $this->Html5(
            $this->HeadMenu(),
            $this->PageWrapper($body) //.$ui->DataTable("idTableEdit")
        );
        echo $html;
        parent::__construct();

    }

    public function Content()
    {
        $mainContent = $this->ContentHeader("Editar Usuarios", "Vista");
        $ui = new Utilidades();
        $u = new ModeloProducto();

        // Si se van a guardar datos
        if ($u->SafeSave() == 0) {
            $mainContent .= $ui->ContainerFluid([
                $ui->Row([
                    $u->Object2TableEdit("idTableEdit",
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