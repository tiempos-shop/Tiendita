<?php


namespace Tiendita;


use DateTime;

class Utilidades
{
    public $formatoFecha = "d/m/Y H:i:s";

    public function Object2Table($object){
        if(is_array($object)){
            $html= "<table class='table table-bordered'>";
            foreach($object as $val){
                $a = get_object_vars($val);
                $html.= "<tr>";
                foreach($a as $v ){
                    if(!is_array($v))
                        $html.= "<td>$v</td>";
                    else
                        $html.="<td>".$this->Object2Table($v)."</td>";
                }
                $html.= "</tr>";
            }
            $html.= "</table>";
            return $html;
        }
    }



    public function Fecha(int $dia,int $mes,int $ano,int $horas,int $minutos,int $segundos):DateTime
    {

        $external = "$dia/$mes/$ano $horas:$minutos:$segundos";
        $dateobj = DateTime::createFromFormat($this->formatoFecha, $external);
        return $dateobj;
    }

    public function FechaHoyObjeto()
    {

        $hoy=getdate();
        $segundos=$hoy["seconds"];
        $minutos=$hoy["minutes"];
        $horas=$hoy["hours"];
        $dia=$hoy["mday"];
        $mes=$hoy["mon"];
        $ano=$hoy["year"];

        $external = "$dia/$mes/$ano $horas:$minutos:$segundos";
        $dateobj = DateTime::createFromFormat($this->formatoFecha, $external);
        return $dateobj;
    }

    public function FechaHoy():string
    {
        $hoy=getdate();
        $segundos=$hoy["seconds"];
        $minutos=$hoy["minutes"];
        $horas=$hoy["hours"];
        $dia=$hoy["mday"];
        $mes=$hoy["mon"];
        $ano=$hoy["year"];
        $external = "$dia/$mes/$ano $horas:$minutos:$segundos";
        return $external;
    }

    public function Obtenerfecha(DateTime $fecha):string
    {
        return $fecha->format($this->formatoFecha);
    }

    public function Leerfecha(string $fecha):DateTime
    {
        return DateTime::createFromFormat($this->formatoFecha,$fecha);
    }



}