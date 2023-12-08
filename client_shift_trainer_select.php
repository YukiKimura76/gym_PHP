<?php include 'receive_trainer_id.php'; ?>
<?php 
require_once 'funcs.php';
checkAndRedirect();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>シフトスケジュール</title>
    <style>
        body {
            padding-top: 50px;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 50vh;
            }

        .form-container {
            background: #fff;
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 10px;
        }

        select, input[type="date"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            margin-top: 50px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

    

    </style>
</head>

<body>
<?php include 'client_navbar.php'; ?>
    <form action="receive_trainer_shift.php" method="get">
        <label for="trainer-select">トレーナー</label>
        <select name="trainer" id="trainer-select">
            <?php foreach ($trainers as $trainer): ?>
                <option value="<?php echo htmlspecialchars($trainer['trainer_id']); ?>">
                    <?php echo htmlspecialchars($trainer['tname']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label for="date-select">日付</label>
        <input type="date" id="date-select" name="date">

        <input type="submit" value="シフトを表示">
    </form>
</body>

</html>
