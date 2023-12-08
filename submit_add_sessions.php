<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sessionName = $_POST['sessionName'] ?? '';
    $date = $_POST['date'] ?? '';
    $startTime = $_POST['startTime'] ?? '';
    $endTime = $_POST['endTime'] ?? '';

    // データをファイルに保存
    $file = fopen("data/sessions.txt", "a");
    if ($file) {
        $newSession = $sessionName . "," . $date . "," . $startTime . "," . $endTime . "\n";
        fwrite($file, $newSession);
        fclose($file);
        echo "<p>セッションが追加されました。</p>";
    } else {
        echo "<p>エラー: セッションが追加できませんでした。</p>";
    }
}
?>
