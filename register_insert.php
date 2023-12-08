<?php
ini_set('display_errors', "On");
session_start();

$uname = $_POST["uname"];
$email = $_POST["email"];
$upass = $_POST["upass"];

$hashed_upass = password_hash($upass, PASSWORD_DEFAULT);

/* DB接続 */
try {
    //upass:MAMP='root',XAMPP=''
    $pdo = new PDO('mysql:dbname=pt_db;charset=utf8;host=localhost','root',''); //テーブル名ではなくDB名 XAMPPはIDはroot
    } catch (PDOException $e) { 
    exit('DB_CONNECTION:'.$e->getMessage()); //DB接続できなかった場合の処理　　->は「〜の中の」
    } 

/* My SQLにテーブル作成 */
$sql = "INSERT INTO pt_register (uname,email,upass,indate) VALUES (:uname,:email,:upass,sysdate())";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':uname', $uname, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':upass', $hashed_upass, PDO::PARAM_STR); 
$status = $stmt->execute();

/* データ登録処理ご */
if($status==false){
        $error = $stmt->errorInfo();
        exit ("SQL Error:".$error[2]);
    }else{
        header("Location: registered.php");
        exit;
}
?>