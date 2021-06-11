<?php

namespace App\controllers;

use App\Models\GeneralFunctions;
use App\Models\Municipios;
use Carbon\Carbon;
use Carbon\Traits\Creator;

class MunicipiosController
{
    private array $dataMunicipios; //Almacenaran Datos que vengan de la interfaz

    public function __construct(array $_FORM) //Datos del formulario
    {
        $this->dataMunicipios = array();
        $this->dataMunicipios['id'] = $_FORM['id'] ?? NULL;
        $this->dataMunicipios['nombre'] = $_FORM['nombre'] ?? NULL;

    }

    public function create()
    {
        try {
            if (!empty($this->dataMunicipios['nombre'])  && !Municipios::InsumosRegistrado($this->dataMunicipios['nombre'])) {
                $Municipios = new Municipios ($this->dataMunicipios);
                if ($Municipios->insert()) {
                    //unset($_SESSION['frmMunicipios']);
                    header("Location: ../../views/modules/Municipios/index.php?respuesta=success&mensaje=Municipios Registrado");
                }
            } else {
                header("Location: ../../views/modules/Municipios/create.php?respuesta=error&mensaje=Municipios ya registrado");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }

    public function edit()
    {
        try {
            $user = new Municipios($this->dataMunicipios);
            if ($user->update()) {
                //unset($_SESSION['frmMunicipios']);
            }
            header("Location: ../../views/modules/Municipios/show.php?id=" . $user->getId() . "&respuesta=success&mensaje=Insumos Actualizado");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }

    static public function searchForID(array $data)
    {
        try {
            $result = Municipios::searchForId($data['id']);
            if (!empty($data['request']) and $data['request'] === 'ajax' and !empty($result)) {
                header('Content-type: application/json; charset=utf-8');
                $result = json_encode($result->jsonSerialize());
            }
            return $result;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
        return null;
    }

    static public function getAll(array $data = null)
    {
        try {
            $result = Municipios::getAll();
            if (!empty($data['request']) and $data['request'] === 'ajax') {
                header('Content-type: application/json; charset=utf-8');
                $result = json_encode($result);
            }
            return $result;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
        return null;
    }

    static public function activate(int $id)
    {
        try {
            $ObjMunicipios = Municipios::searchForId($id);
            $ObjMunicipios->setnombre("nombre");
            if ($ObjMunicipios->update()) {
                header("Location: ../../views/modules/Municipios/index.php");
            } else {
                header("Location: ../../views/modules/Municipios/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }

    static public function inactivate(int $id)
    {
        try {
            $ObjMunicipios = Municipios::searchForId($id);
            $ObjMunicipios->setNombre("nombres");
            if ($ObjMunicipios->update()) {
                header("Location: ../../views/modules/Municipios/index.php");
            } else {
                header("Location: ../../views/modules/Municipios/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }

    static public function selectMunicipios(array $params = [])
    {

        //Parametros de Configuracion
        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "Municipios_id";
        $params['name'] = $params['name'] ?? "Municipios_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array(); //[Bebidas, Frutas]
        $params['request'] = $params['request'] ?? 'html';

        $arrMunicipios= array();
        if ($params['where'] != "") {
            $base = "SELECT * FROM Municipios WHERE id ";
            $arrMunicipios = Municipios::search($base . ' ' . $params['where']);
        } else {
            $arrMunicipios = Municipios::getAll();
        }

        $htmlSelect = "<select " . (($params['isMultiple']) ? "multiple" : "") . " " . (($params['isRequired']) ? "required" : "") . " id= '" . $params['id'] . "' name='" . $params['name'] . "' class='" . $params['class'] . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (is_array($arrMunicipios) && count($arrMunicipios) > 0) {
            /* @var $arrMunicipios Municipios[] */
            foreach ($arrMunicipios as $Municipios)
                if (!MunicipiosController::MunicipiosIsInArray($Municipios->getId(), $params['arrExcluir']))
                    $htmlSelect .= "<option " . (($Municipios != "") ? (($params['defaultValue'] == $Municipios->getId()) ? "selected" : "") : "") . " value='" . $Municipios->getId() . "'>" . $Municipios->getNombre()  . "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    private static function MunicipiosIsInArray($idMunicipios, $ArrMunicipios)
    {
        if (count($ArrMunicipios) > 0) {
            foreach ($ArrMunicipios as $Municipios) {
                if ($Municipios->getId() == $idMunicipios) {
                    return true;
                }
            }
        }
        return false;
    }

}
