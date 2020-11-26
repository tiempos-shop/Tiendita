<?php


namespace Tiendita;

include_once "Data/Models/ModeloUsuarios.php";
include_once "Business/Utilidades.php";


class Test
{
    private $usuarios;
    private $utilidades;
    public function __construct()
    {
        $this->usuarios=new ModeloUsuarios();
        $this->utilidades=new Utilidades();
    }

    public function TestInsert(){

        $usuario=new Usuarios(
            "Armando",
            "Gonzalez",
            "1234",
            "ale",
            "ale",
            "correo@correo.com",
            "1234",
            1,
            1
        );

        $this->usuarios->insert(
            $usuario
        );
        $this->usuarios->insert(
            $usuario
        );
    }

    public function TestUpdate(){
        $row1=$this->usuarios->getById(1);
        $row1->Nombres="Cambio Nombre 1";

        $row2=$this->usuarios->getById(2);
        $row2->Nombres="Cambio Nombre 2";

        $this->usuarios->update(
            $row1
        );
        $this->usuarios->update(
            $row2
        );


    }

    public function TestSaveAll(){
        echo "<pre>";
        $this->usuarios->SaveAll();
        echo "</pre>";
    }

    public function TestGetAll(){
        return $this->usuarios->getAll();
    }

    public function TestObjectToTable(){
        $head1=[ "head1"=>"Editar", "head2"=>"Borrar"];
        $head2=Usuarios::getCampos();
        $head=$head1+$head2;

        return $this->utilidades->Object2TableEdit(
            $this->usuarios->getAll(),
            $head,
            "<strong>[]</strong> Editar",
            "<strong>X</strong> Borrar",
            "<strong>+</strong> Agregar"

        );

    }
}