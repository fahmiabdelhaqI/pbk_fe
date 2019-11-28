<?php include "../config.php"; include "../session.php"; ?>
<!doctype html>
<html lang="en">
    <head>
        <?php include "../partials/assets_css.php";?>
        <title>Profile Settings</title>
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
                                <h6 class="h2 d-inline-block mb-0">Settings</h6>
                                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                    <ol class="breadcrumb breadcrumb-links">
                                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                        <li class="breadcrumb-item" aria-current="page"><a href="#">Profile Settings</a></li>
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
                    <div class="col-xl-12 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="h3 mb-0"><strong>Profile Settings</strong></h5>
                            </div>
                            <div class="card-body">
                                <nav>
                                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Change Username</a>
                                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Change Password</a>
                                    </div>
                                </nav>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" style="margin-top: 30px">
                                        <form action="../action/profile_settings.php?parts=username" method="post" enctype="multipart/form-data" accept-charset="UTF-8" data-toggle="validator" role="form">
                                            <div class="form-row">
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-control-label">Username Lama</label>
                                                    <?php
                                                        $sqlFetchUsername = $conn->query("SELECT * FROM users WHERE id = ".$_SESSION['id_user']);
                                                        $rowFetchUsername = $sqlFetchUsername->fetch_assoc();
                                                    ?>
                                                    <input type="text" class="form-control" name="username_lama" id="username_lama" value="<?= $rowFetchUsername['username']?>" required readonly/>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-control-label">Username Baru</label>
                                                    <input type="text" class="form-control" name="username_baru" id="username_baru" required/>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-control-label">Password Konfirmasi</label>
                                                    <input type="password" class="form-control" name="password_konfirmasi" id="password_konfirmasi" required/>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                    <center>
                                                        <input type="submit" class="btn" style="background: #FF3860; color: white" value="CHANGE USERNAME" onclick="return confirm('Yakin data sudah benar?')"/>
                                                        <a href="#" class="btn btn-white" onclick="return confirm('Yakin membatalkan pengubahan ini?')">CANCEL</a>
                                                    </center>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-contact-tab" style="margin-top: 30px">
                                        <form action="../action/profile_settings.php?parts=password" method="post" enctype="multipart/form-data" accept-charset="UTF-8" data-toggle="validator" role="form">
                                            <div class="form-row">
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-control-label">Password Lama</label>
                                                    <input type="password" class="form-control" name="password_lama" id="password_lama" required/>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-control-label">Password Baru</label>
                                                    <input type="password" class="form-control" name="password_baru" id="password_baru" required/>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-control-label">Konfirmasi Password Baru</label>
                                                    <input type="password" class="form-control" name="konfirmasi_password_baru" id="konfirmasi_password_baru" required/>
                                                    <span id="message"></span>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                    <center>
                                                        <input id="btn_create" type="submit" class="btn" style="background: #FF3860; color: white" value="CHANGE PASSWORD" onclick="return confirm('Yakin data sudah benar?')"/>
                                                        <a href="#" class="btn btn-white" onclick="return confirm('Yakin membatalkan pengubahan ini?')">CANCEL</a>
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
            $('#konfirmasi_password_baru, #password_baru').on('keyup', function () {
                if($('#konfirmasi_password_baru').val() == $('#password_baru').val()) {
                    $('#message').html('Password matched!').css('color', 'green');
                    $('#btn_create').prop('disabled', false);
                }
                else if($('#konfirmasi_password_baru').val() == '' || $('#password_baru').val() == '') {
                    $('#message').html('').css('color', 'green');
                    $('#btn_create').prop('disabled', true);
                }
                else {
                    $('#message').html('Password not matched!').css('color', 'red');
                    $('#btn_create').prop('disabled', true);
                }
            });
        </script>
    </body>
</html>