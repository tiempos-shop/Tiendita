<?php


namespace Tiendita;
use stdClass;

include_once ("iModeloBase.php");
include_once("Business/Collection.php");
include_once("Business/Utilidades.php");
include_once("Data/Connection/EntidadBase.php");

abstract class ModeloBase implements iModeloBase
{

    private $Tabla;
    private $Id;
    private $campos;
    private $camposEditar;
    protected $properties;
    private $tipos;
    protected $NombreEntidad;
    private $userId;


    public $Datos;

    private $auditoria;
    private $entidadBase;
    public $ui;


    // Tabla Externa TipoMovimiento
    public $NombreTablaTipoMovimiento="TipoMovimiento";
    public $NombreIdTipoMovimiento="IdTipoMovimiento";
    /**
     * @var bool
     */
    private $getAll;

    public function __construct(string $nombreTabla,string $nombreId,array $campos,array $camposEditar,array $tipos,array $properties,bool $auditoria=true)
    {
        if(isset($_SESSION["userId"])){
            $this->userId=$_SESSION["userId"];
        }
        else{
            // TODO: Debe enviar al login e impedir iniciar la aplicación
            $this->userId=0;
        }
        $this->properties=$properties;
        $this->auditoria=$auditoria;
        $this->setTabla($nombreTabla);
        $this->setId($nombreId);
        $this->setCampos($campos);
        $this->setTipos($tipos);
        $this->camposEditar=$camposEditar;
        $this->Datos=new Collection();
        $this->ui=new Utilidades();
        $this->entidadBase=new EntidadBase();

    }


    public function getAll()
    {
        $data=$this->entidadBase->getAll($this->getTabla());
        $Entidad=array();

        foreach ($data as $row) {
            $Entidad[]=$this->CreateElement($row);
        }
        $this->Datos=$Entidad;
        $this->getAll=true;

        return $this->Datos;
    }

    public function CreateElement(object $row)
    {
        $element = (object)array();
        $id=$this->getId();
        $element->$id=$row->$id;
        foreach ($this->properties as $campo=>$property){
                $element->$campo=$row->$campo;
        }

        if($this->auditoria===true){
            // Objetos Externos
            $element->TipoMovimiento=$this->entidadBase->getBy($this->NombreTablaTipoMovimiento,$this->NombreIdTipoMovimiento,$element->IdTipoMovimiento);
            $element->UsuarioBase=$this->entidadBase->getBy($this->getTabla(),$this->getId(),$element->IdUsuarioBase);
        }
        return $element;
    }

    public function getById(int $valor)
    {
        $row=$this->entidadBase->getBy($this->getTabla(),$this->getId(),$valor);

        return $this->CreateElement($row[0]);
    }

    public function getBy(string $campo,$valor)
    {
        $row=$this->entidadBase->getBy($this->getTabla(),$campo,$valor);
        return $this->CreateElement($row[0]);
    }

    public function update(object $row){

        $n=$this->getId();
        $id=intval($row->$n);
        $sql="UPDATE $this->Tabla SET ";
        $valores="";
        foreach ($this->properties as $campo=>$property){
            if($property["typeDb"]=="#"){
                $valores.="$campo = ".$row->$campo.",";
            }
            else {
                $valores.="$campo = '".$row->$campo."', ";
            }

        }
        $valores=trim($valores,",");
        $sql.=$sql.$valores." WHERE $this->Id = $id;";
        $this->entidadBase->AddQuerys($sql);
        $this->getAll=false;

    }

    public function insert(object $row){

        $sql="INSERT INTO $this->Tabla ";
        $campos="";
        $valores="";
        foreach ($this->properties as $campo=>$property){
            if($property["type"]<>"I"){
                $campos.=$campo.",";
                if($property["typeDb"]=="#"){
                    $valores.=$row->$campo;
                }
                else{
                    $valores.="'".$row->$campo."'";
                }

                $valores.=",";
            }
        }
        $campos=trim($campos,",");
        $valores=trim($valores,",");
        $sql.="($campos) VALUES ($valores);";
        $this->entidadBase->AddQuerys($sql);
        $this->getAll=false;
    }

    public function delete(object $row){

        $n=$this->getId();
        $id=intval($row->$n);
        $sql="DELETE FROM $this->Tabla  WHERE $this->Id = $id;";
        $this->entidadBase->AddQuerys($sql);
        $this->getAll=false;
    }

    public function SaveAll(){
        $this->entidadBase->SaveAll();
    }

    public function getTabla(): string
    {
        return $this->Tabla;
    }

    public function setTabla(string $Tabla): void
    {
        $this->Tabla = $Tabla;
    }

    public function getId():string
    {
        return $this->Id;
    }

    public function setId($Id): void
    {
        $this->Id = $Id;
    }

    public function getCampos(): array
    {
        return $this->campos;
    }

    public function setCampos(array $campos): void
    {
        $this->campos = $campos;
    }

    public function getDatos(): Collection
    {
        return $this->Datos;
    }


    public function getNombreEntidad():string
    {
        return $this->NombreEntidad;
    }

    public function setNombreEntidad(string $NombreEntidad): void
    {
        $this->NombreEntidad = $NombreEntidad;
    }

    public function Agregar($tabla,$elemento){

        $this->Datos->addItem($elemento,$elemento->IdUsuario);
        $sqlInsert="insert into Usuarios ";
    }

    /**
     * @return array
     */
    public function getTipos(): array
    {
        return $this->tipos;
    }

    /**
     * @param array $tipos
     */
    public function setTipos(array $tipos): void
    {
        $this->tipos = $tipos;
    }

    // UTILIDADES

    public function Object2TableEdit(string $id,string $botonEditar,string $botonBorrar,string $botonInsertar,string $footer="",array $ocultos=[]){
        $object=$this->getAll();
        $html= '<table class="table table-bordered">';
        $html.="<caption>$footer</caption>";
        // Encabezados
        $html.='<tr>';
        $camposEditar=array();
        foreach ($this->properties as $campo=>$property){
            $type=$property["type"];
            if(!($type=="I" or $type=="F"))
                $camposEditar[]=$property["label"];
        }
        $headers=[ "h1"=>"Editar","h2"=>"Borrar" ]+$camposEditar+$this->Adicional();
        foreach ($headers as $head){
            $html.="<th>$head</th>";
        }
        $html.='</tr>';
        $i=0;
        // Campos
        $html.='<tr>';
        $inputNV="";
        foreach($object as $val){
            $a = get_object_vars($val);
            $datoId=$a[$this->getId()];
            $i++;
            $html.= '<tr>';
            $columns="";
            $input=$this->ui->Hidden($this->getId(),$datoId);

            foreach($a as $k=>$v ){

                if(!is_array($v) and !is_object($v)){
                    if($this->auditoria){
                        if($k=="FechaCambio") $v=$this->ui->FechaHoy();
                        if($k=="IdTipoMovimiento") $v=1;
                        if($k=="IdUsuarioBase") $v=$this->userId;
                    }
                    $type=$this->properties[$k]["type"];
                    $req=$this->properties[$k]["required"];
                    if(!($type=="I" or $type=="F")) $columns.= "<td>$v</td>";
                    //if(in_array($k,$this->camposEditar)) $columns.= "<td>$v</td>";
                    if(array_key_exists($k,$this->tipos) and !is_null($this->tipos[$k])){
                        $input.=$this->ui->Input($k,$k,$v,$type,$req);
                        if($i==1) {
                            if($type=="F"){
                                $inputNV.=$this->ui->Input($k,$k,$v,$type,$req);
                            }
                            else{
                                $inputNV.=$this->ui->Input($k,$k,"",$type,$req);
                            }

                        }
                    }
                }
                else{
                    $columns.="<td>".$this->Object2SimpleTable($k,$v[0])."</td>";
                    $input.=$this->Object2SimpleFormulary($k,$v[0]);
                    if($i==1) $inputNV.=$this->Object2SimpleFormulary($k,$v[0]);
                }

            }

        // Botones
            $button="<td>".$this->ui->ModalButton("idEditTable".$i,$botonEditar,"","Edicion de Campos","Cancelar",
                    $this->ui->Form([
                        $input,"<br/>"
                    ],"","Guardar"),"","","primary  btn-sm"
                )."</td>";

            $button.='
                <td>'
                .$this->ui->ModalButton("idDeleteTable".$i,$botonBorrar,"","Borrar Registro","Cancelar",
                    $this->ui->Form([
                        "<p>Desea borrar el registro?</p>",
                        "<br/>",
                        $this->ui->Hidden($this->getId(),$datoId),
                        $this->ui->Hidden("delete",true)
                    ],"","Borrar"),"","","danger btn-sm"
                ).
                '</td>';
        // Genera html Fila
            $html.= $button.$columns."</tr>";
        }
        $html.= "</table><br/>";
        // Boton Insertar
        //$html.='<button class="btn btn-success">'.$botonInsertar.'</button>';
        $html.=$this->ui->ModalButton("idInsertTable",$botonInsertar,"","Agregar un Registro","Cancelar",
            $this->ui->Form([
                $inputNV,
                "<br/>"
            ],"","Agregar"),"","","info"
        );

        // Script
        // TODO: No se activa el script.
        $html.="
            <script>
               $(document).ready(function() {
                    $('$id').DataTable();
                });
            </script>";

        return $html;
    }

    public function SafeSave():int
    {
        // TODO:
        var_dump($_POST);
        if(count($_POST)<>0){

            $id=null;
            $deleteConfirm=false;
            $delete=array_key_exists("delete",$_POST);
            if(array_key_exists($this->getId(),$_POST)){
                $id=$_POST[$this->getId()];
            }
            else
            {
                $id="";
            }
            $entidad=new Collection();
            $nombreId=$this->getId();
            $entidad->$nombreId=$id;
            foreach($this->campos as $key) {
                if(array_key_exists($key,$_POST)){
                    $entidad->$key=$_POST[$key];
                }
                else
                {
                    $deleteConfirm=true;
                }
            }
            if($this->auditoria){
                $entidad->FechaCambiofecha=$this->ui->FechaHoy();
            }
            if($deleteConfirm and $delete){
                $this->delete($entidad);
            }
            else{
                if($deleteConfirm){
                    $this->ui->MessageBox("Error en Campos: No se encuentran todos los campos para actualizar");
                    return 1;
                }
                elseif ($id==""){
                    $this->insert($entidad);
                }
                else{
                    $this->update($entidad);
                }
            }

            $this->SaveAll();
            $this->ui->MessageBox("Los datos se guardaron correctamente.");
            return 0;
        }
        else
        {
            return 0;
        }
    }



    public function Object2Table(string $id,array $ocultos=[]){
        $object=$this->getAll();
        $html= '<table class="table table-bordered">';
        $html.='<tr>';
        $headers=["h1"=>"Id"]+$this->campos+$this->SimpleAdd();
        foreach ($headers as $head){
            $html.="<th>$head</th>";
        }
        $html.='<tr>';
        foreach($object as $val){
            $a = get_object_vars($val);
            $html.= '<tr>';
            foreach($a as $k=>$v ){
                if(!is_array($v)){
                    if(!in_array($v,$ocultos)){
                        $html.= "<td>$v</td>";
                    }
                }
                else
                    $html.="<td>".$this->Object2SimpleTable($k,$v[0])."</td>";
            }
            $html.= "</tr>";
        }
        $html.= "</table>";
        return $html;
    }

    public abstract function Object2SimpleTable(string $k,object $v);
    public abstract function Object2SimpleFormulary(string $k,object $v);
    public abstract function Adicional();
    public abstract function SimpleAdd();

}