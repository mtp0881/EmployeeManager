<?php
	session_start();

	$msg = "";

	if(isset($_SESSION['LoginOK']) == TRUE){

		if($_SESSION['LoginOK'] == "NG"){

			$msg = "入力された内容では認証できません！";
			
			$_SESSION['LoginOK'] = "";
		}
	}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="./emp_style.css" />
<title>EX28　yyJNccnn　ユーザー認証(ログイン画面)</title>
</head>
<body class="container">
	<div class="login-box">
		<div class="login-left">
			<p class="title-left">社員管理</p>
		</div>
		<div class="login-right">
			<h3 class="title">ログイン</h3>
			<p class="text">ダッシュボードへのアクセス</p>
			<form action="./ninsyou.php" class="text-center" method="POST">
				<div class="form-group">
					<input type="text" placeholder="ユーザーID" class="form-control" name="UserID">
				</div>
				<div class="form-group">
					<input type="password" placeholder="パスワード" class="form-control" name="Password">
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary center">ログイン</button>
				</div>
			</form>
			<a href="">パスワードが忘れました？</a>
			<div class="login-or">
				<span class="or-line"></span>
				<span class="or-text">その他</span>
			</div>
			<div class="social-login">
				<span>サービスアカウントでログイン</span>
			</div>
			<div class="error-div">
				<?php echo $msg ?>
			</div>
		</div>
	</div>
</body>
</html>
