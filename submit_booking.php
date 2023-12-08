<?php
require_once 'funcs.php';
checkAndRedirect();

// DB接続
$pdo = new PDO('mysql:dbname=pt_db;charset=utf8;host=localhost', 'root', '');


// フォームから送信されたshift_idを取得
$shift_id = $_POST['shift_id'];

// 予約処理
$sql = "UPDATE trainer_shifts SET is_booked = '1' WHERE shift_id = :shift_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':shift_id', $shift_id, PDO::PARAM_INT);
$stmt->execute();

// エラーチェックと結果の処理
$errorInfo = $stmt->errorInfo();
if (!empty($errorInfo[2])) {
    die("データベースエラー: " . $errorInfo[2]);
}

if ($stmt->rowCount() > 0) {
    echo "<script>alert('予約が完了しました。'); window.location.href='booking_list.php';</script>";
} else {
    echo "<script>alert('予約に失敗しました。'); window.location.href='client_shift_trainer_select.php';</script>";
}
?>
