<?php
require("../../partials/routes.php");
require_once("../../partials/check_login.php");
require("../../../app/Controllers/InsumosController.php");

use App\Controllers\InsumosController;
use App\Models\GeneralFunctions;
use App\Models\Insumos;

$nameModel = "Insumos";
$pluralModel = $nameModel . 's';
//$frmSession = $_SESSION['frm' . $pluralModel] ?? NULL;
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $_ENV['TITLE_SITE'] ?> | Datos del <?= $nameModel ?></title>
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
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Informacion del <?= $nameModel ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                        href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php"><?= $pluralModel ?></a></li>
                            <li class="breadcrumb-item active">Ver</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Generar Mensajes de alerta -->
            <?= (!empty($_GET['respuesta'])) ? GeneralFunctions::getAlertDialog($_GET['respuesta'], $_GET['mensaje']) : ""; ?>
            <?= (empty($_GET['id'])) ? GeneralFunctions::getAlertDialog('error', 'Faltan Criterios de B??squeda') : ""; ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="card card-green">
                            <?php if (!empty($_GET["id"]) && isset($_GET["id"])) {
                                $DataInsumos = InsumosController::searchForID(["id" => $_GET["id"]]);
                                /* @var $DataInsumos Insumos */
                                if (!empty($DataInsumos)) {
                                    ?>
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-info"></i> &nbsp; Ver Informaci??n
                                            de <?= $DataInsumos->getNombre() ?></h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="card-refresh"
                                                    data-source="show.php" data-source-selector="#card-refresh-content"
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
                                            <div class="col-sm-10">
                                                <p>
                                                    <strong><i class="fas fa-book mr-1"></i> Nombre y
                                                        cantidad</strong>
                                                <p class="text-muted">
                                                    <?= $DataInsumos->getNombre() . " " . $DataInsumos->getCantidad() ?>
                                                </p>
                                                <hr>
<<<<<<< HEAD:views/Modules/usuarios/show.php
                                                <strong><i class="fas fa-user mr-1"></i> Documento</strong>
                                                <p class="text-muted"><?= $DataUsuario->getTipoDocumento() . ": " . $DataUsuario->getDocumento() ?></p>
                                                <hr>

                                                <strong><i class="fas fa-map-marker-alt mr-1"></i> Direccion</strong>
                                                <p class="text-muted"><?= $DataUsuario->getDireccion() ?>
                                                    , <?= $DataUsuario->getMunicipio()->getNombre() ?>
                                                    - <?= $DataUsuario->getMunicipio()->getDepartamento()->getNombre() ?></p>
                                                <hr>
                                                <strong><i class="fas fa-calendar mr-1"></i> Fecha Nacimiento</strong>
                                                <p class="text-muted"><?= $DataUsuario->getFechaNacimiento()->translatedFormat('l, j \\de F Y'); ?>
                                                    &nbsp;
                                                    ????Tienes: <?= $DataUsuario->getFechaNacimiento()->diffInYears(); ?>
                                                    A??os????
                                                </p>
                                                <hr>
                                                <strong><i class="fas fa-phone mr-1"></i> Telefono</strong>
                                                <p class="text-muted"><?= $DataUsuario->getTelefono() ?></p>
=======
                                                <strong><i class="fas fa-user mr-1"></i> Presentasion</strong>
                                                <p class="text-muted"><?= $DataInsumos->getPresentasion() . ": " . $DataInsumos->getPresentasion() ?></p>

                                                 <hr>
                                                    <strong><i class="fas fa-user mr-1"></i> Valor</strong>
                                                <p class="text-muted"><?= $DataInsumos->getValor() . ": " . $DataInsumos->getValor() ?></p>
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf:views/Modules/insumos/show.php
                                                <hr>
                                                <strong><i class="fas fa-map-marker-alt mr-1"></i>Valor</strong>
                                                <p class="text-muted"><?= $DataInsumos->getValor() ?>
                                                    <hr>
                                                    <strong><i class="fas fa-user mr-1"></i> empresa_id</strong>
                                                <p class="text-muted"><?= $DataInsumos->getempresa_id() . ": " . $DataInsumos->getempresa_id() ?></p>
                                                <hr>
                                                <strong><i class="fas fa-map-marker-alt mr-1"></i> empresa_id</strong>
                                                <p class="text-muted"><?= $DataInsumos->getempresa_id() ?>
                                                </p>
                                            </div>
                                    </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-auto mr-auto">
<<<<<<< HEAD:views/Modules/usuarios/show.php
                                                <a role="button" href="index.php" class="btn btn-success float-right"
=======
                                                <a role="button" href="../../../../parqueadero/views/Modules/insumos/index.php" class="btn btn-success float-right"
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf:views/Modules/insumos/show.php
                                                   style="margin-right: 5px;">
                                                    <i class="fas fa-tasks"></i> Gestionar <?= $pluralModel ?>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <a role="button" href="edit.php?id=<?= $DataInsumos->getId(); ?>"
                                                   class="btn btn-primary float-right"
                                                   style="margin-right: 5px;">
                                                    <i class="fas fa-edit"></i> Editar <?= $nameModel ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                            &times;
                                        </button>
                                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                        No se encontro ningun registro con estos parametros de
                                        busqueda <?= ($_GET['mensaje']) ?? "" ?>
                                    </div>
                                <?php }
                            } ?>
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
