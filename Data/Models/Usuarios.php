<?php


namespace Tiendita;

include_once "BaseAuditoria.php";
class Usuarios extends BaseAuditoria
{
    public $IdUsuario=0;
    public $Nombres="";
    public $Apellidos="";
    public $NumeroEmpleado="";
    public $Usuario="";
    public $Password="";
    public $CorreoElectronico="";
    public $Telefono="";

    public function __construct(string $nombres,string $apellidos,string $numeroEmpleado,string $usuario,string $password, string $correoElectronico,string $telefono, int $idUsuario, int $idTipoMovimiento)
    {
        $this->Nombres=$nombres;
        $this->Apellidos=$apellidos;
        $this->NumeroEmpleado=$numeroEmpleado;
        $this->Usuario=$usuario;
        $this->Password=$password;
        $this->CorreoElectronico=$correoElectronico;
        $this->Telefono=$telefono;
        parent::__construct($idUsuario, $idTipoMovimiento);
    }

    public static function getCampos():array
    {
        return array(1=>"Nombres",2=>"Apellidos",3=>"Usuario",4=>"Password",
            5=>"CorreoElectronico",6=>"Telefono",7=>"NumeroEmpleado",8=>"FechaCambio",9=>"IdTipoMovimiento",
            10=>"IdUsuarioBase");
    }
    public static function getType():array
    {
        return array("Nombres"=>"$","Apellidos"=>"$","Usuario"=>"$","Password"=>"$",
            "CorreoElectronico"=>"$","Telefono"=>"$","NumeroEmpleado"=>"$","FechaCambio"=>"$","IdTipoMovimiento"=>"#",
            "IdUsuarioBase"=>"#");
    }
}