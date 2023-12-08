<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $shop_uname = $_POST['shop_uname'];
    $shop_email = $_POST['shop_email'];
    $shop_pass = password_hash($_POST['shop_pass'], PASSWORD_DEFAULT); // パスワードのハッシュ化
    $role = $_POST['role'];

    try {
        $pdo = new PDO('mysql:dbname=pt_db;charset=utf8;host=localhost', 'root', '');
        $stmt = $pdo->prepare("INSERT INTO add_shop (shop_uname, shop_email, shop_pass, role, created_at, updated_at) VALUES (:shop_uname, :shop_email, :shop_pass, :role, NOW(), NOW())");
        $stmt->bindValue(':shop_uname', $shop_uname);
        $stmt->bindValue(':shop_email', $shop_email);
        $stmt->bindValue(':shop_pass', $shop_pass);
        $stmt->bindValue(':role', $role);
        $stmt->execute();

        header("Location: admin_panel.php"); // 管理画面にリダイレクト
    } catch (PDOException $e) {
        exit('DB Error: ' . $e->getMessage());
    }
}
?>
