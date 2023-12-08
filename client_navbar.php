<?php 
require_once 'funcs.php';
checkAndRedirect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>クライアントナビゲーションバー</title>
    <style>
        .client-navbar {
            background-color: #5cb85c;
            color: white;
            padding: 10px 20px;
            text-align: center;
            position: fixed; 
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .client-navbar ul {
            padding: 0;
            list-style: none;
        }

        .client-navbar ul li {
            display: inline;
            margin-right: 20px;
        }

        .client-navbar ul li a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="client-navbar">
        <ul>
            <li><a href="client_shift_trainer_select.php">パーソナルレッスン予約</a></li>
            <li><a href="sessions.php">セッション予約</a></li>
            <li><a href="booking_list.php">予約済一覧</a></li>
        </ul>
    </div>
</body>
</html>
