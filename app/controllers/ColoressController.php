<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php');
use App\Models\GeneralFunctions;
use App\Models\Coloress;
use Carbon\Carbon;

class ColoressController{

    private array $dataColores;

    public function __construct(array $_FORM)
    {
        $this->dataColores = array();
        $this->dataColores['id'] = $_FORM['id'] ?? NULL;
        $this->dataColores['nombre'] = $_FORM['nombre'] ?? '';
        $this->dataColores['descripcion'] = $_FORM['descripcion'] ?? '';
        $this->dataColores['estado'] = $_FORM['estado'] ?? 'Activo';
    }

    public function create() {
        try {
            if (!empty($this->dataColores['nombre']) && !Coloress::coloresRegistrada($this->dataColores['nombre'])) {
                $Colores = new Coloress($this->dataColores);
                if ($Colores->insert()) {
                    unset($_SESSION['frmColoress']);
                    header("Location: ../../views/modules/coloress/index.php?respuesta=success&mensaje=Color Registrado!");
                }
            } else {
                header("Location: ../../views/modules/coloress/create.php?respuesta=error&mensaje=Color ya registrado!");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    public function edit()
    {
        try {
            $Colores = new Coloress($this->dataColores);
            if($Colores->update()){
                unset($_SESSION['frmColoress']);
            }

            header("Location: ../../views/modules/coloress/show.php?id=" . $Colores->getId() . "&respuesta=success&mensaje=Color Actualizado!");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function searchForID (array $data){
        try {
            $result = Coloress::searchForId($data['id']);
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
            $result = Coloress::getAll();
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
            $ObjColores = Coloress::searchForId($id);
            $ObjColores->setEstado("Activo");
            if($ObjColores->update()){
                header("Location: ../../views/modules/coloress/index.php");
            }else{
                header("Location: ../../views/modules/coloress/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function inactivate (int $id){
        try {
            $ObjColores = Coloress::searchForId($id);
            $ObjColores->setEstado("Inactivo");
            if($ObjColores->update()){
                header("Location: ../../views/modules/coloress/index.php");
            }else{
                header("Location: ../../views/modules/coloress/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function selectColores (array $params = []){

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "colores_id";
        $params['name'] = $params['name'] ?? "colores_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrColores = array();
        if($params['where'] != ""){
            $base = "SELECT * FROM coloress WHERE ";
            $arrColores = Coloress::search($base.$params['where']);
        }else{
            $arrColores = Coloress::getAll();
        }

        $htmlSelect = "<select ".(($params['isMultiple']) ? "multiple" : "")." ".(($params['isRequired']) ? "required" : "")." id= '".$params['id']."' name='".$params['name']."' class='".$params['class']."'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(count($arrColores) > 0){
            /* @var $arrColores Colors[] */
            foreach ($arrColores as $colores)
                if (!ColoressController::coloresIsInArray($colores->getId(),$params['arrExcluir']))
                    $htmlSelect .= "<option ".(($colores != "") ? (($params['defaultValue'] == $colores->getId()) ? "selected" : "" ) : "")." value='".$colores->getId()."'>".$colores->getNombre()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    public static function coloresIsInArray($idColores, $ArrColores){
        if(count($ArrColores) > 0){
            foreach ($ArrColores as $Colores){
                if($Colores->getId() == $idColores){
                    return true;
                }
            }
        }
        return false;
    }

}