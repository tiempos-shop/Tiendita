<?php


namespace Tiendita;

use mysqli;
use mysqli_sql_exception;


class Conectar{
    private $driver;
    private $host, $user, $pass, $database, $charset;

    public function __construct() {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $db_cfg = require 'Database.php';
        $this->driver=$db_cfg["driver"];
        $this->host=$db_cfg["host"];
        $this->user=$db_cfg["user"];
        $this->pass=$db_cfg["pass"];
        $this->database=$db_cfg["database"];
        $this->charset=$db_cfg["charset"];
    }

    public function conexion(){

        if($this->driver=="mysql" || $this->driver==null){
            try {
                $con=new mysqli($this->host, $this->user, $this->pass, $this->database);
                $con->query("SET NAMES '".$this->charset."'");
            } catch (mysqli_sql_exception  $e){
                echo "<script>alert('Error al intentar conectarse al servidor');<script>";
                echo "error";
            }

        }

        return $con;
    }



}
