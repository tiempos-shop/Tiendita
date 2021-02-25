<?php


namespace Tiendita;
include_once "BaseAuditoria.php";
include_once "iEntity.php";


class Producto extends BaseAuditoria implements iEntity
{
    public $IdProducto = 0 ;
    public $Clave = "" ;
    public $Nombre = "" ;
    public $Descripcion = "" ;
    public $Costo = 0.0 ;
    //TODO: Faltan agregar los datos del negocio para describir las caracteristicas del producto

    public static function getProperties(): array
    {
        return [
            "IdProducto"=>["label"=>"Id","type"=>"I","typeDb"=>"#","required"=>false],
            "Nombre"=>["label"=>"Producto","type"=>"$","typeDb"=>"$","required"=>true],
            //"Descripcion"=>["label"=>"Características","type"=>"$","typeDb"=>"$","required"=>true],
            //"RutaImagen"=>["label"=>"Ruta de la Imagen","type"=>"$","typeDb"=>"$","required"=>true],
            //"DescripcionLarga"=>["label"=>"Descripción","type"=>"&","typeDb"=>"$","required"=>true],
            //"Clave"=>["label"=>"Clave","type"=>"$","typeDb"=>"$","required"=>true],
            //"Costo"=>["label"=>"Precio","type"=>"#","typeDb"=>"#","required"=>true],
            "FechaCambio"=>["label"=>"Fecha Auditoria","type"=>"F","typeDb"=>"$","required"=>false],
            "IdTipoMovimiento"=>["label"=>"Tipo Movimiento","type"=>"F","typeDb"=>"#","required"=>false],
            "IdUsuarioBase"=>["label"=>"Usuario de Registro]","type"=>"F","typeDb"=>"#","required"=>false]
        ];
    }
}