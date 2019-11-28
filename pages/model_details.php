<?php include "../config.php"; include "../session.php"; $idModel = $_GET['idModel']?>
<!doctype html>
<html lang="en">
    <head>
        <title>Model Details</title>
        <?php include "../partials/assets_css.php"; ?>
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
                                        <li class="breadcrumb-item active" aria-current="page">Model Details</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-lg-6 col-5 text-right">
                                <a href="model_form.php?method=create&idModel=<?= $idModel;?>">
                                    <button class="btn-new-scorecard">
                                        <i class="far fa-plus-square" style="font-size: 18px; margin-right: 10px"></i> Add Parameter
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
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <h3 class="mb-0">
                                            <?php
                                                $sqlFetchNamaModel = $conn->query("SELECT * FROM models WHERE id = $idModel");
                                                $rowFetchNamaModel = $sqlFetchNamaModel->fetch_assoc();
                                                echo "<strong>Model</strong> - ".$rowFetchNamaModel['nama'];
                                            ?>
                                        </h3>
                                    </div>
<!--                                    <div class="col-4 text-right" id="tempat_tombol_params">-->
<!--                                        <a id="web_params" class="btn btn-sm btn-pinterest" href="model_form.php?method=create&idModel=--><?//= $idModel;?><!--">-->
<!--                                            <i class="fas fa-plus-square"></i><span>Test</span>-->
<!--                                        </a>-->
<!--                                    </div>-->
                                </div>
                            </div>
                            <div class="table-responsive py-4">
                                <table class="table table-flush" id="parameter_list">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Parameter</th>
                                            <th>Label</th>
                                            <th>Data Type</th>
                                            <th>Is Web</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sqlListParameter = $conn->query("SELECT * FROM model_parameters WHERE id_model = $idModel");
                                            while($rowListParameter = $sqlListParameter->fetch_assoc())
                                            {
                                                ?>
                                                    <tr>
                                                        <td><?= $rowListParameter['parameter']?></td>
                                                        <td><?= $rowListParameter['label']?></td>
                                                        <td><?= $rowListParameter['tipe_data']?></td>
                                                        <td>
                                                            <?php
                                                                if($rowListParameter['is_web'] == 'Y')
                                                                {
                                                                    echo "Yes";
                                                                }
                                                                else
                                                                {
                                                                    echo "No";
                                                                }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <a href="model_form.php?method=edit&idModel=<?= $idModel?>&idParameter=<?= $rowListParameter['id']?>" class="btn btn-sm btn-white">EDIT</a>
                                                            <a href="../action/parameter.php?idParameter=<?= $rowListParameter['id']?>&crud=delete&idModel=<?= $idModel?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau menghapus parameter ini?')">DELETE</a>
                                                            <a href="parameter_logic.php?idParameter=<?= $rowListParameter['id']?>" class="btn btn-sm btn-info">View Logic</a>
                                                        </td>
                                                    </tr>
                                                <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include "../partials/assets_js.php";?>
        <script>
            $("#parameter_list").DataTable({
                ordering: false,
                language: {
                    paginate: {
                        previous: "<i class='fas fa-angle-left'>",
                        next: "<i class='fas fa-angle-right'>"
                    }
                }
            });
            
            $(document).ready(function () {
                $('.tbl_web_param').on('click', function () {
                    $('#model_params').remove();
                    $('#tempat_tombol_params').append('<a id="web_params" class="btn btn-sm btn-pinterest" href="model_form.php?method=create&idModel=<?= $idModel;?>">\n' +
                        '                                            <i class="fas fa-plus-square"></i><span>Test</span>\n' +
                        '                                        </a>');
                });

                $('.tbl_model_param').on('click', function () {
                    $('#web_params').remove();
                    $('#tempat_tombol_params').append('<a id="model_params" class="btn btn-sm btn-pinterest" href="#">\n' +
                        '                                            <i class="fas fa-plus-square"></i><span>Test 2</span>\n' +
                        '                                        </a>');
                });
            });
        </script>
    </body>
</html>
