<?php
namespace Tiendita;
use mysql_xdevapi\Exception;
class ModeloUsuarios
{
    // Tabla Usuarios
    public $Tabla="Usuarios";
    public $Id="IdUsuario";
    public $campos=
        array(1=>"Nombres",2=>"Apellidos",3=>"Usuario",4=>"Password",
            5=>"CorreoElectronico",6=>"Telefono",7=>"NumeroEmpleado",8=>"FechaCambio",9=>"IdTipoMovimiento",
            10=>"IdUsuarioBase");

    // Tabla Externa TipoMovimiento
    public $NombreTablaTipoMovimiento="TipoMovimiento";
    public $NombreIdTipoMovimiento="IdTipoMovimiento";

    public $Datos;
    private $utilidades;

    public function __construct()
    {
        $Entidad=array();
        include_once("Business/Collection.php");
        $this->Datos=new Collection();
        include_once("Business/Utilidades.php");
        $this->utilidades=new Utilidades();


        include_once("Data/Connection/EntidadBase.php");
        $entidadBase=new EntidadBase();
        $data=$entidadBase->getAll($this->Tabla);
        include_once ("Data/Models/Usuarios.php");

        foreach ($data as $row) {

            $element = new Usuarios();

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
}