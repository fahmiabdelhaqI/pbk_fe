<?php include "../config.php"; include "../session.php"; $idParameter = $_GET['idParameter'];?>
<!doctype html>
<html lang="en">
    <head>
        <?php include "../partials/assets_css.php"?>
        <title>Parameter Logic</title>
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
                                        <li class="breadcrumb-item active" aria-current="page">Parameter Logic</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-lg-6 col-5 text-right">
                                <a href="parameter_logic_form.php?method=create&idParameter=<?= $idParameter?>">
                                    <button class="btn-new-scorecard">
                                        <i class="far fa-plus-square" style="font-size: 18px; margin-right: 10px"></i> Add Logic
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
                                <h3 class="mb-0">
                                    <?php
                                        $sqlFetchParam = $conn->query("SELECT * FROM model_parameters WHERE id = $idParameter");
                                        $rowFetchParam = $sqlFetchParam->fetch_assoc();
                                        echo "<strong>Parameter </strong> - ".ucfirst($rowFetchParam['parameter']);
                                    ?>
                                </h3>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive py-4">
                                    <table class="table table-flush" id="logic_list">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Sequence</th>
                                                <th>Operator</th>
                                                <th>Start Value</th>
                                                <th>End Value</th>
                                                <th>Like Value</th>
                                                <th>Weight</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sqlFetchLogic = $conn->query("SELECT * FROM parameter_details WHERE id_model_parameter = $idParameter");
                                                while($rowFetchLogic = $sqlFetchLogic->fetch_assoc())
                                                {
                                                    ?>
                                                        <tr>
                                                            <td><?= $rowFetchLogic['sequence']?></td>
                                                            <td><?= $rowFetchLogic['operator']?></td>
                                                            <td><?= $rowFetchLogic['start_value']?></td>
                                                            <td><?= $rowFetchLogic['end_value']?></td>
                                                            <td><?= $rowFetchLogic['like_value']?></td>
                                                            <td><?= $rowFetchLogic['weight']?></td>
                                                            <td>
                                                                <a href="parameter_logic_form.php?method=edit&idParamDetails=<?= $rowFetchLogic['id']?>&idParameter=<?= $idParameter?>" class="btn btn-sm btn-info">Edit</a>
                                                                <a href="../action/logic.php?idParamDetails=<?= $rowFetchLogic['id']?>&idParameter=<?= $idParameter;?>&crud=delete" onclick="return confirm('Yakin mau menghapus data ini?')" class="btn btn-sm btn-danger">Delete</a>
                                                                <?php
                                                                    if($rowFetchLogic['id_reason_code'] == null or $rowFetchLogic['id_reason_code'] == '')
                                                                    {
                                                                        ?>
                                                                            <a href="reason_code_form.php?method=create&idLogic=<?= $rowFetchLogic['id']?>&idParameter=<?= $idParameter?>" class="btn btn-sm btn-facebook">Reason Code</a>
                                                                        <?php
                                                                    }
                                                                    else
                                                                    {
                                                                        ?>
                                                                            <a href="reason_code_form.php?method=edit&idLogic=<?= $rowFetchLogic['id']?>&idParameter=<?= $idParameter?>&idReason=<?= $rowFetchLogic['id_reason_code']?>" class="btn btn-sm btn-facebook"><span class="fas fa-check"></span> Reason Code</a>
                                                                        <?php
                                                                    }
                                                                ?>

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

        </div>
        <?php include "../partials/assets_js.php"?>
        <script>
            $("#logic_list").DataTable({
                ordering: false,
                language: {
                    paginate: {
                        previous: "<i class='fas fa-angle-left'>",
                        next: "<i class='fas fa-angle-right'>"
                    }
                }
            });
        </script>
    </body>
</html>
