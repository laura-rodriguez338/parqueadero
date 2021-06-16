<?php


namespace App\controllers;

use App\Models\GeneralFunctions;
use App\Models\Insumos;
use Carbon\Carbon;
use Carbon\Traits\Creator;

class InsumosController
{
    private array $dataInsumos; //Almacenaran Datos que vengan de la interfaz

    public function __construct(array $_FORM) //Datos del formulario
    {
        $this->dataInsumos = array();
        $this->dataInsumos['id'] = $_FORM['id'] ?? NULL;
        $this->dataInsumos['nombre'] = $_FORM['nombre'] ?? NULL;
        $this->dataInsumos['cantidad'] = $_FORM['cantidad'] ?? null;
        $this->dataInsumos['presentasion'] = $_FORM['presentasion'] ?? NULL;
        $this->dataInsumos['valor'] = $_FORM['valor'] ?? NULL;
        $this->dataInsumos['empresa_id'] = $_FORM['empresa_id'] ?? NULL;
    }

    public function create()
    {
        try {
            if (!empty($this->dataInsumos['nombre']) && !empty($this->dataInsumos['cantidad']) && !Insumos::InsumosRegistrado($this->dataInsumos['nombre'], $this->dataInsumos['cantidad'])) {
                $Insumos = new Insumos ($this->dataInsumos);
                if ($Insumos->insert()) {
                    //unset($_SESSION['frmInsumos']);
                    header("Location: ../../views/modules/Insumos/index.php?respuesta=success&mensaje=Insumos Registrado");
                }
            } else {
                header("Location: ../../views/modules/Insumos/create.php?respuesta=error&mensaje=Insumos ya registrado");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }

    public function edit()
    {
        try {
            $user = new Insumos($this->dataInsumos);
            if ($user->update()) {
                //unset($_SESSION['frmInsumos']);
            }
            header("Location: ../../views/modules/Insumos/show.php?id=" . $user->getId() . "&respuesta=success&mensaje=Insumos Actualizado");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }

    static public function searchForID(array $data)
    {
        try {
            $result = Insumos::searchForId($data['id']);
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
            $result = Insumos::getAll();
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
            $ObjInsumos = Insumos::searchForId($id);
            $ObjInsumos->setvalor("valor");
            if ($ObjInsumos->update()) {
                header("Location: ../../views/modules/Insumos/index.php");
            } else {
                header("Location: ../../views/modules/Insumos/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }

    static public function inactivate(int $id)
    {
        try {
            $ObjInsumos = Insumos::searchForId($id);
            $ObjInsumos->setvalor("valor");
            if ($ObjInsumos->update()) {
                header("Location: ../../views/modules/Insumos/index.php");
            } else {
                header("Location: ../../views/modules/Insumos/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }

    static public function selectInsumos(array $params = [])
    {

        //Parametros de Configuracion
        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "Insumos_id";
        $params['name'] = $params['name'] ?? "Insumos_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array(); //[Bebidas, Frutas]
        $params['request'] = $params['request'] ?? 'html';

        $arrInsumos = array();
        if ($params['where'] != "") {
            $base = "SELECT * FROM Insumos WHERE empresa_id ";
            $arrInsumos = Insumos::search($base . ' ' . $params['where']);
        } else {
            $arrInsumos = Insumos::getAll();
        }

        $htmlSelect = "<select " . (($params['isMultiple']) ? "multiple" : "") . " " . (($params['isRequired']) ? "required" : "") . " id= '" . $params['id'] . "' name='" . $params['name'] . "' class='" . $params['class'] . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (is_array($arrInsumos) && count($arrInsumos) > 0) {
            /* @var $arrInsumos Insumos[] */
            foreach ($arrInsumos as $insumos)
                if (!InsumosController::InsumosIsInArray($insumos->getId(), $params['arrExcluir']))
                    $htmlSelect .= "<option " . (($insumos != "") ? (($params['defaultValue'] == $insumos->getId()) ? "selected" : "") : "") . " value='" . $insumos->getId() . "'>" . $insumos->getNombres() . " - " . $insumos->getApellidos() . "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    private static function InsumosInArray($idInsumos, $ArrInsumos)
    {
        if (count($ArrInsumos) > 0) {
            foreach ($ArrInsumos as $Insumos) {
                if ($Insumos->getId() == $idInsumos) {
                    return true;
                }
            }
        }
        return false;
    }


}