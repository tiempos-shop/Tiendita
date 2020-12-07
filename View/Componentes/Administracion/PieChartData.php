<?php


namespace Administracion;


class PieChartData
{

    public $Etiqueta="";
    public $Valor=0;
    public $Color="";
    public $Fondo="";

    public function __construct($etiqueta,$valor,$color,$fondo)
    {
        $this->Etiqueta=$etiqueta;
        $this->Valor=$valor;
        $this->Color=$color;
        $this->Fondo=$fondo;
    }
}