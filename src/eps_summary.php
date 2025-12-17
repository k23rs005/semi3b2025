<h3>希望状況集計</h3>
<?php
require_once 'db_inc.php'; //データベースに接続する

$sql = "
SELECT p.pid, p.pname, COUNT(w.sid) AS people
FROM tbl_program p
LEFT JOIN tbl_wish w ON p.pid = w.pid
GROUP BY p.pid, p.pname
ORDER BY p.pid
";

$result = $conn->query($sql);
if (!$result) {
    die("クエリ実行エラー: " . $conn->error);
}

echo "<table border='1'>";
echo "<tr><th>プログラムID</th><th>プログラム名</th><th>希望人数</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['pid']}</td>";
    echo "<td>{$row['pname']}</td>";
    echo "<td>{$row['people']}</td>";
    echo "</tr>";
}
echo "</table>";

$conn->close();
?>
