<?php

namespace Tiendita;

interface iModeloBase
{


    public function Agregar(string $tabla,object $elemento);

    /**
     * @return string
     */
    public function getTabla(): string;

    /**
     * @param string $Tabla
     */
    public function setTabla(string $Tabla): void;

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @param string $Id
     */
    public function setId($Id): void;

//    /**
//     * @return string[]
//     */
//    public function getCampos(): array;
//
//    /**
//     * @param string[] $campos
//     */
//    public function setCampos(array $campos): void;

    /**
     * @return array
     */
    public function getDatos(): Collection;

    /**
     * @return string
     */
    public function getNombreEntidad(): string;

    /**
     * @param string $NombreEntidad
     */
    public function setNombreEntidad(string $NombreEntidad): void;

}