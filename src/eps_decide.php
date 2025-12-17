<?php
require_once 'db_inc.php';
$sid = $_GET['sid']; // URLパラメータから学籍番号取得

$pid = 0;
$reason = '';

// 学生の希望状況を取得
$sql = "SELECT pid, reason FROM tbl_wish WHERE sid = '$sid'";
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);

$row = $rs->fetch_assoc();
if ($row) {
    $pid = $row['pid'];
    $reason = $row['reason'];
}

// 学生情報（氏名・性別・GPA等）を取得
$sql = "SELECT sid, sname, sex, gpa, credit, decided FROM tbl_student WHERE sid = '$sid'";
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);
?>

<table border=1>
<tr><th>学籍番号</th><th>氏名</th><th>性別</th><th>GPA</th><th>修得単位数</th><th>本人希望</th><th>操作</th></tr>
<form action="?do=eps_decide_save" method="post">
<input type="hidden" name="sid" value="<?= htmlspecialchars($sid, ENT_QUOTES) ?>">
<?php 
$row = $rs->fetch_assoc();
if ($row) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['sid']) . '</td>';
    echo '<td>' . htmlspecialchars($row['sname']) . '</td>';
    echo '<td>' . ($row['sex'] == 1 ? '男' : '女') . '</td>';
    echo '<td>' . htmlspecialchars($row['gpa']) . '</td>';
    echo '<td>' . htmlspecialchars($row['credit']) . '</td>';
    echo '<td>';
    if ($pid == 0) {
        echo '未提出';
    } else {
        echo $pid . ' - ' . htmlspecialchars($reason);
    }
    echo '</td>';
    echo '<td>';

    // 配属決定ラジオボタンの表示
    $decided = $row['decided'];
    $codes = array(
        1 => '綜合教育',
        2 => '応用教育'
    );
    foreach ($codes as $key => $label) {
        $checked = ($decided == $key) ? 'checked' : '';
        echo "<label><input type='radio' name='decided' value='$key' $checked> $label</label><br>";
    }

    echo '</td>';
    echo '</tr>';
}
?>

<tr>
  <td><a href="?do=eps_list"><button type="button">戻る</button></a></td>
  <td colspan="5"></td>
  <td><input type="submit" value="送信">&nbsp;<input type="reset" value="取消"></td>
</tr>
</form>
</table>
