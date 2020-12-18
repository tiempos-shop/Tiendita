<?php


namespace Tiendita;
include_once "iEntity.php";

class ProductosPedido implements iEntity
{

    public $IdProductosPedido = 0 ;
    public $IdPedido = 0 ;
    public $IdProducto = 0 ;
    public $Cantidad = 0 ;

    public static function getProperties(): array
    {
        return [
            "IdProductoPedido"=>["label"=>"Id","type"=>"I","typeDb"=>"#","required"=>false],
            "IdPedido"=>["label"=>"Estatus","type"=>"K","typeDb"=>"#","required"=>true,"table"=>"Pedidos"],
            "IdCliente"=>["label"=>"Cliente","type"=>"F","typeDb"=>"#","required"=>true,"table"=>"Clientes"],
            "IdProducto"=>["label"=>"Producto","type"=>"F","typeDb"=>"#","required"=>false,"table"=>"Productos"],
            "Cantidad"=>["label"=>"Cantidad","type"=>"#","typeDb"=>"#","required"=>true],
            "FechaPedido"=>["label"=>"Fecha de Pedido","type"=>"D","typeDb"=>"$","required"=>true]
        ];
    }
}