<h3>未提出者一覧</h3>
<?php
require_once 'db_inc.php'; //データベースに接続する

$sql = "
SELECT s.sid, s.sname, s.sex, s.gpa, s.credit
FROM tbl_student s
LEFT JOIN tbl_wish w ON s.sid = w.sid
WHERE w.sid IS NULL
ORDER BY s.sid
";

$result = $conn->query($sql);
if (!$result) {
    die("クエリ実行エラー: " . $conn->error);
}

echo "<table border='1'>";
echo "<tr><th>学籍番号</th><th>氏名</th><th>性別</th><th>GPA</th><th>修得単位数</th></tr>";
while ($row = $result->fetch_assoc()) {
    $sex = ($row['sex'] == 1) ? "男" : (($row['sex'] == 2) ? "女" : "不明");
    echo "<tr>";
    echo "<td>{$row['sid']}</td>";
    echo "<td>{$row['sname']}</td>";
    echo "<td>{$sex}</td>";
    echo "<td>{$row['gpa']}</td>";
    echo "<td>{$row['credit']}</td>";
    echo "</tr>";
}
echo "</table>";

$conn->close();
?>
