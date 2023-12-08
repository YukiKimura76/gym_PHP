

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            display: flex;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .login-logo {
            background-color:white;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 150px;
        }

        .login-logo img {
            max-width: 100%;
            max-height: 150px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .login-form {
            padding: 20px;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            max-width: 350px;
        }

        input[type=email], input[type=password] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
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
        }

        input[type=submit]:hover {
            background-color: #4cae4c;
        }

        a {
            font-size: 10px;
        }

    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-logo">
            <img src="./img/logo.png" alt="logo">
        </div>
        <div class="login-form">
            <form method="POST" action="./login_check.php">
                <input type="email" name="email" placeholder="メールアドレス">
                <input type="password" name="upass" placeholder="パスワード">
                <input type="submit" value="ログイン">
                <a href="register.php">新規会員登録はこちら</a>
            </form>
        </div>
    </div>
</body>
</html>
