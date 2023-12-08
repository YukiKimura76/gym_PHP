<?php

require_once 'funcs.php';
checkAndRedirect();

// DB接続とデータ取得のロジック
$pdo = new PDO('mysql:dbname=pt_db;charset=utf8;host=localhost', 'root', '');

$trainer_id = $_GET['trainer_id'] ?? '';
$date = $_GET['date'] ?? '';
$time = $_GET['time'] ?? '';

$trainerName = '';
if ($trainer_id) {
    $stmt = $pdo->prepare("SELECT tname FROM pt_trainers WHERE trainer_id = :trainer_id");
    $stmt->bindParam(':trainer_id', $trainer_id, PDO::PARAM_INT);
    $stmt->execute();
    $trainer = $stmt->fetch(PDO::FETCH_ASSOC);
    $trainerName = $trainer['tname'] ?? '不明なトレーナー';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            width: 50%;
            margin: auto;
            overflow: hidden;
        }

        .card {
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 5px;
        }

        h2 {
            color: #333;
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        p {
            font-size: 1.1em;
            margin-bottom: 10px;
        }

        form {
            margin-top: 20px;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background: #5cb85c;
            color: white;
            border: 0;
            cursor: pointer;
            border-radius: 5px;
        }

        input[type="submit"]:hover {
            background: #5cb85c;
            opacity: 75%;

        }

        .checkbox-group {
            margin: 20px 0;
        }

        .checkbox-group input {
            margin-right: 10px;
        }

        .checkbox-group label {
            font-size: 1em;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h2>予約詳細</h2>
            <p>トレーナー名: <?php echo htmlspecialchars($trainerName); ?></p>
            <p>日付: <?php echo htmlspecialchars($date); ?></p>
            <p>時間: <?php echo htmlspecialchars($time); ?>:00</p>
            <p>場所: 東京都渋谷区XXXXXX</p>

            <h3>キャンセル規約</h3>
            <p>レッスン開始24時間前までにキャンセルの場合はキャンセル料は発生しません。それ以降のキャンセルについては全額のキャンセル料が発生します。</p>

            <form action='submit_booking.php' method='post'>
                <div class="checkbox-group">
                    <input type='checkbox' id='agree' name='agree' required>
                    <label for='agree'>キャンセル規約に同意する</label>
                </div>
                <input type='submit' value='予約する' onclick="showThankYouMessage()">
                <input type='hidden' name='shift_id' value='<?php echo $_GET['shift_id']; ?>'>
            </form>
        </div>
    </div>
    <script>
        function showThankYouMessage() {
            alert("ご予約ありがとうございます。当日はお気をつけてお越しください。");
        }
    </script>
</body>
</html>
