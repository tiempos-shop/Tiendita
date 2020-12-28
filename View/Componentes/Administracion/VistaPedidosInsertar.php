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
        if(count($_POST)>0){
            $r=$ui->Post(["IdEstatusPedido","IdEnvio","FechaPedido","IdCliente"]);
            if($r["out"]){
                $data=$r["data"];
            }
            $ui->MessageBox("Guardar Datos");
        }
        $mainContent .=
        $ui->ContainerFluid([
            $ui->Row([
                $ui->Container([
                    $ui->Form([
                        $ui->Input("IdCliente", "Cliente Pedido", "", "*", true,
                            $ui->GetCatalog($u->entidadBase->getAll("Clientes"), "IdCliente", "Nombre")
                        ),
                        $ui->Input("FechaPedido","Fecha de Pedido","","D",true),
                        $ui->Input("IdEstatusPedido", "Estatus Pedido", "", "*", true,
                            $ui->GetCatalog($u->entidadBase->getAll("EstatusPedido"), "IdEstatusPedido", "Nombre")
                        ),
                        "<p>Seleccione entre un envio que ya existe o capturar un nuevo pedido</p>",
                        $ui->OptionPage("Envio",["<i class='fa fa-edit'></i> Existente","<i class='fa fa-plus'></i> Nuevo Envio"],[
                            $ui->Container([
                                "<br/><p><strong>Seleccione un Envio existente</strong></p>",
                                $ui->Input("IdEnvio","Num. Envio","","*",false,
                                    $ui->GetCatalog($u->entidadBase->getAll("Envios"),"IdEnvio","IdEnvio")
                                )
                            ]),

                            $ui->Container([
                                "<br/><p><strong>Capture un nuevo Envio</strong></p>",
                                $ui->Input("IdEmpresa","Empresa Envio","","*",true,
                                    $ui->GetCatalog($u->entidadBase->getAll("EmpresaEnvio"),"IdEmpresa","Nombre")
                                ),
                                $ui->Input("EstatusEnvio","Estatus del Envio","","$",false),
                            ])
                        ]),
                        $ui->OptionPage("Pago",["<i class='fa fa-edit'></i> Existente","<i class='fa fa-plus'></i> Nuevo Pago"],[
                            $ui->Container([
                                "<br/><p><strong>Seleccione un pago existente</strong></p>",
                                $ui->Input("IdPago","Num. Pago","","*",false,
                                    $ui->GetCatalog($u->entidadBase->getAll("Pagos"),"IdPago","Descripcion")
                                )
                            ]),

                            $ui->Container([
                                "<br/><p><strong>Capture un nuevo pago</strong></p>",
                                $ui->Input("Descripcion","Descripción","","$",false),
                                $ui->Input("Compania","Identificación","","#",false),
                                $ui->Input("EstatusPago","Pagado","","%",false),
                                $ui->Input("MontoPago","Monto del Pago","","M",false),
                            ])
                        ])
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