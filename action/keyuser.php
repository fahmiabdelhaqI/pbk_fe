<?php
    include "../config.php"; include "../session.php";
    $crud = $_GET['crud'];
    $id_member = $_POST['member'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['repeat_password'];
    $passwordMD5 = md5($password);
    $ipAddress = $_POST['ip_address'];

    if($crud == 'create')
    {
        if($id_member != '' or $id_member != null)
        {
            $conn->query("INSERT INTO users(nama, username, password, role_code, id_member, ip_address) VALUES ('$nama', '$username', '$passwordMD5', 'keyuser', $id_member, '$ipAddress')");
        }
        else
        {
            $conn->query("INSERT INTO users(nama, username, password, role_code, id_member, ip_address) VALUES ('$nama', '$username', '$passwordMD5', 'keyuser', null, '$ipAddress')");
        }

        $_SESSION['status'] = "Success!";
        $_SESSION['message'] = "Key User berhasil dibuat!";
    }
    else if($crud == 'delete')
    {
        $idUsers = $_GET['idUsers'];
        $conn->query("DELETE FROM users WHERE id = ".$idUsers);
        $_SESSION['status'] = "Success!";
        $_SESSION['message'] = "Key User berhasil dihapus!";
    }
    else
    {
        $idUsers = $_GET['idUsers'];
        $conn->query("UPDATE users SET username = '$username', nama = '$nama', password = '$passwordMD5', ip_address = '$ipAddress' WHERE id = ".$idUsers);
        $_SESSION['status'] = "Success!";
        $_SESSION['message'] = "Key User berhasil diubah!";
    }

    header("Location: ../pages/user_management.php");

