<?php


namespace Tiendita;


class Utilidades
{
    public function Object2Table($object){
        if(is_array($object)){
            $html="";
            $html.= "<table class='table table-bordered'>";
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
}