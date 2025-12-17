<?php
require_once 'db_inc.php';
$uid = $_SESSION['uid']; // ログイン中のユーザのIDを取得
$sid = strtoupper($uid); // 学籍番号（大文字）

// ★ ここで調査期間チェックを行う ★
$sql = "SELECT setting_name, setting_value FROM tbl_config";
$rs = $conn->query($sql);
$config = [];
while ($row = $rs->fetch_assoc()) {
    $config[$row['setting_name']] = $row['setting_value'];
}

$today = date('Y-m-d');
if ($today < $config['survey_start']) {
    echo "<p>調査はまだ始まっていません。</p>";
    exit;
}
if ($today > $config['survey_end']) {
    echo "<p>調査期間は終了しました。</p>";
    exit;
}

// 初期値（新規登録）
$act = 'insert';
$pid = '';
$reason = '';
// 既存データがあるか確認
$sql = "SELECT pid, reason FROM tbl_wish WHERE sid = '$sid'";
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);
$row = $rs->fetch_assoc();
if ($row) {
  $act = 'update';
  $pid = $row['pid'];
  $reason = $row['reason'];
}
?>
<h3>情報科学科教育プログラム配属希望登録</h3>
<form action="?do=eps_save" method="post">
<input type="hidden" name="act" value="<?php echo $act; ?>">
<input type="hidden" name="sid" value="<?php echo htmlspecialchars($sid); ?>">
<p><strong>希望プログラム選択</strong></p>
<label><input type="radio" name="pid" value="1" <?php if ($pid == '1') echo 'checked'; ?>> 総合教育プログラム</label><br>
<label><input type="radio" name="pid" value="2" <?php if ($pid == '2') echo 'checked'; ?>> 応用教育プログラム</label><br><br>
<p><strong>希望理由</strong></p>
<textarea name="reason" rows="4" cols="50"><?php echo htmlspecialchars($reason); ?></textarea><br><br>
<input type="submit" value="送信" style="background-color:#3399FF; color:white; padding:5px 20px;">
<input type="button" value="取消" onclick="history.back();" style="background-color:#66CC66; color:white; padding:5px 20px;">
</form>