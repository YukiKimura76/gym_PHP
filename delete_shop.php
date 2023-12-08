<?php
// データベース設定
$host = 'localhost';
$dbname = 'pt_db';
$username = 'root';
$password = '';

// POSTからIDを取得
$id = $_POST['id'];

try {
    // PDOインスタンスの作成
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // エラーモードの設定
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL文を準備
    $sql = "DELETE FROM add_shop WHERE id = :id";

    // ステートメントの準備
    $stmt = $pdo->prepare($sql);

    // パラメータをバインド
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    // SQL実行
    $stmt->execute();

    header('Location: admin_panel.php');
    exit;

} catch (PDOException $e) {
    echo "削除に失敗しました: " . $e->getMessage();
    // エラーメッセージを表示した後、スクリプトの実行を終了
    exit;
}
?>
