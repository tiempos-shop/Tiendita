<?php


class PackageModel
{
    ///Modelo para los datos del paquete a enviar;
    /// Debe contener la suma de las dimensiones de los productos;
    public int $number;
    public float $weight;
    public float $length;
    public float $width;
    public float $height;

    public function __construct()
    {

    }
}