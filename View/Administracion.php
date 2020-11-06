<!DOCTYPE html>
<?php

use Tiendita\ModeloUsuarios;

$header="";
$styles="";
$body="";
$foot="";

// Begin

// Configuración

$header.='
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modulo de Administracion</title>';

// Scripts
$header.='<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>';
$header.='<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>';

// Hojas de Estilo
$header.='<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">';
$header.='<link href="https://fonts.googleapis.com/css2?family=Grandstander:wght@100&display=swap" rel="stylesheet">';



// Estilos Directos
$styles.="body{font-family: 'Grandstander', cursive;}";


$body.='<!-- Button trigger modal -->
<button type="button" class="btn btn-link float-right" data-toggle="modal" data-target="#exampleModal">
  Reingreso
</button>
<button type="button" class="btn btn-link float-right">
  Cerrar Sesión
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Correo: </span>
            </div>
            <input type="email" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
        </div>
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Password: </span>
            </div>
            <input type="password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Accesar</button>
      </div>
    </div>
  </div>
</div>';
$body.='<div class="jumbotron"><h1>Administración de Tiempos Shop</h1><p>Configuración | Usuarios | Finanzas | Reportes | Ayuda</p></div>';




// End
$HtmlInjection="<html lang='es'><head><style>".$styles."</style>".$header."</head><body>".$body."</body></html>";

echo $HtmlInjection;