<?php
ini_set('display_errors', "On");

// POSTデータの取得
$trainer_id = $_POST['trainer_id'];
$shift_date = $_POST['shift_date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$break_time = $_POST['break_time'];

// DB接続
try {
    $pdo = new PDO('mysql:dbname=pt_db;charset=utf8;host=localhost','root',''); 
} catch (PDOException $e) { 
    exit('DB_CONNECTION:'.$e->getMessage()); 
} 

// SQLに送信
$sql = "INSERT INTO trainer_shifts (trainer_id, shift_date, start_time, end_time, break_time) VALUES (:trainer_id, :shift_date, :start_time, :end_time, :break_time)";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':trainer_id', $trainer_id, PDO::PARAM_INT);
$stmt->bindValue(':shift_date', $shift_date, PDO::PARAM_STR);
$stmt->bindValue(':start_time', $start_time, PDO::PARAM_STR);
$stmt->bindValue(':end_time', $end_time, PDO::PARAM_STR);
$stmt->bindValue(':break_time', $break_time, PDO::PARAM_STR);

// SQLを実行
if($stmt->execute()) {
    echo "<script>
      alert('シフトの登録完了しました');
      window.location.href='sessions.php'; //ページ構成が決まったら再度遷移先検討
      </script>";
    } else {
        echo "<script>
        alert('シフトの登録に失敗しました');
        window.location.href='trainer_shift.php';
        </script>";
}
?>
