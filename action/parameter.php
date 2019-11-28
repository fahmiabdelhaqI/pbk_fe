<?php
    include "../config.php";
    include "../session.php";

    $crud = $_GET['crud'];
    $parameter = $_POST['parameter'];
    $tipe_data = $_POST['tipe_data'];
    $idModel = $_GET['idModel'];
    $isWeb = $_POST['is_web'];
    $label = $_POST['label'];

    if($crud == 'create')
    {
        for($i = 0; $i < count($_REQUEST['parameter']); $i++)
        {
            if($_REQUEST['parameter'][$i] != null or $_REQUEST['parameter'][$i] != '')
            {
                $conn->query("INSERT INTO model_parameters(parameter, tipe_data, id_model, is_web, label) VALUES ('".$_REQUEST['parameter'][$i]."', '".$_REQUEST['tipe_data'][$i]."', $idModel, '".$_REQUEST['is_web'][$i]."', '".$_REQUEST['label'][$i]."')");
            }
        }
        $_SESSION['status'] = "Success!";
        $_SESSION['message'] = "Parameter berhasil dibuat!";
    }
    else if($crud == 'delete')
    {
        $idParameter = $_GET['idParameter'];
        $conn->query("DELETE FROM model_parameters WHERE id = $idParameter");
        $_SESSION['status'] = "Success!";
        $_SESSION['message'] = "Parameter berhasil dihapus!";
    }
    else
    {
        $idParameter = $_GET['idParameter'];
        $conn->query("UPDATE model_parameters SET parameter = '$parameter', tipe_data = '$tipe_data', is_web = '$isWeb', label = '$label' WHERE id = $idParameter");
        $_SESSION['status'] = "Success!";
        $_SESSION['message'] = "Parameter berhasil diubah!";
    }

    header("Location: ../pages/model_details.php?idModel=$idModel");