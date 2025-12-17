<h3>希望状況一覧</h3>
<?php
require_once 'db_inc.php'; // mysqliで$connを使用

// 希望状況一覧のSQL
// 学生情報に対し、希望プログラム（未提出ならNULL）と配属プログラムをJOIN
$sql = "
SELECT 
  s.sid, s.sname, s.sex, s.gpa, s.credit, 
  w.pid AS wish_pid, p1.pname AS wish_pname, 
  s.decided, p2.pname AS decided_pname
FROM tbl_student s
LEFT JOIN tbl_wish w ON s.sid = w.sid
LEFT JOIN tbl_program p1 ON w.pid = p1.pid
LEFT JOIN tbl_program p2 ON s.decided = p2.pid
ORDER BY s.sid
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr>
            <th>学籍番号</th>
            <th>氏名</th>
            <th>性別</th>
            <th>GPA</th>
            <th>修得単位数</th>
            <th>本人希望</th>
            <th>配属結果</th>
            <th>配属決定</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        $sex_label = ($row['sex'] == 1) ? "男" : "女";
        $wish_label = $row['wish_pid'] ? "{$row['wish_pid']} - {$row['wish_pname']}" : "未提出";
        $decided_label = $row['decided'] == 0 ? "未配属" : "{$row['decided']} - {$row['decided_pname']}";

        echo "<tr>";
        echo "<td>{$row['sid']}</td>";
        echo "<td>{$row['sname']}</td>";
        echo "<td>{$sex_label}</td>";
        echo "<td>{$row['gpa']}</td>";
        echo "<td>{$row['credit']}</td>";
        echo "<td>{$wish_label}</td>";
        echo "<td>{$decided_label}</td>";
         echo '<td><a href="?do=eps_decide&sid=' . $row['sid'] . '">配属決定</a></td>';
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "データがありません。";
}

$conn->close();
?>
