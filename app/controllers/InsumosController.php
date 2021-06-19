<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php');
use App\Models\GeneralFunctions;
use App\Models\Insumos;
use Carbon\Carbon;

class InsumosController{

    private array $dataInsumo;

    public function __construct(array $_FORM)
    {
        $this->dataInsumo = array();
        $this->dataInsumo['id'] = $_FORM['id'] ?? NULL;
        $this->dataInsumo['nombre'] = $_FORM['nombre'] ?? '';
        $this->dataInsumo['descripcion'] = $_FORM['descripcion'] ?? '';
        $this->dataInsumo['estado'] = $_FORM['estado'] ?? 'Activo';
    }

    public function create() {
        try {
            if (!empty($this->dataInsumo['nombre']) && !Insumos::insumoRegistrada($this->dataInsumo['nombre'])) {
                $Insumo = new Insumos($this->dataInsumo);
                if ($Insumo->insert()) {
                    unset($_SESSION['frmInsumos']);
                    header("Location: ../../views/modules/insumos/index.php?respuesta=success&mensaje=Insumo Registrado!");
                }
            } else {
                header("Location: ../../views/modules/insumos/create.php?respuesta=error&mensaje=Insumo ya registrado!");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    public function edit()
    {
        try {
            $Insumo = new Insumos($this->dataInsumo);
            if($Insumo->update()){
                unset($_SESSION['frmInsumos']);
            }

            header("Location: ../../views/modules/insumos/show.php?id=" . $Insumo->getId() . "&respuesta=success&mensaje=Insumo Actualizado!");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function searchForID (array $data){
        try {
            $result = Insumos::searchForId($data['id']);
            if (!empty($data['request']) and $data['request'] === 'ajax' and !empty($result)) {
                header('Content-type: application/json; charset=utf-8');
                $result = json_encode($result->jsonSerialize());
            }
            return $result;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    static public function getAll (array $data = null){
        try {
            $result = Insumos::getAll();
            if (!empty($data['request']) and $data['request'] === 'ajax') {
                header('Content-type: application/json; charset=utf-8');
                $result = json_encode($result);
            }
            return $result;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    static public function activate (int $id){
        try {
            $ObjInsumo = Insumos::searchForId($id);
            $ObjInsumo->setEstado("Activo");
            if($ObjInsumo->update()){
                header("Location: ../../views/modules/insumos/index.php");
            }else{
                header("Location: ../../views/modules/insumos/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function inactivate (int $id){
        try {
            $ObjInsumo = Insumos::searchForId($id);
            $ObjInsumo->setEstado("Inactivo");
            if($ObjInsumo->update()){
                header("Location: ../../views/modules/insumos/index.php");
            }else{
                header("Location: ../../views/modules/insumos/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function selectInsumo (array $params = []){

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "insumo_id";
        $params['name'] = $params['name'] ?? "insumo_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrInsumo = array();
        if($params['where'] != ""){
            $base = "SELECT * FROM insumos WHERE ";
            $arrInsumo = Insumos::search($base.$params['where']);
        }else{
            $arrInsumo = Insumos::getAll();
        }

        $htmlSelect = "<select ".(($params['isMultiple']) ? "multiple" : "")." ".(($params['isRequired']) ? "required" : "")." id= '".$params['id']."' name='".$params['name']."' class='".$params['class']."'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(count($arrInsumo) > 0){
            /* @var $arrInsumo Insumos[] */
            foreach ($arrInsumo as $insumo)
                if (!InsumosController::insumoIsInArray($insumo->getId(),$params['arrExcluir']))
                    $htmlSelect .= "<option ".(($insumo != "") ? (($params['defaultValue'] == $insumo->getId()) ? "selected" : "" ) : "")." value='".$insumo->getId()."'>".$insumo->getNombre()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    public static function insumoIsInArray($idInsumo, $ArrInsumo){
        if(count($ArrInsumo) > 0){
            foreach ($ArrInsumo as $Insumo){
                if($Insumo->getId() == $idInsumo){
                    return true;
                }
            }
        }
        return false;
    }

}