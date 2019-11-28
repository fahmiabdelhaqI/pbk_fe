<?php
    include "../config.php"; include "../config_postgre.php"; include "../session.php"; $idModel = $_GET['idModel']; $messageID = $_GET['messageID'];

    $sqlFetchModel = $conn->query("SELECT * FROM models WHERE id = $idModel");
    $rowFetchModel = $sqlFetchModel->fetch_assoc();

    $stmtFetchScore = $myPDO->prepare("SELECT * FROM scoring.scoring_param_results WHERE message_id = '$messageID'");
    $stmtFetchScore->execute();
    $row = $stmtFetchScore->fetch();

    $jsonDecodedScoreParam = json_decode($row['scoring_param'], true);
    $jsonDecodedScoreResult = json_decode($row['scoring_result'], true);
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Print Report</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link href="../assets/css/invoice.css" rel="stylesheet"/>
        <link rel="stylesheet" href="../assets/vendor/donutchart/simple-donut.css"/>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="../assets/vendor/donutchart/simple-donut-jquery.js"></script>
        <!-- Gauge JS -->
        <script src="../assets/vendor/gauge_chart/gauge.min.js"></script>
        <script src="../assets/vendor/gauge_chart/Chart.LinearGauge.js"></script>
        <style>
            td {
                font-size: 18px;
            }
        </style>
    </head>
    <body>
        <div id="invoice">
            <div class="invoice overflow-auto">
                <div style="min-width: 600px">
                    <header>
                        <div class="row">
                            <div class="col">
                                <a target="_blank" href="https://www.idscore.id/">
                                    <img src="https://www.idscore.id/assets/frontend/img/pefindologo.png" data-holder-rendered="true" />
                                </a>
                            </div>
                            <div class="col company-details">
                                <h2 class="name">
                                    PT. PEFINDO Biro Kredit
                                </h2>
                                <div style="font-size: 10pt">Gedung AD Premier, Lantai 2</div>
                                <div style="font-size: 10pt">Jl. TB Simatupang No.5, Ragunan, Ps. Minggu,</div>
                                <div style="font-size: 10pt">Jakarta Selatan, DKI Jakarta 12550</div>
                            </div>
                        </div>
                    </header>
                    <main>
                        <center>
                            <h2 style="margin-bottom: 70px"><strong><u>SCORING REPORT</u></strong></h2>
                        </center>
                        <h3 style="margin-bottom: 20px">
                            <strong>
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
                                    echo $rowFetchModel['nama']." Scoring";
                                ?>
                            </strong>
                        </h3>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <?php
                                            if($rowFetchModel['nama'] == "Telco" or $rowFetchModel['nama'] == "Test POC")
                                            {
                                                ?>
                                                    <tr>
                                                        <td><strong>Phone Number</strong></td>
                                                        <td>:</td>
                                                        <td><?= $jsonDecodedScoreParam['phone_no']?></td>
                                                    </tr>
                                                <?php
                                            }
                                            else if($rowFetchModel['nama'] == "Credit")
                                            {
                                                ?>
                                                    <tr>
                                                        <td><strong>NIK</strong></td>
                                                        <td>:</td>
                                                        <td><?php echo $jsonDecodedScoreParam['nik'];?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Nama Lengkap</strong></td>
                                                        <td>:</td>
                                                        <td><?= $jsonDecodedScoreParam['full_name'];?></td>
                                                    </tr>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                    <tr>
                                                        <td><strong>Nama Lengkap</strong></td>
                                                        <td>:</td>
                                                        <td><?php echo $jsonDecodedScoreParam['full_name'];?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Nomor Telepon</strong></td>
                                                        <td>:</td>
                                                        <td><?= $jsonDecodedScoreParam['phone'];?></td>
                                                    </tr>
                                                <?php
                                            }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td><strong><center>Basepoints</center></strong></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <center>
                                                    <canvas height="180" id="basepoint_chart"></canvas>
                                                    <h1 class="text-center" id="preview-textfield"></h1>
                                                    <span class="text-center" id="grading" style="font-weight: bold; font-size: 18pt"></span>
                                                </center>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <?php
                                    if($row['module'] != "bre")
                                    {
                                        ?>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td>
                                                            <strong>
                                                                <center> Prob.
                                                                    <?php
                                                                    if($rowFetchModel['nama'] == "Telco")
                                                                    {
                                                                        if($row['module'] == 'tb')
                                                                        {
                                                                            echo "to Pay";
                                                                        }
                                                                        else
                                                                        {
                                                                            echo "to Default";
                                                                        }
                                                                    }
                                                                    else
                                                                    {
                                                                        echo "to Pay";
                                                                    }
                                                                    ?>
                                                                </center>
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <center>
                                                                <div id="probdefault_chart" class="donut-size">
                                                                    <div class="pie-wrapper">
                                                                <span class="label">
                                                                    <span class="num"><?= floor($jsonDecodedScoreResult['prob_default'])?></span><span class="smaller">%</span>
                                                                </span>
                                                                        <div class="pie">
                                                                            <div class="left-side half-circle"></div>
                                                                            <div class="right-side half-circle"></div>
                                                                        </div>
                                                                        <div class="shadow"></div>
                                                                    </div>
                                                                    <p class="text-center" id="grading2" style="margin-top: 10px; font-weight: bold; font-size: 18pt"></p>
                                                                </div>
                                                            </center>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        <?php
                                    }
                                ?>
                            </div>
                            <div class="col-sm-7">
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="3">
                                            <strong>
                                                <span style="margin-bottom: 20px"><center>Summaries</center></span>
                                            </strong>
                                        </td>
                                    </tr>
                                    <?php
                                        if($row['module'] == 'ai' or $row['module'] == 'tb')
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
                                        else
                                        {
                                            if($rowFetchModel['nama'] == "Telco" or $rowFetchModel['nama'] == "Test POC")
                                            {
                                                if(isset($jsonDecodedScoreResult['night_charge_per_second']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Night Charge per Second</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['night_charge_per_second']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['intl_charge_per_mins']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>International Minutes per Minute</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['intl_charge_per_mins']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['eve_mins']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Evening Minutes</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['eve_mins']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['eve_charge_per_second']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Evening Charges per Second</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['eve_charge_per_second']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['night_calls']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Night Calls</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['night_calls']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['day_mins']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Day Minutes</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['day_mins']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['vmail_message']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Voice Mail Message</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['vmail_message']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['intl_plan']))
                                                {
                                                    ?>
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
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['cust_serv_calls']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Customer Service Calls</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['cust_serv_calls']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['day_charge_per_second']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Day Charge per Second</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['day_charge_per_second']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['eve_calls']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Evening Calls</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['eve_calls']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['intl_calls']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>International Calls</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['intl_calls']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['day_calls']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Day Calls</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['day_calls']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['night_charge_per_second']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Night Charge per Second</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['night_charge_per_second']?></td>
                                                        </tr>
                                                    <?php
                                                }
                                            }
                                            else if($rowFetchModel['nama'] == "E-Commerce")
                                            {
                                                if(isset($jsonDecodedScoreResult['avg_web_browser_trans_device']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Average Web Browser Trans Device</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['avg_web_browser_trans_device'];?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['avg_nondiscounted_product']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Average Non-Discounted Product</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['avg_nondiscounted_product'];?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['avg_mobile_app_trans_device']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Average Mobile App Transaction Device</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['avg_mobile_app_trans_device'];?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['avg_other_payment']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Average Other Payment</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['avg_other_payment'];?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['sum_transaction_value']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Sum Transaction Value</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['sum_transaction_value'];?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['avg_ewallet_payment']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Average E-Wallet Payment</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['avg_ewallet_payment'];?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['cosmetics_product_count']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Cosmetics Product Count</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['cosmetics_product_count'];?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['avg_cc_payment']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Average Credit Card Payment</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['avg_cc_payment'];?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['avg_cosmetics_product']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Average Cosmetics Product</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['avg_cosmetics_product'];?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['elektronics_product_count']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Electronics Product Count</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['elektronics_product_count'];?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['avg_transaction_value']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Average Transaction Value</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['avg_transaction_value'];?></td>
                                                        </tr>
                                                    <?php
                                                }
                                                if(isset($jsonDecodedScoreResult['avg_conv_store_payment']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Average Convenience Store Payment</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['avg_conv_store_payment'];?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['transaction_disc']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Transaction Discount</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['transaction_disc'];?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['avg_food_product']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Average Food Product</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['avg_food_product'];?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['avg_bank_tf_payment']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Average Bank Transfer Payment</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['avg_bank_tf_payment'];?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['avg_discounted_product']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Average Discounted Product</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['avg_discounted_product'];?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['mobile_app_trans_device_count']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Mobile App Transaction Device Count</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['mobile_app_trans_device_count'];?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['avg_baby_products']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Average Baby Products</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['avg_baby_products'];?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['avg_clothes_product']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Average Clothes Product</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['avg_clothes_product'];?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['avg_other_product']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Average Other Product</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['avg_other_product'];?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['avg_elektronics_product']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Average Electronics Product</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['avg_elektronics_product'];?></td>
                                                        </tr>
                                                    <?php
                                                }
                                            }
                                            else
                                            {

                                                if(isset($jsonDecodedScoreResult['days_employed']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Days Employed</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['days_employed']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['days_id_publish']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Days ID Publish</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['days_id_publish']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['amt_goods_price']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Amount Goods Price</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['amt_goods_price']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['avg_days_decision']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Average Days Decision</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['avg_days_decision']?></td>
                                                        </tr>
                                                    <?php
                                                }
                                                if(isset($jsonDecodedScoreResult['amt_goods_price']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Amount Goods Price</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['amt_goods_price']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['avg_days_enddate_fact']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Average Days End Date Fact</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['avg_days_enddate_fact']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['avg_amt_annuity_prev']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Average Amount Annuity Previous</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['avg_amt_annuity_prev']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['days_birth']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Days Birth</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['days_birth']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['max_days_credit']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Maximum Days Credit</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['max_days_credit']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['avg_days_first_drawing']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Average Days First Drawing</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['avg_days_first_drawing']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['amt_credit']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Amount Credit</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['amt_credit']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['ext_source_2']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>External Source 2</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['ext_source_2']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['ext_source_3']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>External Source 3</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['ext_source_3']?></td>
                                                        </tr>
                                                    <?php
                                                }

                                                if(isset($jsonDecodedScoreResult['good_price_to_credit_ratio']))
                                                {
                                                    ?>
                                                        <tr>
                                                            <td>Good Price to Credit Ratio</td>
                                                            <td>:</td>
                                                            <td><?= $jsonDecodedScoreResult['good_price_to_credit_ratio']?></td>
                                                        </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                    ?>
                                </table>

                                <?php
                                    if($row['module'] == 'tb')
                                    {
                                        ?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td colspan="3">
                                                        <strong>
                                                            <span style="margin-bottom: 20px"><center>Reason Code</center></span>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <?php
                                                    if(count($jsonDecodedScoreResult['reason']) == 0)
                                                    {
                                                        ?>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <h5 class="h3 mb-0 text-center">No reason code available</h5>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                    }
                                                    else
                                                    {
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
                                        <?php
                                    }
                                    else if($row['module'] == 'ai')
                                    {
                                        ?>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td colspan="3">
                                                        <strong>
                                                            <span style="margin-bottom: 20px"><center>Explanation</center></span>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <?php
                                                    if($rowFetchModel['nama'] == "Telco" or $rowFetchModel['nama'] == "Test POC")
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
                                                    else if($rowFetchModel['nama'] == "Credit")
                                                    {
                                                        foreach ($jsonDecodedScoreResult['explanation'] as $rowExplanation)
                                                        {
                                                            ?>
                                                                <tr>
                                                                    <td><?= getParamsLengkapCredit($rowExplanation['criteria'])?></td>
                                                                    <td>:</td>
                                                                    <td><?= $rowExplanation['value']?></td>
                                                                </tr>
                                                            <?php
                                                        }
                                                    }
                                                    else
                                                    {
                                                        foreach ($jsonDecodedScoreResult['explanation'] as $rowExplanation)
                                                        {
                                                            ?>
                                                                <tr>
                                                                    <td><?= getParamsLengkapECommerce($rowExplanation['criteria'])?></td>
                                                                    <td>:</td>
                                                                    <td><?= $rowExplanation['value']?></td>
                                                                </tr>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                            </table>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
        <script>
            var randomScalingFactor = function(k) {
                return Math.round(Math.random() * k)
            };

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

            //Based on Prob. Default
            function colorRatingKebalikanScore(element, percent) {
                if(percent > 80 && percent <= 100) {
                    $(element).css('color', '#b30000');
                    $(element).text('Meragukan');
                }
                else if(percent > 60 && percent <= 80) {
                    $(element).css('color', '#E00000');
                    $(element).text('Kurang Yakin');
                }
                else if(percent > 40 && percent <= 60) {
                    $(element).css('color', '#E0A500');
                    $(element).text('Dipertimbangkan');
                }
                else if(percent > 20 && percent <= 40) {
                    $(element).css('color', '#00A303');
                    $(element).text('Cukup Yakin');
                }
                else {
                    $(element).css('color', '#006602');
                    $(element).text('Sangat Yakin');
                }
            }

            //Based on Prob. Default
            function colorRatingAIBasePoint(element, score) {
                if(score >= 0 && score <= 20) {
                    $(element).css('color', '#006602');
                    $(element).text('Very Low Risk');
                }
                else if(score >= 21 && score <= 40) {
                    $(element).css('color', '#00A303');
                    $(element).text('Low Risk');
                }
                else if(score >= 41 && score <= 60) {
                    $(element).css('color', '#E0A500');
                    $(element).text('Average Risk');
                }
                else if(score >= 61 && score <= 80) {
                    $(element).css('color', '#E00000');
                    $(element).text('High Risk');
                }
                else {
                    $(element).css('color', '#b30000');
                    $(element).text('Very High Risk');
                }
            }

            function colorRatingBRE(element, score) {
                if(score >= 721 && score <= 900) {
                    $(element).css('color', '#006602');
                    $(element).text('Very Low Risk');
                }
                else if(score >= 541 && score <= 720) {
                    $(element).css('color', '#00A303');
                    $(element).text('Low Risk');
                }
                else if(score >= 361 && score <= 540) {
                    $(element).css('color', '#E0A500');
                    $(element).text('Average Risk');
                }
                else if(score >= 180 && score <= 360) {
                    $(element).css('color', '#E00000');
                    $(element).text('High Risk');
                }
                else {
                    $(element).css('color', '#b30000');
                    $(element).text('Very High Risk');
                }
            }

            // Berlaku juga untuk AI
            function colorRatingTradisional(element, score) {
                if(score > 770 && score <= 900) {
                    $(element).css('color', '#006602');
                    $(element).text('Very Low Risk');
                }
                else if(score > 640 && score <= 769) {
                    $(element).css('color', '#00A303');
                    $(element).text('Low Risk');
                }
                else if(score > 510 && score <= 639) {
                    $(element).css('color', '#E0A500');
                    $(element).text('Average Risk');
                }
                else if(score > 380 && score <= 509) {
                    $(element).css('color', '#E00000');
                    $(element).text('High Risk');
                }
                else {
                    $(element).css('color', '#b30000');
                    $(element).text('Very High Risk');
                }
            }

            demoGauge = new Gauge(document.getElementById("basepoint_chart"));
            var opts = {
                angle: -0.25,
                lineWidth: 0.2,
                radiusScale:0.9,
                pointer: {
                    length: 0.6,
                    strokeWidth: 0.05,
                    color: '#000000'
                },
                staticLabels: {
                    font: "10px sans-serif",
                    <?php
                        if($row['module'] == 'bre' or $row['module'] == 'tb')
                        {
                            ?>
                                labels: [0, 180, 361, 541, 721, 900], /* Penamaan label dari minimal */
                                // labels: ['E', 'D', 'C', 'B', 'A'], /* Penamaan label dari minimal */
                            <?php
                        }
                        else if($row['module'] == 'ai')
                        {
                            ?>
                                labels: [0, 361, 541, 721, 900], /* Penamaan label dari minimal */
                            <?php
                        }
                    ?>
                    fractionDigits: 0
                },
                staticZones: [
                    <?php
                        if($row['module'] == 'bre')
                        {
                            ?>
                                {strokeStyle: "#b30000", min: 0, max: 180},
                                {strokeStyle: "#e00000", min: 181, max: 360},
                                {strokeStyle: "#e0a500", min: 361, max: 540},
                                {strokeStyle: "#00a303", min: 541, max: 720},
                                {strokeStyle: "#006602", min: 721, max: 900}
                            <?php
                        }
                        else if($row['module'] == 'ai' or $row['module'] == 'tb')
                        {
                            ?>
                                {strokeStyle: "#b30000", min: 0, max: 379},
                                {strokeStyle: "#e00000", min: 380, max: 509},
                                {strokeStyle: "#e0a500", min: 510, max: 639},
                                {strokeStyle: "#00a303", min: 640, max: 769},
                                {strokeStyle: "#006602", min: 770, max: 900}
                            <?php
                        }
                    ?>
                ],
                limitMax: false,
                limitMin: false,
                highDpiSupport: true
            };
            demoGauge.setOptions(opts);
            demoGauge.setTextField(document.getElementById("preview-textfield"));
            demoGauge.minValue = 0;
            demoGauge.maxValue = 900;

            <?php
                if($row['module'] == 'bre')
                {
                    ?>
                        demoGauge.set(<?= floor($jsonDecodedScoreResult['basepoints']);?>);
                        colorRatingBRE("#grading", <?= floor($jsonDecodedScoreResult['basepoints']);?>);
                    <?php
                }
                else if ($row['module'] == 'ai')
                {
                    if($rowFetchModel['nama'] == "Telco")
                    {
                        ?>
                            demoGauge.set(<?= floor($jsonDecodedScoreResult['score']);?>);
                            colorRatingAIBasePoint("#grading", <?= floor(($jsonDecodedScoreResult['score'] - 250) / (900 - 250) * 100);?>);

                            updateDonutChart("#probdefault_chart", <?= floor($jsonDecodedScoreResult['prob_default'])?>, true);
                            colorRatingKebalikanScore('#grading2', <?= floor($jsonDecodedScoreResult['prob_default'])?>);
                        <?php
                    }
//                    else if($rowFetchModel['nama'] == "Credit" or $rowFetchModel['nama'] == "E-Commerce")
                    else
                    {
                        ?>
                            demoGauge.set(<?= floor($jsonDecodedScoreResult['score']);?>);
                            colorRatingTradisional("#grading", <?= floor($jsonDecodedScoreResult['score']);?>);

                            updateDonutChart("#probdefault_chart", <?= floor(100 - ($jsonDecodedScoreResult['prob_default']))?>, true);
                            colorRatingKebalikanScore('#grading2', <?= floor($jsonDecodedScoreResult['prob_default'])?>);
                        <?php
                    }
                }
                else
                {
                    ?>
                        demoGauge.set(<?= floor($jsonDecodedScoreResult['score']);?>);
                        colorRatingTradisional("#grading", <?= floor($jsonDecodedScoreResult['score']);?>);

                        updateDonutChart("#probdefault_chart", <?= 100 - (floor($jsonDecodedScoreResult['prob_default']))?>, true);
                        colorRatingKebalikanScore('#grading2', <?= floor($jsonDecodedScoreResult['prob_default'])?>);
                    <?php
                }
            ?>
        </script>
    </body>
</html>