<?php
// DB接続情報
$pdo = new PDO('mysql:dbname=pt_db;charset=utf8;host=localhost', 'root', '');

// フォームから送信されたデータを取得
$id = $_POST['id'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // パスワードのハッシュ化
$role = $_POST['role'];

// SQLクエリの準備と実行
$sql = "UPDATE user_management SET username = :username, email = :email WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id);
$stmt->bindValue(':username', $username);
$stmt->bindValue(':email', $email);

if ($stmt->execute()) {
    header('Location: user_management.php'); // ユーザー管理ページにリダイレクト
} else {
    echo "ユーザー更新に失敗しました。";
}

?>