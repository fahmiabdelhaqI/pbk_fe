<?php
    include "../config.php"; include "../session.php"; include "../config_postgre.php"; $idModel = $_GET['idModel']; $mode = $_GET['mode'];

    $sqlFetchModel = $conn->query("SELECT * FROM models WHERE id = $idModel");
    $rowFetchModel = $sqlFetchModel->fetch_assoc();
?>
<!doctype html>
<html lang="en">
    <head>
        <?php include "../partials/assets_css.php"?>
        <title>History Scoring</title>
        <style>
            .modal-body {
                overflow: auto;
            }
        </style>
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
                                <h6 class="h2 d-inline-block mb-0">Scoring Engine</h6>
                                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                    <ol class="breadcrumb breadcrumb-links">
                                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="scoring_engine.php">Scoring Engine</a></li>
                                        <li class="breadcrumb-item"><a href="#"><?= $rowFetchModel['nama']?></a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Scoring History</a></li>
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
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <?php
                                            if($mode == 'tradisional')
                                            {
                                                ?>
                                                    <h5 class="h3 mb-0"><strong>Scoring History (<?php echo $rowFetchModel['nama']." - Tradisional"?>)</strong></h5>
                                                <?php
                                            }
                                            else if($mode == 'ai')
                                            {
                                                ?>
                                                    <h5 class="h3 mb-0"><strong>Scoring History (<?php echo $rowFetchModel['nama']." - AI"?>)</strong></h5>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                    <h5 class="h3 mb-0"><strong>Scoring History (<?php echo $rowFetchModel['nama']." - BRE"?>)</strong></h5>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="col-4 text-right"></div>
                                </div>
                            </div>
                            <div class="table-responsive py-4">
                                <table class="table table-flush" id="history_scoring_list">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>DateTime</th>
                                            <th>Message ID</th>
                                            <?php
                                                if($rowFetchModel['nama'] == 'Telco' or $rowFetchModel['nama'] == "Test POC")
                                                {
                                                    ?>
                                                        <th>Phone Number</th>
                                                    <?php
                                                }
                                                else if($rowFetchModel['nama'] == 'Credit')
                                                {
                                                    ?>
                                                        <th>Full Name</th>
                                                    <?php
                                                }
                                                else if($rowFetchModel['nama'] == "E-Commerce")
                                                {
                                                    ?>
                                                        <th>Full Name</th>
                                                        <th>Phone No.</th>
                                                    <?php
                                                }
                                            ?>
                                            <th>Scoring Params</th>
                                            <th>Scoring Results</th>
                                            <th>Module</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if($mode == 'tradisional')
                                            {
                                                $modeDB = "tb";
                                            }
                                            else
                                            {
                                                $modeDB = $mode;
                                            }

                                            if($rowFetchModel['nama'] == 'Telco' or $rowFetchModel['nama'] == 'Test POC')
                                            {
                                                $dataset = "telco";
                                            }
                                            else if($rowFetchModel['nama'] == 'E-Commerce')
                                            {
                                                $dataset = "ecommerce";
                                            }
                                            else
                                            {
                                                $dataset = "credit";
                                            }


                                            $nomor = 1;
                                            foreach ($myPDO->query("SELECT * FROM scoring.scoring_param_results WHERE user_refference_id = '".$_SESSION['id_user']."' AND status = 'success' AND user_refference_id = '".$_SESSION['id_user']."' AND module = '$modeDB' AND dataset = '$dataset' ORDER BY end_datetime DESC LIMIT 10") as $itemHistoryScoring)
                                            {
                                                ?>
                                                    <tr>
                                                        <td><?= $itemHistoryScoring['end_datetime']?></td>
                                                        <td><?= $itemHistoryScoring['message_id']?></td>
                                                        <?php
                                                            if($rowFetchModel['nama'] == 'Telco' or $rowFetchModel['nama'] == "Test POC")
                                                            {
                                                                ?>
                                                                    <td>
                                                                        <?php
                                                                            $jsonDecodedScoreParam = json_decode($itemHistoryScoring['scoring_param'], true);
                                                                            echo $jsonDecodedScoreParam['phone_no'];
                                                                        ?>
                                                                    </td>
                                                                <?php
                                                            }
                                                            else if($rowFetchModel['nama'] == 'Credit')
                                                            {
                                                                ?>
                                                                    <td>
                                                                        <?php
                                                                            $jsonDecodedScoreParam = json_decode($itemHistoryScoring['scoring_param'], true);
                                                                            echo $jsonDecodedScoreParam['full_name'];
                                                                        ?>
                                                                    </td>
                                                                <?php
                                                            }
                                                            else if($rowFetchModel['nama'] == "E-Commerce")
                                                            {
                                                                $jsonDecodedScoreParam = json_decode($itemHistoryScoring['scoring_param'], true);
                                                                ?>
                                                                    <td><?= $jsonDecodedScoreParam['full_name']?></td>
                                                                    <td><?= $jsonDecodedScoreParam['phone']?></td>
                                                                <?php
                                                            }
                                                        ?>

                                                        <td>
                                                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-score-param-<?= $nomor++?>">View</button>
                                                            <!-- Modal Here -->
                                                            <div class="modal fade" id="modal-score-param-<?= $nomor++ - 1;?>">
                                                                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                                                    <div class="modal-content">

                                                                        <!-- Modal Header -->
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Score Params</h4>
                                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                        </div>
                                                                        <!-- Modal body -->
                                                                        <div class="modal-body">
                                                                            <form>
                                                                                <?php
                                                                                    $jsonDecoded = json_decode($itemHistoryScoring['scoring_param'], true);

                                                                                    if($rowFetchModel['nama'] == 'Telco' or $rowFetchModel['nama'] == 'Test POC')
                                                                                    {
                                                                                        ?>
                                                                                            <div class="form-row">
                                                                                                <div class="col-md-4 mb-3">
                                                                                                    <label class="form-control-label">Phone Number</label>
                                                                                                    <input type="text" class="form-control" value="<?= $jsonDecoded['phone_no']?>" readonly/>
                                                                                                </div>

                                                                                                <?php
                                                                                                    if(isset($jsonDecoded['intl_plan']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">International Plan</label>
                                                                                                                <input type="text" class="form-control" value="<?php if($jsonDecoded['intl_plan'] == 'y'){echo 'yes';}else{echo 'no';}?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['vmail_plan']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Voice Mail Plan</label>
                                                                                                                <input type="text" class="form-control" value="<?php if($jsonDecoded['vmail_plan'] == 'y'){echo 'yes';}else{echo 'no';}?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['vmail_message']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Voice Mail Message</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['vmail_message']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['day_mins']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Day Minutes</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['day_mins']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['day_calls']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Day Calls</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['day_calls']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['day_charge']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Day Charge</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['day_charge']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['eve_mins']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Evening Minutes</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['eve_mins']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['eve_calls']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Evening Calls</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['eve_calls']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['eve_charge']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Evening Charge</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['eve_charge']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['night_mins']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Night Minutes</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['night_mins']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['night_calls']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Night Calls</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['night_calls']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['night_charge']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Night Charge</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['night_charge']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['intl_mins']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">International Minutes</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['intl_mins']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['intl_calls']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">International Calls</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['intl_calls']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['intl_charge']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">International Charge</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['intl_charge']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['cust_serv_calls']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Customer Service Calls</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['cust_serv_calls']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }
                                                                                                ?>

                                                                                                <div class="col-md-4 mb-3">
                                                                                                    <label class="form-control-label">Basepoints</label>
                                                                                                    <input type="text" class="form-control" value="<?= $jsonDecoded['basepoints']?>" readonly/>
                                                                                                </div>
                                                                                            </div>
                                                                                        <?php
                                                                                    }
                                                                                    else if($rowFetchModel['nama'] == "Credit")
                                                                                    {
                                                                                        ?>
                                                                                            <div class="form-row">
                                                                                                <?php
                                                                                                    if(isset($jsonDecoded['nik']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">NIK</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['nik']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['full_name']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Full Name</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['full_name']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['phone']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Phone Number</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['phone']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['amt_credit']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Amount Credit</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['amt_credit']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['amt_goods_price']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Amount Good Price</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['amt_goods_price']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['good_price_to_credit_ratio']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Good Price to Credit Ratio</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['good_price_to_credit_ratio']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['days_birth']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Days Birth</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['days_birth']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['days_employed']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Days Employed</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['days_employed']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['days_id_publish']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Days ID Publish</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['days_id_publish']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['region_rating_client_w_city']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Region Rating Client with City</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['region_rating_client_w_city']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['ext_source_2']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">External Source 2</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['ext_source_2']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['ext_source_3']))
                                                                                                    {

                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">External Source 3</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['ext_source_3']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['max_days_credit']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Maximum Days Credit</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['max_days_credit']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['avg_days_enddate_fact']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Average Days End Date Fact</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['avg_days_enddate_fact']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['avg_amt_annuity_prev']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Average Amount Annuity Previous</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['avg_amt_annuity_prev']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['max_dp2gp_ratio']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Maximum DP2GP Ratio</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['max_dp2gp_ratio']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['max_rate_down_payment']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Maximum Rate Down Payment</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['max_rate_down_payment']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['count_approved_prev']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Count Approved Previous</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['count_approved_prev']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['count_refused_prev']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Count Refused Previous</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['count_refused_prev']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['avg_days_decision']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Average Days Decision</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['avg_days_decision']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['count_walkin_prod_type_prev']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Count Walkin' Production Type Previous</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['count_walkin_prod_type_prev']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['avg_days_first_drawing']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Average Days First Drawing</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['avg_days_first_drawing']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }
                                                                                                ?>
                                                                                            </div>
                                                                                        <?php
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        ?>
                                                                                            <div class="form-row">
                                                                                                <?php
                                                                                                    if(isset($jsonDecoded['cust_id']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Customer ID</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['cust_id']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['full_name']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Full Name</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['full_name']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['gender']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Gender</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['gender']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['date_of_birth']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Date of Birth</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['date_of_birth']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['phone']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Phone Number</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['phone']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['email']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Email</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['email']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['two_digit_zip_code_address']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Two Digit Zip Code Address</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['two_digit_zip_code_address']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['gbi']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">GBI</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['gbi']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['usia']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Age</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['usia']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['min_transaction_date']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Minimum Transaction Date</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['min_transaction_date']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['max_transaction_date']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Maximum Transaction Date</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['max_transaction_date']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['transaction_days']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Transaction Days</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['transaction_days']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['baby_products_count']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Baby Products Count</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['baby_products_count']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset( $jsonDecoded['clothes_product_count']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Clothes Product Count</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['clothes_product_count']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['cosmetics_product_count']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Cosmetics Product Count</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['cosmetics_product_count']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['elektronics_product_count']))
                                                                                                    {
                                                                                                        ?>
                                                                                                        <div class="col-md-4 mb-3">
                                                                                                            <label class="form-control-label">Electronics Product Count</label>
                                                                                                            <input type="text" class="form-control" value="<?= $jsonDecoded['elektronics_product_count']?>" readonly/>
                                                                                                        </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['food_product_count']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Food Product Count</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['food_product_count']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }


                                                                                                    if(isset($jsonDecoded['other_product_count']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Other Product Count</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['other_product_count']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['bank_tf_payment_count']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Bank Transfer Payment Count</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['bank_tf_payment_count']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['conv_store_payment_count']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Convenience Store Payment Count</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['conv_store_payment_count']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['cc_payment_count']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Credit Card Payment Count</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['cc_payment_count']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['ewallet_payment_count']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">E-Wallet Payment Count</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['ewallet_payment_count']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['other_payment_count']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Other Payment Count</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['other_payment_count']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['mobile_app_trans_device_count']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Mobile App Transaction Device Count</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['mobile_app_trans_device_count']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['web_browser_trans_device_count']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Web Browser Transaction Device Count</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['web_browser_trans_device_count']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['nondiscounted_product_count']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Non-Discounted Product Count</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['nondiscounted_product_count']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['discounted_product_count']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Discounted Product Count</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['discounted_product_count']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['sum_transaction_value']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Sum Transaction Value</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['sum_transaction_value']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['avg_transaction_value']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Average Transaction Value</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['avg_transaction_value']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['transaction_disc']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Transaction Discount</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['transaction_disc']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['baby_products_prop']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Baby Products Prop</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['baby_products_prop']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['clothes_products_prop']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Clothes Products Prop</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['clothes_products_prop']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['cosmetics_products_prop']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Cosmetics Products Prop</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['cosmetics_products_prop']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['elektronics_product_prop']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Electronics Product Prop</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['elektronics_product_prop']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['food_product_prop']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Food Product Prop</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['food_product_prop']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['other_product_prop']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Other Product Prop</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['other_product_prop']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['bank_tf_payment_prop']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Bank Transfer Payment Prop</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['bank_tf_payment_prop']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['conv_store_payment_prop']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Convenience Store Payment Prop</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['conv_store_payment_prop']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['cc_payment_prop']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Credit Card Payment Pro</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['cc_payment_prop']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['ewallet_payment_prop']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">E-Wallet Payment Prop</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['ewallet_payment_prop']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['other_payment_prop']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Other Payment Prop</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['other_payment_prop']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['mobile_app_trans_device_prop']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Mobile App Trans Device Prop</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['mobile_app_trans_device_prop']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['web_browser_trans_device_prop']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Web Browser Trans Device Prop</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['web_browser_trans_device_prop']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['nondiscounted_product_prop']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Non-Discounted Product Prop</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['nondiscounted_product_prop']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['discounted_product_prop']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Discounted Product Prop</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['discounted_product_prop']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['avg_baby_products']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Average Baby Products</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['avg_baby_products']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['avg_clothes_product']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Average Clothes Product</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['avg_clothes_product']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['avg_cosmetics_product']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Average Cosmetics Product</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['avg_cosmetics_product']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['avg_elektronics_product']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Average Electronics Product</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['avg_elektronics_product']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['avg_food_product']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Average Food Product</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['avg_food_product']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['avg_other_product']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Average Other Product</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['avg_other_product']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['avg_bank_tf_payment']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Average Bank Transfer Payment</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['avg_bank_tf_payment']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['avg_conv_store_payment']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Average Convenience Store Payment</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['avg_conv_store_payment']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['avg_cc_payment']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Average Credit Card Payment</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['avg_cc_payment']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['avg_ewallet_payment']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Average E-Waller Payment</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['avg_ewallet_payment']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['avg_other_payment']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Average Other Payment</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['avg_other_payment']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['avg_mobile_app_trans_device']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Average Mobile App Trans Device</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['avg_mobile_app_trans_device']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['avg_web_browser_trans_device']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Average Web Browser Trans Device</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['avg_web_browser_trans_device']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['avg_web_browser_trans_device']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Average Web Browser Trans Device</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['avg_web_browser_trans_device']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['avg_nondiscounted_product']))
                                                                                                    {
                                                                                                        ?>
                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                <label class="form-control-label">Average Non-Discounted Product</label>
                                                                                                                <input type="text" class="form-control" value="<?= $jsonDecoded['avg_nondiscounted_product']?>" readonly/>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }

                                                                                                    if(isset($jsonDecoded['avg_discounted_product']))
                                                                                                    {
                                                                                                        ?>
                                                                                                        <div class="col-md-4 mb-3">
                                                                                                            <label class="form-control-label">Average Discounted Product</label>
                                                                                                            <input type="text" class="form-control" value="<?= $jsonDecoded['avg_discounted_product']?>" readonly/>
                                                                                                        </div>
                                                                                                        <?php
                                                                                                    }
                                                                                                ?>
                                                                                            </div>
                                                                                        <?php
                                                                                    }
                                                                                ?>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
<!--                                                        <td>--><?//= $itemHistoryScoring['scoring_result']?><!--</td>-->
                                                        <td>
<!--                                                            <a href="reporting.php?idModel=--><?//= $idModel?><!--&messageID=--><?//= $itemHistoryScoring['message_id']?><!--" class="btn btn-sm btn-secondary">View</a>-->
                                                            <a target="_blank" href="reporting_2.php?idModel=<?= $idModel?>&messageID=<?= $itemHistoryScoring['message_id']?>" class="btn btn-sm btn-secondary">View</a>
                                                        </td>
                                                        <td><?= $itemHistoryScoring['module']?></td>
                                                        <td><?= ucfirst($itemHistoryScoring['status'])?></td>
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
            $("#history_scoring_list").DataTable({
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
