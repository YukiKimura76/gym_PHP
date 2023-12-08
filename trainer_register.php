<?php 
require_once 'funcs.php';
checkAndRedirect();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>トレーナー登録</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
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

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="file"],
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #5cb85c;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        .form-group input[type="submit"]:hover {
            background-color: #4cae4c;
        }

        .logo-image {
            width: 100%;
            max-width: 80px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
    <img src="./img/logo.png" alt="logo" class="logo-image">
        <h2>トレーナー登録フォーム</h2>
        <form action="submit_trainer_info.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="tname">名前:</label>
                <input type="text" id="tname" name="tname">
            </div>
            <div class="form-group">
                <label for="experience_years">経験年数:</label>
                <input type="number" id="experience_years" name="experience_years">
            </div>
            <div class="form-group">
                <label for="expertise">専門分野と資格:</label>
                <textarea id="expertise" name="expertise"></textarea>
            </div>
            <div class="form-group">
                <label for="awards">表彰歴:</label>
                <textarea id="awards" name="awards"></textarea>
            </div>
            <div class="form-group">
                <label for="personal_message">お客様へ一言:</label>
                <textarea id="personal_message" name="personal_message"></textarea>
            </div>
            <div class="form-group">
                <label for="t_email">メールアドレス:</label>
                <input type="text" id="t_email" name="t_email">
            </div>
            <div class="form-group">
                <label for="phone_number">電話番号:</label>
                <input type="number" id="phone_number" name="phone_number">
            </div>
            <div class="form-group">
                <input type="submit" value="登録">
            </div>
        </form>
    </div>
</body>
</html>