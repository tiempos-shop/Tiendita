<?php


namespace Tiendita;
include_once "Data/Models/iEntity.php";
include_once "Data/Models/Clientes.php";


class Direcciones implements iEntity
{

    public $IdDireccion = 0 ;
    public $Pais = "" ;
    public $CodigoPostal = "" ;
    public $Ciudad = "" ;
    public $Calle = "" ;
    public $Colonia = "" ;
    public $IdCliente=0;
    public $Cliente;

    public function __construct()
    {
        $this->Cliente=new Clientes();
    }


    public static function getProperties(): array
    {
        return [
            "IdDireccion"=>["label"=>"Id","type"=>"I","typeDb"=>"#","required"=>false],
            "Pais"=>["label"=>"Pais","type"=>"$","typeDb"=>"$","required"=>true],
            "CodigoPostal"=>["label"=>"Código Postal","type"=>"$","typeDb"=>"$","required"=>true],
            "Ciudad"=>["label"=>"Ciudad","type"=>"$","typeDb"=>"$","required"=>true],
            "Calle"=>["label"=>"Calle","type"=>"$","typeDb"=>"$","required"=>true],
            "Colonia"=>["label"=>"Colonia","type"=>"$","typeDb"=>"$","required"=>true],
            "IdCliente"=>["label"=>"Cliente","type"=>"F","typeDb"=>"#","required"=>true],
        ];
    }
}