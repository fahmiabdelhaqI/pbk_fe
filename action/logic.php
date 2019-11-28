<?php
    include "../config.php";
    include "../session.php";

    $crud = $_GET['crud'];
    $idParameter = $_GET['idParameter'];

    $sequence = $_POST['sequence'];
    $operator = $_POST['operator'];
    $start_value = $_POST['start_value'];
    $end_value = $_POST['end_value'];
    $like_value = $_POST['like_value'];
    $weight = $_POST['weight'];

    if($crud == 'create')
    {
        for($i = 0; $i < count($_REQUEST['sequence']); $i++)
        {
            if($_REQUEST['operator'][$i] == 'LESS THAN' or $_REQUEST['operator'][$i] == 'LESS THAN EQUAL')
            {
                $conn->query("INSERT INTO parameter_details(sequence, operator, end_value, weight, id_model_parameter) VALUES ('".$_REQUEST['sequence'][$i]."', '".$_REQUEST['operator'][$i]."', ".$_REQUEST['end_value'][$i].", ".$_REQUEST['weight'][$i].", ".$idParameter.")");
            }
            else if($_REQUEST['operator'][$i] == 'GREATER THAN' or $_REQUEST['operator'][$i] == 'GREATER THAN EQUAL' or $_REQUEST['operator'][$i] == 'EQUAL')
            {
                $conn->query("INSERT INTO parameter_details(sequence, operator, start_value, weight, id_model_parameter) VALUES ('".$_REQUEST['sequence'][$i]."', '".$_REQUEST['operator'][$i]."', ".$_REQUEST['start_value'][$i].", ".$_REQUEST['weight'][$i].", ".$idParameter.")");
            }
            else if($_REQUEST['operator'][$i] == 'BETWEEN')
            {
//                $conn->query("INSERT INTO parameter_details(sequence, operator, start_value, end_value, weight, id_model_parameter) VALUES ('".$_REQUEST['sequence'][$i]."', '".$_REQUEST['operator'][$i]."', ".$_REQUEST['start_value'][$i].", ".$_REQUEST['end_value'][$i].", ".$_REQUEST['weight'][$i]."], ".$idParameter.")");
                $conn->query("INSERT INTO parameter_details(sequence, operator, start_value, end_value, weight, id_model_parameter) VALUES ('".$_REQUEST['sequence'][$i]."', '".$_REQUEST['operator'][$i]."', '".$_REQUEST['start_value'][$i]."', '".$_REQUEST['end_value'][$i]."', '".$_REQUEST['weight'][$i]."', '".$idParameter."')");
            }
            else
            {
                $conn->query("INSERT INTO parameter_details(sequence, operator, like_value, weight, id_model_parameter) VALUES ('".$_REQUEST['sequence'][$i]."', '".$_REQUEST['operator'][$i]."', ".$_REQUEST['like_value'][$i].", ".$_REQUEST['weight'][$i].", ".$idParameter.")");
            }
        }

        $_SESSION['status'] = "Success!";
        $_SESSION['message'] = "Parameter logic berhasil dibuat!";
    }
    else if($crud == 'edit')
    {
        $idParamDetails = $_GET['idParamDetails'];
        if($operator == 'LESS THAN' or $operator == 'LESS THAN EQUAL')
        {
            $conn->query("UPDATE parameter_details SET sequence = '$sequence', operator = '$operator', end_value = '$end_value', weight = '$weight', start_value = null, like_value = null WHERE id = $idParamDetails");
        }
        else if($operator == 'GREATER THAN' or $operator == 'GREATER THAN EQUAL' or $operator == 'EQUAL')
        {
            $conn->query("UPDATE parameter_details SET sequence = '$sequence', operator = '$operator', start_value = '$start_value', weight = '$weight', end_value = null, like_value = null WHERE id = $idParamDetails");
        }
        else if($operator == 'BETWEEN')
        {
            $conn->query("UPDATE parameter_details SET sequence = '$sequence', operator = '$operator', start_value = '$start_value', end_value = '$end_value',weight = '$weight', like_value = null WHERE id = $idParamDetails");
        }
        else
        {
            $conn->query("UPDATE parameter_details SET sequence = '$sequence', operator = '$operator', like_value = '$like_value', weight = '$weight', start_value = null, end_value = null WHERE id = $idParamDetails");
        }

        $_SESSION['status'] = "Success!";
        $_SESSION['message'] = "Parameter logic berhasil diubah!";
    }
    else
    {
        $idParamDetails = $_GET['idParamDetails'];
        $conn->query("DELETE FROM parameter_details WHERE id = $idParamDetails");

        $_SESSION['status'] = "Success!";
        $_SESSION['message'] = "Parameter logic berhasil dihapus!";
    }

    header("Location: ../pages/parameter_logic.php?idParameter=$idParameter");
?>