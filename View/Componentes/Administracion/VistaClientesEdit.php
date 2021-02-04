<?php


namespace Administracion;


use Tiendita\ModeloClientes;
use Tiendita\ModeloUsuarios;
use Tiendita\Utilidades;

include_once "View/Componentes/Administracion/VistasMenu.php";
include_once "Data/Models/ModeloClientes.php";
include_once "Business/Utilidades.php";

class VistaClientesEdit extends VistasMenu
{
    public function __construct()
    {
        $ui = new Utilidades();
        $body = $this->BodyMenu();
        $html = $this->Html5(
            $this->HeadMenu(),
            $this->PageWrapper($body).$ui->DataTable("idClientes")
        );
        echo $html;
        parent::__construct();

    }

    public function Content()
    {
        $mainContent = $this->ContentHeader("Editar Clientes", "Vista");
        $ui = new Utilidades();
        $u = new ModeloClientes();

        // Si se van a guardar datos
        if ($u->SafeSave() == 0)                                                                                                                                                                                     {
            $mainContent .= $ui->ContainerFluid([
                $ui->Row([
                    $u->Object2TableEdit("idClientes",
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