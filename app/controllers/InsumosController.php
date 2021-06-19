<?php

<<<<<<< HEAD
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
=======

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
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
        }
    }

    public function edit()
    {
        try {
<<<<<<< HEAD
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
=======
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
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
        try {
            $result = Insumos::searchForId($data['id']);
            if (!empty($data['request']) and $data['request'] === 'ajax' and !empty($result)) {
                header('Content-type: application/json; charset=utf-8');
                $result = json_encode($result->jsonSerialize());
            }
            return $result;
        } catch (\Exception $e) {
<<<<<<< HEAD
            GeneralFunctions::logFile('Exception',$e, 'error');
=======
            GeneralFunctions::logFile('Exception', $e, 'error');
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
        }
        return null;
    }

<<<<<<< HEAD
    static public function getAll (array $data = null){
=======
    static public function getAll(array $data = null)
    {
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
        try {
            $result = Insumos::getAll();
            if (!empty($data['request']) and $data['request'] === 'ajax') {
                header('Content-type: application/json; charset=utf-8');
                $result = json_encode($result);
            }
            return $result;
        } catch (\Exception $e) {
<<<<<<< HEAD
            GeneralFunctions::logFile('Exception',$e, 'error');
=======
            GeneralFunctions::logFile('Exception', $e, 'error');
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
        }
        return null;
    }

<<<<<<< HEAD
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
=======
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
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

<<<<<<< HEAD
    public static function insumoIsInArray($idInsumo, $ArrInsumo){
        if(count($ArrInsumo) > 0){
            foreach ($ArrInsumo as $Insumo){
                if($Insumo->getId() == $idInsumo){
=======
    private static function InsumosInArray($idInsumos, $ArrInsumos)
    {
        if (count($ArrInsumos) > 0) {
            foreach ($ArrInsumos as $Insumos) {
                if ($Insumos->getId() == $idInsumos) {
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
                    return true;
                }
            }
        }
        return false;
    }

<<<<<<< HEAD
=======

>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
}