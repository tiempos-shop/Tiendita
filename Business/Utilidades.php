<?php


namespace Tiendita;


use DateTime;
use ReflectionClass;

abstract class Enum
{
    const NONE = null;
    final private function __construct(){ throw new NotSupportedException(); }
    final private function __clone(){ throw new NotSupportedException(); }
    final public static function toArray(){
        return (new ReflectionClass(static::class))->getConstants();
    }
    final public static function isValid($value){
        return in_array($value, static::toArray());
    }
}

class partOf12 extends Enum {
    const sizeNull="";
    const size1of12="1";
    const size2of12="2";
    const size3of12="3";
    const size4of12="4";
    const size5of12="5";
    const size6of12="6";
    const size7of12="7";
    const size8of12="8";
    const size9of12="9";
    const size10of12="10";
    const size11f12="11";
    const size12f12="12";
}

class Utilidades
{
    public $formatoFecha = "d/m/Y H:i:s";

    // Tablas

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

    public function BaseContainer(string $class,array $contenidos){
        $html='<div class="'.$class.'">';
        $html.=implode("",$contenidos);
        $html.='</div>';
        return $html;
    }

    public function ContainerFluid(array $rows){
        return $this->BaseContainer("container-fluid",$rows);
    }

    public function Container(array $rows){
        return $this->BaseContainer("container",$rows);
    }

    public function Row(array $columns){
        $html='<div class="row">';
        $html.=implode("",$columns);
        $html.='</div>';
        return $html;
    }

    public function Columns(string $html,int $mediumScreen,int $tinyScreen=0,int $smallScreen=0,int $largeScreen=0){
        if($tinyScreen==0) $tiny="";
        else $tiny='col-xs-'.$tinyScreen;
        if($smallScreen==0) $small="";
        else $small='col-sm-'.$smallScreen;
        if($mediumScreen==0) $medium="";
        else $medium='col-md-'.$mediumScreen;
        if($largeScreen==0) $large="";
        else $large='col-lg-'.$largeScreen;

        return "<div class='$tiny $small $medium $large'>
                    $html
                </div>";
    }

    //DateTime

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