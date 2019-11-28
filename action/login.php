<?php
    include "../config.php";
    function getUserIpAddr(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    session_start();

    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $ipAddress = getUserIpAddr();

    $sqlLogin = $conn->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");
    $rowLogin = $sqlLogin->fetch_assoc();
    $rowsNumber = $sqlLogin->num_rows;

    if($rowsNumber == 0)
    {
        $_SESSION['error_message'] = "Username atau password salah. Silahkan coba lagi!";
        header("Location: ../");
    }
    else
    {
        if($rowLogin['ip_address'] == $ipAddress)
        {
            $_SESSION['id_user'] = $rowLogin['id'];
            $_SESSION['role'] = $rowLogin['role_code'];
            $_SESSION['nama'] = $rowLogin['nama'];
            $_SESSION['username'] = $rowLogin['username'];

            if($rowLogin['id_member'] != null or $rowLogin['id_member'] != '')
            {
                $_SESSION['id_member'] = $rowLogin['id_member'];
            }

            header("Location: ../pages/scoring_engine.php");
        }
        else
        {
            $_SESSION['error_message'] = "This IP Address is not authorized to access this app";
            header("Location: ../");
        }
    }