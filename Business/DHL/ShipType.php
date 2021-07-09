<?php
use Tiendita\EntidadBase;


include_once "../../Data/Connection/EntidadBase.php";

class ShipType
{
    private int $postal_code;
    public function __construct(int $cp)
    {
        $this->postal_code=$cp;
    }

    public function Ship():array{
        //$db=new EntidadBase();
        //$cp=$db->getby("CodigosPostales","CP",$this->postal_code);
        //$city=$cp["City"];
        //$idioma=[ "ESPAÑOL"=>[ "MENU"=>[ "INICIO","ARCHIVO","MARCA","ENGLISH","CARRITO(*)"] ],"ENGLISH"=>[ "MENU"=>[ "HOME","ARCHIVE","IMPRINT","ESPAÑOL","CART(*)" ] ] ];
        return
            [
                "City" => "monterrey",
                "PostalCode" => "44100",
                "CountryCode" => "MX"
            ];
    }
}