<?php


namespace App\controllers;

    use App\Models\GeneralFunctions;
    use App\Models\Empresa;
    use Carbon\Carbon;
    use Carbon\Traits\Creator;

class EmpresasController
{
    private array $dataEmpresa; //Almacenaran Datos que vengan de la interfaz

    public function __construct(array $_FORM) //Datos del formulario
    {
        $this->dataEmpresa = array();
        $this->dataEmpresa['id'] = $_FORM['id'] ?? NULL;
        $this->dataEmpresa['nombre'] = $_FORM['nombre'] ?? NULL;
        $this->dataEmpresa['telefono'] = $_FORM['telefono'] ?? 0;
        $this->dataEmpresa['direccion'] = $_FORM['direccion'] ?? NULL;
        $this->dataEmpresa['municipios_id'] = $_FORM['municipios_id'] ?? 0;
    }

    public function create()
    {
        try {
            if (!empty($this->dataEmpresa['nombre']) && !empty($this->dataEmpresa['telefono']) && !Empresa::EmpresaRegistrada($this->dataEmpresa['nombre'], $this->dataEmpresa['telefono'])) {
                $Empresa = new Empresa ($this->dataEmpresa);
                if ($Empresa->insert()) {
                    //unset($_SESSION['frmEmpresa']);
                    header("Location: ../../views/modules/Empresa/index.php?respuesta=success&mensaje=Empresa Registrado");
                }
            } else {
                header("Location: ../../views/modules/Empresa/create.php?respuesta=error&mensaje=Empresa ya registrada");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }

    public function edit()
    {
        try {
            $user = new Empresa($this->dataEmpresa);
            if ($user->update()) {
                //unset($_SESSION['frmEmpresa']);
            }
            header("Location: ../../views/modules/Empresa/show.php?id=" . $user->getId() . "&respuesta=success&mensaje=Empresa Actualizado");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }

    static public function searchForID(array $data)
    {
        try {
            $result = Empresa::searchForId($data['id']);
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
            $result = Empresa::getAll();
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
            $ObjEmpresa = Empresa::searchForId($id);
            $ObjEmpresa->setvalor("valor");
            if ($ObjEmpresa->update()) {
                header("Location: ../../views/modules/Empresa/index.php");
            } else {
                header("Location: ../../views/modules/Empresa/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }

    static public function inactivate(int $id)
    {
        try {
            $ObjEmpresa = Empresa::searchForId($id);
            $ObjEmpresa->setvalor("valor");
            if ($ObjEmpresa->update()) {
                header("Location: ../../views/modules/Empresa/index.php");
            } else {
                header("Location: ../../views/modules/Empresa/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }

    static public function selectEmpresa(array $params = [])
    {

        //Parametros de Configuracion
        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "Empresa_id";
        $params['name'] = $params['name'] ?? "Empresa_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array(); //[Bebidas, Frutas]
        $params['request'] = $params['request'] ?? 'html';

        $arrEmpresa = array();
        if ($params['where'] != "") {
            $base = "SELECT * FROM Empresa WHERE  ";
            $arrEmpresa = Empresa::search($base . ' ' . $params['where']);
        } else {
            $arrEmpresa = Empresa::getAll();
        }

        $htmlSelect = "<select " . (($params['isMultiple']) ? "multiple" : "") . " " . (($params['isRequired']) ? "required" : "") . " id= '" . $params['id'] . "' name='" . $params['name'] . "' class='" . $params['class'] . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (is_array($arrEmpresa) && count($arrEmpresa) > 0) {
            /* @var $arrEmpresa Empresa[] */
            foreach ($arrEmpresa as $empresa)
                if (!EmpresasController::EmpresaIsInArray($empresa->getId(), $params['arrExcluir']))
                    $htmlSelect .= "<option " . (($empresa != "") ? (($params['defaultValue'] == $empresa->getId()) ? "selected" : "") : "") . " value='" . $empresa->getId() . "'>" . $empresa->getnombre() . " - " . $empresa->gettelefono() . "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    private static function EmpresaInArray($idEmpresa, $ArrEmpresa)
    {
        if (count($ArrEmpresa) > 0) {
            foreach ($ArrEmpresa as $Empresa) {
                if ($Empresa->getId() == $idEmpresa) {
                    return true;
                }
            }
        }
        return false;
    }

}
