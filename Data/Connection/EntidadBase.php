<?php


namespace Tiendita;



class EntidadBase{

    private $db;
    private $conectar;

    public function __construct() {

        try {
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

    public function getAll($table){
        $resultSet=array();
        $queryString="SELECT * FROM $table";
        $query=$this->db->query($queryString);

        while ($row = $query->fetch_object()) {
            $resultSet[]=$row;
        }
        return $resultSet;
    }

    public function getBy($table,$column,$value){
        $resultSet=array();
        $queryString="SELECT * FROM $table WHERE $column=$value";
        $query=$this->db->query($queryString);
        echo "<p>".$queryString."</p>";

        while($row = $query->fetch_object()) {
           $resultSet[]=$row;
        }

        return $resultSet;
    }

    public function deleteById($table,$id){
        $query=$this->db->query("DELETE FROM $table WHERE id=$id");
        return $query;
    }

    public function deleteBy($table,$column,$value){
        $query=$this->db->query("DELETE FROM $table WHERE $column='$value'");
        return $query;
    }
}
?>
