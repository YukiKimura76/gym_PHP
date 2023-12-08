<?php 
require_once 'funcs.php';
checkAndRedirect();
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>週間シフト登録</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .shift-form-container {
            background: #fff;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group h3 {
            color: #4CAF50;
            margin-bottom: 10px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="time"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #5cb85c;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #4cae4c;
        }

        .select-style {
            display: block;
            width: 25%;
            padding: 10px;
            margin-bottom: 15px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            font-size: 16px;
        }

        .select-style option {
            padding: 10px;
        }

        label img {
            width: 24px;
            height: 24px;
        }


    </style>
    <script>
        function addShiftForm(date, day) {
            const container = document.getElementById('shift-forms-container');
            const formGroup = document.createElement('div');
            formGroup.className = 'form-group';
            formGroup.innerHTML = `
                <h3>${date}</h3>
                <input type="hidden" name="date_${day}" value="${date}">
                <label for="start_time_${day}">開始時間:</label>
                <input type="time" id="start_time_${day}" name="start_time_${day}">
                <label for="end_time_${day}">終了時間:</label>
                <input type="time" id="end_time_${day}" name="end_time_${day}">
                <label for="break_start_time_${day}">休憩開始時間:</label>
                <input type="time" id="break_start_time_${day}" name="break_start_time_${day}">
                <label for="break_end_time_${day}">休憩終了時間:</label>
                <input type="time" id="break_end_time_${day}" name="break_end_time_${day}">
            `;
            container.appendChild(formGroup);
        }

        function generateWeekForms() {
            const currentDate = new Date();
            const currentDayOfWeek = currentDate.getDay();
            const startDate = new Date(currentDate);
            startDate.setDate(currentDate.getDate() - currentDayOfWeek + 7);

            for (let day = 0; day < 7; day++) {
                const date = new Date(startDate);
                date.setDate(startDate.getDate() + day);
                const dateString = `${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getDate().toString().padStart(2, '0')}`;
                addShiftForm(dateString, day);
            }
        }

        window.onload = generateWeekForms;
    </script>
</head>

<?php
// DB接続
$pdo = new PDO('mysql:dbname=pt_db;charset=utf8;host=localhost', 'root', '');

// トレーナーIDおよびトレーナー名を取得
$sql = "SELECT trainer_id, tname FROM pt_trainers";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$trainers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
<?php include 'navbar.php'; ?>
    <div class="shift-form-container">
        <h2>トレーナーの週間シフト登録</h2>
        <form action="submit_weekly_shift.php" method="post">
            <div class="form-group">
            <label for="trainer">
                <img src="./img/icons_trainer.png" alt="Trainer Icon">
            </label>
                <select id="trainer" name="trainer" class="select-style">
                    <?php foreach ($trainers as $trainer): ?>
                        <option value="<?php echo htmlspecialchars($trainer['trainer_id']); ?>">
                            <?php echo htmlspecialchars($trainer['tname']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div id="shift-forms-container">
                <!-- JavaScriptの結果はここに反映 -->
            </div>
            <div class="form-group">
                <input type="submit" value="登録">
            </div>
        </form>

    </div>
</body>
</html>
