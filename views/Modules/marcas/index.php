<?php
<<<<<<< HEAD:views/Modules/marcas/index.php
require_once("../../../app/Controllers/MarcasController.php");
=======
require_once("../../../app/Controllers/InsumosController.php");
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf:views/Modules/insumos/index.php
require_once("../../partials/routes.php");
//require_once("../../partials/check_login.php");

<<<<<<< HEAD:views/Modules/marcas/index.php
use App\Controllers\MarcasController;
use App\Models\GeneralFunctions;
use App\Models\Marcas;

$nameModel = "Marca";
=======
use App\controllers\InsumosController;
use App\Models\GeneralFunctions;

$nameModel = "Insumos";
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf:views/Modules/insumos/index.php
$pluralModel = $nameModel.'s';
$frmSession = $_SESSION['frm'.$pluralModel] ?? NULL;
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $_ENV['TITLE_SITE'] ?> | Gestión de <?= $pluralModel ?></title>
    <?php require("../../partials/head_imports.php"); ?>
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= $adminlteURL ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="<?= $adminlteURL ?>/plugins/datatables-responsive/css/responsive.bootstrap4.css">
    <link rel="stylesheet" href="<?= $adminlteURL ?>/plugins/datatables-buttons/css/buttons.bootstrap4.css">
</head>
<body class="hold-transition sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">
    <?php require_once("../../partials/navbar_customization.php"); ?>

    <?php require_once("../../partials/sliderbar_main_menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Pagina Principal</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item active"><?= $pluralModel ?></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Generar Mensajes de alerta -->
            <?= (!empty($_GET['respuesta'])) ? GeneralFunctions::getAlertDialog($_GET['respuesta'], $_GET['mensaje']) : ""; ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Default box -->
                        <div class="card card-dark">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-boxes"></i> &nbsp; Gestionar <?= $pluralModel ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="card-refresh"
                                            data-source="index.php" data-source-selector="#card-refresh-content"
                                            data-load-on-init="false"><i class="fas fa-sync-alt"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                                class="fas fa-expand"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"
                                            data-toggle="tooltip" title="Remove">
                                        <i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-auto mr-auto"></div>
                                    <div class="col-auto">
                                        <a role="button" href="create.php" class="btn btn-primary float-right"
                                           style="margin-right: 5px;">
                                            <i class="fas fa-plus"></i> Crear <?= $nameModel ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <table id="tbl<?= $pluralModel ?>" class="datatable table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombres</th>
<<<<<<< HEAD:views/Modules/marcas/index.php
                                                <th>Descripción</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
=======
                                                <th>cantidad</th>
                                                <th>presentasion</th>
                                                <th>valor</th>
                                                <th>empresa_id</th>
                                                <th>Acciones</th>


>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf:views/Modules/insumos/index.php
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
<<<<<<< HEAD:views/Modules/marcas/index.php
                                            $arrMarcas = MarcasController::getAll();
                                            /* @var $arrMarcas Marcas[] */
                                            foreach ($arrMarcas as $marca) {
                                                ?>
                                                <tr>
                                                    <td><?= $marca->getId(); ?></td>
                                                    <td><?= $marca->getNombre(); ?></td>
                                                    <td><?= $marca->getDescripcion(); ?></td>
                                                    <td><?= $marca->getEstado(); ?></td>
                                                    <td>
                                                        <a href="edit.php?id=<?= $marca->getId(); ?>"
=======
                                            $arrinsumos = InsumosController::getAll();
                                            /* @var $arrinsumos insumos[] */
                                            if(!empty($arrinsumos)){
                                            foreach ($arrinsumos as $insumos) {
                                                ?>
                                                <tr>
                                                    <td><?= $insumos->getId(); ?></td>
                                                    <td><?= $insumos->getNombre(); ?></td>
                                                    <td><?= $insumos->getcantidad(); ?></td>
                                                    <td><?= $insumos->getpresentasion(); ?></td>
                                                    <td><?= $insumos->getvalor(); ?></td>
                                                    <td><?= $insumos->getempresa_id(); ?></td>

                                                    <td>
                                                        <a href="edit.php?id=<?php echo $insumos->getId(); ?>"
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf:views/Modules/insumos/index.php
                                                           type="button" data-toggle="tooltip" title="Actualizar"
                                                           class="btn docs-tooltip btn-primary btn-xs"><i
                                                                    class="fa fa-edit"></i></a>
                                                        <a href="show.php?id=<?= $marca->getId(); ?>"
                                                           type="button" data-toggle="tooltip" title="Ver"
                                                           class="btn docs-tooltip btn-warning btn-xs"><i
<<<<<<< HEAD:views/Modules/marcas/index.php
                                                                    class="fa fa-eye"></i></a>
                                                        <a href="../productos/index.php?idMarca=<?= $marca->getId(); ?>"
                                                           type="button" data-toggle="tooltip" title="Ver Productos"
                                                           class="btn docs-tooltip btn-success btn-xs"><i
                                                                    class="fa fa-sitemap"></i></a>
                                                        <?php if ($marca->getEstado() != "Activo") { ?>
                                                            <a href="../../../app/Controllers/MainController.php?controller=<?= $pluralModel ?>&action=activate&id=<?= $marca->getId(); ?>"
                                                               type="button" data-toggle="tooltip" title="Activar"
                                                               class="btn docs-tooltip btn-success btn-xs"><i
                                                                        class="fa fa-check-square"></i></a>
                                                        <?php } else { ?>
                                                            <a type="button"
                                                               href="../../../app/Controllers/MainController.php?controller=<?= $pluralModel ?>&action=inactivate&id=<?= $marca->getId(); ?>"
                                                               data-toggle="tooltip" title="Inactivar"
                                                               class="btn docs-tooltip btn-danger btn-xs"><i
                                                                        class="fa fa-times-circle"></i></a>
                                                        <?php } ?>
=======
                                                                class="fa fa-eye"></i></a>
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf:views/Modules/insumos/index.php
                                                    </td>
                                                </tr>
                                            <?php } } ?>

                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombres</th>
<<<<<<< HEAD:views/Modules/marcas/index.php
                                                <th>Descripción</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
=======
                                                <th>cantidad</th>
                                                <th>presentasion</th>
                                                <th>valor</th>
                                                <th>empresa_id</th>
                                                <th>Acciones</th>

>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf:views/Modules/insumos/index.php
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                Pie de Página.
                            </div>
                            <!-- /.card-footer-->
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
<!-- Scripts requeridos para las datatables -->
<?php require('../../partials/datatables_scripts.php'); ?>
</body>
</html>
