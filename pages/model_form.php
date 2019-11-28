<?php include "../config.php"; include "../session.php"; $idModel = $_GET['idModel']; $idParameter = isset($_GET['idParameter']) ? $_GET['idParameter'] : ''; $method = $_GET['method'];?>
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
                                        <li class="breadcrumb-item"><a href="model_details.php?idModel=<?= $idModel;?>">Parameter</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Parameter Form</li>
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
                        <h3 class="mb-0">Form <?php if($method == 'create'){echo 'Add';}else{echo 'Edit';}?> Parameter</h3>
                    </div>
                    <div class="card-body">
                        <?php
                            if($method == 'edit')
                            {
                                $sqlFetchParameter = $conn->query("SELECT * FROM model_parameters WHERE id = $idParameter");
                                $rowFetchParameter = $sqlFetchParameter->fetch_assoc();
                                ?>
                                    <form action="../action/parameter.php?crud=edit&idParameter=<?= $rowFetchParameter['id']?>&idModel=<?= $idModel?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8" data-toggle="validator" role="form">
                                        <div class="form-row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-control-label">Parameter</label>
                                                <input type="text" class="form-control" name="parameter" id="parameter" value="<?= $rowFetchParameter['parameter']?>" required/>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-control-label">Label</label>
                                                <input type="text" class="form-control" name="label" id="label" value="<?= $rowFetchParameter['label']?>" required/>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-control-label">Tipe Data</label>
                                                <select class="form-control" name="tipe_data" id="tipe_data">
                                                    <option>--- Pilih Salah Satu</option>
                                                    <option <?php if($rowFetchParameter['tipe_data'] == 'INT'){echo 'selected';}?> value="INT">INT</option>
                                                    <option <?php if($rowFetchParameter['tipe_data'] == 'FLOAT'){echo 'selected';}?> value="FLOAT">FLOAT</option>
                                                    <option <?php if($rowFetchParameter['tipe_data'] == 'STRING'){echo 'selected';}?> value="STRING">STRING</option>
                                                    <option <?php if($rowFetchParameter['tipe_data'] == 'DATE'){echo 'selected';}?> value="DATE">DATE</option>
                                                    <option <?php if($rowFetchParameter['tipe_data'] == 'DATETIME'){echo 'selected';}?> value="DATETIME">DATETIME</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-control-label">Is Web?</label>
                                                <select class="form-control" name="is_web">
                                                    <option <?php if($rowFetchParameter['is_web'] == 'N'){echo 'selected';}?> value="N">No</option>
                                                    <option <?php if($rowFetchParameter['is_web'] == 'Y'){echo 'selected';}?> value="Y">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <input type="submit" class="btn" style="background: #FF3860; color: white" value="EDIT" onclick="return confirm('Yakin data sudah benar?')"/>
                                                <a href="model_list.php" class="btn btn-white" onclick="return confirm('Yakin membatalkan pengubahan ini?')">CANCEL</a>
                                            </div>
                                        </div>
                                    </form>
                                <?php
                            }
                            else
                            {
                                ?>
                                    <form action="../action/parameter.php?crud=create&idModel=<?= $idModel;?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8" data-toggle="validator" role="form">
                                        <div class="form-row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-control-label">Parameter</label>
                                                <input type="text" class="form-control" name="parameter[]" id="parameter" required/>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-control-label">Label</label>
                                                <input type="text" class="form-control" name="label[]" id="label"/>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-control-label">Tipe Data</label>
                                                <select class="form-control" name="tipe_data[]" id="tipe_data">
                                                    <option>--- Pilih Salah Satu</option>
                                                    <option value="INT">INT</option>
                                                    <option value="FLOAT">FLOAT</option>
                                                    <option value="STRING">STRING</option>
                                                    <option value="DATE">DATE</option>
                                                    <option value="DATETIME">DATETIME</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-control-label">Is Web?</label>
                                                <select class="form-control" name="is_web[]">
                                                    <option value="N">No</option>
                                                    <option value="Y">Yes</option>
                                                </select>
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
                                                    <a href="model_list.php" class="btn btn-white" onclick="return confirm('Yakin membatalkan pengubahan ini?')">CANCEL</a>
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

                var newFieldHTML = '<div class="form-row" id="row'+inputCount+'">\n' +
                    '                                            <div class="col-md-3 mb-3">\n' +
                    '                                                <label class="form-control-label">Parameter</label>\n' +
                    '                                                <input type="text" class="form-control" name="parameter[]" id="parameter" required/>\n' +
                    '                                            </div>\n' +
                    '                                            <div class="col-md-3 mb-3">\n' +
                    '                                                <label class="form-control-label">Label</label>\n' +
                    '                                                <input type="text" class="form-control" name="label[]" id="label"/>\n' +
                    '                                            </div>\n' +
                    '                                            <div class="col-md-3 mb-3">\n' +
                    '                                                <label class="form-control-label">Tipe Data</label>\n' +
                    '                                                <select class="form-control" name="tipe_data[]" id="tipe_data">\n' +
                    '                                                    <option>--- Pilih Salah Satu</option>\n' +
                    '                                                    <option value="INT">INT</option>\n' +
                    '                                                    <option value="FLOAT">FLOAT</option>\n' +
                    '                                                    <option value="STRING">STRING</option>\n' +
                    '                                                    <option value="DATE">DATE</option>\n' +
                    '                                                    <option value="DATETIME">DATETIME</option>\n' +
                    '                                                </select>\n' +
                    '                                            </div>\n' +
                    '                                            <div class="col-md-2 mb-3">\n' +
                    '                                                <label class="form-control-label">Is Web?</label>\n' +
                    '                                                <select class="form-control" name="is_web[]">\n' +
                    '                                                    <option value="N">No</option>\n' +
                    '                                                    <option value="Y">Yes</option>\n' +
                    '                                                </select>\n' +
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
            });
        </script>
    </body>
</html>