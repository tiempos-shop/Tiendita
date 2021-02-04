<?php


namespace Administracion;

use Administracion\VistasHtml;
use Tiendita\Utilidades;

include_once "View/Componentes/Administracion/VistasHtml.php";
include_once "Business/Utilidades.php";

class VistaConekta extends VistasHtml
{
    /**
     * @var Utilidades
     */
    private $ui;

    public function __construct()
    {
        $this->ui = new Utilidades();
    }

    public function render(){
        return $this->Html5(
            $this->Head(
                "Pagos",
                $this->Meta(
                    "utf-8",
                    "Pagos de Tiempos Shop",
                    "Tiempos Shop Conekta"),
                    $this->LoadStyles([]),
                    $this->LoadScripts([
                        "https://cdn.conekta.io/js/latest/conekta.js"
                    ])),
            $this->ui->Container([

            ])
        );
    }

}