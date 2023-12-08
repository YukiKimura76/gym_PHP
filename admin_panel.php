<!-- <?php 
require_once 'funcs.php';
checkAndRedirect();
?> -->

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>顧客管理画面</title>
    <link rel="stylesheet" href="./css/shop_register.css">
</head>
<body>
    <h1>システム側管理画面</h1>

    <!-- 新規店舗管理者の追加フォーム -->
    
    <form method="POST" class="add-form" action="add_shop.php">
    <h2>新しいジムを追加</h2>
        ユーザーネーム: <input type="text" name="shop_uname" required><br>
        メールアドレス: <input type="email" name="shop_email" required><br>
        パスワード: <input type="password" name="shop_pass" required><br>
        <label for="role">権限種別:</label>
        <select name="role" id="role">
            <option value="user">一般</option>
            <option value="admin">店舗責任者</option>
        </select>
        <input type="submit" class="form-submit" value="追加">
    </form>

    <!-- 既存の店舗管理者一覧 -->
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

            // 店舗管理者の一覧を取得
            $stmt = $pdo->prepare("SELECT * FROM add_shop");
            $stmt->execute();
            $trainers = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($trainers) {
                foreach ($trainers as $trainer) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($trainer['id'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td><span class='view-mode'>" . htmlspecialchars($trainer['shop_uname'], ENT_QUOTES, 'UTF-8') . "</span>
                            <input type='text' class='edit-mode' value='" . htmlspecialchars($trainer['shop_uname'], ENT_QUOTES, 'UTF-8') . "' style='display:none;'></td>";
                    echo "<td><span class='view-mode'>" . htmlspecialchars($trainer['shop_email'], ENT_QUOTES, 'UTF-8') . "</span>
                            <input type='text' class='edit-mode' value='" . htmlspecialchars($trainer['shop_email'], ENT_QUOTES, 'UTF-8') . "' style='display:none;'></td>";
                    echo "<td>" . htmlspecialchars($trainer['role'], ENT_QUOTES, 'UTF-8') . "</td>"; 
                    echo "<td>" . htmlspecialchars($trainer['created_at'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($trainer['updated_at'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>
                            <button onclick='toggleEditMode(this);'>変更</button>
                            <button onclick='saveChanges(this, " . $trainer['id'] . ");' style='display:none;'>保存</button>
                            <form method='POST' action='delete_shop.php' onsubmit='return confirmDelete()' style='display: inline;'>
                                <input type='hidden' name='id' value='" . $trainer['id'] . "'>
                                <input type='submit' value='削除' class='operation-button'>
                            </form>
                        </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>店舗管理者はまだ登録されていません。</td></tr>";
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
        xhr.open('POST', 'update_shop.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // レスポンス処理
                console.log(this.responseText);
            }
        };
        xhr.send('id=' + id + '&uname=' + encodeURIComponent(updatedUname) + '&email=' + encodeURIComponent(updatedEmail));

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
