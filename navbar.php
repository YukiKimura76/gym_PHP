<div class="dashboard-nav">
    <h1>店舗管理画面</h1>
    <nav>
        <ul>
            <li><a href="dashboard.php">TOP</a></li>
            <li><a href="trainer_register.php">トレーナー登録</a></li>
            <li><a href="trainer_shift.php">シフト登録</a></li>
            <li><a href="add.sessions.php">セッション登録</a></li>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <li><a href="user_management.php">ユーザー管理</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION['user'])): ?>
                <!-- <li>ログイン中: <?php echo $_SESSION['user']['username']; ?></li> -->
                <li><a href="logout.php">ログアウト</a></li>
            <?php else: ?>
                <li><a href="login_shop.php">ログイン</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<style>
    .dashboard-nav {
        background-color: #5cb85c;
        color: white;
        padding: 10px 20px;
        text-align: center;
    }

    .dashboard-nav h1 {
        margin: 0;
    }

    .dashboard-nav nav ul {
        padding: 0;
        list-style: none;
    }

    .dashboard-nav nav ul li {
        display: inline;
        margin-right: 20px;
    }

    .dashboard-nav nav ul li a {
        color: white;
        text-decoration: none;
    }
</style>