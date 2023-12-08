<?php
ini_set('display_errors', 1);

// DB接続情報
$pdo = new PDO('mysql:dbname=pt_db;charset=utf8;host=localhost', 'root', '');

// フォームから送信されたデータを取得
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // パスワードのハッシュ化
$role = $_POST['role'];

// SQLクエリの準備と実行
$sql = "INSERT INTO user_management (username, email, password, role) VALUES (:username, :email, :password, :role)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username);
$stmt->bindValue(':email', $email);
$stmt->bindValue(':password', $password);
$stmt->bindValue(':role', $role);

if ($stmt->execute()) {
    header('Location: user_management.php'); // ユーザー管理ページにリダイレクト
} else {
    echo "ユーザー追加に失敗しました。";
}
?>