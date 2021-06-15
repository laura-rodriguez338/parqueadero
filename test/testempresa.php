<?php

require ("..\app\Models\Empresa.php");
use App\Models\Empresa;
$arrUser = [

    'nombre' => 'parqueadero',
    'telefono' => 3217057860,
    'direccion' => 'cra14#7-57',


];



$objUser = new Empresa($arrUser);
$objUser->insert();


$objUser->setnombre("parqueadero");
$objUser->settelefono(3217057860);
//$objUser->update();

//$objUser->Disconnect();


$arrResult = Empresa::search("SELECT * FROM Empresa WHERE telefono = 3217057860 ");
if(!empty($arrResult)){
    /* @var $arrResult Empresa[] */
    foreach ($arrResult as $empresa){
        echo "Nombre: ".$empresa->getId()." - ".$empresa->getNombre()."\n";
    }
}

$objUserparqueadero = Empresa::searchForId(3);
if(!empty($objUserparqueadero)){
    $objUserparqueadero->settelefono(3217057860);
    $objUserparqueadero->update();
}

$arrUsers = Empresa::getAll();
if(!empty($arrUsers)){
    /* @var $arrUsers Empresa[] */
    foreach ($arrUsers as $empresa){
        echo "id: ".$empresa->getId().", Nombre: ".$empresa->getNombre().", telefono: ".$empresa->gettelefono().", direccion: ".$empresa->getdireccion() ()."\n";
    }
}

$objUserparqueadero = empresa::searchForId(5);
echo json_encode($objUserparqueadero);
