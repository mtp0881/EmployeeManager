<?php
  include 'logincheck.php';
  date_default_timezone_set ('Asia/Tokyo');
  session_start();
  session_regenerate_id(TRUE);
  
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="./images/man.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500;600&family=Noto+Serif+JP:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./css/dashboard.css" />
    <title>ホーム</title>
  </head>
  <body>
    <header>
      <div class="header-left">
        <a class="header-title" href="./index.php"><i class="fas fa-users-cog" style="margin-right: 16px;"></i>Master Management</a>
      </div>
      <div class="header-right">
        <div class="header-right-search">
          <div class="input">
            <input class="header-input" type="text" placeholder="ここに検索する">
            <a class="search-icon" href="#">
            <i class="fas fa-search"></i>
            </a>
          </div>
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
          <p>こんにちは <?= $_SESSION['userName'] ?></p>
          <p><?= date('Y年m月d日 H:i') ?></p>
        </div>
        <div class="body-left-menu">
          <table>
            <tr class="first-tr">
              <td>
                <a href="./index.php">
                  <i class="fas fa-home"></i>
                  <p>ダッシュボード</p>
                </a>
              </td>
              <td>
                <a href="./syainlist.php">
                  <i class="fas fa-users"></i>
                  <p>社員</p>
                </a>
              </td>
            </tr>
            <tr>
              <td>
                <a href="#">
                  <i class="fas fa-building"></i>
                  <p>会社</p>
                </a>
              </td>
              <td>
                <a href="#">
                  <i class="fas fa-calendar-week"></i>
                  <p>カレンダー</p>
                </a>
              </td>
            </tr>
            <tr class="last-tr">
              <td>
                <a href="#">
                  <i class="fas fa-paste"></i>
                  <p>レポート</p>
                </a>
              </td>
              <td>
                <a href="#">
                  <i class="fas fa-cog"></i>
                  <p>設定</p>
                </a>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <?php if($_SESSION['role'] == 1){ ?>
      <div class="body-right">
        <div class="right-menu">
          <div class="right-menu-item">
            <div class="employee-icon menu-icon">
              <i class="fas fa-user-friends"></i>
            </div>
            <div class="menu-title">
              <p>社員</p>
              <p>12</p>
            </div>
          </div>
          <div class="right-menu-item">
            <div div class="company-icon menu-icon">
              <i class="fas fa-building"></i>
            </div>
            <div class="menu-title">
              <p>支店</p>
              <p>15</p>
            </div>
          </div>
        </div>
        <div class="right-content">
          <div class="grid-wrapper">
            <div class="grid-item">
              <div class="grid-header">
                <div class="grid-title">会員合計</div>
              </div>
              <div class="grid-content"></div>
            </div>
            <div class="grid-item">
              <div class="grid-header">
                <div class="grid-title">販売合計</div>
              </div>
              <div class="grid-content"></div>
            </div>
            <div class="grid-item">
              <div class="grid-header">
                <div class="grid-title">今日のイベント</div>
              </div>
              <div class="grid-content"></div>
            </div>
            <div class="grid-item">
              <div class="grid-header">
                <div class="grid-title">チーム</div>
              </div>
              <div class="grid-content"></div>
            </div>
          </div>
        </div>
      </div>
      <?php } else{ ?>
      <?php } ?>
    </div>
  </body>
</html>