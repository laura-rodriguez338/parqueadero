<?php
require("../../partials/routes.php");
require_once("../../partials/check_login.php");
require("../../../app/Controllers/EmpresaControllers.php");


use App\Controllers\EmpresaControllers;
use App\Models\GeneralFunctions;
use App\Models\Empresa;
use Carbon\Carbon;

$nameModel = "Empresa";
$pluralModel = $nameModel.'s';
//$frmSession = $_SESSION['frm'.$pluralModel] ?? null;

?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $_ENV['TITLE_SITE']  ?> | Editar <?= $nameModel ?></title>
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
                        <h1>Editar <?= $nameModel ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="../../../../parqueadero/views/Modules/Empresa/index.php"><?= $pluralModel ?></a></li>
                            <li class="breadcrumb-item active">Editar</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Generar Mensajes de alerta -->
            <?= (!empty($_GET['respuesta'])) ? GeneralFunctions::getAlertDialog($_GET['respuesta'], $_GET['mensaje']) : ""; ?>
            <?= (empty($_GET['id'])) ? GeneralFunctions::getAlertDialog('error', 'Faltan Criterios de Búsqueda') : ""; ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-user"></i>&nbsp; Información del <?= $nameModel ?></h3>
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
                            <?php if (!empty($_GET["id"]) && isset($_GET["id"])) { ?>
                                <p>
                                <?php

                                $DataMunicipios = EmpresaControllers::searchForID(["id" => $_GET["id"]]);
                                /* @var $DataMunicipios Empresa*/
                                if (!empty($DataEmpresa)) {
                                    ?>
                                    <!-- form start -->
                                    <div class="card-body">
                                        <form class="form-horizontal" enctype="multipart/form-data" method="post" id="frmEdit<?= $nameModel ?>"
                                              name="frmEdit<?= $nameModel ?>"
                                              action="../../../app/Controllers/MainController.php?controller=<?= $pluralModel ?>&action=edit">
                                            <input id="id" name="id" value="<?= $DataEmpresa->getId(); ?>" hidden
                                                   required="required" type="text">
                                            <div class="row">
                                                <div class="col-sm-10">
                                                    <div class="form-group row">
                                                        <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                                                        <div class="col-sm-10">
                                                            <input required type="text" class="form-control" id="nombre"
                                                                   name="nombre" value="<?= $DataEmpresa->getNombre(); ?>"
                                                                   placeholder="Ingrese sus nombre">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <div class="form-group row">
                                                            <label for="Telefono" class="col-sm-2 col-form-label">Telefono</label>
                                                            <div class="col-sm-10">
                                                                <input required type="text" class="form-control" id="Telefono"
                                                                       name="Telefono" value="<?= $DataEmpresa->getTelefono(); ?>"
                                                                       placeholder="Ingrese su Telefono">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <div class="form-group row">
                                                                <label for="Direccion" class="col-sm-2 col-form-label">Direccion</label>
                                                                <div class="col-sm-10">
                                                                    <input required type="text" class="form-control" id="Direccion"
                                                                           name="Direccion" value="<?= $DataEmpresa->getDireccion(); ?>"
                                                                           placeholder="Ingrese su Direccion">
                                                                </div>
                                                            </div>
                                                        <?php if ($_SESSION['UserInSession']['rol'] == 'Administrador'){ ?>
                                                            <div class="form-group row">
                                                                <label for="user" class="col-sm-2 col-form-label">Empresa</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="user" name="user" value="<?= $DataEmpresa->getUser(); ?>" placeholder="Ingrese su empresa">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="password" class="col-sm-2 col-form-label">Password</label>
                                                                <div class="col-sm-10">
                                                                    <input type="password" class="form-control" id="password" name="password" value="" placeholder="Ingrese su Password">
                                                                </div>
                                                            </div>

                                                        <?php } ?>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="info-box">
                                                            <div class="imageupload panel panel-primary">
                                                                <div class="panel-heading clearfix">
                                                                    <h5 class="panel-title pull-left">Foto de Perfil</h5>
                                                                </div>
                                                                <div class="file-tab panel-body">
                                                                    <label class="btn btn-default btn-file">
                                                                        <span>Seleccionar</span>
                                                                        <!-- The file is stored here. -->
                                                                        <input value="<?= $DataEmpresa->getFoto(); ?>" type="file" id="foto" name="foto">
                                                                    </label>
                                                                    <button type="button" class="btn btn-default">Eliminar</button>
                                                                </div>
                                                                <div class="panel-footer">
                                                                    <?php if(!empty($DataEmpresa->getFoto())){?>
                                                                        <img id="thumbFoto" src="../../public/uploadFiles/photos/<?= $DataEmpresa->getFoto(); ?>"
                                                                             alt="Sin Foto de Perfil" class="thumbnail" style="max-width: 250px; max-height: 250px">
                                                                    <?php } ?>
                                                                    <input type="hidden" name="nameFoto" id="nameFoto" value="<?= $DataEmpresa->getFoto() ?? '' ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <button type="submit" class="btn btn-info">Enviar</button>
                                                <a href="../../../../parqueadero/views/Modules/empresa/index.php" role="button" class="btn btn-default float-right">Cancelar</a>
                                        </form>
                                    </div>
                                    <!-- /.card-body -->

                                <?php } else { ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                            &times;
                                        </button>
                                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                        No se encontro ningun registro con estos parametros de
                                        busqueda <?= ($_GET['mensaje']) ?? "" ?>
                                    </div>
                                <?php } ?>
                                </p>
                            <?php } ?>
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
