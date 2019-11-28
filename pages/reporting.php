<?php
    include "../config.php"; include "../session.php"; include "../config_postgre.php"; $idModel = $_GET['idModel']; $messageID = $_GET['messageID'];

    // Fetch Model
    $sqlFetchModel = $conn->query("SELECT * FROM models WHERE id = $idModel");
    $rowFetchModel = $sqlFetchModel->fetch_assoc();

?>
<!doctype html>
<html lang="en">
    <head>
        <?php include "../partials/assets_css.php";?>
        <title>Score Report</title>
        <!-- Custom CSS -->
        <link rel="stylesheet" href="../assets/vendor/donutchart/simple-donut.css"/>
        <script src="../assets/vendor/donutchart/simple-donut-jquery.js"></script>
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
                            <div class="col-lg-8 col-7">
                                <h6 class="h2 d-inline-block mb-0">Scoring Engine</h6>
                                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                    <ol class="breadcrumb breadcrumb-links">
                                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="scoring_engine.php">Scoring Engine</a></li>
                                        <li class="breadcrumb-item"><a href="#"><?= $rowFetchModel['nama']?></a></li>
                                        <li class="breadcrumb-item"><a href="#">Scoring History</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Scoring Report</a></li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-lg-4 col-5 text-right">
                                <a href="paper_report.php?idModel=<?= $idModel;?>&messageID=<?= $messageID;?>" class="btn btn-danger" target="_blank"><span class="fas fa-print"></span> Print</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid mt--6">
                <?php
                    $stmtFetchScore = $myPDO->prepare("SELECT * FROM scoring.scoring_param_results WHERE message_id = '$messageID'");
                    $stmtFetchScore->execute();
                    $row = $stmtFetchScore->fetch();

                    $jsonDecodedScoreParam = json_decode($row['scoring_param'], true);
                    $jsonDecodedScoreResult = json_decode($row['scoring_result'], true);

                ?>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="text-uppercase text-muted ls-1 mb-1">Phone Number</h6>
                                        <h5 class="h3 mb-0"><strong><?php echo $jsonDecodedScoreParam['phone_no'];?></strong></h5>
                                    </div>
                                    <div class="col-4 text-right"></div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <h2>
                                            <?php
                                                if($row['module'] == 'ai')
                                                {
                                                    echo "AI";
                                                }
                                                else if($row['module'] == 'bre')
                                                {
                                                    echo "BRE";
                                                }
                                                else
                                                {
                                                    echo "Traditional";
                                                }

                                                echo " - "
                                            ?>
                                            <?php
                                                if($row['dataset'] == 'telco')
                                                {
                                                    echo "Telco";
                                                }

                                                echo " Scoring";
                                            ?>
                                        </h2>
                                    </div>
                                    <div class="col-xl-4">
                                        <?php
                                            if($row['module'] == 'tb' or $row['module'] == 'ai' or $row['module'] == 'bre')
                                            {
                                                ?>
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h3 class="mb-0 text-center"><strong>Credit Score</strong></h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <?php
                                                                if($row['module'] == 'bre')
                                                                {
                                                                    ?>
                                                                        <h1 class="mb-0 text-center"><?= floor(($jsonDecodedScoreResult['basepoints']));?></h1>
                                                                    <?php
                                                                }
                                                                else
                                                                {
                                                                    ?>
                                                                        <h1 class="mb-0 text-center"><?= floor(($jsonDecodedScoreResult['score']));?></h1>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="h3 mb-0 text-center"><strong>Percentage</strong></h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div id="scoreGraphic" class="donut-size">
                                                                <div class="pie-wrapper">
                                                                        <span class="label">
                                                                            <?php
                                                                                if($row['module'] == 'tb')
                                                                                {
                                                                                    ?>
                                                                                        <span class="num"><?= floor(($jsonDecodedScoreResult['score'] / 900) * 100);?></span><span class="smaller">%</span>
                                                                                    <?php
                                                                                }
                                                                                else if($row['module'] == 'bre')
                                                                                {
                                                                                    ?>
                                                                                        <span class="num"><?= floor(($jsonDecodedScoreResult['basepoints'] / 900) * 100);?></span><span class="smaller">%</span>
                                                                                    <?php
                                                                                }
                                                                                else
                                                                                {
                                                                                    ?>
                                                                                        <span class="num"><?= floor(100 - ($jsonDecodedScoreResult['prob_default']));?></span><span class="smaller">%</span>
                                                                                    <?php
                                                                                }
                                                                            ?>

                                                                        </span>
                                                                    <div class="pie">
                                                                        <div class="left-side half-circle"></div>
                                                                        <div class="right-side half-circle"></div>
                                                                    </div>
                                                                    <div class="shadow"></div>
                                                                </div>
                                                                <center>
                                                                    <p id="grading" style="margin-top: 30px; font-weight: bold; font-size: 18pt"></p>
                                                                </center>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="col-xl-8">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="h3 mb-0 text-left"><strong>Summaries</strong></h5>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-bordered">
                                                    <?php
                                                        if($row['module'] == 'ai')
                                                        {
                                                            ?>
                                                                <tr>
                                                                    <td><strong>Description</strong></td>
                                                                    <td>:</td>
                                                                    <td><?= $jsonDecodedScoreResult['grade']['description']?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Grade</strong></td>
                                                                    <td>:</td>
                                                                    <td><?= $jsonDecodedScoreResult['grade']['grade']?></td>
                                                                </tr>
                                                            <?php
                                                        }
                                                        else if($row['module'] == 'tb')
                                                        {
                                                            ?>
                                                                <tr>
                                                                    <td><strong>Description</strong></td>
                                                                    <td>:</td>
                                                                    <td><?= $jsonDecodedScoreResult['grade']['description']?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Grade</strong></td>
                                                                    <td>:</td>
                                                                    <td><?= $jsonDecodedScoreResult['grade']['grade']?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Score</strong></td>
                                                                    <td>:</td>
                                                                    <td><?= $jsonDecodedScoreResult['score']?></td>
                                                                </tr>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                                <tr>
                                                                    <td>Night Charge per Second</td>
                                                                    <td>:</td>
                                                                    <td><?= $jsonDecodedScoreResult['night_charge_per_second']?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>International Minutes per Minute</td>
                                                                    <td>:</td>
                                                                    <td><?= $jsonDecodedScoreResult['intl_charge_per_mins']?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Evening Minutes</td>
                                                                    <td>:</td>
                                                                    <td><?= $jsonDecodedScoreResult['eve_mins']?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Evening Charges per Second</td>
                                                                    <td>:</td>
                                                                    <td><?= $jsonDecodedScoreResult['eve_charge_per_second']?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Night Calls</td>
                                                                    <td>:</td>
                                                                    <td><?= $jsonDecodedScoreResult['night_calls']?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Day Minutes</td>
                                                                    <td>:</td>
                                                                    <td><?= $jsonDecodedScoreResult['day_mins']?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Voice Mail Message</td>
                                                                    <td>:</td>
                                                                    <td><?= $jsonDecodedScoreResult['vmail_message']?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>International Plan</td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        <?php
                                                                            if($jsonDecodedScoreResult['intl_plan'] == "n")
                                                                            {
                                                                                echo "No";
                                                                            }
                                                                            else
                                                                            {
                                                                                echo "Yes";
                                                                            }
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Customer Service Calls</td>
                                                                    <td>:</td>
                                                                    <td><?= $jsonDecodedScoreResult['cust_serv_calls']?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Day Charge per Second</td>
                                                                    <td>:</td>
                                                                    <td><?= $jsonDecodedScoreResult['day_charge_per_second']?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Evening Calls</td>
                                                                    <td>:</td>
                                                                    <td><?= $jsonDecodedScoreResult['eve_calls']?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>International Calls</td>
                                                                    <td>:</td>
                                                                    <td><?= $jsonDecodedScoreResult['intl_calls']?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Day Calls</td>
                                                                    <td>:</td>
                                                                    <td><?= $jsonDecodedScoreResult['day_calls']?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Night Charge per Second</td>
                                                                    <td>:</td>
                                                                    <td><?= $jsonDecodedScoreResult['night_charge_per_second']?></td>
                                                                </tr>
                                                            <?php
                                                        }
                                                    ?>

                                                </table>
                                            </div>
                                        </div>

                                        <?php
                                            if($row['module'] == 'ai' or $row['module'] == 'tb')
                                            {
                                                ?>
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="h3 mb-0 text-left"><strong>Explanation</strong></h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <table class="table table-bordered">
                                                                <?php
                                                                if($row['module'] == 'ai')
                                                                {
                                                                    foreach ($jsonDecodedScoreResult['explanation'] as $rowExplanation)
                                                                    {
                                                                        ?>
                                                                            <tr>
                                                                                <td><?= getParamsLengkapTelco($rowExplanation['criteria'])?></td>
                                                                                <td>:</td>
                                                                                <td><?= $rowExplanation['value']?></td>
                                                                            </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                                else if($row['module'] == 'tb')
                                                                {
                                                                    echo "<strong style='margin-bottom: 30px'>Reason Code</strong>";
                                                                    foreach ($jsonDecodedScoreResult['reason'] as $rowExplanation)
                                                                    {
                                                                        ?>
                                                                            <tr>
                                                                                <td><?= $rowExplanation['code']?></td>
                                                                                <td>:</td>
                                                                                <td><?= $rowExplanation['reason']?></td>
                                                                            </tr>
                                                                        <?php
                                                                    }
                                                                }

                                                                ?>
                                                            </table>
                                                        </div>
                                                    </div>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include "../partials/assets_js.php";?>
        <script>
            function colorRatingScore(element, percent) {
                if(percent > 80 && percent <= 100) {
                    $(element).css('color', '#006602');
                    $(element).text('Sangat Yakin');
                }
                else if(percent > 60 && percent <= 80) {
                    $(element).css('color', '#00A303');
                    $(element).text('Cukup Yakin');
                }
                else if(percent > 40 && percent <= 60) {
                    $(element).css('color', '#E0A500');
                    $(element).text('Dipertimbangkan');
                }
                else if(percent > 20 && percent <= 40) {
                    $(element).css('color', '#E00000');
                    $(element).text('Kurang Yakin');
                }
                else {
                    $(element).css('color', '#b30000');
                    $(element).text('Meragukan');
                }
            }

            $(document).ready(function () {
                <?php
                    if($row['module'] == 'tb')
                    {
                        ?>
                            updateDonutChart("#scoreGraphic", <?= floor(($jsonDecodedScoreResult['score'] / 900) * 100);?>, true);
                            colorRatingScore("#grading", <?= floor(($jsonDecodedScoreResult['score'] / 900) * 100);?>);
                        <?php
                    }
                    else if($row['module'] == 'bre')
                    {
                        ?>
                            updateDonutChart("#scoreGraphic", <?= floor(($jsonDecodedScoreResult['basepoints'] / 900) * 100);?>, true);
                            colorRatingScore("#grading", <?= floor(($jsonDecodedScoreResult['basepoints'] / 900) * 100);?>);
                        <?php
                    }
                    else
                    {
                        ?>
                            updateDonutChart("#scoreGraphic", <?= floor(100 - ($jsonDecodedScoreResult['prob_default']))?>, true);
                            colorRatingScore("#grading", <?= floor(100 - ($jsonDecodedScoreResult['prob_default']))?>);
                        <?php
                    }
                ?>

            });
        </script>
    </body>
</html>
