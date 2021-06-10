<?php


require ("..\app\Models\Insumos.php");
use App\Models\Insumos;
$arrUser = [

     'nombre' => 'detergente',
     'cantidad' => 10,
     'presentasion' => 'polvo',
     'valor' => 30000,
     'empresa_id' => 1,

];

$arrUser2 = [

    'nombre' => 'jabonliquido',
    'cantidad' => 15,
    'presentasion' => 'liquido',
    'valor' => 40000,
    'empresa_id' => 1,

];


$objUser = new Insumos($arrUser);
$objUser->insert();


$objUser->setnombre("jabon");
$objUser->setcantidad(20);
//$objUser->update();

//$objUser->Disconnect();


$objUser2 = new insumos($arrUser2);
$objUser2->insert();

$arrResult = Insumos::search("SELECT * FROM Insumos WHERE cantidad = 10 ");
if(!empty($arrResult)){
    /* @var $arrResult Insumos[] */
    foreach ($arrResult as $Insumos){
        echo "Nombre: ".$Insumos->getId()." - ".$Insumos->getNombre()."\n";
    }
}

$objUserjabonliquido = Insumos::searchForId(3);
if(!empty($objUserjabonliquido)){
    $objUserjabonliquido->setcantidad(20);
    $objUserjabonliquido->update();
}

$arrUsers = Insumos::getAll();
if(!empty($arrUsers)){
    /* @var $arrUsers Insumos[] */
    foreach ($arrUsers as $Insumos){
        echo "id: ".$Insumos->getId().", Nombre: ".$Insumos->getNombre().", cantidad: ".$Insumos->getcantidad().", presentasion: ".$Insumos->getpresentasion ()."\n";
    }
}

$objUserjabonliquido = Insumos::searchForId(5);
echo json_encode($objUserjabonliquido);
