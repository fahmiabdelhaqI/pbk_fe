<?php include "../config.php"; include "../session.php"; $method = $_GET['method']; $idParameter = $_GET['idParameter'];?>
<!doctype html>
<html lang="en">
    <head>
        <?php include "../partials/assets_css.php";?>
        <title>Model Parameter <?php if($method == 'edit'){echo "Edit";}else{echo "Add";}?></title>
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
                                        <li class="breadcrumb-item"><a href="parameter_logic.php?idParameter=<?= $idParameter?>">Parameter</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Parameter Logic Form</li>
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
                        <h3 class="mb-0">Form <?php if($method == 'create'){echo 'Add';}else{echo 'Edit';}?> Parameter Logic</h3>
                    </div>
                    <div class="card-body">
                        <?php
                            if($method == 'create')
                            {
                                ?>
                                    <form action="../action/logic.php?crud=create&idParameter=<?= $idParameter?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8" data-toggle="validator" role="form">
                                        <div class="form-row">
                                            <div class="col-md-1 mb-3">
                                                <label class="form-control-label">Sequence</label>
                                                <input type="text" class="form-control" name="sequence[]" id="sequence" required/>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-control-label">Operator</label>
<!--                                                <input type="text" class="form-control" name="operator[]" id="operator" required/>-->
                                                <select id="operator" class="form-control" name="operator[]" required>
                                                    <option>--- Pilih salah satu ---</option>
                                                    <option value="LESS THAN">LESS THAN</option>
                                                    <option value="LESS THAN EQUAL">LESS THAN EQUAL</option>
                                                    <option value="EQUAL">EQUAL</option>
                                                    <option value="GREATER THAN">GREATER THAN</option>
                                                    <option value="GREATER THAN EQUAL">GREATER THAN EQUAL</option>
                                                    <option value="BETWEEN">BETWEEN</option>
                                                    <option value="LIKE">LIKE</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-control-label">Start Value</label>
                                                <input type="text" class="form-control" name="start_value[]" id="start_value"/>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-control-label">End Value</label>
                                                <input type="text" class="form-control" name="end_value[]" id="end_value"/>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-control-label">Like Value</label>
                                                <input type="text" class="form-control" name="like_value[]" id="like_value"/>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-control-label">Weight Point</label>
                                                <input type="text" class="form-control" name="weight[]" id="weight" required/>
                                            </div>
                                            <div class="col-md-1 mb-3">
                                                <label class="form-control-label" style="margin-top: 50px"></label>
                                                <button type="button" id="button_add_form" class="btn btn-danger btn-icon-only rounded-circle">
                                                    <i class="fa fa-plus-square"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="insert-form"></div>
                                        <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <center>
                                                    <input type="submit" class="btn" style="background: #FF3860; color: white" value="CREATE" onclick="return confirm('Yakin data sudah benar?')"/>
                                                    <a href="parameter_logic.php?idParameter=<?= $idParameter?>" class="btn btn-white" onclick="return confirm('Yakin membatalkan pengubahan ini?')">CANCEL</a>
                                                </center>
                                            </div>
                                        </div>
                                    </form>
                                <?php
                            }
                            else
                            {
                                $idParamDetails = $_GET['idParamDetails'];
                                $sqlFetchParamDetails = $conn->query("SELECT * FROM parameter_details WHERE id = $idParamDetails");
                                $rowFetchParamDetails = $sqlFetchParamDetails->fetch_assoc();
                                ?>
                                    <form action="../action/logic.php?crud=edit&idParamDetails=<?= $idParamDetails?>&idParameter=<?= $idParameter;?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8" data-toggle="validator" role="form">
                                        <div class="form-row">
                                            <div class="col-md-2 mb-3">
                                                <label class="form-control-label">Sequence</label>
                                                <input type="text" class="form-control" name="sequence" id="sequence" value="<?= $rowFetchParamDetails['sequence']?>" required/>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-control-label">Operator</label>
                                                <select id="operator" class="form-control" name="operator" required>
                                                    <option>--- Pilih salah satu ---</option>
                                                    <option <?php if($rowFetchParamDetails['operator'] == 'LESS THAN'){echo 'selected';}?> value="LESS THAN">LESS THAN</option>
                                                    <option <?php if($rowFetchParamDetails['operator'] == 'LESS THAN EQUAL'){echo 'selected';}?> value="LESS THAN EQUAL">LESS THAN EQUAL</option>
                                                    <option <?php if($rowFetchParamDetails['operator'] == 'EQUAL'){echo 'selected';}?> value="EQUAL">EQUAL</option>
                                                    <option <?php if($rowFetchParamDetails['operator'] == 'GREATER THAN'){echo 'selected';}?> value="GREATER THAN">GREATER THAN</option>
                                                    <option <?php if($rowFetchParamDetails['operator'] == 'GREATER THAN EQUAL'){echo 'selected';}?> value="GREATER THAN EQUAL">GREATER THAN EQUAL</option>
                                                    <option <?php if($rowFetchParamDetails['operator'] == 'BETWEEN'){echo 'selected';}?> value="BETWEEN">BETWEEN</option>
                                                    <option <?php if($rowFetchParamDetails['operator'] == 'LIKE'){echo 'selected';}?> value="LIKE">LIKE</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-control-label">Start Value</label>
                                                <input type="text" class="form-control" name="start_value" id="start_value" value="<?= $rowFetchParamDetails['start_value']?>"/>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-control-label">End Value</label>
                                                <input type="text" class="form-control" name="end_value" id="end_value" value="<?= $rowFetchParamDetails['end_value']?>"/>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-control-label">Like Value</label>
                                                <input type="text" class="form-control" name="like_value" id="like_value" value="<?= $rowFetchParamDetails['like_value']?>"/>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-control-label">Weight Point</label>
                                                <input type="text" class="form-control" name="weight" id="weight" value="<?= $rowFetchParamDetails['weight']?>" required/>
                                            </div>
<!--                                            <div class="col-md-1 mb-3">-->
<!--                                                <label class="form-control-label" style="margin-top: 50px"></label>-->
<!--                                                <button type="button" id="button_add_form" class="btn btn-danger btn-icon-only rounded-circle">-->
<!--                                                    <i class="fa fa-plus-square"></i>-->
<!--                                                </button>-->
<!--                                            </div>-->
                                        </div>
                                        <div id="insert-form"></div>
                                        <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <center>
                                                    <input type="submit" class="btn" style="background: #FF3860; color: white" value="EDIT" onclick="return confirm('Yakin data sudah benar?')"/>
                                                    <a href="parameter_logic.php?idParameter=<?= $idParameter;?>" class="btn btn-white" onclick="return confirm('Yakin membatalkan pengubahan ini?')">CANCEL</a>
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
        <script>
            $(document).ready(function () {
                var inputCount = 1;
                var maxFields = 10;
                var addInputButton = $("#button_add_form");
                var fieldWrapper = $("#insert-form");

                var newFieldHTML = '<div class="form-row" id="row'+inputCount+'" style="margin-bottom: 20px">\n' +
                    '                                            <div class="col-md-1 mb-3">\n' +
                    '                                                <label class="form-control-label">Sequence</label>\n' +
                    '                                                <input type="text" class="form-control" name="sequence[]" id="sequence" required/>\n' +
                    '                                            </div>\n' +
                    '                                            <div class="col-md-2 mb-3">\n' +
                    '                                                <label class="form-control-label">Operator</label>\n' +
                    '                                                <select id="operator" class="form-control" name="operator[]" required>\n' +
                    '                                                    <option>--- Pilih salah satu ---</option>\n'+
                    '                                                    <option value="LESS THAN">LESS THAN</option>\n' +
                    '                                                    <option value="LESS THAN EQUAL">LESS THAN EQUAL</option>\n' +
                    '                                                    <option value="EQUAL">EQUAL</option>\n' +
                    '                                                    <option value="GREATER THAN">GREATER THAN</option>\n' +
                    '                                                    <option value="GREATER THAN EQUAL">GREATER THAN EQUAL</option>\n' +
                    '                                                    <option value="BETWEEN">BETWEEN</option>\n' +
                    '                                                    <option value="LIKE">LIKE</option>\n' +
                    '                                                </select>\n' +
                    '                                            </div>\n' +
                    '                                            <div class="col-md-2 mb-3">\n' +
                    '                                                <label class="form-control-label">Start Value</label>\n' +
                    '                                                <input type="text" class="form-control" name="start_value[]" id="start_value"/>\n' +
                    '                                            </div>\n' +
                    '                                            <div class="col-md-2 mb-3">\n' +
                    '                                                <label class="form-control-label">End Value</label>\n' +
                    '                                                <input type="text" class="form-control" name="end_value[]" id="end_value"/>\n' +
                    '                                            </div>\n' +
                    '                                            <div class="col-md-2 mb-3">\n' +
                    '                                                <label class="form-control-label">Like Value</label>\n' +
                    '                                                <input type="text" class="form-control" name="like_value[]" id="like_value"/>\n' +
                    '                                            </div>\n' +
                    '                                            <div class="col-md-2 mb-3">\n' +
                    '                                                <label class="form-control-label">Weight Point</label>\n' +
                    '                                                <input type="text" class="form-control" name="weight[]" id="weight" required/>\n' +
                    '                                            </div>\n' +
                    '                                            <div class="col-md-1 mb-3">\n' +
                    '                                                <label class="form-control-label" style="margin-top: 50px"></label>\n' +
                    '                                                <button type="button" id="'+inputCount+'" class="btn btn-white btn-icon-only rounded-circle button_remove_form">\n' +
                    '                                                    <i class="fa fa-minus-square"></i>\n' +
                    '                                                </button>\n' +
                    '                                            </div>\n' +
                    '                                        </div>';

                $(addInputButton).click(function () {
                    if(inputCount < maxFields) {
                        inputCount++;
                        $(fieldWrapper).append(newFieldHTML);
                    }
                    else {
                        alert("Maksimal hanya 10 field!");
                    }
                });

                $(fieldWrapper).on("click", '.button_remove_form', function (e) {
                    e.preventDefault();
                    // $(this).parent('div').fadeOut();
                    // $(this).parent('div').remove();
                    // $(".form-row").remove();
                    console.log($(this).attr("id"));
                    var frmId = $(this).attr("id");
                    $('#row'+frmId+'').remove();
                    inputCount--;
                });

                // $('#operator').on('change', function () {
                //     var optionText = $("#operator option:selected").text();
                //     if(optionText === 'LESS THAN') {
                //         $('#start_value').prop('disabled', true);
                //         $('#like_value').prop('disabled', true);
                //         $('#end_value').prop('disabled', false);
                //     }
                //     else if(optionText === 'GREATER THAN') {
                //         $('#start_value').prop('disabled', false);
                //         $('#end_value').prop('disabled', true);
                //         $('#like_value').prop('disabled', true);
                //     }
                // });
            });
        </script>
    </body>
</html>
