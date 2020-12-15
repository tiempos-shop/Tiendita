<?php


namespace Tiendita;

use stdClass;

include_once("iModeloBase.php");
include_once("Business/Collection.php");
include_once("Business/Utilidades.php");
include_once("Data/Connection/EntidadBase.php");

abstract class ModeloBase implements iModeloBase
{

    private $Table;
    private $Id;

    protected $properties;

    protected $entityName;
    private $userId;


    public $Datos;

    private $auditoria;
    protected $entidadBase;
    public $ui;


    // Tabla Externa TipoMovimiento
    public $NombreTablaTipoMovimiento = "TipoMovimiento";
    public $NombreIdTipoMovimiento = "IdTipoMovimiento";

    // Tabla Externa Usuario Auditoria
    public $NombreTablaUsuario="Usuarios";
    public $NombreIdUsuario="IdUsuario";

    private $getAll;

    public function __construct(string $nombreTabla, string $nombreId, array $properties, bool $auditoria = true)
    {

        $this->properties = $properties;
        $this->auditoria = $auditoria;
        $this->setTabla($nombreTabla);
        $this->setId($nombreId);

        $this->Datos = new Collection();
        $this->ui = new Utilidades();
        $this->entidadBase = new EntidadBase();

    }


    public function getAll()
    {
        $data = $this->entidadBase->getAll($this->getTabla());
        $Entidad = array();

        foreach ($data as $row) {
            $Entidad[] = $this->CreateElement($row);
        }
        $this->Datos = $Entidad;
        $this->getAll = true;

        return $this->Datos;
    }

    public function CreateElement(object $row)
    {
        $element = (object)array();
        $id = $this->getId();
        $element->$id = $row->$id;
        foreach ($this->properties as $campo => $property) {
            $element->$campo = $row->$campo;
        }

        if ($this->auditoria === true) {
            // Objetos Externos
            $element->TipoMovimiento = $this->entidadBase->getBy($this->NombreTablaTipoMovimiento, $this->NombreIdTipoMovimiento, $element->IdTipoMovimiento);
            $element->UsuarioBase = $this->entidadBase->getBy($this->NombreTablaUsuario, $this->NombreIdUsuario, $element->IdUsuarioBase);
        }
        return $element;
    }

    public function getById(int $valor)
    {
        $row = $this->entidadBase->getBy($this->getTabla(), $this->getId(), $valor);

        return $this->CreateElement($row[0]);
    }

    public function getBy(string $campo, $valor)
    {
        $row = $this->entidadBase->getBy($this->getTabla(), $campo, $valor);
        return $this->CreateElement($row[0]);
    }

    public function update(object $row)
    {

        $n = $this->getId();
        echo $this->getId();
        $id = intval($row->$n);
        $sql = "UPDATE $this->Table SET ";
        $valores = "";
        foreach ($this->properties as $campo => $property) {
            if ($property["typeDb"] == "#") {
                if($property["type"]<>"I")
                    $valores .= "$campo = " . $row->$campo . ",";
            } else {
                $valores .= "$campo = '" . $row->$campo . "', ";
            }

        }
        $valores = trim($valores, ",");
        $sql .= $valores . " WHERE $this->Id = $id;";
        $this->entidadBase->AddQuerys($sql);
        $this->getAll = false;

    }

    public function insert(object $row)
    {

        $sql = "INSERT INTO $this->Table ";
        $campos = "";
        $valores = "";
        foreach ($this->properties as $campo => $property) {
            if ($property["type"] <> "I") {
                $campos .= $campo . ",";
                if ($property["typeDb"] == "#") {
                    $valores .= $row->$campo;
                } else {
                    $valores .= "'" . $row->$campo . "'";
                }

                $valores .= ",";
            }
        }
        $campos = trim($campos, ",");
        $valores = trim($valores, ",");
        $sql .= "($campos) VALUES ($valores);";
        $this->entidadBase->AddQuerys($sql);
        $this->getAll = false;
    }

    public function delete(object $row)
    {

        $n = $this->getId();
        $id = intval($row->$n);
        $sql = "DELETE FROM $this->Table  WHERE $this->Id = $id;";
        $this->entidadBase->AddQuerys($sql);
        $this->getAll = false;
    }

    public function SaveAll()
    {
        $this->entidadBase->SaveAll();
    }

    public function getTabla(): string
    {
        return $this->Table;
    }

    public function setTabla(string $Tabla): void
    {
        $this->Table = $Tabla;
    }

    public function getId(): string
    {
        return $this->Id;
    }

    public function setId($Id): void
    {
        $this->Id = $Id;
    }

    public function getDatos(): Collection
    {
        return $this->Datos;
    }


    public function getEntityName(): string
    {
        return $this->entityName;
    }

    public function setEntityName(string $entityName): void
    {
        $this->entityName = $entityName;
    }

    public function Add(string $table, object $item)
    {

        $this->Datos->addItem($item->IdUsuario);
        $sqlInsert = "insert into Usuarios ";
    }


    // UTILIDADES

    public function Object2TableEdit(string $id, string $botonEditar, string $botonBorrar, string $botonInsertar, string $footer = "", array $ocultos = [])
    {
        $object = $this->getAll();
        $html = '<table class="table table-bordered" id="'.$id.'">';
        //$html .= "<caption>$footer</caption>";
        // Encabezados
        $html .= '<thead><tr>';
        $camposEditar = array();
        foreach ($this->properties as $campo => $property) {
            $type = $property["type"];
            if (!($type == "I" or $type == "F" or $type=="*"))
                $camposEditar[] = $property["label"];
        }
        $headers = ["h1" => "Editar", "h2" => "Borrar"] + $camposEditar + $this->Adicional();
        foreach ($headers as $head) {
            $html .= "<th>$head</th>";
        }
        $html .= '</tr></thead>';
        $i = 0;
        // Campos
        $html .= '<tbody>';
        $inputNV = "";
        foreach ($object as $val) {
            $a = get_object_vars($val);
            $datoId = $a[$this->getId()];
            $i++;
            $html .= '<tr>';
            $columns = "";
            $input = $this->ui->Hidden($this->getId(), $datoId);

            foreach ($a as $k => $v) {

                if (!is_array($v) and !is_object($v)) {
                    if ($this->auditoria) {
                        if ($k == "FechaCambio") $v = $this->ui->FechaHoy();
                        if ($k == "IdTipoMovimiento") $v = 2;
                        if ($k == "IdUsuarioBase") $v = $this->userId;
                    }
                    $label=$this->properties[$k]["label"];
                    $type = $this->properties[$k]["type"];
                    $req = $this->properties[$k]["required"];
                    if (!($type == "I" or $type == "F" or $type=="*")) $columns .= "<td>$v</td>";
                    if(($type=="F" or $type=="*") and $k<>"IdTipoMovimiento" and $k<>"IdUsuarioBase" and $k<>"FechaCambio")
                    {
                        $columns.=$this->Foreign($k,$v);
                        $input .= $this->ForeignInput($k,$v);
                    } else{
                        $input .= $this->ui->Input($k, $label, $v, $type, $req);
                    }

                    if ($i == 1) {
                        if ($type == "F") {
                            $inputNV .= $this->ui->Input($k, $label, $v, $type, $req);
                        } elseif ($type=="*"){
                            $inputNV .=$this->ForeignInput($k,"");
                        } else {
                            $inputNV .= $this->ui->Input($k, $label, "", $type, $req);
                        }

                    }
                    //}
                } else {
                    $columns .= "<td>" . $this->Object2SimpleTable($k, $v[0]) . "</td>";
                    $input .= $this->Object2SimpleFormulary($k, $v[0]);
                    if ($i == 1) $inputNV .= $this->Object2SimpleFormulary($k, $v[0]);
                }

            }



            // Botones
            $button = "<td>" . $this->ui->ModalButton("idEditTable" . $i, $botonEditar, "", "Edicion de Campos", "Cancelar",
                    $this->ui->Form([
                        $input, "<br/>"
                    ], "", "Guardar"), "", "", "primary  btn-sm"
                ) . "</td>";

            $button .= '
                <td>'
                . $this->ui->ModalButton("idDeleteTable" . $i, $botonBorrar, "", "Borrar Registro", "Cancelar",
                    $this->ui->Form([
                        "<p>Desea borrar el registro?</p>",
                        "<br/>",
                        $this->ui->Hidden($this->getId(), $datoId),
                        $this->ui->Hidden("delete", true)
                    ], "", "Borrar"), "", "", "danger btn-sm"
                ) .
                '</td>';
            // Genera html Fila
            $html .= $button . $columns . "</tr>";
        }
        $html .= "</tbody></table>";

        // Script
        // TODO: No se activa el script. Probablemente porque esta en medio de div y codigo HTML


        // Boton Insertar

        $html .= $this->ui->ModalButton("idInsertTable", $botonInsertar, "", "Agregar un Registro", "Cancelar",
            $this->ui->Form([
                $inputNV,
                "<br/>"
            ], "", "Agregar"), "", "", "info"
        );




        return $html;
    }

    public abstract function Foreign(string $k,string $v);
    public abstract function ForeignInput(string $k,string $v);


    public function SafeSave(): int
    {
        // TODO:

        if (count($_POST) <> 0) {

            $id = null;
            $deleteConfirm = false;
            $delete = array_key_exists("delete", $_POST);
            if (array_key_exists($this->getId(), $_POST)) {
                $id = $_POST[$this->getId()];
            } else {
                $id = "";
            }
            $entidad = new Collection();
            $nombreId = $this->getId();
            $entidad->$nombreId = $id;
            foreach ($this->properties as $key => $property) {
                if (array_key_exists($key, $_POST)) {
                    $entidad->$key = $_POST[$key];
                } else {
                    if ($property["type"] <> "I")
                        $deleteConfirm = true;
                }
            }
            if ($this->auditoria) {
                $entidad->FechaCambiofecha = $this->ui->FechaHoy();
            }
            if ($deleteConfirm and $delete) {
                $this->delete($entidad);
            } else {
                if ($deleteConfirm) {
                    $this->ui->MessageBox("Error en Campos: No se encuentran todos los campos para actualizar");
                    return 1;
                } elseif ($id == "") {
                    $this->insert($entidad);
                } else {
                    $this->update($entidad);
                }
            }

            $this->SaveAll();
            $this->ui->MessageBox("Los datos se guardaron correctamente.");
            return 0;
        } else {
            return 0;
        }
    }


    public function Object2Table()
    {
        $object = $this->getAll();
        $html = '<table class="table table-bordered">';
        $html .= '<tr>';
        $camposEditar = array();
        foreach ($this->properties as $campo => $property) {
            $type = $property["type"];
            if (!($type == "I" or $type == "F"))
                $camposEditar[] = $property["label"];
        }
        $headers = ["h1" => "Id"] + $camposEditar;//+$this->SimpleAdd();
        foreach ($headers as $head) {
            $html .= "<th>$head</th>";
        }
        $html .= '<tr>';
        foreach ($object as $val) {
            $a = get_object_vars($val);
            $html .= '<tr>';
            foreach ($a as $k => $v) {
                if (!is_array($v)) {
                    if ($this->properties[$k]["type"] <> "F") {
                        $html .= "<td>$v</td>";
                    }
                } else {

                }
                //$html.="<td>".$this->Object2SimpleTable($k,$v[0])."</td>";
            }
            $html .= "</tr>";
        }
        $html .= "</table>";
        return $html;
    }

    public abstract function Object2SimpleTable(string $k, object $v);

    public abstract function Object2SimpleFormulary(string $k, object $v);

    public abstract function Adicional();

    public abstract function SimpleAdd();

}