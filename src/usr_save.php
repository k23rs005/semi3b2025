<?php
require_once 'db_inc.php';

//print_r($_POST); //デバッグ：送信されたデータを目視で確認する
$act = $_POST['act'];
$uid = $_POST['uid'];
$uname = $_POST['uname'];
$upass1 = $_POST['upass1'];
$upass2 = $_POST['upass2'];
$urole = $_POST['urole'];
if ($upass1===$upass2){
  if ($act=='update'){ //既存のアカウントを編集する場合
    $sql = "UPDATE tbl_user SET uname='{$uname}',upass='{$upass1}',urole=$urole WHERE uid='{$uid}'";
  }else{//新規アカウントを登録する場合
    $sql ="INSERT INTO tbl_user(uid,uname,upass,urole) VALUES ('{$uid}','{$uname}','{$upass1}',$urole)";
  }
  $rs = $conn->query($sql);
  if ($conn->errno){
     echo 'エラー：' . $conn->error;
  }else{
     echo '<h3>アカウントが更新されました</h3>';
  }
}else{
  echo '<h3>エラー：パスワードが一致しないので登録できません</h3>';
}
?>