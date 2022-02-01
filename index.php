<?php
  include 'logincheck.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500;600&family=Noto+Serif+JP:wght@500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="./css/dashboard.css" />
  <title>Dashboard</title>
</head>
<body>
  <header>
    <div class="header-left">
      <a class="header-title" href="./index.php">Master Management</a>
    </div>
    <div class="header-right">
      <div class="header-right-search">
        <input class="header-input" type="text" placeholder="ここに検索する">
      </div>
      <div class="header-right-img">
        <img src="./images/image01.jpg" alt="">
      </div>
    </div>
  </header>
  <div class="body">
    <div class="body-left">
      <div class="body-left-place">
        <a href="./index.php">ホーム</a>
        <p>ホーム</p>
      </div>
      <div class="body-left-profile">
        <div class="body-left-img">
          <img src="./images/image01.jpg" alt="">
        </div>
        <p>Welcome Sample</p>
        <p>Sun,29 Nov 2022</p>
      </div>
      <div class="body-left-menu">
        <div class="menu-wrap row">
            <div class="col-6 menu-item">
                <a href="./index.php">
                  <span><i class="fas fa-home"></i></span>
                  <span>ダッシュボード</span>
                </a>
            </div>
            <div class="col-6 menu-item">
                <a href="./syainlist.php">
                  <span><i class="fas fa-users"></i></span>
                  <span>社員</span>
                </a>
            </div>
            <div class="col-6 menu-item">
                <a href="#">
                  <span><i class="fas fa-building"></i></span>
                  <span>会社</span>
                </a>
            </div>
            <div class="col-6 menu-item">
                <a href="#">
                  <span><i class="fas fa-calendar-week"></i></span>
                  <span>カレンダー</span>
                </a>
            </div>
            <div class="col-6 menu-item">
                <a href="#">
                  <span><i class="fas fa-paste"></i></span>
                  <span>レポート</span>
                </a>
            </div>
            <div class="col-6 menu-item">
                <a href="#">
                  <span><i class="fas fa-cog"></i></span>
                  <span>設定</span>
                </a>
            </div>
          </div>
      </div>
    </div>
    <div class="body-right">
      
    </div>
    
  </div>
</body>
</html>