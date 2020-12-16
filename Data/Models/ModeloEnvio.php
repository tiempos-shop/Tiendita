<?php


namespace Tiendita;
include_once "Data/Models/Envios.php";
include_once "ModeloBase.php";

class ModeloEnvio extends ModeloBase
{
    public function __construct()
    {
        parent::__construct("Envios","IdEnvio",Envios::getProperties());
    }

    public function Adicional(){
        return [ "ad1"=>"Tipo Movimiento", "ad2"=>"Usuario ","ad3"=>"EmpresaEnvio"];
    }

    public function Object2SimpleTable(string $k, object $v)
    {
        if($k=="TipoMovimiento") {
            return $v->Descripcion;
        }
        elseif ($k=="UsuarioBase"){
            return $v->Nombres." ".$v->Apellidos;
        }
        elseif($k=="EmpresaEnvio") {
            return $v->Nombre;
        }
        else{
            return "No definido campo: ".$k;
        }
    }

    public function SimpleAdd()
    {
        return $this->Adicional();
    }

    public function Object2SimpleFormulary(string $k, object $v)
    {
        if($k=="TipoMovimiento") {
            return "
            <div class='row'>
                <div class='col-sm-2'>Modificación</div>
                <div class='col-sm-10'>$v->Descripcion</div>
            </div>";
        }
        elseif ($k=="UsuarioBase"){
            return "
            <div class='row'>
                <div class='col-sm-2'>Usuario</div>
                <div class='col-sm-10'>$v->Nombres $v->Apellidos</div>
            </div>";

        }
        elseif($k=="EmpresaEnvio") {
            return "
            <div class='row'>
                <div class='col-sm-2'>Empresa de Envio</div>
                <div class='col-sm-10'>$v->Nombre</div>
            </div>";
        }
        else{
            return "No definido campo: ".$k;
        }
    }

    public function Foreign(string $k, string $v)
    {
        $table=$this->properties[$k]["table"];
        $datos=$this->entidadBase->getBy($table,$k,$v)[0];
        $nombre=$datos->Nombre;
        return "<td>$nombre</td>";
    }

    public function ForeignInput(string $k, string $v)
    {
        $table=$this->properties[$k]["table"];
        $label=$this->properties[$k]["label"];
        $type=$this->properties[$k]["type"];
        $datos=$this->entidadBase->getAll($table);
        $options=array();
        foreach ($datos as $dato) {
            $nombre=$dato->Nombre;
            $options[$dato->IdEmpresa]=$nombre;

        }
        var_dump($options);
        return $this->ui->Input($k, $label, $v, $type,true,$options);
    }
}