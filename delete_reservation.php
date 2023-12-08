<?php
ini_set('display_errors', "On");

// DB接続
$pdo = new PDO('mysql:dbname=pt_db;charset=utf8;host=localhost', 'root', '');

// POSTデータからshift_idを取得
$shift_id = $_POST['shift_id'];

// 予約キャンセル処理
$sql = "UPDATE trainer_shifts SET is_booked = 0 WHERE shift_id = :shift_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':shift_id', $shift_id, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->execute()) {
    $message = "予約の削除が完了しました。";
} else {
    $message = "予約の削除に失敗しました。";
}

echo "<script>alert('$message'); window.location.href='booking_list.php';</script>";
exit;
?>
