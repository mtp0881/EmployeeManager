<?php
    //ログインチェック
	include 'logincheck.php';
	date_default_timezone_set ('Asia/Tokyo');
  $pageClass = 'active';

  $limitEnd = 9;

  if(isset($_GET['limitStart']) == TRUE &&  $_GET['limitStart'] != ''){
    $limitStart =$_GET['limitStart'];
  }
  else{
    $limitStart = 0;
  }

	try{
			//DB接続
			require_once('./DBInfo.php');
			$pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD, array(PDO::ATTR_PERSISTENT => true));
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sqlSelectAll = "SELECT employee_no FROM employee";
      $statementAll = $pdo->prepare($sqlSelectAll);
			$statementAll->execute();
						

			//参照系SQL
			$sql = "SELECT * FROM employee LEFT JOIN department ON employee.department = department.department_no ORDER BY department.department_no LIMIT :limitStart,:limitEnd";

						
			//参照系SQLを発行
			$statement = $pdo->prepare($sql);

      $statement->bindValue(":limitStart", $limitStart,PDO::PARAM_INT);
      $statement->bindValue(":limitEnd", $limitEnd,PDO::PARAM_INT);

			$statement->execute();

				//DB切断
			$pdo = null;

	} catch(PDOException $e){
		//DB切断
		$pdo = null;
					
		//エラーページに移動する
		header('location:error.php');
	}

  $rowCount = $statementAll->rowCount();
  $cnt = 0;
  $i = 0;

  for($i = 0; $i < $rowCount; $i++){
    if($i % 9 == 0){
      $arr[$cnt] = $i;
      $cnt++;
    }
  }



?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8" />
<link rel="icon" href="./images/man.png" />
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
<link rel="stylesheet" type="text/css" href="./css/employeedetail.css" />


<title>社員データ一覧</title>
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
        <a href="./index.php">ホーム</a><span> / 会員</span>
        <p>会員管理</p>
      </div>
      <!-- <div class="body-left-profile">
        <div class="body-left-img">
          <img src="./images/image01.jpg" alt="">
        </div>
        <p>おかえりなさい</p>
        <p><?= date('Y年m月d日 H:i') ?></p>
      </div> -->
      <div class="body-left-menu">
			<table>
          <tr class="first-tr">
            <td>
                <a href="./index.php">
                  <i class="fas fa-home"></i>
                  <p>ホーム</p>
                </a>
            </td>
            <td class="<?=$pageClass?>">
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
      <div class="body-right-option">
        <div class="option-item is-active_<?=$pageClass?>"><a href="./syainlist.php">ダッシュボード</a></div>
        <div class="option-item"><a href="#">部門</a></div>
        <div class="option-item"><a href="#">チーム</a></div>
      </div>
			<div class="body-right-create">
				<div class="create-left">
					<p><?= $statementAll->rowCount() ?> 社員が在職しています</p>
				</div>
				<div class="create-right">
					<form action="./toroku.php" method="GET">
						<div class="form-group create-from">
							<button type="submit" class="btn btn-warning ">新規登録</button>
						</div>
					</form>
				</div>
			</div>
      
		<div class="container-option">
        <form action="personal.php" method="GET" class="form form2">
                <div class="input-group mb-3 nonemargin">
                  <input type="text" name="employee_no" class="form-control" placeholder="社員番号を入力してください">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">社員検索</button>
                  </div>
                </div>
              </form>
        <div class="wraper">
          <div class="employee-list">
          <?php while($row = $statement->fetchObject()){ 
            
            $date1 = new DateTime("NOW");
            $date2 = new DateTime($row->entrance_date);
            
            $interval = $date1->diff($date2);
            
            if($interval->y < 1){
              $hireToNow = '在職'.$interval->y.'年以下';
            } else{
              $hireToNow = '在職'.$interval->y.'年以上';
            }
            ?>
                  <div class="employee-list-item">
                    <div class="employee-list-logo">
                      <img src="images/<?= $row->face_image?>.jpg" alt="" />
                    </div>
                    <h3 class="employee-list-title"><?= $row->last_name?> <?= $row->first_name?></h3>
                    <div class="employee-list-detail">
                      sampleEmail@gmail.com
                    </div>
                    <div class="employee-list-tag">
                      <div class="tag-item"><?= $row->department_name?></div>
                      <div class="tag-item"><?= $hireToNow?></div>
                      <!-- <div class="tag-item"><?= $row->department?></div> -->
                    </div>
                    <div class="employee-list-friends">
                      <div class="friends-item">
                        <img src="images/image01.jpg" alt="" />
                      </div>
                      <div class="friends-item">
                        <img src="images/image02.jpg" alt="" />
                      </div>
                      <div class="friends-item">
                        <img src="images/image03.jpg" alt="" />
                      </div>
                      <div class="friends-item">+2</div>
                      <div class="friends-count">5チーム共同</div>
                    </div>
                    <div class="employee-list-action">
                      <a class="btn btn-outline-primary form-control" href='personal.php?employee_no=<?= $row->employee_no?>'>
                        詳細
                      </a>
                      <!-- <a class="action-button action-button--gray btn btn-secondary" href='sakujyo.php?employee_no=<?= $row->employee_no?>'>
                        削除
                      </a> -->
                    </div>
                  </div>
                <?php
              } ?>
              <div class="paginate-btn">
                <nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-end">
                    <li class="page-item disabled">
                      <a class="page-link" href="#" tabindex="-1">前のページ</a>
                    </li>
                    <?php 
                      $cnt = 1;
                      if(isset($_GET['state']) != TRUE){
                        $_GET['state'] = 1;
                      }
                      foreach($arr as $value){
                        if($_GET['state'] == $cnt){
                          ?>
                          <li class="page-item state"><a class="page-link" href="./syainlist.php?state=<?= $cnt ?>&limitStart=<?= $value ?>"><?= $cnt ?></a></li>
                          <?php
                        } else {
                        ?>
                          <li class="page-item"><a class="page-link" href="./syainlist.php?state=<?= $cnt ?>&limitStart=<?= $value ?>"><?= $cnt ?></a></li>
                        <?php }
                          $cnt++;
                      }
                    ?>
                    <li class="page-item disabled" >
                      <a class="page-link" href="#">次ぎ</a>
                    </li>
                  </ul>
                </nav>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
