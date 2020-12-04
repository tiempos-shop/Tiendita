<?php
include_once "Data/Models/ModeloUsuarios.php";

$nombreEntidad=$_POST["Entidad"];
switch ($nombreEntidad){
    case "Usuarios":

        //$entidad=new \Tiendita\Usuarios(\);
        $modelo=new \Tiendita\ModeloUsuarios();
        break;

}






var_dump($_POST);
echo "\n";
echo $_POST["Nombres"];
echo "\n";
echo "</pre>";
