<?php


namespace Tiendita;
include_once "ModeloBase.php";

class ModeloPedidos extends ModeloBase
{
    public function __construct()
    {
        parent::__construct("Pedidos","IdPedido",Pedidos::getProperties());
    }

    public function Adicional(){
        return [ "ad1"=>"Núm. Pedido", "ad2"=>"Motivo Devoluciones ","ad3"=>"Tipo Movimiento","ad4"=>"Usuario"];
    }

    public function Object2SimpleTable(string $k, object $v)
    {
        if($k=="TipoMovimiento") {
            return $v->Descripcion;
        }
        elseif ($k=="UsuarioBase"){
            return $v->Nombres." ".$v->Apellidos;
        }
        elseif($k=="MotivoDevoluciones") {
            return $v->Descripcion;
        }
        elseif($k=="Pedidos") {
            return $v->IdPedido;
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
        elseif($k=="MotivoDevoluciones") {
            return "
            <div class='row'>
                <div class='col-sm-2'>Motivo Devoluciones</div>
                <div class='col-sm-10'>$v->Descripcion</div>
            </div>";
        }
        elseif($k=="Pedidos") {
            return "
            <div class='row'>
                <div class='col-sm-2'>Pedido</div>
                <div class='col-sm-10'>$v->IdPedido</div>
            </div>";
        }
        else{
            return "No definido campo: ".$k;
        }
    }

    public function Foreign(string $k, string $v)
    {
        if($k=="IdMotivoDevolucion"){
            $table=$this->properties[$k]["table"];
            $datos=$this->entidadBase->getBy($table,$k,$v)[0];
            $nombre=$datos->Descripcion;
            return "<td>$nombre</td>";
        }
        elseif($k=="IdPedido"){
            $table=$this->properties[$k]["table"];
            $datos=$this->entidadBase->getBy($table,$k,$v)[0];
            $nombre=$datos->IdPedido;
            return "<td>$nombre</td>";
        }
        else{
            return "No definido campo: ".$k;
        }

    }

    public function ForeignInput(string $k, string $v)
    {
        if($k=="IdMotivoDevolucion"){
            $table=$this->properties[$k]["table"];
            $label=$this->properties[$k]["label"];
            $type=$this->properties[$k]["type"];
            $datos=$this->entidadBase->getAll($table);
            $options=array();
            foreach ($datos as $dato) {
                $nombre=$dato->Descripcion;
                $options[$dato->IdMotivoDevolucion]=$nombre;

            }
            var_dump($options);
            return $this->ui->Input($k, $label, "", $type,true,$options);
        }
        elseif($k=="IdPedido"){
            $table=$this->properties[$k]["table"];
            $label=$this->properties[$k]["label"];
            $type=$this->properties[$k]["type"];
            $datos=$this->entidadBase->getAll($table);
            $options=array();
            foreach ($datos as $dato) {
                $nombre=$dato->IdPedido;
                $options[$dato->IdPedido]=$nombre;

            }
            var_dump($options);
            return $this->ui->Input($k, $label, "", $type,true,$options);
        }
        else{
            return "No definido campo: ".$k;
        }

    }
}