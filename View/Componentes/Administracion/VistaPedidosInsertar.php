<?php


namespace Administracion;
use Tiendita\ModeloEstatusPedido;
use Tiendita\ModeloPedidos;
use Tiendita\Utilidades;
include_once "VistasMenu.php";
include_once "Data/Models/ModeloPedidos.php";
include_once "Data/Models/ModeloEstatusPedido.php";
include_once "Business/Utilidades.php";

class VistaPedidosInsertar extends VistasMenu
{
    public function __construct()
    {
        $ui = new Utilidades();
        $body = $this->BodyMenu();
        $html = $this->Html5(
            $this->HeadMenu(),
            $this->PageWrapper($body).$ui->DataTable("idTableEdit")
        );
        echo $html;
        parent::__construct();

    }

    public function Content()
    {
        $mainContent = $this->ContentHeader("Insertar Pedidos", "Vista");
        $ui = new Utilidades();
        $u = new ModeloPedidos();


        // Si se van a guardar datos


        $mainContent .= $ui->ContainerFluid([
            $ui->Row([
                $ui->Container([
                    $ui->Form([
                        $ui->Input("IdEstatusPedido", "Estatus Pedido", "", "*", true,
                            $ui->GetCatalog($u->entidadBase->getAll("EstatusPedido"), "IdEstatusPedido", "Nombre")),
                        $ui->Input("IdEnvio","Envio","","*",false,
                            $ui->GetCatalog($u->entidadBase->getAll("Envios"),"IdEnvio","IdEnvio"))



                    ],
                        "",
                        "<i class='fa fa-plus'></i> Agregar"
                    ),

                ]),

            ])
        ]);



        return $mainContent;
    }
}