<?php include "../config.php"; include "../session.php"; $method = $_GET['method']; ?>
<!doctype html>
<html lang="en">
    <head>
        <?php include "../partials/assets_css.php";?>
        <title>Form <?php if($method == 'create'){echo 'Add';}else{echo 'Edit';}?> User</title>
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
                                <h6 class="h2 d-inline-block mb-0">User Management</h6>
                                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                    <ol class="breadcrumb breadcrumb-links">
                                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="user_management_2.php">User List</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><a href="#">User Form</a></li>
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
                        <h3 class="mb-0">Form <?php if($method == 'create'){echo 'Add';}else{echo 'Edit';}?> User</h3>
                    </div>
                    <div class="card-body">
                        <?php
                            if($method == 'create')
                            {
                                ?>
                                    <form action="../action/user.php?crud=create&idMember=<?= $_SESSION['id_member'];?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8" data-toggle="validator" role="form">
                                        <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-control-label">Member</label>
                                                <select id="select-member" class="form-control" name="member" disabled>
                                                    <?php
                                                        $sqlFetchMember = $conn->query("SELECT * FROM members WHERE id = ".$_SESSION['id_member']);
                                                        while($rowFetchMember = $sqlFetchMember->fetch_assoc())
                                                        {
                                                            ?>
                                                                <option value="<?= $rowFetchMember['id']?>"><?= "(".$rowFetchMember['member_code'].") ".$rowFetchMember['member_name']?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-control-label">Nama</label>
                                                <input type="text" class="form-control" name="nama" required/>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-control-label">Username</label>
                                                <input type="text" class="form-control" name="username" maxlength="20" required/>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-control-label">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" maxlength="20" required/>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-control-label">Repeat Password</label>
                                                <input type="password" class="form-control" id="repeat_password" name="repeat_password" maxlength="20" required/>
                                                <span id="message"></span>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-control-label">IP Address</label>
                                                <input type="text" class="form-control" name="ip_address" maxlength="15" required/>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <center>
                                                    <input id="btn_create" type="submit" class="btn" style="background: #FF3860; color: white" value="CREATE" onclick="return confirm('Yakin data sudah benar?')"/>
                                                    <a href="model_list.php" class="btn btn-white" onclick="return confirm('Yakin membatalkan pengubahan ini?')">CANCEL</a>
                                                </center>
                                            </div>
                                        </div>
                                    </form>
                                <?php
                            }
                            else
                            {
                                $idUser = $_GET['idUsers'];
                                $sqlFetchUser = $conn->query("SELECT * FROM users WHERE id = $idUser");
                                $rowFetchUser = $sqlFetchUser->fetch_assoc();
                                ?>
                                    <form action="../action/user.php?crud=edit&idUser=<?= $idUser;?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8" data-toggle="validator" role="form">
                                        <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-control-label">Member</label>
                                                <select id="select-member" class="form-control" name="member" disabled>
                                                    <?php
                                                        $sqlFetchMember = $conn->query("SELECT * FROM members WHERE id = ".$_SESSION['id_member']);
                                                        while($rowFetchMember = $sqlFetchMember->fetch_assoc())
                                                        {
                                                            ?>
                                                                <option value="<?= $rowFetchMember['id']?>"><?= "(".$rowFetchMember['member_code'].") ".$rowFetchMember['member_name']?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-control-label">Nama</label>
                                                <input type="text" class="form-control" name="nama" required value="<?= $rowFetchUser['nama']?>"/>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-control-label">Username</label>
                                                <input type="text" class="form-control" name="username" maxlength="20" required value="<?= $rowFetchUser['username']?>"/>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-control-label">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" maxlength="20" required/>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-control-label">Repeat Password</label>
                                                <input type="password" class="form-control" id="repeat_password" name="repeat_password" maxlength="20" required/>
                                                <span id="message"></span>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-control-label">IP Address</label>
                                                <input type="text" class="form-control" name="ip_address" maxlength="15" required value="<?= $rowFetchUser['ip_address']?>"/>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <center>
                                                    <input id="btn_create" type="submit" class="btn" style="background: #FF3860; color: white" value="EDIT" onclick="return confirm('Yakin data sudah benar?')"/>
                                                    <a href="user_management_2.php" class="btn btn-white" onclick="return confirm('Yakin membatalkan pengubahan ini?')">CANCEL</a>
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
            $('#password, #repeat_password').on('keyup', function () {
                if($('#password').val() == $('#repeat_password').val()) {
                    $('#message').html('Password matched!').css('color', 'green');
                    $('#btn_create').prop('disabled', false);
                }
                else if($('#password').val() == '' || $('#repeat_password').val() == '') {
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
