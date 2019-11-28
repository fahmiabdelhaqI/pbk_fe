<?php include "../config.php"; include "../session.php";?>
<!doctype html>
<html lang="en">
    <head>
        <?php include "../partials/assets_css.php";?>
        <title>Key User Management</title>
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
                                <h6 class="h2 d-inline-block mb-0">Key User Management</h6>
                                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                    <ol class="breadcrumb breadcrumb-links">
                                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><a href="user_management.php">Key User List</a></li>
                                    </ol>
                                </nav>
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
                                    <div class="col-8">
                                        <h5 class="h3 mb-0"><strong>List Key User</strong></h5>
                                    </div>
                                    <div class="col-4 text-right">
                                        <a href="user_form.php?method=create" class="btn btn-sm btn-pinterest"><i class="fas fa-plus-square"></i> Add Key User</a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive py-4">
                                <table class="table table-flush" id="user_list">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sqlFetchUser = $conn->query("SELECT * FROM users WHERE role_code = 'keyuser'");
                                            $nomor = 1;
                                            while($rowFetchUser = $sqlFetchUser->fetch_assoc())
                                            {
                                                ?>
                                                    <tr>
                                                        <td><?= $nomor++;?></td>
                                                        <td><?= $rowFetchUser['nama'];?></td>
                                                        <td><?= $rowFetchUser['username'];?></td>
                                                        <td><?= $rowFetchUser['role_code'];?></td>
                                                        <td>
                                                            <a href="user_form.php?idUsers=<?= $rowFetchUser['id']?>&method=edit" class="btn btn-sm btn-info">EDIT</a>
                                                            <a href="../action/keyuser.php?idUsers=<?= $rowFetchUser['id']?>&crud=delete" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau menghapus data ini?')">DELETE</a>
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
            $("#user_list").DataTable({
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
