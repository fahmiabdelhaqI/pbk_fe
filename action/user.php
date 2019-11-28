<?php
    include "../config.php"; include "../session.php";

    $idMember = $_GET['idMember'];
    $crud = $_GET['crud'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['repeat_password'];
    $passwordMD5 = md5($password);
    $ipAddress = $_POST['ip_address'];

    if($crud == 'create')
    {
        $conn->query("INSERT INTO users(nama, username, password, id_member, role_code, ip_address) VALUES ('$nama', '$username', '$passwordMD5', $idMember, 'user', '$ipAddress')");
        $_SESSION['status'] = "Success!";
        $_SESSION['message'] = "User berhasil dibuat!";
    }
    else if($crud == 'edit')
    {
        $idUser = $_GET['idUser'];
        $conn->query("UPDATE users SET nama = '$nama', username = '$username', password = '$passwordMD5', ip_address = '$ipAddress' WHERE id = $idUser");
        $_SESSION['status'] = "Success!";
        $_SESSION['message'] = "User berhasil diubah!";
    }
    else
    {
        $idUser = $_GET['idUser'];
        $conn->query("DELETE FROM users WHERE id = $idUser");
        $_SESSION['status'] = "Success!";
        $_SESSION['message'] = "User berhasil dihapus!";
    }

    header("Location: ../pages/user_management_2.php");