<?php include "../config.php"; include "../session.php"; $method = $_GET['method']; ?>
<!doctype html>
<html lang="en">
    <head>
        <?php include "../partials/assets_css.php";?>
        <title>Score Card <?php if($method == 'edit'){echo "Edit";}else{echo "Add";}?></title>
    </head>
    <body>
        <?php include "../partials/sidenav.php"; ?>
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
                                        <li class="breadcrumb-item active" aria-current="page">Model Form</li>
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
                        <h3 class="mb-0">Form <?php if($method == 'create'){echo 'Add';}else{echo 'Edit';}?> Model</h3>
                    </div>
                    <div class="card-body">
                        <?php
                            if($method == 'create')
                            {
                                ?>
                                    <form action="../action/model.php?crud=create" method="post" enctype="multipart/form-data" accept-charset="UTF-8" data-toggle="validator" role="form">
                                        <div class="form-row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-control-label">Nama Model</label>
                                                <input type="text" class="form-control" name="nama" id="nama" required/>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-control-label">Endpoint Tradisional</label>
                                                <input type="text" class="form-control" name="endpoint_tradisional" id="endpoint_tradisional"/>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-control-label">Endpoint AI</label>
                                                <input type="text" class="form-control" name="endpoint_ai" id="endpoint_ai"/>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-control-label">Endpoint BRE</label>
                                                <input type="text" class="form-control" name="endpoint_bre" id="endpoint_bre"/>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-control-label">Base Score</label>
                                                <input type="text" class="form-control" name="base_score" id="base_score" required/>
                                            </div>
                                            <div class="col-md-1 mb-3">
                                                <label class="form-control-label">Icon</label>
                                                <input type="text" class="form-control" name="icon" id="icon" required/>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <center>
                                                    <input type="submit" class="btn" style="background: #FF3860; color: white" value="CREATE" onclick="return confirm('Yakin data sudah benar?')"/>
                                                    <a href="model_list.php" class="btn btn-white" onclick="return confirm('Yakin membatalkan pengubahan ini?')">CANCEL</a>
                                                </center>
                                            </div>
                                        </div>
                                    </form>
                                <?php
                            }
                            else
                            {
                                $idModel = $_GET['idModel'];
                                $sqlFetchModel = $conn->query("SELECT * FROM models WHERE id = $idModel");
                                $rowFetchModel = $sqlFetchModel->fetch_assoc();

                                ?>
                                    <form action="../action/model.php?crud=edit&idModel=<?= $idModel;?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8" data-toggle="validator" role="form">
                                        <div class="form-row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-control-label">Nama Model</label>
                                                <input type="text" class="form-control" name="nama" id="nama" value="<?= $rowFetchModel['nama']?>" required/>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-control-label">Endpoint Tradisional</label>
                                                <input type="text" class="form-control" name="endpoint_tradisional" id="endpoint_tradisional" value="<?= $rowFetchModel['endpoint_tradisional']?>"/>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-control-label">Endpoint AI</label>
                                                <input type="text" class="form-control" name="endpoint_ai" id="endpoint_ai" value="<?= $rowFetchModel['endpoint_ai']?>"/>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-control-label">Endpoint BRE</label>
                                                <input type="text" class="form-control" name="endpoint_bre" id="endpoint_bre" value="<?= $rowFetchModel['endpoint_bre']?>"/>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-control-label">Base Score</label>
                                                <input type="text" class="form-control" name="base_score" id="base_score" value="<?= $rowFetchModel['base_score']?>" required/>
                                            </div>
                                            <div class="col-md-1 mb-3">
                                                <label class="form-control-label">Icon</label>
                                                <input type="text" class="form-control" name="icon" id="icon" value="<?= $rowFetchModel['icons']?>" required/>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <center>
                                                    <input type="submit" class="btn" style="background: #FF3860; color: white" value="EDIT" onclick="return confirm('Yakin data sudah benar?')"/>
                                                    <a href="model_list.php" class="btn btn-white" onclick="return confirm('Yakin membatalkan pengubahan ini?')">CANCEL</a>
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
