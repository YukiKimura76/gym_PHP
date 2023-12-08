<?php

require_once 'funcs.php';
checkAndRedirect();

// ファイルから予約情報を読み込む
$reservations = file("data/reservations.txt");

function displayReservations($reservations) {
    echo "<table>";
    echo "<tr><th>メール</th><th>セッションID</th><th>セッション名</th><th>開始時間</th><th>終了時間</th></tr>";

    foreach ($reservations as $reservation) {
        list($email, $sessionId, $name,$startTime, $endTime) = explode(",", trim($reservation));
        echo "<tr>";
        echo "<td>$email</td>";
        echo "<td>$sessionId</td>";
        echo "<td>$name</td>";
        echo "<td>$startTime</td>";
        echo "<td>$endTime</td>";
        echo "</tr>";
    }

    echo "</table>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>予約情報一覧</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <h2>予約済みレッスン一覧</h2>
    <?php displayReservations($reservations); ?>
</body>
</html>
