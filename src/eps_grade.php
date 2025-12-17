<h3>成績確認</h3>
<?php
require_once 'db_inc.php'; // DB接続（$conn）

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$uid = $_SESSION['uid'];
$sid = strtoupper($uid); // 学籍番号（例：s0001 → S0001）

// 学生情報を取得
$sql = "SELECT sid, sname, sex, gpa, credit FROM tbl_student WHERE sid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $sid);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo "<table border='1'>";
    echo "<tr><th>学籍番号</th><th>氏名</th><th>性別</th><th>GPA</th><th>修得単位数</th></tr>";
    $sex_label = $row['sex'] == 1 ? "男" : "女";
    echo "<tr>";
    echo "<td>{$row['sid']}</td>";
    echo "<td>{$row['sname']}</td>";
    echo "<td>{$sex_label}</td>";
    echo "<td>{$row['gpa']}</td>";
    echo "<td>{$row['credit']}</td>";
    echo "</tr></table>";
} else {
    echo "学生情報が見つかりません。";
}
$stmt->close();
?>
