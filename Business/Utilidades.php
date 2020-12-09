<?php


namespace Tiendita;


use DateTime;
use ReflectionClass;

class Utilidades
{
    public $formatoFecha = "d/m/Y H:i:s";
    // Expresiones regulares
    const password="^(?=.*[A-Z].*[A-Z])(?=.*[!@#$&*])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8}$";
    const nombres="/^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/";
    const correo="/^[\w]+@{1}[\w]+\.[a-z]{2,3}$/";


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

    // Bootstrap

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

    public function Columns(string $html,int $mediumScreen,int $tinyScreen=0,int $smallScreen=0,int $largeScreen=0,string $class=""){
        if($tinyScreen==0) $tiny="";
        else $tiny='col-xs-'.$tinyScreen;
        if($smallScreen==0) $small="";
        else $small='col-sm-'.$smallScreen;
        if($mediumScreen==0) $medium="";
        else $medium='col-md-'.$mediumScreen;
        if($largeScreen==0) $large="";
        else $large='col-lg-'.$largeScreen;

        return "<div class='$tiny $small $medium $large $class'>
                    $html
                </div>";
    }

    // Mensajaes
    public function MessageBox(string $mensaje){
        echo "
            <script>
                alert('$mensaje');
            </script>";
    }

    // Modal

    public function ModalButton(string $id,string $button,string $buttonAction,string $title,string $close,string $content,string $action="",string $javascriptAction="",string $type="primary"){
        $html='
            <!-- Button trigger modal -->
            <button type="button" onclick="'.$buttonAction.'" class="btn btn-'.$type.'" data-toggle="modal" data-target="#'.$id.'">
              '.$button.'
            </button>
            
            <!-- Modal -->
            <div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 1000px">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">'.$title.'</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    '.$content.'
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">'.$close.'</button>';
        if($action<>"") $html.='<button type="button" class="btn btn-primary" onclick="'.$javascriptAction.'">'.$action.'</button>';
        $html.='  </div>
                </div>
              </div>
            </div>
        ';
        return $html;
    }

    public function ModalButtonNormal(string $id,string $button,string $buttonAction,string $title,string $close,string $content,string $action="",string $javascriptAction="",string $type="primary"){
        $html='
            <!-- Button trigger modal -->
            <button type="button" onclick="'.$buttonAction.'" class="btn btn-'.$type.'" data-toggle="modal" data-target="#'.$id.'">
              '.$button.'
            </button>
            
            <!-- Modal -->
            <div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">'.$title.'</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    '.$content.'
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">'.$close.'</button>';
        if($action<>"") $html.='<button type="button" class="btn btn-primary" onclick="'.$javascriptAction.'">'.$action.'</button>';
        $html.='  </div>
                </div>
              </div>
            </div>
        ';
        return $html;
    }

    // Button

    public function Button($class,$content){
        return "
            <button class='$class'>$content</button>
        ";
    }

    // Forms

    public function Form(array $content,string $url,string $button){
        $html= "
            <form method='post' action='$url'>";
        $html.=implode("",$content);
        $html.='
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">'.$button.'</button>
                    </div>
                </div>
            </form>';
        return $html;
    }



    public function Input(string $id, string $label, $value, string $type,bool $required,array $options=[]){
        switch ($type){
            case "F": // Hidden
                return $this->Hidden($id,$value);
            case "$": // Texto
                return $this->TextBox($id,$label,$value,"text","abc",$required);
            case "?": // Password
                return $this->TextBox($id,$label,$value,"password","password",$required);
            case "#": // Numerico
                return $this->TextBox($id,$label,$value,"number","123",$required);
            case "D": // Fecha
                return $this->TextBox($id,$label,$value,"date","123",$required);
            case "@": // Correo
                return $this->TextBox($id,$label,$value,"email","nombre@empresa.com",$required);
            case "&": // Textarea
                return $this->TextArea($id,$label,3,"abc...xyz");
            case "%": // Checkbox
                return '
                    <div class="form-group row">
                        <div class="col-sm-2">'.$label.'</div>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="'.$id.'">
                                <label class="form-check-label" for="'.$id.'">
                                    '.$options[1].'
                                </label>
                            </div>
                        </div>
                    </div>
                ';
            case "*": // Combobox
                return $this->Select($id,$label,$value,"",$options);
            case "|": // Multiple Combobox
                return $this->Select($id,$label,$value,"multiple",$options);
            case "~": // Options
                return $this->Options($id,$label,$value,$options);
            case "^": // Subir Archivo
                return $this->TextBox($id,$label,$value,"file","abc");
            case "!": // Rango
                return "";
        }

    }

    public function Options(string $id,string $label,$value,array $options){
        $html='
            <fieldset class="form-group">
                <div class="row">
                  <legend class="col-form-label col-sm-2 pt-0">'.$label.'</legend>
                  <div class="col-sm-10">';
        foreach ($options as $key=>$option){
            $html.='
                    <div class="form-check">';
            if($key==$value or $option==$value){
                $html.='            <input class="form-check-input" checked type="radio" name="'.$id.'" id="'.$id.$key.'" value="'.$key.'" >';
            }
            else
            {
                $html.='            <input class="form-check-input" type="radio" name="'.$id.'" id="'.$id.$key.'" value="'.$key.'" >';
            }


            $html.='
                        <label class="form-check-label" for="'.$id.$key.'">
                            '.$option.'
                        </label>
                    </div>
            ';
        }

        $html.='
                  </div>
                </div>
            </fieldset>
        ';
        return $html;
    }

    public function Select(string $id,string $label, $value, string $multiple="",array $options=[]){
        $html= '
                     <div class="form-group row">
                        <label for="'.$id.'" class="col-sm-2 col-form-label">'.$label.'</label>
                        <div class="col-sm-10">    
                            <select '.$multiple.' class="form-control" name="'.$id.'" id="'.$id.'">';
        foreach ($options as $key=>$option){
            if($key==$value or $option==$value){
                $html.="<option value='$key' selected>$option</option>";
            }
            else{
                $html.="<option value='$key'>$option</option>";
            }

        }
        $html.='    
                            </select>
                        </div>
                    </div>
                ';
        return $html;
    }



    public function sql_injection($text):bool
    {
        return true;
    }

    public function crossSiteScripting($text):bool
    {
        return true;
    }

    public function Hidden(string $id, $value)
    {
        return '<input type="hidden" value="'.$value.'" name="'.$id.'" id="'.$id.'" >';
    }

    public function TextBox(string $id,string $label,$value,string $type,string $placeholder,bool $required,$pattern="",$title=""){
        if($pattern<>"") $pattern='pattern="'.$pattern.'" ';
        if($title<>"") $title='title="'.$title.'"';
        $r="";
        if($required) $r="required";
        return '
        <div class="form-group row">
            <label for="'.$id.'" class="col-sm-2 col-form-label">'.$label.'</label>
            <div class="col-sm-10">
                <input type="'.$type.'" value="'.$value.'" class="form-control" name="'.$id.'" id="'.$id.'" placeholder="'.$placeholder.'" '.$pattern.' '.$title.' '.$r.' >
            </div>
        </div>
        ';
    }

    public function TextArea(string $id,$label,$value,int $rows=3,string $placeholder=""){

        return '
        <div class="form-group row">
            <label for="'.$id.'" class="col-sm-2 col-form-label">'.$label.'</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="'.$id.'" id="'.$id.'" rows="'.$rows.'" placeholder="'.$placeholder.'">'.$value.'</textarea>\
            </div>
        </div>';
    }

    //DateTime

    public function Fecha(int $dia,int $mes,int $ano,int $horas,int $minutos,int $segundos):DateTime
    {
        $external = "$dia/$mes/$ano $horas:$minutos:$segundos";
        $dateobj = DateTime::createFromFormat($this->formatoFecha, $external);
        return $dateobj;
    }

    public function FechaHoyObjeto():DateTime
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