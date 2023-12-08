<?php 
require_once 'funcs.php';
checkAndRedirect();

// DB接続
$pdo = new PDO('mysql:dbname=pt_db;charset=utf8;host=localhost', 'root', '');

// セッションデータとトレーナー名を取得
$sql = "SELECT st.*, pt.tname FROM sessions_table st LEFT JOIN pt_trainers pt ON st.trainer_id = pt.trainer_id";
$stmt = $pdo->query($sql);
$sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>セッション一覧</title>
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
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>セッション一覧</h1>

    <table>
        <tr>
            <th>セッション名</th>
            <th>トレーナー名</th>
            <th>日付</th>
            <th>開始時間</th>
            <th>終了時間</th>
        </tr>
        <?php foreach ($sessions as $session): ?>
            <tr>
                <td><?php echo htmlspecialchars($session['session_name']); ?></td>
                <td><?php echo htmlspecialchars($session['tname']); ?></td>
                <td><?php echo htmlspecialchars($session['session_date']); ?></td>
                <td><?php echo htmlspecialchars($session['start_time']); ?></td>
                <td><?php echo htmlspecialchars($session['end_time']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
