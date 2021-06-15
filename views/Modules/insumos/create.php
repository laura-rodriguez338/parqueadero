<?php
require("../../partials/routes.php");
//require_once("../../partials/check_login.php");

use App\Models\GeneralFunctions;
use Carbon\Carbon;


$nameModel = "Insumo";
$pluralModel = $nameModel.'s';
$frmSession = $_SESSION['frm'.$pluralModel] ?? NULL;
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $_ENV['TITLE_SITE'] ?> | Crear <?= $nameModel ?></title>
    <?php require("../../partials/head_imports.php"); ?>
</head>
<body class="hold-transition sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">
    <?php require("../../partials/navbar_customization.php"); ?>

    <?php require("../../partials/sliderbar_main_menu.php"); ?>


    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Crear un Nuevo <?= $nameModel ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                        <li class="breadcrumb-item"><a href="../../../../parqueadero.git/views/Modules/Insumos/index.php"><?= $pluralModel ?></a></li>
                        <li class="breadcrumb-item active">Crear</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->

        <!-- Main content -->
        <section class="content">
            <!-- Generar Mensaje de alerta -->
            <?= (!empty($_GET['respuesta'])) ? GeneralFunctions::getAlertDialog($_GET['respuesta'], $_GET['mensaje']) : ""; ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-user"></i> &nbsp; Información del <?= $nameModel ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="card-refresh"
                                            data-source="create.php" data-source-selector="#card-refresh-content"
                                            data-load-on-init="false"><i class="fas fa-sync-alt"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                            class="fas fa-expand"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- form start -->
                                <form class="form-horizontal" enctype="multipart/form-data" method="post" id="frmCreate<?= $nameModel ?>"
                                      name="frmCreate<?= $nameModel ?>"
                                      action="../../../app/Controllers/MainController.php?controller=<?=  $pluralModel ?>&action=create">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                                                <div class="col-sm-10">
                                                    <input required type="text" class="form-control" id="nombre" name="nombre"
                                                           placeholder="Ingrese el nombre" value="<?= $frmSession['nombres'] ?? '' ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="cantidad" class="col-sm-2 col-form-label">Cantidad</label>
                                                <div class="col-sm-10">
                                                    <input required type="text" class="form-control" id="cantidad"
                                                           name="cantidad" placeholder="Ingrese la cantidad"
                                                           value="<?= $frmSession['cantidad'] ?? '' ?>">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="presentasion" class="col-sm-2 col-form-label">Presentasion</label>
                                                <div class="col-sm-10">
                                                    <input required type="text"  class="form-control"
                                                           id="presentasion" name="presentasion" placeholder="Tipo de presentasion"
                                                           value="<?= $frmSession['presentasion'] ?? '' ?>">
                                                </div>

                                            </div>
                                            <div class="form-group row">
                                                <label for="valor" class="col-sm-2 col-form-label">Valor</label>
                                                <div class="col-sm-10">
                                                    <input required type="text" class="form-control" id="valor"
                                                           name="valor" placeholder="Ingrese el valor"
                                                           value="<?= $frmSession['valor'] ?? '' ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="empresa_id" class="col-sm-2 col-form-label">empresa_id</label>
                                                <div class="col-sm-10">
                                                    <input required type="text" class="form-control" id="empresa_id"
                                                           name="empresa_id" placeholder="Ingrese la empresa_id"
                                                           value="<?= $frmSession['empresa_id'] ?? '' ?>">
                                                </div>
                                            </div>
                                        </div>
                                    <hr>
                                    <button type="submit" class="btn btn-info">Enviar</button>
                                    <a href="../../../../parqueadero.git/views/Modules/insumos/index.php" role="button" class="btn btn-default float-right">Cancelar</a>
                                    <!-- /.card-footer -->
                                </form>
                            </div>
                            <!-- /.card-body -->

                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php require('../../partials/footer.php'); ?>
</div>
<!-- ./wrapper -->
<?php require('../../partials/scripts.php'); ?>

</body>
</html>

