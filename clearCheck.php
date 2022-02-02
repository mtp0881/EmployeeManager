<?php
  include 'logincheck.php';

  if(isset($_GET['employee_no'])== TRUE && $_GET['employee_no'] != ''){
    $key =$_GET['employee_no'];
  }
  else{
      header('location:syainlist.php');
  }
  //表示用変数
  $title = '社員情報修正';
  $employee_no = '';
  $last_name = '';
  $first_name = '';
  $face_image = '';
  
  try{
  
  //DB接続
  require_once('./DBInfo.php');
  $pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD, array(PDO::ATTR_PERSISTENT => true));
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  //参照系SQL
  $sql = "SELECT * FROM employee WHERE employee_no = :employee_no";
  
  //参照系SQLを発行
  $statement = $pdo->prepare($sql);
  
  $statement->bindValue(":employee_no", $key);
  
  $statement->execute();
  
  //データの取得
  if($row = $statement->fetch()){
    $employee_no     = $row[0];
    $last_name       = $row[1];
    $first_name      = $row[2];
  $face_image      = $row[10];			
  }
  else{
  $title = '該当データはありません';
  }
  
  //DB切断
  $pdo = null;
  
  }
  catch(PDOException $e){
  
  //DB切断
  $pdo = null;
  
  //エラーページに移動する
  header('location:error.php');
  }
  
  ?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500;600&family=Noto+Serif+JP:wght@500&display=swap" rel="stylesheet">
    <link
      rel="stylesheet"
      href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
      integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
      crossorigin="anonymous"
      />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./css/employeelist.css" />
    <link rel="stylesheet" type="text/css" href="./css/dashboard.css" />
    <link rel="stylesheet" type="text/css" href="./css/emp_style.css" />
    <link rel="stylesheet" type="text/css" href="./css/employeedetail.css" />
    <title>データ検索・修正</title>
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
          <a href="./index.php">ホーム</a><span> / <a href="./syainlist.php">会員</a> / 削除</span>
          <p>削除確認</p>
        </div>
        <div class="body-left-profile">
          <div class="body-left-img">
            <img src="./images/<?=$face_image?>.jpg" alt="">
          </div>
          <p><?= $last_name ?> <?= $first_name ?></p>
          <p>example@example.com</p>
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
      <div class="body-right">
        <div class="container-person">
          <div class="form-wraper">
            <div class="form-clear">
              <form action="./delete.php" method="GET">
                <p class="form-group form-title">削除確認</p>
                <div class="form-group">
                  <p>このアクションは元に戻せません。これにより、<span class="name-span"><?= $first_name?> <?= $last_name?></span> さんの情報が完全に削除され、すべての共同作業者の関連付けが削除されます。</p>
                  <p>確認するには、<span class="name-span"><?= $employee_no ?></span>と入力してください。</p>
                </div>
                <div class="form-group">
                  <div class="form-group">
                    <input type="text" class="form-control" name="employee_no" placeholder="会員番号を入力してください">
                  </div>
                </div>
                <?php 
			            session_start();
                  if(isset($_SESSION["error"]) == TRUE){
                    ?>
                    <div class="form-group">
                      <?=$_SESSION["error"]?>
                    </div>      
                    <?php
                    unset($_SESSION["error"]);
                  }
                ?>
                <input type="hidden" value="<?= $employee_no ?>" name="compareCode">
                <div class="create-btn-div">
                  <button type="submit" class="btn btn-danger">削除</button>
                </div>
              </form>
              <div class="turn-back">
                <form action="syainlist.php">
                  <input type="submit" value="社員一覧へ" class="btn btn-outline-secondary"/>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>