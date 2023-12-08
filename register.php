<?php 
require_once 'funcs.php';
checkAndRedirect();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録</title>
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

        .register-container {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .register-logo {
            margin-bottom: 20px;
        }

        .register-logo img {
            max-width: 100%;
            height: auto;
        }

        input[type=text], input[type=email], input[type=password] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type=submit] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #5cb85c;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        input[type=submit]:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-logo">
            <img src="./img/logo.png" alt="ロゴ">
        </div>
        <h2>会員登録</h2>
        <form action="./register_insert.php" method="post">
            <input type="text" name="uname" placeholder="ユーザー名">
            <input type="email" name="email" placeholder="メールアドレス">
            <input type="password" name="upass" placeholder="パスワード">
            <input type="submit" value="登録">
        </form>
    </div>
</body>
</html>
