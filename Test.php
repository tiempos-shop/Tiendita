<?php


namespace Tiendita;

use Cassandra\Rows;

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

    public function TestDelete(){
        $row1=$this->usuarios->getById(1);
        $this->usuarios->delete($row1);
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

        return $this->usuarios->Object2TableEdit(
            "tabla",
    "<strong>[]</strong> Editar",
    "<strong>X</strong> Borrar",
    "<strong>+</strong> Agregar",
        "Tabla de Usuario"
        );

    }

    public function TestGrid(){
        return $this->utilidades->ContainerFluid(
            [
                $this->utilidades->Row(
                    [
                        $this->utilidades->Columns(
                            "Hola Mundo 1",
                            6
                        ),
                        $this->utilidades->Columns(
                            "Hola Mundo 1 de 2",
                            3
                        ),
                        $this->utilidades->Columns(
                            "Hola Mundo 2 de 2",
                            3
                        )
                    ]
                )
            ]
        );
    }
}