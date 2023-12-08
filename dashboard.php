<?php 
require_once 'funcs.php';
checkAndRedirect();

// DB接続
$pdo = new PDO('mysql:dbname=pt_db;charset=utf8;host=localhost', 'root', '');

// 現在の年月を取得
$currentYear = date('Y');
$currentMonth = date('m');

// 現在の月のシフトを取得
// トレーナーシフトとセッションデータを取得
$sqlShifts = "SELECT ts.*, DATE_FORMAT(ts.work_hour, '%H:%i') AS formatted_work_hour, pt.tname FROM trainer_shifts ts JOIN pt_trainers pt ON ts.trainer_id = pt.trainer_id WHERE MONTH(ts.shift_date) = :currentMonth AND YEAR(ts.shift_date) = :currentYear";
$sqlSessions = "SELECT st.*, DATE_FORMAT(st.start_time, '%H:%i') AS formatted_start_time, pt.tname FROM sessions_table st JOIN pt_trainers pt ON st.trainer_id = pt.trainer_id WHERE MONTH(st.session_date) = :currentMonth AND YEAR(st.session_date) = :currentYear";

$stmtShifts = $pdo->prepare($sqlShifts);
$stmtShifts->bindValue(':currentYear', $currentYear, PDO::PARAM_INT);
$stmtShifts->bindValue(':currentMonth', $currentMonth, PDO::PARAM_INT);
$stmtShifts->execute();
$shifts = $stmtShifts->fetchAll(PDO::FETCH_ASSOC);

$stmtSessions = $pdo->prepare($sqlSessions);
$stmtSessions->bindValue(':currentYear', $currentYear, PDO::PARAM_INT);
$stmtSessions->bindValue(':currentMonth', $currentMonth, PDO::PARAM_INT);
$stmtSessions->execute();
$sessions = $stmtSessions->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>店舗管理ダッシュボード</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }

        .content {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .content section {
            margin-bottom: 40px;
        }

        .content h2 {
            color: #333;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        #calendar-container table {
            width: 100%;
            border-collapse: collapse;
        }

        #calendar-container th, 
        #calendar-container td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        #calendar-container th {
            background-color: #BFE9DB;
        }

        #calendar-container td {
            min-width: 100px;
            height: 100px;
            vertical-align: top;
            padding: 5px;
            overflow: hidden;
        }

        .shift-info {
            display: block;
            background-color: #dcdcdc;
            color: black;
            padding: 2px;
            margin-top: 5px;
            white-space: nowrap;
            text-decoration: none;
        }

        .shift-info:hover {
            text-decoration: none; 
            background-color: #757575;
        }

    </style>
</head>
<body>
    <?php require_once 'funcs.php'; ?>
    <?php include 'navbar.php'; ?>

    <div class="content">
            <section id="calendar-section">
                <h2>予約済み一覧（今月）</h2>
                <div id="calendar-container">
                    <!-- カレンダーの内容はここで表示 -->
                </div>
            </section>
        <!-- ユーザー管理セクション（管理者のみ表示） -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
            <section id="user-management">
                <h2>ユーザー管理</h2>
                <!-- ユーザー管理フォームの内容 -->
            </section>
        <?php endif; ?>
    </div>

    <script>
    const shifts = <?php echo json_encode($shifts); ?>;
    const sessions = <?php echo json_encode($sessions); ?>;

    function formatDateTime(date) {
        const pad = (num) => (num < 10 ? '0' + num : num);
        return date.getFullYear() +
            pad(date.getMonth() + 1) +
            pad(date.getDate()) +
            'T' +
            pad(date.getHours()) +
            pad(date.getMinutes()) +
            pad(date.getSeconds());
    }


    function createCalendar() {
        const container = document.getElementById('calendar-container');
        const currentDate = new Date();
        const currentMonth = currentDate.getMonth();
        const currentYear = currentDate.getFullYear();
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

        let calendarHtml = "<table><thead><tr>";

        // 曜日のヘッダーを追加
        const daysOfWeek = ['日', '月', '火', '水', '木', '金', '土'];
        for (let day of daysOfWeek) {
            calendarHtml += `<th>${day}</th>`;
        }

        calendarHtml += "</tr></thead><tbody><tr>";

        // 月の最初の日の曜日を取得
        const firstDay = new Date(currentYear, currentMonth, 1).getDay();

        // 最初の週の空白セルを追加
        for (let i = 0; i < firstDay; i++) {
            calendarHtml += "<td></td>";
        }

        // 日付のセルを追加
        for (let day = 1; day <= daysInMonth; day++) {
            if ((day + firstDay - 1) % 7 === 0 && day !== 1) {
                calendarHtml += "</tr><tr>";
            }

            let dayShifts = shifts.filter(shift => 
                new Date(shift.shift_date).getDate() === day && shift.is_booked == 1
            );
            let shiftHtml = dayShifts.map(shift => `
            <div class="shift-info" data-shift-id="${shift.id}">
                ${shift.formatted_work_hour} (${shift.tname})
            </div>
            `).join('');

            calendarHtml += `<td>${day}<div>${shiftHtml}</div></td>`;
            console.log(shifts);
        }

        calendarHtml += "</tr></tbody></table>";
        container.innerHTML = calendarHtml;

        // カレンダー生成後にイベントリスナーを設定
        document.querySelectorAll('.shift-info').forEach(element => {
            element.addEventListener('click', (event) => {
            event.stopPropagation();
                console.log('Shift info clicked');
                
                event.preventDefault();
                const shiftId = event.currentTarget.dataset.shiftId;
                const shift = shifts.find(s => s.id === shiftId);
                console.log(shift);
                

                if (shift) {
                    const icalData = generateICalData(shift);
                    const blob = new Blob([icalData], { type: 'text/calendar' });
                    const url = URL.createObjectURL(blob);

                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'shift.ics';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);
                }
            
            });
        });
    // console.log(document.querySelectorAll('.shift-info'));
    }

    window.onload = createCalendar;
    
</script>

</body>
</html>
