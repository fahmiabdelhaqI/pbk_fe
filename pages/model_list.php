<?php include "../config.php"; include "../session.php"?>
<!doctype html>
<html lang="en">
    <head>
        <title>Model Details</title>
        <?php include "../partials/assets_css.php"; ?>
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
                                        <li class="breadcrumb-item" aria-current="page"><a href="model_list.php">Model</a></li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-lg-6 col-5 text-right">
                                <a href="scorecard_form.php?method=create">
                                    <button class="btn-new-scorecard">
                                        <i class="far fa-plus-square" style="font-size: 18px; margin-right: 10px"></i> Input New Model
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid mt--6">
                <?php
                    if(isset($_SESSION['message']) or isset($_SESSION['status']))
                    {
                        if($_SESSION['status'] == 'Success!')
                        {
                            ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong><?= $_SESSION['status']?>!</strong> <?= $_SESSION['message']?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php
                        }
                        else
                        {
                            ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong><?= $_SESSION['status']?>!</strong> <?= $_SESSION['message']?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php
                        }
                    }
                    unset($_SESSION['message']); unset($_SESSION['status']);
                ?>
                <div class="row">
                    <?php
                        $sqlFetchModel = $conn->query("SELECT * FROM models");
                        while($rowFetchModel = $sqlFetchModel->fetch_assoc())
                        {
                            ?>
                                <div class="col-xl-4 col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <center>
                                                <i class="fas <?= $rowFetchModel['icons']?>" style="font-size: 50px"></i>
                                            </center>
                                            <h2 style="margin-top: 40px; text-align: center" class="card-title"><?= $rowFetchModel['nama']?></h2>

                                            <center>
                                                <a class="btn btn-lg btn-primary" href="model_details.php?idModel=<?= $rowFetchModel['id']?>">View</a>
                                                <a href="scorecard_form.php?idModel=<?= $rowFetchModel['id']?>&method=edit" class="btn btn-lg btn-warning">Edit</a>
                                                <a class="btn btn-lg btn-danger" href="../action/model.php?crud=delete&idModel=<?= $rowFetchModel['id']?>" onclick="return confirm('Yakin akan menghapus model ini?')">Delete</a>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
        </div>

        <?php include "../partials/assets_js.php";?>
    </body>
</html>
