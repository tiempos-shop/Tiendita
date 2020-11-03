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
            5=>"CorreoElectronico",6=>"Telefono",7=>"NumeroEmpleado",8=>"FechaCambio");

    // Tabla Externa TipoMovimiento
    public $NombreTablaTipoMovimiento="TipoMovimiento";
    public $NombreIdTipoMovimiento="IdTipoMovimientos";

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
            $element->IdUsuario = $row->IdUsuario;
            $element->Nombres = $row->Nombres;
            $element->Apellidos = $row->Apellidos;
            $element->Usuario = $row->Usuario;
            $element->Password = $row->Password;
            $element->Telefono = $row->Telefono;
            $element->CorreoElectronico = $row->CorreoElectronico;
            $element->NumeroEmpleado = $row->NumeroEmpleado;
            $element->FechaCambio = ""; // \DateTime::createFromFormat("",$row->IdTipoMovimiento,\DateTimeZone::AMERICA) ;

            $tipoMovimiento=$entidadBase->getBy($this->NombreTablaTipoMovimiento,$this->NombreIdTipoMovimiento,(int)$row->IdTipoMovimientos);
            $element->IdTipoMovimiento=$tipoMovimiento;


            $usuarioBase=$entidadBase->getBy($this->Tabla,$this->Id,(int)$row->IdUsuarioBase);
            $element->IdUsuarioBase=$usuarioBase;

            $Entidad[] = $element;
        }
        echo $this->utilidades->Object2Table($Entidad);
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