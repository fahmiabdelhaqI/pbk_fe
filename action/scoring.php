<?php
    include "../config.php"; include "../session.php"; $idModel = $_GET['idModel']; $mode = $_GET['mode'];

    //Fetch data model
    $sqlFetchModel = $conn->query("SELECT * FROM models WHERE id = $idModel");
    $rowFetchModel = $sqlFetchModel->fetch_assoc();

    //Fetch data member
    $sqlFetchMember = $conn->query("SELECT * FROM users WHERE id = ".$_SESSION['id_user']);
    $rowFetchMember = $sqlFetchMember->fetch_assoc();

    $ch = curl_init();

    if($mode == 'ai')
    {
        curl_setopt($ch, CURLOPT_URL, "http://192.168.10.173:11000".$rowFetchModel['endpoint_ai']);
//        curl_setopt($ch, CURLOPT_URL, "http://192.168.10.171:2200".$rowFetchModel['endpoint_ai']);
    }
    else if($mode == 'bre')
    {
        curl_setopt($ch, CURLOPT_URL, "http://192.168.10.173:11000".$rowFetchModel['endpoint_bre']);
//        curl_setopt($ch, CURLOPT_URL, "http://192.168.10.171:2200".$rowFetchModel['endpoint_bre']);
    }
    else
    {
//        curl_setopt($ch, CURLOPT_URL, "http://192.168.10.171:2200".$rowFetchModel['endpoint_tradisional']);
        curl_setopt($ch, CURLOPT_URL, "http://192.168.10.173:11000".$rowFetchModel['endpoint_tradisional']);
    }

    curl_setopt($ch, CURLOPT_POST, 1);

    if($rowFetchModel['nama'] == 'Telco' or $rowFetchModel['nama'] == 'Test 123')
    {
        curl_setopt($ch, CURLOPT_POSTFIELDS, "phone_no=".$_POST['phone_no']);
    }
    else if($rowFetchModel['nama'] == 'Credit')
    {
        $fields = array(
            "nik" => $_POST['nik'],
            "fullname" => $_POST['fullname'],
            "phone" => $_POST['phone']
        );

        $fieldsString = http_build_query($fields);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsString);
    }
    else
    {
        $fields = array(
            "phone_no" => $_POST['phone_no'],
            "full_name" => $_POST['full_name']
        );

        $fieldsString = http_build_query($fields);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsString);
    }

    $headers = array(
        'Content-Type: application/x-www-form-urlencoded',
        'Score-User-ID: '.$_SESSION['id_user'],
        'Score-Member-ID: '.$rowFetchMember['id_member']
    );

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Receive server response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);

    curl_close ($ch);
    $jsonStatus = json_decode($server_output, true);

    if($jsonStatus['status'] == 'error')
//    if(empty($jsonStatus))
    {
        $_SESSION['message'] = $jsonStatus['error'];
        $_SESSION['status'] = $jsonStatus['status'];
//        var_dump($jsonStatus);
//        echo "kosong";
        header("Location: ../pages/scoring_form.php?idModel=$idModel&mode=$mode");
    }
    else
    {
//        var_dump($jsonStatus);
        header("Location: ../pages/history_scoring.php?idModel=".$rowFetchModel['id']."&mode=$mode");
    }
