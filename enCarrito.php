<?php

session_start();

$data = json_decode(file_get_contents("php://input"), true);
$productoJson = $data["producto"];



if (isset($data["movimiento"]))
{
    $movimiento =$data["movimiento"]; //Letra
}
else
{
    $movimiento = "-1";
}

$productoJson = json_encode($productoJson);
$productoJson = json_decode($productoJson);


//echo $productoJson->nombre;
if (isset($_SESSION["ProductosEnCarrito"]))
{
    $productosCarrito= $_SESSION["ProductosEnCarrito"];
}
else
{
    $_SESSION["ProductosEnCarrito"] = [];
}

echo $movimiento;
return;



switch ($movimiento) {
    case 'A':
        # AGREGAR PRODUCTO AL CARRIO...
        return "argregar";
        break;
    case 'E':
        # Eliminar Producto en carrito
        break;
    default:
        # code...
        break;
}

return "ok";

$productosCarrito = null;

if(isset($_SESSION["ProductosCarrito"])){
    $productosCarrito=$_SESSION["ProductosCarrito"];
}
else{
    $productosCarrito=null;
}

echo json_encode($productosCarrito);