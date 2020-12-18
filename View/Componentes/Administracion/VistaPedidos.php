<?php


namespace Administracion;


use Tiendita\ModeloPedidos;
use Tiendita\Utilidades;

class VistaPedidos extends VistasMenu
{
    public function __construct()
    {
        $body=$this->BodyMenu();
        $html=$this->Html5(
            $this->HeadMenu(),
            $this->PageWrapper($body)
        );
        echo $html;

    }

    public function Content(){
        $mainContent=$this->ContentHeader("Lista Usuarios","Vista");
        $ui=new Utilidades();
        $u=new ModeloPedidos();
        $mainContent.=$ui->ContainerFluid([
            $ui->Row([
                $u->Object2Table()
            ])
        ]);
        return $mainContent;
    }
}