<?php
	include 'logincheck.php';
  $pageName = 'calendar';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8" />
<?php include "./calendar_library.php" ?>
<?php include "./common_library.php" ?>
<title>カレンダー</title>
</head>
<body>
<?php include "./common_header.php" ?>
  <div class="body">
    <div class="body-left">
      <div class="body-left-place">
        <a href="./index.php">ホーム</a><span> / カレンダー</span>
        <p>カレンダー</p>
      </div>
      <?php include "./common_body_left.php" ?>
    </div>
    <div class="body-right">
		<div class="container-option2 container-option">
        <div class="wraper">
          <div id='calendar'></div>  
      </div>
    </div>
  </div>
</body>
</html>
