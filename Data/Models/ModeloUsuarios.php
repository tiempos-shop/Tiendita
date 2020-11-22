<?php
namespace Tiendita;
use mysql_xdevapi\Exception;
include_once("Business/Collection.php");
include_once("Business/Utilidades.php");
include_once("Data/Connection/EntidadBase.php");
include_once ("Data/Models/Usuarios.php");
class ModeloUsuarios
{
    // Tabla Usuarios

    private $Tabla;
    private $Id;
    private $campos;
    private $NombreEntidad;

    // Tabla Externa TipoMovimiento
    public $NombreTablaTipoMovimiento="TipoMovimiento";
    public $NombreIdTipoMovimiento="IdTipoMovimiento";

    public $Datos;
    private $utilidades;
    public $Entidad;

    public function __construct()
    {
        $this->setTabla("Usuarios");
        $this->setId("IdUsuario");
        $this->setCampos(
        array(1=>"Nombres",2=>"Apellidos",3=>"Usuario",4=>"Password",
            5=>"CorreoElectronico",6=>"Telefono",7=>"NumeroEmpleado",8=>"FechaCambio",9=>"IdTipoMovimiento",
            10=>"IdUsuarioBase"));
        $this->setNombreEntidad("Usuarios");
        $Entidad=array();
        $this->Datos=new Collection();
        $this->utilidades=new Utilidades();
        $entidadBase=new EntidadBase();

        $data=$entidadBase->getAll($this->Tabla);


        foreach ($data as $row) {

            //$element = new Usuarios();
            $element = new $this->NombreEntidad();

            foreach ($this->campos as $campo){
                $element->$campo=$row->$campo;
            }

            // Objetos Externos
            $element->TipoMovimiento=$entidadBase->getBy($this->NombreTablaTipoMovimiento,$this->NombreIdTipoMovimiento,$element->IdTipoMovimiento);
            $element->UsuarioBase=$entidadBase->getBy($this->Tabla,$this->Id,$element->IdUsuarioBase);

            $Entidad[] = $element;
        }
        // echo $this->utilidades->Object2Table($Entidad);
        $this->Datos=$Entidad;
    }



    public function Agregar($elemento){
        if (!is_a($elemento, 'Usuario')) {
            throw new Exception("La clase no es de tipo Usuario");
        }
        $this->Datos->addItem($elemento,$elemento->IdUsuario);
        $sqlInsert="insert into Usuarios ";
    }

    /**
     * @return string
     */
    public function getTabla(): string
    {
        return $this->Tabla;
    }

    /**
     * @param string $Tabla
     */
    public function setTabla(string $Tabla): void
    {
        $this->Tabla = $Tabla;
    }

    /**
     * @return string
     */
    public function getId():string
    {
        return $this->Id;
    }

    /**
     * @param string $Id
     */
    public function setId($Id): void
    {
        $this->Id = $Id;
    }

    /**
     * @return string[]
     */
    public function getCampos(): array
    {
        return $this->campos;
    }

    /**
     * @param string[] $campos
     */
    public function setCampos(array $campos): void
    {
        $this->campos = $campos;
    }

    /**
     * @return array
     */
    public function getDatos(): array
    {
        return $this->Datos;
    }

    /**
     * @param Collection $Datos
     */
    public function setDatos(Collection $Datos): void
    {
        $this->Datos = $Datos;
    }

    /**
     * @return Utilidades
     */
    public function getUtilidades(): Utilidades
    {
        return $this->utilidades;
    }

    /**
     * @param Utilidades $utilidades
     */
    public function setUtilidades(Utilidades $utilidades): void
    {
        $this->utilidades = $utilidades;
    }

    /**
     * @return string
     */
    public function getNombreEntidad():string
    {
        return $this->NombreEntidad;
    }

    /**
     * @param string $NombreEntidad
     */
    public function setNombreEntidad(string $NombreEntidad): void
    {
        $this->NombreEntidad = $NombreEntidad;
    }

    /**
     * @return mixed
     */
    public function getEntidad()
    {
        return $this->Entidad;
    }

    /**
     * @param mixed $Entidad
     */
    public function setEntidad($Entidad): void
    {
        $this->Entidad = $Entidad;
    }
}