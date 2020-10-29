<?php


namespace Tiendita;


class ModeloUsuarios
{
    public $NombreTablaUsuarios="Usuarios";
    public $NombreTablaTipoMovimiento="TipoMovimiento";
    public $NombreIdTipoMovimiento="IdTipoMovimientos";
    public $NombreIdUsuarios="IdUsuario";
    public $Datos;

    public function __construct()
    {
        $EntidadUsuarios=array();
        include_once("Business/Collection.php");
        $this->Datos=new Collection();
        include_once("Data/Connection/EntidadBase.php");
        $entidadBase=new EntidadBase();
        $data=$entidadBase->getAll($this->NombreTablaUsuarios);
        echo "<p>Ingresa al contructor</p>";
        include_once ("Data/Models/Usuarios.php");

        foreach ($data as $row) {
            echo "<p>Genera un usuario</p>";
            $usuario = new Usuarios();
            echo "<p>Finaliza Genera un usuario</p>";
            $usuario->IdUsuario = $row->IdUsuario;
            $usuario->Nombres = $row->Nombres;
            $usuario->Apellidos = $row->Apellidos;
            $usuario->Usuario = $row->Usuario;
            $usuario->Password = $row->Password;
            $usuario->Telefono = $row->Usuario;
            $usuario->CorreoElectronico = $row->CorreoElectronico;
            $usuario->NumeroEmpleado = $row->NumeroEmpleado;
            $tipoMovimiento=$entidadBase->getBy($this->NombreTablaTipoMovimiento,$this->NombreIdTipoMovimiento,(int)$row->IdTipoMovimientos);
            $usuario->IdTipoMovimiento=$tipoMovimiento;
            $usuario->FechaCambio = ""; // \DateTime::createFromFormat("",$row->IdTipoMovimiento,\DateTimeZone::AMERICA) ;

            $usuarioBase=$entidadBase->getBy($this->NombreTablaUsuarios,$this->NombreIdUsuarios,(int)$row->IdUsuarioBase);
            $usuario->IdUsuarioBase=$usuarioBase;

            $EntidadUsuarios[] = $usuario;
        }
        echo "<p>Sale del contructor</p>";
        var_dump($EntidadUsuarios[0]);

        $this->Datos=$EntidadUsuarios;

    }

    public function AgregarUsuario($Usuario){
        if (!is_a($Usuario, 'Usuario')) {
            throw new Exception("La clase no es de tipo Usuario");
        }
        $this->Datos->addItem($Usuario,$Usuario->IdUsuario);
    }
}