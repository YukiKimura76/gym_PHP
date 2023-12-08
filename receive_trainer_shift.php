<?php


// DB接続
$pdo = new PDO('mysql:dbname=pt_db;charset=utf8;host=localhost', 'root', '');

// 選択されたトレーナーIDと日付を取得
$selectedDate = $_GET['date'] ?? date('Y-m-d');
$selected_trainer_id = $_GET['trainer'] ?? null;
$selected_date = $_GET['date'] ?? null;

if ($selected_trainer_id && $selected_date) {
    // 選択されたトレーナーのシフト情報を取得
    $sql = "SELECT * FROM trainer_shifts WHERE trainer_id = :trainer_id AND shift_date = :shift_date";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':trainer_id', $selected_trainer_id, PDO::PARAM_INT);
    $stmt->bindParam(':shift_date', $selected_date, PDO::PARAM_STR);
    $stmt->execute();
    $shifts = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// HTMLテーブルでシフト情報を表示
echo '<style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 50px;
            margin-left: 80px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            width: 50%;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        .time-slot {
            background-color: #f2f2f2;
        }

        .no-shift {
            background-color: #cccccc; /* 灰色 */
        }

        .available-shift a {
            color: inherit;
            text-decoration: none;
        }

        .available-shift:hover {
            background-color: #4CAF50;
            opacity:75%;
            cursor: pointer;
            color: white;
        }



      </style>';

echo "<table>";
echo "<tr>
        <th>時間 (" . htmlspecialchars($selectedDate) . ")</th>
        <th>ステータス</th>
    </tr>";

// 8:00-22:00の時間枠を生成
for ($hour = 8; $hour <= 22; $hour++) {
    echo "<tr>";
    echo "<td>" . sprintf("%02d:00 - %02d:00", $hour, $hour + 1) . "</td>";

    // シフトの存在と予約状況を確認
    $isAvailable = false;
    foreach ($shifts as $shift) {
        $shiftHour = DateTime::createFromFormat('H:i:s', $shift['work_hour'])->format('H');
        if ($hour == $shiftHour && $shift['is_booked'] == false) {
            $isAvailable = true;
            break;
        }
    }

    // シフトが予約可能な場合は「予約可能」、そうでない場合は「予約不可」と表示
    if ($isAvailable) {
        $shiftId = $shift['shift_id'];
        echo "<td class='available-shift'><a href='booking.php?trainer_id=" . urlencode($selected_trainer_id) . "&date=" . urlencode($selectedDate) . "&time=" . urlencode($hour) . "&shift_id=" . urlencode($shiftId) .  "'>予約可能</a></td>";
    } else {
        echo "<td class='no-shift'>予約不可</td>";
    }
    echo "</tr>";
}

echo "</table>";