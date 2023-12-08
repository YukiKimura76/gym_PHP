<?php 
ini_set('display_errors', "On");

require_once 'funcs.php';
checkAndRedirect();

// DB接続
$pdo = new PDO('mysql:dbname=pt_db;charset=utf8;host=localhost', 'root', '');

// フォームデータの取得
$trainer_id = $_POST['trainer'];
$shifts = [];

$allInsertsSuccessful = true; 

for ($day = 0; $day < 7; $day++) {
    $date = $_POST["date_$day"];
    $start_time = $_POST["start_time_$day"];
    $end_time = $_POST["end_time_$day"];
    $break_start_time = $_POST["break_start_time_$day"];
    $break_end_time = $_POST["break_end_time_$day"];

     // 勤務時間を1時間単位で計算
     if (!empty($start_time) && !empty($end_time)) {
        $work_hours = calculateWorkHours($start_time, $end_time, $break_start_time, $break_end_time);

        // データベースに各時間帯を登録
        foreach ($work_hours as $hour) {
            $sql = "INSERT INTO trainer_shifts (trainer_id, shift_date, work_hour, is_booked) VALUES (:trainer_id, :shift_date, :work_hour, FALSE)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':trainer_id', $trainer_id, PDO::PARAM_INT);
            $stmt->bindParam(':shift_date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':work_hour', $hour, PDO::PARAM_STR);

            if (!$stmt->execute()) {
                $allInsertsSuccessful = false;
                break; // 一つでも失敗したらループを抜ける
            }
        }
    }
}

if ($allInsertsSuccessful) {
    echo "<script>alert('シフト登録が完了しました'); window.location.href='trainer_shift.php';</script>";
} else {
    echo "<script>alert('シフト登録に失敗しました'); window.location.href='trainer_shift.php';</script>";
}

// 勤務時間を1時間単位で計算する関数
function calculateWorkHours($start_time, $end_time, $break_start_time, $break_end_time) {
    $start = new DateTime($start_time);
    $end = new DateTime($end_time);
    $break_start = new DateTime($break_start_time);
    $break_end = new DateTime($break_end_time);

    $work_hours = [];
    while ($start < $end) {
        if ($start >= $break_start && $start < $break_end) {
            // 休憩時間内の場合、次の時間にスキップ
            $start->add(new DateInterval('PT1H'));
            continue;
        }

        array_push($work_hours, $start->format('H:i:s'));
        $start->add(new DateInterval('PT1H'));
    }

    return $work_hours;
}

?>