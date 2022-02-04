<?php
  session_start();
  
  $msg = "";
  
  if(isset($_SESSION['LoginOK']) === TRUE){
  
  	if($_SESSION['LoginOK'] === "NG"){
  
  		$msg = "入力された内容では認証できません！";
  		
  		$_SESSION['LoginOK'] = "";
  	}
  }
  ?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8" />
    <?php include "./common_library.php" ?>
    <title>ログイン</title>
  </head>
  <body class="container">
    <div class="login-box">
      <div class="login-left">
        <p class="title-left">Employee Management</p>
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
          <span>以下のアカウントでログインしてくだい</span>
        </div>
        <div class="login-acount">
          <table class="table table-bordered">
            <tbody>
              <tr>
              <td>管理者専用</td>

                <td>admin</td>
                <td>admin</td>
              </tr>
              <tr>
              <td>ユーザー専用</td>

                <td>user</td>
                <td>user</td>
              </tr>
            </tbody>
          </table>
        </div>
          <?php if($msg != ''){ ?>
            <div class="error-div">
              <p><?=$msg?></p>
            </div>
          <?php } ?>
      </div>
    </div>
  </body>
</html>