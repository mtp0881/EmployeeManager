<?php
  include 'logincheck.php';
  date_default_timezone_set ('Asia/Tokyo');
  session_start();
  session_regenerate_id(TRUE);
  $pageName = 'index';
  try{
    //DB接続
    require_once('./DBInfo.php');
    $pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD, array(PDO::ATTR_PERSISTENT => true));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
    $sqlSelectAll = "SELECT employee_no FROM employee";
    $statementAll = $pdo->prepare($sqlSelectAll);
    $statementAll->execute();
          
    $pdo = null;
  } catch(PDOException $e){
    $pdo = null;
    header('location:error.php');
  }
  ?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "./common_library.php" ?>
    <title>ホーム</title>
  </head>
  <body>
    <?php include "./common_header.php" ?>
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
        <?php if($_SESSION['role'] == 1){  include "./common_body_left.php"; } ?>
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
              <p><?=$statementAll->rowCount()?></p>
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
          <div class="right-menu-item">
            <div div class="world-icon menu-icon">
              <i class="fas fa-globe-asia"></i>
            </div>
            <div class="menu-title">
              <p>海外</p>
              <p>3</p>
            </div>
          </div>
        </div>
        <div class="right-content">
          <div class="grid-wrapper">
            <div class="grid-item">
              <div class="grid-header">
                <div class="grid-title">販売状況</div>
                <div class="gird-icon"><a href="#"><i class="fas fa-sort-down"></i></a></div>
              </div>
              <div class="grid-content">
                <div class="container-chart">
                  <canvas id="lineChart"></canvas>
                </div>
              </div>
            </div>
            <div class="grid-item">
              <div class="grid-header">
                <div class="grid-title">役職</div>
                <div class="gird-icon"><a href="#"><i class="fas fa-sort-down"></i></a></div>
              </div>
              <div class="grid-content">
                <div class="container-chart">
                  <canvas id="pieChart"></canvas>
                </div>
              </div>
            </div>
            <div class="grid-item">
              <div class="grid-header">
                <div class="grid-title">プロジェクト</div>
                <div class="gird-icon"><a href="#"><i class="fas fa-sort-down"></i></a></div>
              </div>
              <div class="grid-content grid-content-table overflow-auto">
                <table class="table table-hover table-borderless">
                  <thead class="thead">
                    <tr>
                      <th scope="col">詳細</th>
                      <th scope="col">プロジェクト名</th>
                      <th scope="col">リーダー</th>
                      <th scope="col">状態</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><a href="#"><i class="fas fa-file-alt"></i></a></td>
                      <td>Jec Pizza 販売サイト</td>
                      <td>鈴木 太郎</td>
                      <td><span class="tag tag-color-orange">要件定義</span></td>
                    </tr>
                    <tr>
                      <td><a href="#"><i class="fas fa-file-alt"></i></a></td>
                      <td>UI 図書館管理システム</td>
                      <td>佐藤 由香</td>
                      <td><span class="tag tag-color-green">実装</span></td>
                    </tr>
                    <tr>
                      <td><a href="#"><i class="fas fa-file-alt"></i></a></td>
                      <td>Cola 制御システム</td>
                      <td>福田 真美</td>
                      <td><span class="tag tag-color-green">実装</span></td>
                    </tr>
                    <tr>
                      <td><a href="#"><i class="fas fa-file-alt"></i></a></td>
                      <td>公民館予約システム</td>
                      <td>村田 重雄</td>
                      <td><span class="tag tag-color-red">企画書作成</span></td>
                    </tr>
                    <tr>
                      <td><a href="#"><i class="fas fa-file-alt"></i></a></td>
                      <td>チケット予約システム</td>
                      <td>田代 祐介</td>
                      <td><span class="tag tag-color-green">実装</span></td>
                    </tr>
                    <tr>
                      <td><a href="#"><i class="fas fa-file-alt"></i></a></td>
                      <td>遊園地 園内情報システム</td>
                      <td>小田 博史</td>
                      <td><span class="tag tag-color-yellow">テスト</span></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="grid-item">
              <div class="grid-header">
                <div class="grid-title">今日のイベント</div>
                <div class="gird-icon"><a href="#"><i class="fas fa-sort-down"></i></a></div>
              </div>
              <div class="grid-content event-div">
                <div class="grid-content grid-content-table overflow-auto">
                  <table class="table table-striped table-hover table-borderless">
                    <tr>
                      <td>イベント１</td>
                      <td>内容１</td>
                    </tr>
                    <tr>
                      <td>イベント２</td>
                      <td>内容２</td>
                    </tr>
                    <tr>
                      <td>イベント３</td>
                      <td>内容３</td>
                    </tr>
                    <tr>
                      <td>イベント４</td>
                      <td>内容４</td>
                    </tr>
                    <tr>
                      <td>イベント５</td>
                      <td>内容５</td>
                    </tr>
                    <tr>
                      <td>イベント６</td>
                      <td>内容６</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } else{ ?>
      <?php } ?>
    </div>
    <?php
      try{
      //DB接続
      require_once('./DBInfo.php');
      $pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD, array(PDO::ATTR_PERSISTENT => true));
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
        $sqlSelectAll = "SELECT employee_no FROM employee";
        $statementAll = $pdo->prepare($sqlSelectAll);
      $statementAll->execute();
      		
      
      //参照系SQL
      $sql = "SELECT D.department_name AS name,COUNT(D.department_name) AS count,D.department_no FROM department AS D LEFT JOIN employee AS E ON D.department_no = E.department GROUP BY D.department_name,D.department_no ORDER BY D.department_no";
      
      		
      //参照系SQLを発行
      $statement = $pdo->prepare($sql);
      
        $statement->bindValue(":limitStart", $limitStart,PDO::PARAM_INT);
        $statement->bindValue(":limitEnd", $limitEnd,PDO::PARAM_INT);
      
      $statement->execute();
      
        while($row = $statement->fetchObject()){
          $arr[$row->name] = $row->count;
        }
      
      //DB切断
      $pdo = null;
      
      } catch(PDOException $e){
      //DB切断
      $pdo = null;
      	
      //エラーページに移動する
      header('location:error.php');
      }
      ?>
    <script src="./js/line_chart.js"></script>
    <?php include './js/pie_chart.php'; ?>    
  </body>
</html>