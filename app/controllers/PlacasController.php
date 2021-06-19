<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php');
use App\Models\GeneralFunctions;
use App\Models\Placas;
use Carbon\Carbon;

class PlacasController{

    private array $dataPlaca;

    public function __construct(array $_FORM)
    {
        $this->dataPlaca = array();
        $this->dataPlaca['id'] = $_FORM['id'] ?? NULL;
        $this->dataPlaca['nombre'] = $_FORM['nombre'] ?? '';
        $this->dataPlaca['descripcion'] = $_FORM['descripcion'] ?? '';
        $this->dataPlaca['estado'] = $_FORM['estado'] ?? 'Activo';
    }

    public function create() {
        try {
            if (!empty($this->dataPlaca['nombre']) && !Placas::placaRegistrada($this->dataPlaca['nombre'])) {
                $Placa = new Placas($this->dataPlaca);
                if ($Placa->insert()) {
                    unset($_SESSION['frmPlacas']);
                    header("Location: ../../views/modules/placas/index.php?respuesta=success&mensaje=placa Registrada!");
                }
            } else {
                header("Location: ../../views/modules/placas/create.php?respuesta=error&mensaje=placa ya registrada!");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    public function edit()
    {
        try {
            $Placa = new Placas($this->dataPlaca);
            if($Placa->update()){
                unset($_SESSION['frmPlacas']);
            }

            header("Location: ../../views/modules/placas/show.php?id=" . $Placa->getId() . "&respuesta=success&mensaje=Placa Actualizada!");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function searchForID (array $data){
        try {
            $result = Placas::searchForId($data['id']);
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
            $result = Placas::getAll();
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
            $ObjPlaca = Placas::searchForId($id);
            $ObjPlaca->setEstado("Activo");
            if($ObjPlaca->update()){
                header("Location: ../../views/modules/placas/index.php");
            }else{
                header("Location: ../../views/modules/placas/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function inactivate (int $id){
        try {
            $ObjPlaca = Placas::searchForId($id);
            $ObjPlaca->setEstado("Inactivo");
            if($ObjPlaca->update()){
                header("Location: ../../views/modules/placas/index.php");
            }else{
                header("Location: ../../views/modules/placas/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function selectPlaca (array $params = []){

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "placa_id";
        $params['name'] = $params['name'] ?? "placa_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrPlaca = array();
        if($params['where'] != ""){
            $base = "SELECT * FROM placas WHERE ";
            $arrPlaca = Placas::search($base.$params['where']);
        }else{
            $arrPlaca = Placas::getAll();
        }

        $htmlSelect = "<select ".(($params['isMultiple']) ? "multiple" : "")." ".(($params['isRequired']) ? "required" : "")." id= '".$params['id']."' name='".$params['name']."' class='".$params['class']."'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(count($arrPlaca) > 0){
            /* @var $arrPlaca Placas[] */
            foreach ($arrPlaca as $placa)
                if (!PlacasController::placaIsInArray($placa->getId(),$params['arrExcluir']))
                    $htmlSelect .= "<option ".(($placa != "") ? (($params['defaultValue'] == $placa->getId()) ? "selected" : "" ) : "")." value='".$placa->getId()."'>".$placa->getNombre()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    public static function placaIsInArray($idPlaca, $ArrPlaca){
        if(count($ArrPlaca) > 0){
            foreach ($ArrPlaca as $Placa){
                if($Placa->getId() == $idPlaca){
                    return true;
                }
            }
        }
        return false;
    }

}