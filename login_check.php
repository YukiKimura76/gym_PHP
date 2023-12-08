<?php
session_start();

/* DB接続 */
try {
    //Password:MAMP='root',XAMPP=''
    $pdo = new PDO('mysql:dbname=pt_db;charset=utf8;host=localhost','root','');
  } catch (PDOException $e) {
    exit('DB_CONNECTION:'.$e->getMessage());
  }


/* DBにあるログイン情報を取りにいく */
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST["email"];
    $upass = $_POST["upass"];

    $stmt = $pdo->prepare("SELECT * FROM pt_register where email = :email AND upass = :upass");
    $stmt -> bindValue(':email',$email);
    $stmt -> bindValue(':upass', $upass);
    $stmt -> execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user){
        $_SESSION["user"] = $user;
        header("Location: sessions.php");
        exit;
    } else{
      echo "<script>
      alert('メールアドレスまたはパスワードが間違っています。');
      window.location.href='login.php'; // ログインページにリダイレクト
      </script>";
  
    };
};

?>