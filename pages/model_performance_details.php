<?php include "../config.php"; include "../session.php"; $idModel = $_GET['idModel']; ?>
<?php
    $sqlFetchModel = $conn->query("SELECT * FROM models WHERE id = $idModel");
    $rowFetchModel = $sqlFetchModel->fetch_assoc();
?>
<!doctype html>
<html lang="en">
    <head>
        <?php include "../partials/assets_css.php"?>
        <title><?= $rowFetchModel['nama']." - Model Performance"?></title>
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
                                <h6 class="h2 d-inline-block mb-0">Model Performance</h6>
                                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                    <ol class="breadcrumb breadcrumb-links">
                                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="model_performance.php">Model Performance</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><a href="#"><?= $rowFetchModel['nama']?></a></li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-lg-6 col-5 text-right"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid mt--6">
                <?php
                    if($rowFetchModel['nama'] == 'Telco')
                    {
                        ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="h3 mb-0"><?= $rowFetchModel['nama']?></h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="card" style="width: 20rem;">
                                                        <img src="../assets/telco_performance/telco_tb_ks_auc.PNG" class="card-img-top" alt="...">
                                                        <div class="card-body">
                                                            <h5 class="h3 mb-0 card-title text-center"><strong>KS AUC GINI (Tradisional)</strong></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <img src="../assets/telco_performance/telco_tb_psi.PNG" class="card-img-top" alt="...">
                                                        <div class="card-body">
                                                            <h5 class="h3 mb-0 card-title text-center"><strong>PSI (Tradisional)</strong></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card" style="width: 20rem;">
                                                        <img src="../assets/telco_performance/telco_ai_metrics.PNG" class="card-img-top" alt="...">
                                                        <div class="card-body">
                                                            <h5 class="h3 mb-0 card-title text-center"><strong>Metrics (AI)</strong></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card" style="width: 20rem;">
                                                        <img src="../assets/telco_performance/telco_ai_roc_curve.png" class="card-img-top" alt="...">
                                                        <div class="card-body">
                                                            <h5 class="h3 mb-0 card-title text-center"><strong>ROC Curve (AI)</strong></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }
                    else if($rowFetchModel['nama'] == "E-Commerce")
                    {
                        ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="h3 mb-0"><?= $rowFetchModel['nama']?></h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="card" style="width: 20rem;">
                                                        <img src="../assets/ecommerce_performance/KS-ROC_Ecommerce_AI.PNG" class="card-img-top" alt="...">
                                                        <div class="card-body">
                                                            <h5 class="h3 mb-0 card-title text-center"><strong>KS ROC (AI)</strong></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card" style="width: 20rem;">
                                                        <img src="../assets/ecommerce_performance/PSI_Ecommerce_AI.PNG" class="card-img-top" alt="...">
                                                        <div class="card-body">
                                                            <h5 class="h3 mb-0 card-title text-center"><strong>PSI Performance (AI)</strong></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }
                    else if($rowFetchModel['nama'] == "Credit")
                    {
                        ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="h3 mb-0"><?= $rowFetchModel['nama']?></h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="card" style="width: 20rem;">
                                                        <img src="../assets/credit_performance/KS-ROC_Credit_AI.PNG" class="card-img-top" alt="...">
                                                        <div class="card-body">
                                                            <h5 class="h3 mb-0 card-title text-center"><strong>KS ROC (AI)</strong></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card" style="width: 20rem;">
                                                        <img src="../assets/credit_performance/PSI_Credit_AI.PNG" class="card-img-top" alt="...">
                                                        <div class="card-body">
                                                            <h5 class="h3 mb-0 card-title text-center"><strong>PSI Performance (AI)</strong></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }
                    else if($rowFetchModel['nama'] == "Test POC")
                    {
                        ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="h3 mb-0"><?= $rowFetchModel['nama']?></h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="card" style="width: 20rem;">
                                                        <img src="../assets/telco_performance/telco_tb_ks_auc.PNG" class="card-img-top" alt="...">
                                                        <div class="card-body">
                                                            <h5 class="h3 mb-0 card-title text-center"><strong>KS AUC GINI (Tradisional)</strong></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <img src="../assets/telco_performance/telco_tb_psi.PNG" class="card-img-top" alt="...">
                                                        <div class="card-body">
                                                            <h5 class="h3 mb-0 card-title text-center"><strong>PSI (Tradisional)</strong></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card" style="width: 20rem;">
                                                        <img src="../assets/telco_performance/telco_ai_metrics.PNG" class="card-img-top" alt="...">
                                                        <div class="card-body">
                                                            <h5 class="h3 mb-0 card-title text-center"><strong>Metrics (AI)</strong></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card" style="width: 20rem;">
                                                        <img src="../assets/telco_performance/telco_ai_roc_curve.png" class="card-img-top" alt="...">
                                                        <div class="card-body">
                                                            <h5 class="h3 mb-0 card-title text-center"><strong>ROC Curve (AI)</strong></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }
                ?>

            </div>
        </div>


        <?php include "../partials/assets_js.php"?>
    </body>
</html>