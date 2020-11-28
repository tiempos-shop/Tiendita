<?php


namespace Tiendita;
include_once ("iModeloBase.php");
include_once("Business/Collection.php");
include_once("Business/Utilidades.php");
include_once("Data/Connection/EntidadBase.php");

abstract class ModeloBase implements iModeloBase
{

    private $Tabla;
    private $Id;
    private $campos;
    private $tipos;
    protected $NombreEntidad;

    public $Datos;

    private $auditoria;
    private $entidadBase;


    // Tabla Externa TipoMovimiento
    public $NombreTablaTipoMovimiento="TipoMovimiento";
    public $NombreIdTipoMovimiento="IdTipoMovimiento";
    /**
     * @var bool
     */
    private $getAll;

    public function __construct(string $nombreTabla,string $nombreId,array $campos,array $tipos,bool $auditoria=true)
    {
        $this->auditoria=$auditoria;
        $this->setTabla($nombreTabla);
        $this->setId($nombreId);
        $this->setCampos($campos);
        $this->setTipos($tipos);
        $this->Datos=new Collection();
        //$this->utilidades=new \Tiendita\Utilidades();
        $this->entidadBase=new EntidadBase();
        $this->getAll();
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

    private function CreateElement(object $row)
    {
        $element = (object)array();
        $id=$this->getId();
        $element->$id=$row->$id;
        foreach ($this->getCampos() as $campo){
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
        foreach ($this->getCampos() as $campo){
            if($this->tipos[$campo]=="#"){
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
        foreach ($this->getCampos() as $campo){
            $campos.=$campo.",";
            if($this->tipos[$campo]=="#"){
                $valores.=$row->$campo;
            }
            else{
                $valores.="'".$row->$campo."'";
            }

            $valores.=",";
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
        $html.='<tr>';
        $headers=[ "h1"=>"Editar","h2"=>"Borrar","h3"=>"Id" ]+$this->campos+$this->Adicional();
        foreach ($headers as $head){
            $html.="<th>$head</th>";
        }
        $html.='<tr>';
        foreach($object as $val){
            $a = get_object_vars($val);
            $html.= '<tr>';
            $html.='<td><button class="btn btn-primary">'.$botonEditar.'</button></td>';
            $html.='<td><button class="btn btn-danger">'.$botonBorrar.'</button></td>';
            foreach($a as $k=>$v ){
                if(!is_array($v)){
                    if(in_array($v,$ocultos)) break;
                    $html.= "<td>$v</td>";
                }
                else
                    $html.="<td>".$this->Object2SimpleTable($k,$v[0])."</td>";
            }
            $html.= "</tr>";
        }
        $html.= "</table>";
        $html.='<button class="btn btn-success">'.$botonInsertar.'</button>';

        $html.="
            <script>
               $(document).ready(function() {
                    $('".$id."').DataTable();
                });
            </script>";

        $form='';
        return $html;
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
                    if(in_array($v,$ocultos)) break;
                    $html.= "<td>$v</td>";
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
    public abstract function Adicional();
    public abstract function SimpleAdd();

}