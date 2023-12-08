<?php

require_once 'funcs.php';
checkAndRedirect();

// 予約データを読み込む
$reservations = file("data/reservations.txt");

// セッションごとの予約数を集計
$reservationCounts = [];
foreach ($reservations as $reservation) {
    list($email, $sessionId, $sessionName, $startTime, $endTime) = explode(",", trim($reservation));
    if (!isset($reservationCounts[$sessionId])) {
        $reservationCounts[$sessionId] = 0;
    }
    $reservationCounts[$sessionId]++;
}

// 最大予約数を取得（グラフのスケール用）
$maxReservations = max($reservationCounts);

?>

<!DOCTYPE html>
<html>
<head>
    <title>予約状況グラフ</title>
    <style>
        .bar-container {
            width: 100%;
            background-color: #f1f1f1;
            text-align: center;
            color: white;
        }

        .bar {
            width: 0%;
            height: 30px;
            background-color: #4CAF50;
        }
    </style>
</head>
<body>
    <h2>予約状況</h2>

    <?php foreach ($reservationCounts as $sessionId => $count): ?>
        <div class="bar-container">
            <div class="bar" style="width: <?php echo ($count / $maxReservations * 100); ?>%;">
                <?php echo $count; ?>
            </div>
        </div>
    <?php endforeach; ?>
</body>
</html>
