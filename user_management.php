<?php 
require_once 'funcs.php';
checkAndRedirect();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>顧客管理画面</title>
    <link rel="stylesheet" href="./css/shop_register.css">
</head>
<body>
<?php include 'navbar.php'; ?>

    <!-- 新規ユーザーの追加フォーム -->
    <form method="POST" class="add-form" action="add_user.php">
        <h2>新しいユーザーを追加</h2>
        ユーザーネーム: <input type="text" name="username" required><br>
        メールアドレス: <input type="email" name="email" required><br>
        パスワード: <input type="password" name="password" required><br>
        <label for="role">権限種別:</label>
        <select name="role" id="role">
            <option value="user">一般</option>
            <option value="admin">店舗責任者</option>
        </select>
        <input type="submit" class="form-submit" value="追加">
    </form>

    <!-- 既存のユーザー一覧 -->
    <h2>登録済一覧</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ユーザーネーム</th>
                <th>メールアドレス</th>
                <th>権限種別</th>
                <th>作成日時</th>
                <th>更新日時</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // DB接続
            $pdo = new PDO('mysql:dbname=pt_db;charset=utf8;host=localhost', 'root', '');

            // ユーザーの一覧を取得
            $stmt = $pdo->prepare("SELECT * FROM user_management");
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($users) {
                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($user['user_id'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td><span class='view-mode'>" . htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') . "</span>
                            <input type='text' class='edit-mode' value='" . htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') . "' style='display:none;'></td>";
                    echo "<td><span class='view-mode'>" . htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') . "</span>
                            <input type='text' class='edit-mode' value='" . htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') . "' style='display:none;'></td>";
                    echo "<td>" . htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8') . "</td>"; 
                    echo "<td>" . htmlspecialchars($user['created_at'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($user['updated_at'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>
                            <button onclick='toggleEditMode(this);'>変更</button>
                            <button onclick='saveChanges(this, " . $user['id'] . ");' style='display:none;'>保存</button>
                            <form method='POST' action='delete_user.php' onsubmit='return confirmDelete()' style='display: inline;'>
                                <input type='hidden' name='id' value='" . $user['id'] . "'>
                                <input type='submit' value='削除' class='operation-button'>
                            </form>
                        </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>ユーザーはまだ登録されていません。</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <script>
    function toggleEditMode(button) {
        var tr = button.parentNode.parentNode;
        tr.querySelectorAll('.view-mode').forEach(function(span) {
            span.style.display = 'none';
        });
        tr.querySelectorAll('.edit-mode').forEach(function(input) {
            input.style.display = 'inline';
        });
        button.style.display = 'none';
        button.nextElementSibling.style.display = 'inline';
    }

    function saveChanges(button, id) {
        var tr = button.parentNode.parentNode;
        var updatedUname = tr.querySelector('.edit-mode[type="text"]').value;
        var updatedEmail = tr.querySelectorAll('.edit-mode[type="text"]')[1].value;

        // Ajaxリクエストでサーバーにデータを送信
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'edit_user.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // レスポンス処理
                console.log(this.responseText);
            }
        };
        xhr.send('id=' + id + '&username=' + encodeURIComponent(updatedUname) + '&email=' + encodeURIComponent(updatedEmail));

        // 以下のビューモードの切り替えは、レスポンスが正常であることを確認した後に行う
        tr.querySelectorAll('.view-mode')[0].textContent = updatedUname;
        tr.querySelectorAll('.view-mode')[1].textContent = updatedEmail;

        tr.querySelectorAll('.view-mode').forEach(function(span) {
            span.style.display = 'inline';
        });
        tr.querySelectorAll('.edit-mode').forEach(function(input) {
            input.style.display = 'none';
        });
        button.style.display = 'none';
        button.previousElementSibling.style.display = 'inline';
    }


    function confirmDelete() {
        return confirm("本当に削除してよろしいですか？");
    }
</script>
</body>
</html>
