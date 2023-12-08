<?php

require_once 'funcs.php';
checkAndRedirect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $sessionId = $_POST['sessionId'];
    $sessionName = $_POST['sessionName'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

    // // 予約データをフォーマット
    $reservationData = $email . "," . $sessionId . "," . $sessionName . "," . $startTime ."," . $endTime ."\n";
    // // 予約データをファイルに追記
    file_put_contents("data/reservations.txt", $reservationData, FILE_APPEND);

    echo "予約が完了しました。";
} else {
    header("Location: sessions.php"); // POSTでない場合はセッションページにリダイレクト
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>予約完了</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .message {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .message h1 {
            color: #4CAF50;
            margin: 0 0 20px 0; /* 下部のマージンを増やす */
        }

        .message a {
            display: block; /* インラインブロックからブロックに変更 */
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .message a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="message">
        <h1><?php echo $message; ?></h1>
        <a href="sessions.php">セッション一覧に戻る</a>
    </div>
</body>
</html>
