<?php

require_once 'funcs.php';
checkAndRedirect();

// DB接続
$pdo = new PDO('mysql:dbname=pt_db;charset=utf8;host=localhost', 'root', '');

// 現在の日付を取得
$currentDate = date('Y-m-d');

// 予約済みシフト情報を取得（本日以降のみ）
$sql = "SELECT ts.shift_id, ts.trainer_id, ts.shift_date, ts.work_hour, pt.tname
        FROM trainer_shifts ts
        JOIN pt_trainers pt ON ts.trainer_id = pt.trainer_id
        WHERE ts.is_booked = 1 AND ts.shift_date >= :currentDate
        ORDER BY ts.shift_date ASC, ts.work_hour ASC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':currentDate', $currentDate);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予約済み一覧</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            color: black;
        }
        .button-group {
            display: flex;
            gap: 10px; /* ボタン間のスペース */
        }

        .button {
            background-color: blue; /* 例: 青色の背景 */
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
        }

        .button:hover {
            background-color: darkblue; /* ホバー時の背景色 */
        }

        .add-to-calendar {
            background: none;
            border: none;
            cursor: pointer; 
            padding: 0;
        }

        .add-to-calendar img {
            width: 30px; /* 画像のサイズを調整 */
            height: auto; /* 高さを自動調整 */
            margin-left: 10px;
        }


        .delete-button {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<?php include 'client_navbar.php'; ?>
    <h2>予約済み一覧</h2>
    <table>
        <tr>
            <th>トレーナー名</th>
            <th>日付</th>
            <th>開始時間</th>
            <th>終了時間</th>
            <th>操作</th>
        </tr>
        <?php foreach ($reservations as $reservation): ?>
            <tr>
                <td><?php echo htmlspecialchars($reservation['tname']); ?></td>
                <td><?php echo htmlspecialchars($reservation['shift_date']); ?></td>
                <td><?php echo htmlspecialchars($reservation['work_hour']); ?></td>
                <td><?php echo date('H:i:s', strtotime($reservation['work_hour'] . ' +1 hour')); ?></td>
                <td>
                    <div class="button-group">
                    <form action="delete_reservation.php" method="post" onsubmit="return confirmDelete();">
                        <input type="hidden" name="shift_id" value="<?php echo $reservation['shift_id']; ?>">
                        <input type="submit" value="削除" class="delete-button">
                    </form>
                    <script>
                        function confirmDelete() {
                            if (confirm("本当に削除しますか？")) {
                                // ユーザーがOKをクリックした場合
                                return true;
                            } else {
                                // ユーザーがキャンセルをクリックした場合
                                return false;
                            }
                        }
                    </script>
                    <button class="add-to-calendar" data-id="<?php echo $reservation['shift_id']; ?>" data-date="<?php echo $reservation['shift_date']; ?>" data-time="<?php echo $reservation['work_hour']; ?>" data-trainer="<?php echo htmlspecialchars($reservation['tname']); ?>">
                        <img src="./img/cal_plus.png" alt="カレンダーに追加" />
                    </button>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

<script>

function formatDateToUTC(date, time, hoursToAdd = 0) {
    const dateTime = new Date(date + 'T' + time);
    dateTime.setHours(dateTime.getHours() + hoursToAdd);

    if (isNaN(dateTime.getTime())) {
        console.error('Invalid date or time:', date, time);
        return null;
    }

    // UTC形式の日時文字列を返す（末尾は 'Z'）
    return dateTime.toISOString().replace(/-|:|\.\d\d\d/g, '');
}


function generateICalData(id, startDate, workHour, trainerName) {
    const startDateTime = formatDateToUTC(startDate, workHour);
    const endDateTime = formatDateToUTC(startDate, workHour, 1); // 1時間後の時間を終了時間とする

    // 現在の日時をUTC形式で取得
    const now = new Date();
    const dtStamp = formatDateToUTC(now.toISOString().split('T')[0], now.toISOString().split('T')[1].substring(0, 8));

    if (!startDateTime || !endDateTime || !dtStamp) {
        return null; // 無効な日付の場合は処理を中断
    }

    const icalData = [
        'BEGIN:VCALENDAR',
        'VERSION:2.0',
        'PRODID:-//AAA//BBB//EN',
        'BEGIN:VEVENT',
        `UID:${id}@sample.com`,
        `DTSTAMP:${dtStamp}`,
        `DTSTART:${startDateTime}`,
        `DTEND:${endDateTime}`,
        'SUMMARY:パーソナル予約',
        `DESCRIPTION:担当トレーナーは ${trainerName} です。キャンセル変更は03-1111-2222までお電話ください`,
        'LOCATION:〒144-0052 東京都大田区蒲田１丁目３０−１３ ルアーナジム 101',
        'END:VEVENT',
        'END:VCALENDAR'
    ].join('\r\n');
console.log(icalData);
    return icalData;
}

document.addEventListener('DOMContentLoaded', () => {
document.querySelectorAll('.add-to-calendar').forEach(button => {
    button.addEventListener('click', (event) => {
        console.log('Button clicked');
        const id = button.dataset.id;
        const date = button.dataset.date;
        const time = button.dataset.time;
        const trainerName = button.dataset.trainer;

        const icalData = generateICalData(id, date, time, trainerName);
        downloadICalFile(icalData);
    });
});
});


function downloadICalFile(icalData) {
    const blob = new Blob([icalData], { type: 'text/calendar' });
    const url = URL.createObjectURL(blob);

    const a = document.createElement('a');
    a.href = url;
    a.download = 'reservation.ics';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}
</script>
</body>
</html>
