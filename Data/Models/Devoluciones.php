<?php


namespace Tiendita;


class Devoluciones extends BaseAuditoria
{

    public $IdDevolucion = 0 ;
    public $IdPedido = 0 ;
    public $IdMotivoDevolucion = "" ; // NUM o STR?
    public $GastoEnvio = 0.0 ;
    public $Notas = "" ;

}