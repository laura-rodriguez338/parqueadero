<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php');
use App\Models\GeneralFunctions;
use App\Models\Vehiculos;
use Carbon\Carbon;

class VehiculosController{

    private array $dataVehiculo;

    public function __construct(array $_FORM)
    {
        $this->dataVehiculo = array();
        $this->dataVehiculo['id'] = $_FORM['id'] ?? NULL;
        $this->dataVehiculo['nombre'] = $_FORM['nombre'] ?? '';
        $this->dataVehiculo['descripcion'] = $_FORM['descripcion'] ?? '';
        $this->dataVehiculo['estado'] = $_FORM['estado'] ?? 'Activo';
    }

    public function create() {
        try {
            if (!empty($this->dataVehiculo['nombre']) && !Vehiculos::vehiculoRegistrada($this->dataVehiculo['nombre'])) {
                $Vehiculo = new Vehiculos($this->dataVehiculo);
                if ($Vehiculo->insert()) {
                    unset($_SESSION['frmVehiculos']);
                    header("Location: ../../views/modules/vehiculos/index.php?respuesta=success&mensaje=Vehiculo Registrado!");
                }
            } else {
                header("Location: ../../views/modules/vehiculos/create.php?respuesta=error&mensaje=Vehiculo ya registrado!");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    public function edit()
    {
        try {
            $Vehiculo = new Vehiculos($this->dataVehiculo);
            if($Vehiculo->update()){
                unset($_SESSION['frmVehiculos']);
            }

            header("Location: ../../views/modules/vehiculos/show.php?id=" . $Vehiculo->getId() . "&respuesta=success&mensaje=Vehiculo Actualizado!");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function searchForID (array $data){
        try {
            $result = Vehiculos::searchForId($data['id']);
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
            $result = Vehiculos::getAll();
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
            $ObjVehiculo = Vehiculos::searchForId($id);
            $ObjVehiculo->setEstado("Activo");
            if($ObjVehiculo->update()){
                header("Location: ../../views/modules/vehiculos/index.php");
            }else{
                header("Location: ../../views/modules/vehiculos/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function inactivate (int $id){
        try {
            $ObjVehiculo = Vehiculos::searchForId($id);
            $ObjVehiculo->setEstado("Inactivo");
            if($ObjVehiculo->update()){
                header("Location: ../../views/modules/vehiculos/index.php");
            }else{
                header("Location: ../../views/modules/vehiculos/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function selectVehiculo (array $params = []){

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "vehiculo_id";
        $params['name'] = $params['name'] ?? "vehiculo_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrVehiculo = array();
        if($params['where'] != ""){
            $base = "SELECT * FROM vehiculos WHERE ";
            $arrVehiculo = Vehiculos::search($base.$params['where']);
        }else{
            $arrVehiculo = Vehiculos::getAll();
        }

        $htmlSelect = "<select ".(($params['isMultiple']) ? "multiple" : "")." ".(($params['isRequired']) ? "required" : "")." id= '".$params['id']."' name='".$params['name']."' class='".$params['class']."'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(count($arrVehiculo) > 0){
            /* @var $arrVehiculo Vehiculos[] */
            foreach ($arrVehiculo as $vehiculo)
                if (!VehiculosController::vehiculoIsInArray($vehiculo->getId(),$params['arrExcluir']))
                    $htmlSelect .= "<option ".(($vehiculo != "") ? (($params['defaultValue'] == $vehiculo->getId()) ? "selected" : "" ) : "")." value='".$vehiculo->getId()."'>".$vehiculo->getNombre()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    public static function vehiculoIsInArray($idVehiculo, $ArrVehiculo){
        if(count($ArrVehiculo) > 0){
            foreach ($ArrVehiculo as $Vehiculo){
                if($Vehiculo->getId() == $idVehiculo){
                    return true;
                }
            }
        }
        return false;
    }

}