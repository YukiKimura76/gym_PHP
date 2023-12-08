<?php
ini_set('display_errors', "On");
session_start();

/* POSTデータの取得 */
$tname = $_POST['tname'];
$experience_years = $_POST['experience_years'];
$expertise = $_POST['expertise'];
$awards = $_POST['awards'];
$personal_message = $_POST['personal_message'];
$t_email = $_POST['t_email'];
$phone_number = $_POST['phone_number'];
var_dump($tname);

/* DB接続 */
try {
    $pdo = new PDO('mysql:dbname=pt_db;charset=utf8;host=localhost','root',''); 
    } catch (PDOException $e) { 
    exit('DB_CONNECTION:'.$e->getMessage()); 
    } 

/* My SQLに送信 */
$sql = "INSERT INTO pt_trainers (tname, experience_years, expertise, awards, personal_message, t_email, phone_number, created_at, updated_at) VALUES (:tname, :experience_years, :expertise, :awards, :personal_message, :t_email, :phone_number,sysdate(),sysdate())";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':tname', $tname, PDO::PARAM_STR);
$stmt->bindValue(':experience_years', $experience_years, PDO::PARAM_INT);
$stmt->bindValue(':expertise', $expertise, PDO::PARAM_STR);
$stmt->bindValue(':awards', $awards, PDO::PARAM_STR);
$stmt->bindValue(':personal_message', $personal_message, PDO::PARAM_STR);
$stmt->bindValue(':t_email', $t_email, PDO::PARAM_STR);
$stmt->bindValue(':phone_number', $phone_number, PDO::PARAM_STR);

// SQLを実行
if($stmt->execute()) {
    echo "<script>
      alert('登録完了しました');
      window.location.href='sessions.php'; //ページ構成が決まったら再度遷移先検討
      </script>";
} else {
    echo "<script>
      alert('登録に失敗しました');
      window.location.href='trainer_register.php';
      </script>";
};
?>
