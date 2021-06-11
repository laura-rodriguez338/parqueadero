<?php


require ("..\app\Models\Municipios.php");
use App\Models\Municipios;
$arrUser = [

    'nombre' => 'sogamoso',


];


$objUser = new Municipios($arrUser);
$objUser->insert();


$objUser->setnombre("sogamoso");

//$objUser->update();

//$objUser->Disconnect();



$arrResult = Municipios::search("SELECT * FROM Insumos WHERE id ");
if(!empty($arrResult)){
    /* @var $arrResult Municipios[] */
    foreach ($arrResult as $Municipios){
        echo "Nombre: ".$Municipios->getId()." - ".$Municipios->getNombre()."\n";
    }
}

$objUsersogamoso = Municipios::searchForId(3);
if(!empty($objUsersogamoso)){
    $objUsersogamoso->setNombre($objUsersogamoso);
    $objUsersogamoso->update();
}

$arrUsers = Municipios::getAll();
if(!empty($arrUsers)){
    /* @var $arrUsers Municipios[] */
    foreach ($arrUsers as $municipios){
        echo "id: ".$municipios->getId().", Nombre: ".$municipios->getNombre()."\n";
    }
}

$objUsersogamoso = Municipios::searchForId(5);
echo json_encode($objUsersogamoso);
