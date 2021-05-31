<?php


require ("..\app\Models\Insumos.php");
use App\Models\insumos;
$arrUser = [

     '$nombre' => 'detergente',
     '$cantidad' => '10',
     '$presentasion' => 'polvo',
     '$valor' => 'Activo',
];


$objUser = new insumos($arrUser);
var_dump($objUser);
$objUser->insert();
