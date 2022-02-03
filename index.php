<?php
  include 'logincheck.php';
  date_default_timezone_set ('Asia/Tokyo');
  session_start();
  session_regenerate_id(TRUE);
  $pageClass = 'active';

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

    <script
    src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
    </script>

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
            <tr class="first-tr" >
              <td class="<?=$pageClass?>">
                <a href="./index.php">
                  <i class="fas fa-home"></i>
                  <p>ホーム</p>
                </a>
              </td>
              <td class="btn-div">
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


    <script>
        var xValues = ["11月","12月","1月","2月","3月","4月"];

          new Chart("lineChart", {
            type: "line",
            data: {
              labels: xValues,
              datasets: [{
                label: '販売チーム01',
                data: [860,1140,1060,1060,1070,1110],
                borderColor: '#d95941',
                fill: false
              },{
                label: '販売チーム02',
                data: [1600,1700,1700,1900,2000,2700],
                borderColor: '#ffc906',
                fill: false
              },{
                label: '販売チーム03',
                data: [300,700,2000,5000,5100,4000],
                borderColor: '#3fbca3',
                fill: false
              }]
            },
            options: {
              legend: {display: true}
            }
          });



        var xValues = ["社長", "管理本部", "営業部", "総務部", "品質管理部"];
        var yValues = [<?=$arr["社長"]?>, <?=$arr["管理本部"]?>, <?=$arr["営業部"]?>, <?=$arr["総務部"]?>, <?=$arr["品質管理部"]?>];
        var barColors = [
          "#FECD56",
          "#FF9F40",
          "#FF6383",
          "#2FA0EE",
          "#4BC0C0"
        ];

        new Chart("pieChart", {
          type: "doughnut",
          data: {
            labels: xValues,
            datasets: [{
              backgroundColor: barColors,
              data: yValues
            }]
          },
          options: {
            title: {
              display: false,
            }
          }
        });

  </script>

    


  </body>
</html>