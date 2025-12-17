<h3>配属結果確認</h3>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'db_inc.php'; // mysqliで$connを使用

$uid = $_SESSION['uid'];
$sid = strtoupper($uid); // 学籍番号（ユーザIDの大文字変換）

// 1. 希望プログラムをtbl_wishテーブルから取得
$sql = "SELECT pid FROM tbl_wish WHERE sid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $sid);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $pid = $row['pid']; // 希望プログラムID
} else {
    $pid = 0; // 未提出の場合
}
$stmt->close();

// 2. 学生データと配属プログラム名を取得（decidedが0なら未配属）
$sql = "
    SELECT s.sid, s.sname, s.sex, s.gpa, s.credit, s.decided, p.pname 
    FROM tbl_student s
    LEFT JOIN tbl_program p ON s.decided = p.pid
    WHERE s.sid = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $sid);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // 性別の表示
    $sex_label = ($row['sex'] == 1) ? "男" : "女";

    // 希望プログラム名を取得（pidが0なら「未提出」）
    if ($pid == 0) {
        $wish_label = "未提出";
    } else {
        // 希望プログラム名を取得するSQL（1回のクエリで済ませたい場合はJOINを使う方法もありますが）
        $wish_sql = "SELECT pname FROM tbl_program WHERE pid = ?";
        $wish_stmt = $conn->prepare($wish_sql);
        $wish_stmt->bind_param("i", $pid);
        $wish_stmt->execute();
        $wish_result = $wish_stmt->get_result();
        $wish_label = ($wish_row = $wish_result->fetch_assoc()) ? $wish_row['pname'] : "不明";
        $wish_stmt->close();
    }

    // 配属結果の表示
    $decided_label = ($row['decided'] == 0) ? "未配属" : $row['pname'];

    echo "<table border='1'>";
    echo "<tr><th>学籍番号</th><th>氏名</th><th>性別</th><th>GPA</th><th>修得単位数</th><th>本人希望</th><th>配属結果</th></tr>";
    echo "<tr>";
    echo "<td>{$row['sid']}</td>";
    echo "<td>{$row['sname']}</td>";
    echo "<td>{$sex_label}</td>";
    echo "<td>{$row['gpa']}</td>";
    echo "<td>{$row['credit']}</td>";
    echo "<td>{$wish_label}</td>";
    echo "<td>{$decided_label}</td>";
    echo "</tr>";
    echo "</table>";
} else {
    echo "学生情報が見つかりません。";
}

$stmt->close();
$conn->close();
?>
