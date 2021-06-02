<?php


require ("..\app\Models\Insumos.php");
use App\Models\insumos;
$arrUser = [

     'nombre' => 'detergente',
     'cantidad' => 10,
     'presentasion' => 'polvo',
     'valor' => 30000,
     'empresa_id' => 1,

];


$objUser = new insumos($arrUser);
$objUser->insert();
