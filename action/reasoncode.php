<?php
    include "../config.php";
    include "../session.php";

    $crud = $_GET['crud'];

    $code = $_POST['code'];
    $description = $_POST['description'];
    $id_reason = $_POST['id_reason'];
    $id_logic = $_GET['idLogic'];

    if($crud == 'create')
    {
        $conn->query("INSERT INTO reasons(id, code, description) VALUES ($id_reason, '$code', '$description')");
        $conn->query("UPDATE parameter_details SET id_reason_code = ".$id_reason." WHERE id = $id_logic");

        $_SESSION['status'] = "Success!";
        $_SESSION['message'] = "Reason code berhasil dibuat!";
    }
    else if($crud == 'edit')
    {
        $conn->query("UPDATE reasons SET code = '$code', description = '$description' WHERE id = $id_reason");

        $_SESSION['status'] = "Success!";
        $_SESSION['message'] = "Reason code berhasil diubah!";
    }

    header("Location: ../pages/parameter_logic.php?idParameter=".$_GET['idParameter']);