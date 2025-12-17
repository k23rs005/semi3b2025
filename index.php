<?php
session_start();

$do = 'eps_home'; //ホームページ (eps_home)をデフォルト機能とする
if (isset($_GET['do'])) {//index.php?do=に続くパラメータで実行する機能を指定
  $do = $_GET['do'];
}

if (!in_array($do, ['sys_check','sys_logout','eps_decide_save'])){
    include 'src/pg_header.php';
}

include('src/' . $do . '.php'); //指定されたファイルを読み込む
include('src/pg_footer.php');;  
?>