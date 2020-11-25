<?php


namespace Tiendita;
include_once ("iModeloBase.php");
include_once("Business/Collection.php");
include_once("Business/Utilidades.php");
include_once("Data/Connection/EntidadBase.php");

use Exception;

class ModeloBase implements iModeloBase
{

    private $Tabla;
    private $Id;
    private $campos;
    private $tipos;
    protected $NombreEntidad;

    public $Datos;
    private $utilidades;
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
        $this->utilidades=new Utilidades();
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
            $valores.=$row->$campo;
            $valores.=",";
        }
        $campos=trim($campos,",");
        $valores=trim($valores,",");
        $sql.="($campos) VALUES ($valores);";
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

    public function getUtilidades(): Utilidades
    {
        return $this->utilidades;
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
}