<?php
  include 'logincheck.php';
  $pageName = 'employee';
  $pageName_bar = 'clear-color';


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
    <?php include "./common_library.php" ?>
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
        <?php include "./common_body_left.php" ?>
      </div>
      <div class="body-right">
      <div class="body-right-option">
          <div class="option-item"><a href="./personal.php?employee_no=<?= $employee_no ?>">詳細</a></div>
          <div class="option-item"><a href="#">部門</a></div>
          <div class="option-item"><a href="#">チーム</a></div>
          <div class="option-item <?php if ($pageName_bar == 'clear-color'){ echo "clear-color"; }?>"><a href="./clearCheck.php?employee_no=<?= $employee_no ?>">削除</a></div>
        </div>
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
                    <input type="text" class="form-control" name="compareCode" placeholder="会員番号を入力してください">
                  </div>
                </div>
                <?php 
			            session_start();
                  if(isset($_SESSION["error"]) == TRUE){
                    ?>
                    <div class="form-group alert alert-danger">
                      <?=$_SESSION["error"]?>
                    </div>      
                    <?php
                    unset($_SESSION["error"]);
                  }
                ?>
                <input type="hidden" value="<?= $employee_no ?>" name="employee_no">
                <div class="create-btn-div">
                  <button type="submit" class="btn btn-danger">削除</button>
                </div>
              </form>
              <div class="turn-back">
                <form action="./employee_list.php">
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