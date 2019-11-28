<?php
    date_default_timezone_set("Asia/Jakarta");
    // $conn = new mysqli('192.168.10.171', 'pefindo', 'pefindo123', 'pbk_scoring_2');
   $conn = new mysqli('localhost', 'root', 'root', 'test');

    if($conn->connect_error)
    {
        die("Connection failed: ".$conn->connect_error);
    }
    $baseURL = "http://localhost/pbk_api/public";