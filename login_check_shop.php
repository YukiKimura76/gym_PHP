<?php
require_once 'funcs.php';

/* DB接続 */
try {
    $pdo = new PDO('mysql:dbname=pt_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
    exit('DB_CONNECTION:'.$e->getMessage());
}

/* DBにあるログイン情報を取りにいく */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $upass = $_POST["upass"];

    $stmt = $pdo->prepare("SELECT * FROM add_shop WHERE shop_email = :email");
    $stmt->bindValue(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($upass, $user['shop_pass'])) {
        // 権限情報もセッションに保存
        $_SESSION["user"] = $user;
        $_SESSION["role"] = $user['role']; // 権限情報をセッションに格納

        header("Location: dashboard.php");
        exit;
    } else {
        echo "<script>
        alert('メールアドレスまたはパスワードが間違っています。');
        window.location.href='login_shop.php'; // ログインページにリダイレクト
        </script>";
    }
}
?>
