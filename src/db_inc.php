<?php 
 //$conn = new mysqli("mysql", "root", "root", "wp2025db");//＜開発時の環境設定＞
  $conn = new mysqli("localhost","k23rs005", "Ksu#DB2025", "wdb25k23rs005");//＜運用時の環境設定＞
  if ($conn->connect_errno) die($conn->connect_error);
  $conn->set_charset('utf8'); //文字コードをutf8に設定（文字化け対策）
?>