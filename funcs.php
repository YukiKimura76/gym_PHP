<?php
session_start();

function checkLogin() {
    // ログイン状態を確認するロジック
    if (isset($_SESSION['user'])) {
        return true;
    }
    return false;
}

function checkAndRedirect() {
    if (!isset($_SESSION['user'])) {
        header("Location: login_shop.php");
        exit;
    }
}

function logout() {
    // ログアウト処理
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    session_destroy();
}
