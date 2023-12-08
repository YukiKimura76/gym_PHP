<?php
// DB接続情報
$pdo = new PDO('mysql:dbname=pt_db;charset=utf8;host=localhost', 'root', '');

// POSTからIDを取得
$id = $_POST['id'];

// SQLクエリの準備と実行
$sql = "DELETE FROM user_management WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    header('Location: user_management.php'); // ユーザー管理ページにリダイレクト
} else {
    echo "ユーザー削除に失敗しました。";
}
?>
