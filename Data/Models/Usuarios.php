<?php


namespace Tiendita;
include_once "iEntity.php";
include_once "BaseAuditoria.php";
class Usuarios extends BaseAuditoria implements iEntity
{
    public $IdUsuario=0;
    public $Nombres="";
    public $Apellidos="";
    public $NumeroEmpleado="";
    public $Usuario="";
    public $Password="";
    public $CorreoElectronico="";
    public $Telefono="";



    public function __construct(){

    }

    public static function getCampos():array
    {
        return array(1=>"Nombres",2=>"Apellidos",3=>"Usuario",4=>"Password",
            5=>"CorreoElectronico",6=>"Telefono",7=>"NumeroEmpleado",8=>"FechaCambio",9=>"IdTipoMovimiento",
            10=>"IdUsuarioBase");
    }

    public static function getCamposEditar():array
    {
        return array(1=>"Nombres",2=>"Apellidos",3=>"Usuario",4=>"Password",
            5=>"CorreoElectronico",6=>"Telefono",7=>"NumeroEmpleado");
    }

    public static function getType():array
    {
        return array("IdUsuario"=>"H","Nombres"=>"$","Apellidos"=>"$","Usuario"=>"$","Password"=>"?",
            "CorreoElectronico"=>"@","Telefono"=>"$","NumeroEmpleado"=>"$","FechaCambio"=>"H","IdTipoMovimiento"=>"H",
            "IdUsuarioBase"=>"H");
    }

    public static function getTypeDb():array
    {
        return array("IdUsuario"=>"#","Nombres"=>"$","Apellidos"=>"$","Usuario"=>"$","Password"=>"$",
            "CorreoElectronico"=>"$","Telefono"=>"$","NumeroEmpleado"=>"$","FechaCambio"=>"$","IdTipoMovimiento"=>"#",
            "IdUsuarioBase"=>"#");
    }

    public static function getProperties():array
    {
        return [
            "IdUsuario"=>["label"=>"Id","type"=>"I","typeDb"=>"#"],
            "Nombres"=>["label"=>"Nombre","type"=>"$","typeDb"=>"$"],
            "Apellidos"=>["label"=>"Apellidos","type"=>"$","typeDb"=>"$"],
            "Usuario"=>["label"=>"Usuario","type"=>"$","typeDb"=>"$"],
            "Password"=>["label"=>"Password","type"=>"?","typeDb"=>"$"],
            "CorreoElectronico"=>["label"=>"Email","type"=>"@","typeDb"=>"$"],
            "Telefono"=>["label"=>"Teléfonos","type"=>"$","typeDb"=>"$"],
            "NumeroEmpleado"=>["label"=>"Número Empleado","type"=>"$","typeDb"=>"$"],
            "FechaCambio"=>["label"=>"Fecha Auditoria","type"=>"D","typeDb"=>"$"],
            "IdTipoMovimiento"=>["label"=>"Tipo Movimiento","type"=>"F","typeDb"=>"#","Table"=>"TipoMovimientos"],
            "IdUsuarioBase"=>["label"=>"Usuario de Registro]","type"=>"F","typeDb"=>"#","Table"=>"Usuarios"]
        ];
    }
}