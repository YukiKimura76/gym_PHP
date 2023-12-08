<?php
// DB接続
$pdo = new PDO('mysql:dbname=pt_db;charset=utf8;host=localhost', 'root', '');

// トレーナーのリストを取得
$sql = "SELECT trainer_id, tname FROM pt_trainers";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$trainers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// トレーナーIDの取得
$selected_trainer_id = $_GET['trainer'] ?? null;
?>
