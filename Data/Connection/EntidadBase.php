<?php


namespace Tiendita;
use Exception;

require_once 'Conectar.php';

class EntidadBase{

    private $db;
    private $conectar;
    private $sqlSaveCache;

    public function AddQuerys(string $sql){
        $this->sqlSaveCache[]=$sql;
    }

    public function SaveAll(){
        // Todo Descomentar las lineas
        $querys=implode(" ",$this->sqlSaveCache);
        //$this->db->multi_query($querys);
        var_dump($querys);

    }

    public function __construct() {
        $this->sqlSaveCache=array();
        try {

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
        try {
            $query=$this->db->query($queryString);
        } catch (Exception $e){
            throw new Exception("Error al ejectura el query '$queryString'.".$e);
        }

        try {
            while ($row = $query->fetch_object()) {
                $resultSet[]=$row;
            }
        } catch (Exception $e){
            //var_dump($row);
            throw new Exception("Error al obtener los campos de query '$queryString'");
        }

        return $resultSet;
    }

    public function getBy($table,$column,$value){

        $resultSet=array();


        if(is_string($value)){
            $value=mysqli_real_escape_string($this->db,$value);
            $queryString="SELECT * FROM $table WHERE $column='$value'";
        }
        elseif(is_int($value)){
            $intValue=intval($value);
            $queryString="SELECT * FROM $table WHERE $column=$intValue";
        }
        else{
            $queryString="SELECT * FROM $table WHERE $column=$value";
        }

        $query=$this->db->query($queryString);


        while($row = $query->fetch_object()) {
           $resultSet[]=$row;
        }

        return $resultSet;
    }



    public function deleteById($table,$id){
        $this->sqlSaveCache[]=$this->db->query("DELETE FROM $table WHERE id=$id");

    }

    public function updateBy($table,$id,$column,$value){
        $this->sqlSaveCache[]=$this->db->query("UPDATE $table WHERE id=$id");
    }


    public function close()
    {
        $this->db->close();

    }
}
?>
