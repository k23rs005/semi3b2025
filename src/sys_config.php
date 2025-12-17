<?php
require_once 'db_inc.php';
include('header.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start = $_POST['survey_start'];
    $end   = $_POST['survey_end'];

    // 更新処理
    $sql1 = "UPDATE tbl_config SET setting_value='$start' WHERE setting_name='survey_start'";
    $sql2 = "UPDATE tbl_config SET setting_value='$end' WHERE setting_name='survey_end'";
    $conn->query($sql1);
    $conn->query($sql2);

    echo "<p>調査期間を更新しました！</p>";
}

// 現在の設定を取得
$sql = "SELECT setting_name, setting_value FROM tbl_config";
$rs = $conn->query($sql);
$config = [];
while ($row = $rs->fetch_assoc()) {
    $config[$row['setting_name']] = $row['setting_value'];
}
?>
<h2>調査期間の設定</h2>
<form method="post" action="">
  開始日: <input type="date" name="survey_start" value="<?php echo $config['survey_start']; ?>"><br>
  終了日: <input type="date" name="survey_end" value="<?php echo $config['survey_end']; ?>"><br>
  <input type="submit" value="保存">
</form>
<?php include('footer.php'); ?>
