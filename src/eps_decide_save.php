<?php
require_once 'db_inc.php';

// 入力フォームからデータを受け取り、変数$decided, $sidに代入
if (isset($_POST['sid']) && isset($_POST['decided'])) {
    $sid = $_POST['sid'];
    $decided = intval($_POST['decided']); // 安全のため整数に変換

    // 配属結果をtbl_studentに登録するSQL文
    $sql = "UPDATE tbl_student SET decided = $decided WHERE sid = '$sid'";

    // データベースへ問合せのSQL($sql)を実行 
    if ($conn->query($sql)) {
        // メッセージをセッションに保存して一覧画面で表示することも可能
        $url='?do=eps_list';
        header('Location:' . $url);
        exit(); // 遷移後の処理を防止
    } else {
        echo "<p>エラーが発生しました: " . $conn->error . "</p>";
    }
} else {
    echo "<p>不正なアクセスです。</p>";
}
?>
