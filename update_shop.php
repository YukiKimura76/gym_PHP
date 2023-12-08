<?php
// データベース設定
$host = 'localhost';
$dbname = 'pt_db';
$username = 'root';
$password = '';

// POSTデータを取得
$id = $_POST['id'];
$uname = $_POST['uname'];
$email = $_POST['email'];

try {
    // PDOインスタンスの作成
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // SQL文を準備
    $sql = "UPDATE add_shop SET shop_uname = :uname, shop_email = :email WHERE id = :id";

    // ステートメントの準備
    $stmt = $pdo->prepare($sql);

    // パラメータをバインド
    $stmt->bindValue(':uname', $uname, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    // SQL実行
    $stmt->execute();

    echo "更新成功";
} catch (PDOException $e) {
    echo "更新に失敗しました: " . $e->getMessage();
}
?>
