<h3>画像付きアカウント一覧(ページネーション)</h3>
<?php
require_once 'db_inc.php';
define('MAX_ROWS', 4);//MAX_ROWS: 1ページに表示する最大行数

//結果の行数$num_rows, 最大ページ数$max_pageを計算する
$sql = "SELECT * FROM tbl_user ORDER BY urole,uid";
$rs = $conn->query($sql);
$num_rows = mysqli_num_rows($rs); 
$max_page = ceil($num_rows/ MAX_ROWS);

//表示したいページの番号、行番号を求める
$page = isset($_GET['p']) ? $_GET['p'] : 1;
if ($page < 1) $page = 1; //無効なページ番号を回避
if ($page > $max_page) $page = $max_page;
$offset = ($page - 1)  * MAX_ROWS;

//指定ページの結果を取り出す
$sql .= ' LIMIT ' . MAX_ROWS . ' OFFSET ' . $offset;
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);
$codes = [1=>'学生', 2=>'教員', 9=>'管理者']; 
$domain = 'kyusan-u.ac.jp';
echo '<table>';
while ($row= $rs->fetch_assoc()) {
 $uid = $row['uid'];
 $uname = $row['uname'];
 $i = $row['urole'];
 echo '<tr><td><img src="img/'. $uid . '.png" height="120"></td>';
 echo '<td>' . $uid . '<br>' . $uname . '<br>';
 echo $uid . '@' . $domain . '<br>';
 echo $codes[$i] . '</td></tr>';
}
echo '</table>';
// ページ切り替えのリンクを作る
for ($j=1; $j<=$max_page; $j++){
  if ($j == $page) {
    echo $j, ' ';
  }else {
    echo '<a href="?do=usr_listpage&p=' . $j .'">' . $j . '</a> ';
  }
}
?>