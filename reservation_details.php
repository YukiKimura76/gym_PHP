<?php
// DB接続
$pdo = new PDO('mysql:dbname=pt_db;charset=utf8;host=localhost', 'root', '');

$reservation_id = $_GET['reservation_id'];

// 予約の詳細を取得するクエリ
$sql = "SELECT r.id AS reservation_id, r.reservation_date, r.reservation_time, c.uname AS customer_name, t.tname AS trainer_name
        FROM reservations r
        JOIN customers c ON r.customer_id = c.id
        JOIN trainers t ON r.trainer_id = t.id
        WHERE r.id = :reservation_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':reservation_id', $reservation_id);
$stmt->execute();
$reservation_details = $stmt->fetch(PDO::FETCH_ASSOC);


// 過去の予約一覧を取得するクエリ
// ...

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予約詳細</title>
</head>
<body>
    <h1>予約詳細</h1>
    <div>
        <h2>予約情報</h2>
        <p>お客様名: <?php echo htmlspecialchars($reservation_details['uname']); ?></p>
        <p>予約日時: <?php echo htmlspecialchars($reservation_details['datetime']); ?></p>
        <p>担当トレーナー: <?php echo htmlspecialchars($reservation_details['trainer_name']); ?></p>
    </div>

    <div>
        <h2>過去の予約一覧</h2>
        <!-- 過去の予約一覧を表示するコード -->
    </div>
</body>
</html>
