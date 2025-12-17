<?php
require_once 'db_inc.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ログイン確認
if (!isset($_SESSION['uid'])) {
    echo "<p>ログインしていません。</p>";
    exit;
}

$uid = $_SESSION['uid']; // ログイン中のユーザID
$sid = strtoupper($uid); // 学籍番号（大文字変換）

if (isset($_POST['act'])) {
    // 入力フォームからデータを受け取り、変数に代入
    $act = $_POST['act'];
    $pid = isset($_POST['pid']) ? (int)$_POST['pid'] : 0;
    $reason = isset($_POST['reason']) ? $_POST['reason'] : '';

    if ($act === 'update') {
        // 希望情報の更新
        $stmt = $conn->prepare("UPDATE tbl_wish SET pid = ?, reason = ? WHERE sid = ?");
        $stmt->bind_param("iss", $pid, $reason, $sid);
    } else {
        // 新規希望情報の登録
        $stmt = $conn->prepare("INSERT INTO tbl_wish(sid, pid, reason) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $sid, $pid, $reason);
    }

    // SQL実行と結果メッセージ
    if ($stmt->execute()) {
        echo "<p>希望情報を登録しました。</p>";
    } else {
        echo "<p>エラーが発生しました: " . htmlspecialchars($stmt->error, ENT_QUOTES, 'UTF-8') . "</p>";
    }

    $stmt->close();
}
?>
