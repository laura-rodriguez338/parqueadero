<?php
require("../../partials/routes.php");
require_once("../../partials/check_login.php");
require("../../../app/Controllers/InsumosController.php");


use App\Controllers\empresa_idController;
use App\Controllers\InsumosController;
use App\Models\GeneralFunctions;
use App\Models\Insumos;
use Carbon\Carbon;

$nameModel = "Insumos";
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
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php"><?= $pluralModel ?></a></li>
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

                                $DataInsumos = InsumosController::searchForID(["id" => $_GET["id"]]);
                                /* @var $DataInsumos Insumos */
                                if (!empty($DataInsumos)) {
                                    ?>
                                    <!-- form start -->
                                    <div class="card-body">
                                        <form class="form-horizontal" enctype="multipart/form-data" method="post" id="frmEdit<?= $nameModel ?>"
                                              name="frmEdit<?= $nameModel ?>"
                                              action="../../../app/Controllers/MainController.php?controller=<?= $pluralModel ?>&action=edit">
                                            <input id="id" name="id" value="<?= $DataInsumos->getId(); ?>" hidden
                                                   required="required" type="text">
                                            <div class="row">
                                                <div class="col-sm-10">
                                                    <div class="form-group row">
                                                        <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                                                        <div class="col-sm-10">
                                                            <input required type="text" class="form-control" id="nombre"
                                                                   name="nombre" value="<?= $DataInsumos->getNombre(); ?>"
                                                                   placeholder="Ingrese sus nombre">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="cantidad" class="col-sm-2 col-form-label">Cantidad</label>
                                                        <div class="col-sm-10">
<<<<<<< HEAD:views/Modules/usuarios/edit.php
                                                            <input required type="text" class="form-control" id="apellidos"
                                                                   name="apellidos" value="<?= $DataUsuario->getApellidos(); ?>"
                                                                   placeholder="Ingrese sus apellidos">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="tipo_documento" class="col-sm-2 col-form-label">Tipo
                                                            Documento</label>
                                                        <div class="col-sm-10">
                                                            <select id="tipo_documento" name="tipo_documento"
                                                                    class="custom-select">
                                                                <option <?= ($DataUsuario->getTipoDocumento() == "C.C") ? "selected" : ""; ?>
                                                                        value="C.C">Cedula de Ciudadania
                                                                </option>
                                                                <option <?= ($DataUsuario->getTipoDocumento() == "T.I") ? "selected" : ""; ?>
                                                                        value="T.I">Tarjeta de Identidad
                                                                </option>
                                                                <option <?= ($DataUsuario->getTipoDocumento() == "R.C") ? "selected" : ""; ?>
                                                                        value="R.C">Registro Civil
                                                                </option>
                                                                <option <?= ($DataUsuario->getTipoDocumento() == "Pasaporte") ? "selected" : ""; ?>
                                                                        value="Pasaporte">Pasaporte
                                                                </option>
                                                                <option <?= ($DataUsuario->getTipoDocumento() == "C.E") ? "selected" : ""; ?>
                                                                        value="C.E">Cedula de Extranjeria
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="documento" class="col-sm-2 col-form-label">Documento</label>
                                                        <div class="col-sm-10">
                                                            <input required type="number" minlength="6" class="form-control"
                                                                   id="documento" name="documento"
                                                                   value="<?= $DataUsuario->getDocumento(); ?>"
                                                                   placeholder="Ingrese su documento">
=======
                                                            <input required type="text" class="form-control" id="cantidad"
                                                                   name="cantidad" value="<?= $DataInsumos->getCantidad(); ?>"
                                                                   placeholder="Ingrese su cantidad">
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf:views/Modules/insumos/edit.php
                                                        </div>

                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="Presentasion" class="col-sm-2 col-form-label">Presentasion</label>
                                                        <div class="col-sm-10">
                                                            <input required type="text" class="form-control" id="presentasion"
                                                                   name="presentasion" value="<?= $DataInsumos->getPresentasion(); ?>"
                                                                   placeholder="Ingrese su presentasion">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="valor" class="col-sm-2 col-form-label">Valor</label>
                                                        <div class="col-sm-10">
                                                            <input required type="text" class="form-control" id="valor"
                                                                   name="valor" value="<?= $DataInsumos->getValor(); ?>"
                                                                   placeholder="Ingrese su valor">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="empresa_id" class="col-sm-2 col-form-label">empresa_id</label>
                                                        <div class="col-sm-10">
                                                            <input required type="text" class="form-control" id="valor"
                                                                   name="empresa_id" value="<?= $DataInsumos->getempresa_id(); ?>"
                                                                   placeholder="Ingrese su empresa_id">
                                                        </div>


                                                    <?php if ($_SESSION['UserInSession']['rol'] == 'Administrador'){ ?>
                                                        <div class="form-group row">
                                                            <label for="user" class="col-sm-2 col-form-label">Insumos</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" id="user" name="user" value="<?= $DataInsumos->getUser(); ?>" placeholder="Ingrese su Insumos">
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
                                                                    <input value="<?= $DataInsumos->getFoto(); ?>" type="file" id="foto" name="foto">
                                                                </label>
                                                                <button type="button" class="btn btn-default">Eliminar</button>
                                                            </div>
                                                            <div class="panel-footer">
                                                                <?php if(!empty($DataInsumos->getFoto())){?>
                                                                    <img id="thumbFoto" src="../../public/uploadFiles/photos/<?= $DataInsumos->getFoto(); ?>"
                                                                         alt="Sin Foto de Perfil" class="thumbnail" style="max-width: 250px; max-height: 250px">
                                                                <?php } ?>
                                                                <input type="hidden" name="nameFoto" id="nameFoto" value="<?= $DataInsumos->getFoto() ?? '' ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <button type="submit" class="btn btn-info">Enviar</button>
                                            <a href="index.php" role="button" class="btn btn-default float-right">Cancelar</a>
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
<script>
    $(function() {
        $('#empresa_id').on('change', function() {
            $.post("../../../app/Controllers/MainController.php?controller=Municipios&action=selectMunicipios", {
                isMultiple: false,
                isRequired: true,
                id: "empresa_id",
                nombre: "empresa_id",
                defaultValue: "",
                class: "form-control select2bs4 select2-info",
                where: "empresa_id = "+$('#empresa_id').val()+" and estado = 'Activo'",
                request: 'ajax'
            }, function(e) {
                if (e)
                    console.log(e);
                $("#empresa_id").html(e).select2({ height: '100px'});
            })
        });
        $('#foto').on("change", function(){
            $( "#thumbFoto" ).remove();
        });
    });
</script>
</body>
</html>
