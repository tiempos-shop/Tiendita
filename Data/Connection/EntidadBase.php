<?php


namespace Tiendita;



class EntidadBase{
    private $table;
    private $db;
    private $conectar;

    public function __construct($table) {

        try {
            $this->table=(string) $table;
            require_once 'Conectar.php';
            $this->conectar=new Conectar();
            $this->db=$this->conectar->conexion();
        } catch (Exception $e){
            echo $e->getMessage();
        }

    }

    public function getConetar(){
        return $this->conectar;
    }

    public function db(){
        return $this->db;
    }

    public function getAll(){
        $resultSet=array();
        $queryString="SELECT * FROM $this->table";
        $query=$this->db->query($queryString);

        while ($row = $query->fetch_object()) {
            $resultSet[]=$row;
        }
        return $resultSet;
    }

    public function getById($id){
        $query=$this->db->query("SELECT * FROM $this->table WHERE id=$id");

        if($row = $query->fetch_object()) {
           $resultSet=$row;
        }

        return $resultSet;
    }

    public function getBy($column,$value){
        $query=$this->db->query("SELECT * FROM $this->table WHERE $column='$value'");

        while($row = $query->fetch_object()) {
           $resultSet[]=$row;
        }

        return $resultSet;
    }

    public function deleteById($id){
        $query=$this->db->query("DELETE FROM $this->table WHERE id=$id");
        return $query;
    }

    public function deleteBy($column,$value){
        $query=$this->db->query("DELETE FROM $this->table WHERE $column='$value'");
        return $query;
    }

    public function DB2Entity(){
        $data=$this->getAll();
        switch ($this->table){
            case "Usuarios":
                foreach ($data as $row){
                    $usuario=new Usuarios();
                    $usuario->IdUsuario=$row->IdUsuario;
                    $usuario->Nombres=$row->Nombres;
                    $usuario->IdUsuario=$row->IdUsuario;
                    $usuario->IdUsuario=$row->IdUsuario;


                    $EntidadUsuarios[]=$usuario;
                }

                break;

            default:
                throw new \Exception('Error en la configuración de tablas');
        }





        return $data;
    }

}
?>
