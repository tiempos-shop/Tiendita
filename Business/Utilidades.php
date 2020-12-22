<?php


namespace Tiendita;
use Cassandra\Timestamp;
use DateTime;



class Utilidades
{
    public $formatoFecha = "d/m/Y H:i:s";
    public $formatoFechaCaptura="d/m/Y";

    // Expresiones regulares
    const password="^(?=.*[A-Z].*[A-Z])(?=.*[!@#$&*])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8}$";
    const nombres="/^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/";
    const correo="/^[\w]+@{1}[\w]+\.[a-z]{2,3}$/";


    // Tablas

    public function Object2Table($object){
        $html= "<table class='table table-bordered'>";
        foreach($object as $val){
            $a = get_object_vars($val);
            $html.= "<tbody><tr>";
            foreach($a as $v ){
                if(!is_array($v))
                    $html.= "<td>$v</td>";
                else
                    $html.="<td>".$this->Object2Table($v)."</td>";
            }
            $html.= "</tr></tbody>";

        }
        $html.= "</table>";
        return $html;
    }

    public function DataTable(string $id){
        $language="
            {
                'processing': 'Procesando...',
                'lengthMenu': 'Mostrar _MENU_ registros',
                'zeroRecords': 'No se encontraron resultados',
                'emptyTable': 'Ningún dato disponible en esta tabla',
                'info': 'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
                'infoEmpty': 'Mostrando registros del 0 al 0 de un total de 0 registros',
                'infoFiltered': '(filtrado de un total de _MAX_ registros)',
                'search': 'Buscar:',
                'infoThousands': ',',
                'loadingRecords': 'Cargando...',
                'paginate': {
                    'first': 'Primero',
                    'last': 'Último',
                    'next': 'Siguiente',
                    'previous': 'Anterior'
                },
                'aria': {
                    'sortAscending': ': Activar para ordenar la columna de manera ascendente',
                    'sortDescending': ': Activar para ordenar la columna de manera descendente'
                },
                'buttons': {
                    'copy': 'Copiar',
                    'colvis': 'Visibilidad'
                }
            }         
        ";
        return "
            <script>
               $(document).ready(function() {
                    $('#$id').DataTable({
                        
                        autoWidth: false,
                         
                        language:
                        {
                            'processing': 'Procesando...',
                            'lengthMenu': 'Mostrar _MENU_ registros',
                            'zeroRecords': 'No se encontraron resultados',
                            'emptyTable': 'Ningún dato disponible en esta tabla',
                            'info': 'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
                            'infoEmpty': 'Mostrando registros del 0 al 0 de un total de 0 registros',
                            'infoFiltered': '(filtrado de un total de _MAX_ registros)',
                            'search': 'Buscar:',
                            'infoThousands': ',',
                            'loadingRecords': 'Cargando...',
                            'paginate': {
                                'first': 'Primero',
                                'last': 'Último',
                                'next': 'Siguiente',
                                'previous': 'Anterior'
                            },
                            'aria': {
                                'sortAscending': ': Activar para ordenar la columna de manera ascendente',
                                'sortDescending': ': Activar para ordenar la columna de manera descendente'
                            },
                            'buttons': {
                                'copy': 'Copiar',
                                'colvis': 'Visibilidad'
                            }
                        }
                    });
                    
                });
            </script>";
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
                        <button type="submit" class="btn btn-outline-dark">'.$button.'</button>
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
            case "#": // Entero
                return $this->TextBox($id,$label,$value,"number","123",$required);
            case "M": // Moneda
                return $this->TextBox($id,$label,$value,"number","123",$required,"","","step='.01'");
            case "D": // Fecha
                return $this->TextBox($id,$label,$value,"date","123",$required);
            case "@": // Correo
                return $this->TextBox($id,$label,$value,"email","nombre@empresa.com",$required);
            case "&": // Textarea
                return $this->TextArea($id,$label,$value,3,"abc...xyz");
            case "%": // Checkbox
                $cValue="";
                if(is_int($value)){
                    if($value>0) $cValue="checked";
                }
                else {
                    if($value) $cValue="checked";
                }

                return '
                    <div class="form-group row">
                        <div class="col-sm-2">'.$label.'</div>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="'.$id.'" id="'.$id.'" '.$cValue.'>
                                <label class="form-check-label" for="'.$id.'">
                                    
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
                return $this->TextBox($id,$label,$value,"file","file.ext",$required);
            case "!": // Rango
                return "";
            default: return "";
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

    public function TextBox(string $id,string $label,$value,string $type,string $placeholder,bool $required,$pattern="",$title="",$props=""){
        if($pattern<>"") $pattern='pattern="'.$pattern.'" ';
        if($title<>"") $title='title="'.$title.'"';
        $r="";
        if ($type=="date" and $value<>"") {
            $value=explode(" ",$value)[0];
            $dateTime = DateTime::createFromFormat($this->formatoFechaCaptura, $value);
            if($dateTime===false){
                echo $value;
                echo "<br/>";
                echo $this->formatoFechaCaptura;
                echo "<br/>";
                echo $value;
            }
            $value=$dateTime->format('Y-m-d');


        }
        if($required) $r="required";
        return '
        <div class="form-group row">
            <label for="'.$id.'" class="col-sm-2 col-form-label">'.$label.'</label>
            <div class="col-sm-10">
                <input type="'.$type.'" value="'.$value.'" class="form-control" name="'.$id.'" id="'.$id.'" placeholder="'.$placeholder.'" '.$pattern.' '.$title.' '.$r.' '.$props.'>
            </div>
        </div>
        ';
    }

    public function TextArea(string $id,$label,$value,int $rows=3,string $placeholder=""){

        return '
        <div class="form-group row">
            <label for="'.$id.'" class="col-sm-2 col-form-label">'.$label.'</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="'.$id.'" id="'.$id.'" rows="'.$rows.'" placeholder="'.$placeholder.'">'.$value.'</textarea>
            </div>
        </div>';
    }

    public function OptionPage(string $id,array $optionButtons,array $contents){
        $i=0;
        $html='
            <ul class="nav nav-pills">';
        foreach ($optionButtons as $button){
            $i++;
            $idBtn=$id.$i;
            if($i==1){
                $html.='<li class="active"><a data-toggle="pill" href="#'.$idBtn.'">'.$button.'</a></li>';
            }
            else{
                $html.='<li><a data-toggle="pill" href="#'.$idBtn.'">'.$button.'</a></li>';
            }

        }
        $html.='
            </ul>
            <div class="tab-content">';
        $i=0;
        foreach ($contents as $content){
            $i++;
            $idBtn=$id.$i;
            if($i==1){
                $html.='
                        <div id="'.$idBtn.'" class="tab-pane fade in active">
                            '.$content.'
                        </div>                        
                        ';
            }
            else{
                $html.='
                        <div id="'.$idBtn.'" class="tab-pane fade">
                            '.$content.'
                        </div>                        
                        ';
            }
        }

        $html.='
            </div>
        ';
        return $html;
    }

    // GetPost

    public function Post(array $fields):array
    {
        $out=array();
        if(count($_POST)>0){
            foreach ($fields as $field){
                if(array_key_exists($field,$_POST)){
                    $out[$field]=$_POST[$field];
                }
            }
        }
        if(count($fields)==count($out)){
            return [ "out"=>true,"data"=>$out ];
        }
        else{
            return [ "out"=>false,"data"=>$out ];
        }
    }

    //DateTime

    public function Fecha(int $dia,int $mes,int $ano,int $horas,int $minutos,int $segundos):DateTime
    {
        $external = "$dia/$mes/$ano $horas:$minutos:$segundos";
        return DateTime::createFromFormat($this->formatoFecha, $external);
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

    public function DisplayInputDate(array $date){
        $dia=$date["mday"];
        $mes=$date["mon"];
        $ano=$date["year"];
        $external = "$ano-$mes-$dia";
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

    public function Redirect(string $url)
    {
        echo "<script>window.location.assign('$url')</script>";
    }


}