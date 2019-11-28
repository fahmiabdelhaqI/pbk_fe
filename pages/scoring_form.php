<?php include "../config.php"; include "../session.php"; $idModel = $_GET['idModel']; $mode = $_GET['mode'];?>
<?php
    $sqlFetchModel = $conn->query("SELECT * FROM models WHERE id = $idModel");
    $rowFetchModel = $sqlFetchModel->fetch_assoc();
?>
<!doctype html>
<html lang="en">
    <head>
        <?php include "../partials/assets_css.php";?>
        <title><?= $rowFetchModel['nama'].' - Scoring'?></title>
        <style>
            .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
                color: #FF3860;
                background-color: transparent;
                border-color: transparent transparent #f3f3f3;
                border-bottom: 3px solid !important;
                font-size: 16px;
                font-weight: bold;
            }

            .nav-link {
                border: 1px solid transparent;
                border-top-left-radius: .25rem;
                border-top-right-radius: .25rem;
                color: #FF3860;
                font-size: 16px;
                font-weight: 600;
            }

            .nav-link:hover {
                border: none;
            }
        </style>
    </head>
    <body>
        <?php include "../partials/sidenav.php"?>

        <!-- Main Content -->
        <div class="main-content" id="panel">
            <?php include "../partials/topnav.php"; ?>

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
                                        <li class="breadcrumb-item"><a href="scoring_engine.php">Scoring Engine</a></li>
                                        <li class="breadcrumb-item" aria-current="page"><a href="#"><?= $rowFetchModel['nama']?></a></li>
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
                    if(isset($_SESSION['message']) or isset($_SESSION['status']))
                    {
                        if($_SESSION['status'] != 'error')
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
                                    <strong><?= ucfirst($_SESSION['status'])?>!</strong> <?= $_SESSION['message']?>
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
                    <div class="col-xl-12 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="h3 mb-0"><strong>Pencarian <?php if($mode == 'tradisional'){echo "Tradisional";}else if($mode == 'ai'){echo "AI";}else{echo "BRE";}?> (<?= $rowFetchModel['nama']?>)</strong></h5>
                            </div>
                            <div class="card-body">
                                <nav>
                                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Single Inquiry</a>
                                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Bulk Inquiries</a>
                                    </div>
                                </nav>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" style="margin-top: 30px">
                                        <form action="../action/scoring.php?idModel=<?= $idModel;?>&mode=<?= $mode;?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8" data-toggle="validator" role="form">
                                            <div class="form-row">
                                                <?php
                                                    $sqlFetchParameters = $conn->query("SELECT * FROM model_parameters WHERE id_model = $idModel AND is_web = 'Y'");
                                                    while($rowFetchParameters = $sqlFetchParameters->fetch_assoc())
                                                    {
                                                        ?>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-control-label"><?= $rowFetchParameters['label']?></label>
                                                                <input type="text" class="form-control" name="<?= $rowFetchParameters['parameter']?>" id="<?= $rowFetchParameters['parameter']?>" required/>
                                                            </div>
                                                        <?php
                                                    }
                                                ?>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                    <center>
                                                        <input type="submit" class="btn" style="background: #FF3860; color: white" value="SCORE" onclick="return confirm('Yakin data sudah benar?')"/>
                                                        <a href="scoring_engine.php" class="btn btn-white" onclick="return confirm('Yakin membatalkan pengubahan ini?')">CANCEL</a>
                                                    </center>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-contact-tab" style="margin-top: 30px">
                                        <form action="scoring_bulk_fetch.php" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
                                            <div class="custom-file mb-3">
                                                <input type="file" class="custom-file-input" id="bulk_scoring" name="bulk_scoring">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                    <center>
                                                        <input type="submit" name="submit" value="GO" class="btn btn-kotak-edit" style="color: white" onclick="return confirm('Yakin file sudah benar?')">
                                                        <button type="button" class="btn btn-white">RESET</button>
                                                    </center>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include "../partials/assets_js.php"?>
        <script>
            $(".custom-file-input").on("change", function () {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            function validateForm()
            {
                function hasExtension(inputID, exts) {
                    var fileName = document.getElementById(inputID).value;
                    return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
                }
                if(!hasExtension('bulk_scoring', ['.csv'])){
                    alert("Hanya file CSV (Comma-Separated Values) yang diijinkan.");
                    return false;
                }
            }
        </script>
    </body>
</html>