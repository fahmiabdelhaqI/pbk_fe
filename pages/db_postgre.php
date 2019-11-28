<?php
//    $dbConn = pg_connect("host=192.168.10.173 dbname=pefindo user=pefindo password=pefindo123");
//    $result = pg_query($dbConn,"SELECT * FROM scoring_param_results");
//    var_dump(pg_fetch_all($result));

$myPDO = new PDO('pgsql:host=192.168.10.173;dbname=pefindo', 'pefindo', 'pefindo123');
?>
    <table>
        <?php
        foreach ($myPDO->query("SELECT * FROM scoring.scoring_param_results ORDER BY end_datetime DESC LIMIT 10") as $item) {
            ?>
                <tr>
                    <td><?= $item['message_id']?></td>
                    <td><?= $item['scoring_result']?></td>
                    <td><?= $item['scoring_param']?></td>
                </tr>
            <?php
        }
        ?>
    </table>




