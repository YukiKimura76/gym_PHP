<?php
ini_set('display_errors', "On");
session_start();

// フォームからのデータ取得
$sessionName = $_POST['sessionName'];
$sessionDate = $_POST['date'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$trainerId = $_POST['trainer'];

/* DB接続 */
try {
    $pdo = new PDO('mysql:dbname=pt_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
    exit('DB_CONNECTION:'.$e->getMessage());
}

/* データ登録処理 */
$sql = "INSERT INTO sessions_table (session_name, session_date, start_time, end_time, trainer_id) VALUES (:session_name, :session_date, :start_time, :end_time, :trainer_id)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':session_name', $sessionName, PDO::PARAM_STR);
$stmt->bindValue(':session_date', $sessionDate, PDO::PARAM_STR);
$stmt->bindValue(':start_time', $startTime, PDO::PARAM_STR);
$stmt->bindValue(':end_time', $endTime, PDO::PARAM_STR);
$stmt->bindValue(':trainer_id', $trainerId, PDO::PARAM_INT); // トレーナーIDをバインド
$status = $stmt->execute();

/* データ登録後の処理 */
if ($status == false) {
    $error = $stmt->errorInfo();
    echo "<script>alert('セッションの追加に失敗しました'); window.location.href='error_page.php';</script>";
    exit;
} else {
    echo "<script>alert('セッションが追加されました'); window.location.href='sessions_list.php';</script>";
    exit;
}
?>
