<?php
    include "../config.php";
    include "../session.php";

    $crud = $_GET['crud'];
    $nama = $_POST['nama'];
    $endpoint_tradisional = $_POST['endpoint_tradisional'];
    $endpoint_ai = $_POST['endpoint_ai'];
    $endpoint_bre = $_POST['endpoint_bre'];
    $base_score = $_POST['base_score'];
    $icons = $_POST['icon'];

    if($crud == 'create')
    {
        if($endpoint_tradisional == null or $endpoint_tradisional == '')
        {
            $conn->query("INSERT INTO models(nama, endpoint_ai, endpoint_bre, base_score, icons) VALUES ('$nama', '$endpoint_ai', '$endpoint_bre', $base_score, '$icons')");
        }
        else if($endpoint_bre == null or $endpoint_bre == '')
        {
            $conn->query("INSERT INTO models(nama, endpoint_tradisional, endpoint_ai, base_score, icons) VALUES ('$nama', '$endpoint_tradisional', '$endpoint_ai', $base_score, '$icons')");
        }
        else
        {
            $conn->query("INSERT INTO models(nama, endpoint_tradisional, endpoint_ai, endpoint_bre, base_score, icons) VALUES ('$nama', '$endpoint_tradisional', '$endpoint_ai', '$endpoint_bre', $base_score, '$icons')");
        }
        $_SESSION['status'] = "Success!";
        $_SESSION['message'] = "Model berhasil dibuat!";
    }
    else if($crud == 'delete')
    {
        $idModel = $_GET['idModel'];
        $conn->query("DELETE FROM models WHERE id = $idModel");
        $_SESSION['status'] = "Success!";
        $_SESSION['message'] = "Model berhasil dihapus!";
    }
    else
    {
        $idModel = $_GET['idModel'];
        $conn->query("UPDATE models SET nama = '$nama', endpoint_tradisional = '$endpoint_tradisional', endpoint_ai = '$endpoint_ai', endpoint_bre = '$endpoint_bre', base_score = '$base_score', icons = '$icons' WHERE id = $idModel");
        $_SESSION['status'] = "Success!";
        $_SESSION['message'] = "Model berhasil diubah!";
    }

    header("Location: ../pages/model_list.php");