<?php
    include "../config.php"; include "../session.php";

    $parts = $_GET['parts'];

    if($parts == 'username')
    {
        $username_lama = $_POST['username_lama'];
        $username_baru = $_POST['username_baru'];
        $password_konfirmasi = $_POST['password_konfirmasi'];

        //Check username di semua user
        $sqlCheckUsername = $conn->query("SELECT * FROM users");
        while($rowCheckUsername = $sqlCheckUsername->fetch_assoc())
        {
            if($rowCheckUsername['username'] == $username_baru)
            {
                $_SESSION['status'] = "Error!";
                $_SESSION['message'] = "Username sudah ada, silahkan cari yang lain!";
            }
            else
            {
                //Check password
                $sqlCheckPassword = $conn->query("SELECT * FROM users WHERE id = ".$_SESSION['id_user']);
                $rowCheckPassword = $sqlCheckPassword->fetch_assoc();

                if($rowCheckPassword['password'] == md5($password_konfirmasi))
                {
                    $conn->query("UPDATE users SET username = '$username_baru' WHERE id = ".$_SESSION['id_user']);
                    $_SESSION['status'] = "Success!";
                    $_SESSION['message'] = "Username berhasil diubah!";
                }
                else
                {
                    $_SESSION['status'] = "Error!";
                    $_SESSION['message'] = "Password salah!";
                }
            }
        }
    }
    else
    {
        $password_lama = $_POST['password_lama'];
        $password_baru = $_POST['password_baru'];
        $konfirmasi_password_baru = $_POST['konfirmasi_password_baru'];

        //Check password lama
        $sqlCheckPasswordLama = $conn->query("SELECT * FROM users WHERE id = ".$_SESSION['id_user']);
        $rowCheckPasswordLama = $sqlCheckPasswordLama->fetch_assoc();

        if($rowCheckPasswordLama['password'] != md5($password_lama))
        {
            $_SESSION['status'] = "Error!";
            $_SESSION['message'] = "Password lama salah!";
        }
        else
        {
            $conn->query("UPDATE users SET password = '".md5($konfirmasi_password_baru)."' WHERE id = ".$_SESSION['id_user']);
            $_SESSION['status'] = "Success!";
            $_SESSION['message'] = "Password berhasil diubah!";
        }
    }

    header("Location: ../pages/settings.php");
?>