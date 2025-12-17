<h3>アカウント一覧</h3>
<?php
require_once('db_inc.php');
// ここから　絞り込み/検索条件入力
$urole = isset($_POST['urole']) ? $_POST['urole'] : 0;
$keywd = isset($_POST['keywd']) ? $_POST['keywd'] : '';
echo '<form action="?do=usr_listfilter" method="post">';
$codes = array(0=>'すべて', 1=>'学生', 2=>'教員', 9=>'管理者' );
foreach ($codes as $key => $value){
  $checked = ($key == $urole) ? 'checked' : '';
  echo '<input type="radio" name="urole" value="' . $key . '" ' . $checked . '>' . $value;
  // printf('<input type="radio" name="urole" value="%s" $s>%s', $key, $checked, $value);
}
echo '<br><input type="text" name="keywd" value="' . $keywd . '" placeholder="検索語入力">';
echo '<input type="submit" value="検　索">';
echo '</form>';
echo '<hr>';
// 絞り込み/検索条件をSQL文に適用
$where = ($urole==0) ? 'WHERE 1' : 'WHERE urole=' . $urole;
if (!empty($keywd)) $where .= " AND uname LIKE '%{$keywd}%'";  
$sql = "SELECT * FROM tbl_user $where ORDER BY urole,uid";//$whereを適用

$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);

// 問合せ結果を表形式で出力する
echo '<table border=1>';
// まず、ヘッド部分（項目名）を出力
echo '<tr><th>No.</th><th>氏名</th><th>ユーザ種別</th></tr>';

// ユーザID（uid）、ユーザ名(uname)、ユーザ種別(urole)を一覧表示
$row= $rs->fetch_assoc();
while ($row) {
  echo '<tr>';
  echo '<td>' . $row['uid'] . '</td>';
  echo '<td>' . $row['uname']. '</td>';
  //echo '<td>' . $row['urole']. '</td>'; 　この行をコメントアウトし、以下の3行を追加
  $i  = $row['urole'];     // ユーザ種別のコードを数値で取得
  $codes = array(1=>'学生', 2=>'教員', 9=>'管理者' ); //ユーザ種別を定義する配列
  echo '<td>' . $codes[$i] . '</td>'; // ユーザ種別名を配列の要素として出力
  echo '<td><a href="?do=usr_detail&uid='.$row['uid'] . '">詳細</a></td>';//echo '</tr>';の直前に追加
  echo '<td><a href="?do=usr_edit&uid='.$row['uid'].'">編集</a></td>';// echo '</tr>';の直前に追加
  echo '</tr>';
  $row = $rs->fetch_assoc();//次の行へ
}
echo '</table>';
?>