<?php include "../config.php"; include "../session.php"; $method = $_GET['method']; $idLogic = $_GET['idLogic']; $idParameter = $_GET['idParameter'];?>
<!doctype html>
<html lang="en">
    <head>
        <?php include "../partials/assets_css.php";?>
        <title>Reason Code</title>
    </head>
    <body>
        <?php include "../partials/sidenav.php";?>

        <!-- Main Content -->
        <div class="main-content" id="panel">
            <?php include "../partials/topnav.php"; ?>

            <!-- Header -->
            <div class="header pb-6">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row align-items-center py-4">
                            <div class="col-lg-6 col-7">
                                <h6 class="h2 d-inline-block mb-0">Model</h6>
                                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                    <ol class="breadcrumb breadcrumb-links">
                                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="model_list.php">Model</a></li>
                                        <li class="breadcrumb-item"><a href="model_list.php">Model Details</a></li>
                                        <li class="breadcrumb-item">Parameter Logic</li>
                                        <li class="breadcrumb-item active" aria-current="page">Reason Code</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid mt--6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="mb-0">Form <?php if($method == 'create'){echo 'Add';}else{echo 'Edit';}?> Reason Code</h3>
                    </div>
                    <div class="card-body">
                        <?php
                            if($method == 'create')
                            {
                                $sqlIdReason = $conn->query("SELECT id FROM reasons ORDER BY id DESC LIMIT 1");
                                $rowIdReason = $sqlIdReason->fetch_assoc();
                                $idReason = $rowIdReason['id'] + 1;
                                ?>
                                    <form action="../action/reasoncode.php?crud=create&idLogic=<?= $idLogic?>&idParameter=<?= $idParameter;?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8" data-toggle="validator" role="form">
                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-control-label">Code</label>
                                                <input type="hidden" name="id_reason" value="<?= $idReason?>">
                                                <input type="text" class="form-control" name="code" id="code" required/>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-control-label">Description</label>
                                                <input type="text" class="form-control" name="description" id="description" required/>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <center>
                                                    <input type="submit" class="btn" style="background: #FF3860; color: white" value="CREATE" onclick="return confirm('Yakin data sudah benar?')"/>
                                                    <a href="parameter_logic.php?idParameter=<?= $idParameter?>" class="btn btn-white" onclick="return confirm('Yakin membatalkan pengubahan ini?')">CANCEL</a>
                                                </center>
                                            </div>
                                        </div>
                                    </form>
                                <?php
                            }
                            else
                            {
                                $idReason = $_GET['idReason'];
                                $sqlGetReason = $conn->query("SELECT * FROM reasons WHERE id = $idReason");
                                $rowGetReason = $sqlGetReason->fetch_assoc();
                                ?>
                                    <form action="../action/reasoncode.php?crud=edit&idLogic=<?= $idLogic?>&idParameter=<?= $idParameter;?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8" data-toggle="validator" role="form">
                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-control-label">Code</label>
                                                <input type="hidden" name="id_reason" value="<?= $idReason?>">
                                                <input type="text" class="form-control" name="code" id="code" value="<?= $rowGetReason['code']?>" required/>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-control-label">Description</label>
                                                <input type="text" class="form-control" name="description" id="description" value="<?= $rowGetReason['description']?>" required/>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <center>
                                                    <input type="submit" class="btn" style="background: #FF3860; color: white" value="EDIT" onclick="return confirm('Yakin data sudah benar?')"/>
                                                    <a href="parameter_logic.php?idParameter=<?= $idParameter?>" class="btn btn-white" onclick="return confirm('Yakin membatalkan pengubahan ini?')">CANCEL</a>
                                                </center>
                                            </div>
                                        </div>
                                    </form>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>

        </div>

        <?php include "../partials/assets_js.php";?>
    </body>
</html>
