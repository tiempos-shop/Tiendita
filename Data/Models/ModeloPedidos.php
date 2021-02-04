<?php


namespace Tiendita;
include_once "ModeloBase.php";
include_once "Data/Models/Pedidos.php";

class ModeloPedidos extends ModeloBase
{
    public function __construct()
    {
        parent::__construct("Pedidos","IdPedido",Pedidos::getProperties());
    }

    public function Adicional(){
        return [ "ad1"=>"Estatus", "ad2"=>"Envio","ad3"=>"Cliente","ad4"=>"Tipo Movimiento","ad5"=>"Usuario Captura"];
    }

    public function Object2SimpleTable(string $k, object $v)
    {
        if($k=="TipoMovimiento") {
            return $v->Descripcion;
        }
        elseif ($k=="UsuarioBase"){
            return $v->Nombres." ".$v->Apellidos;
        }
        elseif($k=="EstatusPedido") {
            return $v->Nombre;
        }
        elseif($k=="Envios") {
            return $v->EstatusEnvio;
        }
        elseif($k=="Clientes") {
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
                <div class='col-sm-2'>Tipo Movimiento</div>
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
        elseif($k=="EstatusPedido") {
            return "
            <div class='row'>
                <div class='col-sm-2'>Motivo Devoluciones</div>
                <div class='col-sm-10'>$v->Nombre</div>
            </div>";
        }
        elseif($k=="Envios") {
            return "
            <div class='row'>
                <div class='col-sm-2'>Pedido</div>
                <div class='col-sm-10'>$v->EstatusEnvio</div>
            </div>";
        }
        elseif($k=="Clientes") {
            return "
            <div class='row'>
                <div class='col-sm-2'>Pedido</div>
                <div class='col-sm-10'>$v->Nombre</div>
            </div>";
        }
        else{
            return "No definido campo: ".$k;
        }
    }

    public function Foreign(string $k, string $v)
    {
        if($k=="IdEstatusPedido"){
            $table=$this->properties[$k]["table"];
            $datos=$this->entidadBase->getBy($table,$k,$v)[0];
            $nombre=$datos->Nombre;
            return "<td>$nombre</td>";
        }
        elseif($k=="IdEnvio"){
            $table=$this->properties[$k]["table"];
            $datos=$this->entidadBase->getBy($table,$k,$v)[0];
            $nombre=$datos->EstatusEnvio;
            return "<td>$nombre</td>";
        }
        elseif($k=="IdCliente"){
            $table=$this->properties[$k]["table"];
            $datos=$this->entidadBase->getBy($table,$k,$v)[0];
            $nombre=$datos->Nombre." ".$datos->Apellidos;
            return "<td>$nombre</td>";
        }
        else{
            return "No definido campo: ".$k;
        }

    }

    public function ForeignInput(string $k,$v)
    {
        if($k=="IdEstatusPedido"){
            $table=$this->properties[$k]["table"];
            $label=$this->properties[$k]["label"];
            $type=$this->properties[$k]["type"];
            $datos=$this->entidadBase->getAll($table);
            $options=array();
            foreach ($datos as $dato) {
                $nombre=$dato->Nombre;
                $options[$dato->$k]=$nombre;

            }
            var_dump($options);
            return $this->ui->Input($k, $label, "", $type,true,$options);
        }
        elseif($k=="IdEnvio"){
            $table=$this->properties[$k]["table"];
            $label=$this->properties[$k]["label"];
            $type=$this->properties[$k]["type"];
            $datos=$this->entidadBase->getAll($table);
            $options=array();
            foreach ($datos as $dato) {
                $nombre=$dato->EstatusEnvio;
                $options[$dato->$k]=$nombre;

            }
            var_dump($options);
            return $this->ui->Input($k, $label, "", $type,true,$options);
        }
        elseif($k=="IdCliente"){
            $table=$this->properties[$k]["table"];
            $label=$this->properties[$k]["label"];
            $type=$this->properties[$k]["type"];
            $datos=$this->entidadBase->getAll($table);
            $options=array();
            foreach ($datos as $dato) {
                $nombre=$dato->Nombre." ".$dato->Apellidos;
                $options[$dato->$k]=$nombre;

            }
            var_dump($options);
            return $this->ui->Input($k, $label, "", $type,true,$options);
        }
        else{
            return "No definido campo: ".$k;
        }

    }
}