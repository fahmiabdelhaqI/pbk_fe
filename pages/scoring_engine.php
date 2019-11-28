<?php include "../config.php"; include "../session.php"; ?>
<!doctype html>
<html lang="en">
    <head>
        <?php include "../partials/assets_css.php";?>
        <title>Scoring Engine</title>
    </head>
    <body>
        <?php include "../partials/sidenav.php";?>

        <div class="main-content" id="panel">
            <?php include "../partials/topnav.php";?>

            <!-- Header -->
            <div class="header pb-6">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row align-items-center py-4">
                            <div class="col-lg-6 col-7">
                                <h6 class="h2 d-inline-block mb-0">Scoring Engine</h6>
                                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                    <ol class="breadcrumb breadcrumb-links">
                                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                        <li class="breadcrumb-item" aria-current="page"><a href="scoring_engine.php">Scoring Engine</a></li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-lg-6 col-5 text-right"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid mt--6">
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
                                                <h2 style="margin-top: 40px; text-align: center" class="card-title"><?= $rowFetchModel['nama']?></h2>

                                                <center>
                                                    <?php
                                                        if($rowFetchModel['endpoint_tradisional'] != null or $rowFetchModel['endpoint_tradisional'] != '')
                                                        {
                                                            ?>
                                                                <a href="scoring_form.php?idModel=<?= $rowFetchModel['id']?>&mode=tradisional" class="btn btn-primary">Tradisional</a>
                                                            <?php
                                                        }

                                                        if($rowFetchModel['endpoint_ai'] != null or $rowFetchModel['endpoint_ai'] != '')
                                                        {
                                                            ?>
                                                                <a href="scoring_form.php?idModel=<?= $rowFetchModel['id']?>&mode=ai" class="btn btn-pinterest">AI</a>
                                                            <?php
                                                        }

                                                        if($rowFetchModel['endpoint_bre'] != null or $rowFetchModel['endpoint_bre'] != '')
                                                        {
                                                            ?>
                                                                <a href="scoring_form.php?idModel=<?= $rowFetchModel['id']?>&mode=bre" class="btn btn-info">BRE</a>
                                                            <?php
                                                        }
                                                    ?>
<!--                                                    <a href="scoring_form.php?idModel=--><?//= $rowFetchModel['id']?><!--">-->
<!--                                                        <button class="btn-edit">Scoring</button>-->
<!--                                                    </a>-->
                                                </center>
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
